<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

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
            )->paginate(2),
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
    public function store(Request $request, Listing $listing){
        // dd($request);
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required', //['required', Rule::unique(['listings', 'company'])],
            'location' => 'required', 
            'website' => 'required',
            'email' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        // Listing::creating($formFields);
        $listing->create($formFields);

        return redirect('/')->with('message', 'Listing Created Successfully');
    }
}
