<?php

namespace App\Http\Controllers\Tour;

use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Tour\TourPackage;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourDestination;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TourDestinationController extends Controller
{
    use ValidatesRequests;
    use LogsActivity;


    function __construct()
    {
        $this->middleware('permission:tour_destination-list|tour_destination-create|tour_destination-edit|tour_destination-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:tour_destination-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tour_destination-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tour_destination-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:tour_destination-download', ['only' => ['download', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $title = 'Destinasi Wisata';
        $destinations = TourDestination::orderBy('id', 'DESC')->get();

        return view('dashboard.tour.destinations.index', compact('destinations', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $title = 'Tambah Destinasi Wisata';

        return view('dashboard.tour.destinations.create', compact('roles', 'title'));
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
            'name' => 'required|unique:tour_destinations,name',
            'description' => 'nullable',
            'location' => 'required',
            'maps' => 'required',
            'images.*' => 'nullable|image',
            'operating_days' => 'required',
            'opening_hours' => 'required',
            'closing_hours' => 'required',
            'status' => 'required|in:buka,tutup,sementara_tutup'
        ]);



        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageManager = new ImageManager(new Driver());
                $filePath = 'wisata/destinasi_wisata/' . md5(Str::slug($request->name) . '_' . time()) . '/' . $file->hashName() . '.webp';
                $img = $imageManager->read($file);

                $width = $img->width();
                $height = $img->height();
                $aspectRatio = $width / $height;

                $newWidth = 640;
                $newHeight = intval($newWidth / $aspectRatio);

                $img = $img->resize($newWidth, $newHeight);
                $directory = dirname(storage_path('app/public/' . $filePath));
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                // Add watermark

                $img = $img->toWebp(100)->save(storage_path('app/public/' . $filePath));

                $imagePaths[] = $filePath;
            }
        }

        $validatedData['images'] = json_encode($imagePaths);
        $validatedData['slug'] = Str::slug($request->name);

        $validatedData['uuid'] = Str::uuid()->toString();

        $tour = TourDestination::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan destinasi wisata dengan nama tempat wisata: ' . $tour->name;
        $this->logActivity('tour_destinations', $request->user(), $tour->id, $description);

        return redirect()->route('tour-destinations.index')
            ->with('success', 'Destinasi Wisata berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $tour_destination = TourDestination::find($id);

        return view('dashboard.tour.destinations.show', compact('tour_destination'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = 'Edit Destinasi Wisata';
        $tour = TourDestination::findOrFail($id);
        $packages = TourPackage::where('destination_id', $id)->get();

        return view('dashboard.tour.destinations.edit', compact('tour',  'title', 'packages'));
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
            'name' => 'required|unique:tour_destinations,name,' . $id,
            'description' => 'nullable|',
            'location' => 'required',
            'maps' => 'required',
            'images.*' => 'nullable|image',
            'operating_days' => 'required|array|min:1',
            'opening_hours' => 'required|before:closing_hours|after:00:00',
            'closing_hours' => 'required|after:opening_hours|before:23:59',
            'status' => 'required|in:buka,tutup,sementara_tutup'
        ]);

        $tour_destination = TourDestination::find($id);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            $existingImages = json_decode($tour_destination->images, true);
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
            foreach ($request->file('images') as $file) {
                $imageManager = new ImageManager(new Driver());
                $filePath = 'wisata/destinasi_wisata/' . md5(Str::slug($request->name) . '_' . time()) . '/' . $file->hashName() . '.webp';
                $img = $imageManager->read($file);

                $width = $img->width();
                $height = $img->height();
                $aspectRatio = $width / $height;

                $newWidth = 640;
                $newHeight = intval($newWidth / $aspectRatio);

                $img = $img->resize($newWidth, $newHeight);

                $directory = dirname(storage_path('app/public/' . $filePath));
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                $img = $img->toWebp(100)->save(storage_path('app/public/' . $filePath));

                $imagePaths[] = $filePath;
            }

            $validatedData['images'] = json_encode($imagePaths);
        }


        $validatedData['slug'] = Str::slug($request->name);

        $tour_destination = TourDestination::find($id);
        $tour_destination->update($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' mengubah destinasi wisata dengan nama tempat wisata: ' . $tour_destination->name;
        $this->logActivity('tour_destinations', $request->user(), $tour_destination->id, $description);

        return redirect()->route('tour-destinations.index')
            ->with('success', 'Destinasi Wisata berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $tour = TourDestination::findOrFail($id);
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
            $description = 'Pengguna ' . Auth::user()->name  . ' menghapus data destinasi wisata pada nama tempat wisata: ' . $tour->name;
            $this->logActivity('tour_destinations', Auth::user(), $tour->id, $description);
            $tour->delete();

            return redirect()->route('tour-destinations.index')
                ->with('success', 'Destinasi Wisata berhasil dihapus');
        } else {
            return redirect()->route('tour-destinations.index')
                ->with('error', 'Destinasi Wisata tidak ditemukan');
        }
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $destinationIds = explode(',', $request->input('destinationIds', ''));
        if (!empty($destinationIds)) {
            foreach ($destinationIds as $tourId) {
                $tour = TourDestination::findOrFail($tourId);
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

                    $description = 'Pengguna ' . Auth::user()->name  . ' menghapus data destinasi wisata pada nama tempat wisata: ' . $tour->name;
                    $this->logActivity('tour_destinations', Auth::user(), $tour->id, $description);
                }
            }
            TourDestination::whereIn('id', $destinationIds)->delete();
            return redirect()->route('tour-destinations.index')->with('success', 'Destinasi Wisata berhasil dihapus');
        }
        return redirect()->route('tour-destinations.index')->with('error', 'Tidak ada destinasi wisata yang dipilih');
    }

    public function download($id)
    {
        $tour = TourDestination::findOrFail($id);
        $description = 'Pengguna ' . Auth::user()->name  . ' mengunduh data destinasi wisata pada nama tempat wisata: ' . $tour->name;
        $this->logActivity('tour_destinations', Auth::user(), $tour->id, $description);
        return Storage::disk('public')->download($tour->file_path);
    }
}
