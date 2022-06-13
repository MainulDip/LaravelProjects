<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Show all listings
    public function index(Request $request) {
        // echo "hello";
        // echo $request->getRequestUri();
        // echo request('DOCUMENT_ROOT');
        // echo $request->search;
        // var_dump($request->server);
        // dd($request);
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => Listing::latest()->filter(
                request(['tag', 'search'])
            )->get(),
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'heading' => 'Latest Listing',
            'listing' => $listing
        ]);
    }

    // Create Jobs
    public function create(){
        return view('listings.create');
    }

    // Store/Save newly submitten Job Creation Data
    public function store(Request $request){
        dd($request);
    }
}
