<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourDestination;
use Illuminate\Foundation\Validation\ValidatesRequests;

class HomeController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $title = 'Beranda';
        $tour = TourDestination::with('packages')->get();
        $tour = $tour->filter(function ($destination) {
            return $destination->packages->isNotEmpty() && $destination->status == 'buka' && !is_null($destination->images);
        });
        return view('home.index', compact('title', 'tour'));
    }
}
