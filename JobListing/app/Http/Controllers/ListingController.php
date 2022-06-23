<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class ListingController extends Controller
{
    // Show all listings
    public function index(Request $request, Listing $listing)
    {
        // echo "hello";
        // echo $request->getRequestUri();
        // echo request('DOCUMENT_ROOT');
        // echo $request->search;
        // var_dump($request->server);
        // echo request(['tag', 'search']) != null;
        // dd(request(['tag', 'search']));
        if(request(['tag', 'search']) != null){

            return view('listings.index', [
                'heading' => 'Latest Listing',
                'listings' => $listing -> latest()
                    -> filter(request(['tag', 'search']))
                    -> paginate(20)
                    // -> get()
                    // ->sortDesc()
                    
            ]);

        }
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => $listing -> latest()
                // -> filter(request(['tag', 'search']))
                -> paginate(20)
                // -> sortDesc()
                // -> all()
                // -> sortDesc()
                // ->sortDesc()
                
        ]);
    }

    // Show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'heading' => 'Latest Listing',
            'listing' => $listing,
        ]);
    }

    // Create Jobs
    public function create()
    {
        return view('listings.create');
    }

    // Store/Save newly submitten Job Creation Data
    public function store(Request $request, Listing $listing)
    {
        // dd($request->file('logo'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required', //['required', Rule::unique(['listings', 'company'])],
            'location' => 'required',
            'website' => 'required',
            'email' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request
                ->file('logo')
                ->store('logos', 'public');
        }
        // dd($formFields['logo']);
        // Listing::creating($formFields);
        $listing->create($formFields);

        return redirect('/')->with('message', 'Listing Created Successfully');
    }

    // Show Edit Form
    public function edit(Listing $listing)
    {
        // dd($listing);
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update Edit Form
    public function update(Request $request, Listing $listing)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required', //['required', Rule::unique(['listings', 'company'])],
            'location' => 'required',
            'website' => 'required',
            'email' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request
                ->file('logo')
                ->store('logos', 'public');
        }
        // dd($formFields);
        // Listing::creating($formFields);
        $listing->update($formFields);

        return redirect('/')->with('message', 'Listing Updated Successfully');
    }
}
