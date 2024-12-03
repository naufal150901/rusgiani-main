<?php

namespace App\Http\Controllers;

use App\Models\Item\IncomingItem;
use App\Models\Item\OutgoingItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tour\TourPackage;
use App\Models\Tour\TourDestination;
use App\Models\Letters\IncomingLetter;
use App\Models\Letters\OutgoingLetter;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalBarangMasuk = IncomingItem::count();
        $totalBarangKeluar = OutgoingItem::count();

        return view('dashboard.index', compact('totalBarangMasuk', 'totalBarangKeluar'));
    }
}
