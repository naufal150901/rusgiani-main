<?php

namespace App\Http\Controllers\Tour;

use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Tour\TourPackage;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourDestination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TourPackageController extends Controller
{
    use ValidatesRequests;
    use LogsActivity;


    function __construct()
    {
        $this->middleware('permission:tour_package-list|tour_package-create|tour_package-edit|tour_package-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:tour_package-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tour_package-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tour_package-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:tour_package-download', ['only' => ['download', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $title = 'Paket Wisata';
        $packages = TourPackage::orderBy('id', 'DESC')->get();

        return view('dashboard.tour.packages.index', compact('packages', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $destinations = TourDestination::all();
        $title = 'Tambah Paket Wisata';

        return view('dashboard.tour.packages.create', compact('destinations', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validate($request, [
            'destination_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required',
            'duration' => 'required',
            'inclusions' => 'nullable',
            'availability' => 'required|in:terbatas,tidak_terbatas',
            'cancellation_policy' => 'required|in:ya,tidak',
            'refund_policy' => 'required|in:ya,tidak',
            'status' => 'required|in:aktif,nonaktif,habis',
        ]);

        $validatedData['uuid'] = Str::uuid()->toString();


        $tour = TourPackage::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan paket wisata dengan nama paket wisata: ' . $tour->name . ' pada wisata tujuan: ' . $tour->destination->name;
        $this->logActivity('tour_packages', $request->user(), $tour->id, $description);

        return redirect()->route('tour-packages.index')
            ->with('success', 'Paket Wisata berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $tour_package = TourPackage::find($id);

        return view('dashboard.tour.packages.show', compact('tour_package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = 'Edit Paket Wisata';
        $package = TourPackage::findOrFail($id);
        $destinations = TourDestination::all();

        return view('dashboard.tour.packages.edit', compact('package',  'title', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validatedData = $this->validate($request, [
            'destination_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required',
            'duration' => 'required',
            'inclusions' => 'nullable',
            'availability' => 'required|in:terbatas,tidak_terbatas',
            'cancellation_policy' => 'required|in:ya,tidak',
            'refund_policy' => 'required|in:ya,tidak',
            'status' => 'required|in:aktif,nonaktif,habis',
        ]);


        $tour_package = TourPackage::findOrFail($id);
        $tour_package->update($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' mengubah paket wisata dengan nama paket wisata: ' . $tour_package->name . ' pada wisata tujuan: ' . $tour_package->destination->name;
        $this->logActivity('tour_packages', $request->user(), $tour_package->id, $description);

        return redirect()->route('tour-packages.index')
            ->with('success', 'Paket Wisata berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $tour = TourPackage::findOrFail($id);
        if ($tour) {
            $existingImages = json_decode($tour->images, true);
            if ($existingImages) {
                foreach ($existingImages as $existingImage) {
                    if (Storage::disk('public')->exists($existingImage)) {
                        Storage::disk('public')->delete($existingImage);
                        $directory = dirname(storage_path('app/public/' . $existingImage));
                        if (is_dir($directory) && count(scandir($directory)) == 2) {
                            rmdir($directory);
                        }
                    }
                }
            }
            $description = 'Pengguna ' . Auth::user()->name  . ' menghapus data paket wisata pada nama paket wisata: ' . $tour->name;
            $this->logActivity('tour_packages', Auth::user(), $tour->id, $description);
            $tour->delete();

            return redirect()->route('tour-packages.index')
                ->with('success', 'Paket Wisata berhasil dihapus');
        } else {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Paket Wisata tidak ditemukan');
        }
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $packageIds = explode(',', $request->input('packageIds', ''));
        if (!empty($packageIds)) {
            foreach ($packageIds as $tourId) {
                $tour = TourPackage::findOrFail($tourId);
                if ($tour) {
                    $description = 'Pengguna ' . Auth::user()->name  . ' menghapus data paket wisata pada nama paket wisata: ' . $tour->name;
                    $this->logActivity('tour_packages', Auth::user(), $tour->id, $description);
                }
            }
            TourPackage::whereIn('id', $packageIds)->delete();
            return redirect()->route('tour-packages.index')->with('success', 'Paket Wisata berhasil dihapus');
        }
        return redirect()->route('tour-packages.index')->with('error', 'Tidak ada paket wisata yang dipilih');
    }

    public function download($id)
    {
        $tour = TourPackage::findOrFail($id);
        $description = 'Pengguna ' . Auth::user()->name  . ' mengunduh data paket wisata pada nama paket wisata: ' . $tour->name;
        $this->logActivity('tour_packages', Auth::user(), $tour->id, $description);
        return Storage::disk('public')->download($tour->file_path);
    }
}
