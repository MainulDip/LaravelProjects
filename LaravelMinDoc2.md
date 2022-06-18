## Laravel mini dock part 2:
Check the laravel app lifecycle at https://laravel.com/docs/9.x/lifecycle
 
Topics: 
 1. Layout file as Component
 2. Custom Tags Filter Using Model Controller
 3. Search Filter Using Model Controller
 4. Clockwork Package
 5. Create Listing Form
 6. Validation & Store Listing
 7. Mass Assignment Rule
 8. Flash Messages
 9. Alpine.js For Message Removal
 10. Keep Old Data In Form
 11. Pagination
 12. File Upload
 13. Edit Listing
 14. Delete Listing
 15. User Registration
 16. Auth Links
 17. User Logout
 18. User Login
 19. Auth & Guest Middleware
 20. Relationships
 21. Tinker Tinkering
 22. Add Ownership to Listings
 23. Manage Listings Page
 24. User Authorization

### 1. Layout file as Component
instade of layout with @yield and using that inside template by include + section, we can use it like Components file by "{{$slot}}" and <x-layout> respectedly


### 2. Custom Tags Filter Using Model Controller and Query Scope
Query Scope allowes easily re-use query logic in your models. To define a scope, simply prefix a model method with scope. Note the naiming convention
docs : https://laravel.com/docs/5.0/eloquent#query-scopes
```php
// Controller Function
// Show all listings
    public function index(Request $request) {
        // dd($request);
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => Listing::latest()->filter(
                // anything passed here will be available to the second argument of the scopeFilter method inside model
                request(['tag'])
            )->get(),
        ]);
    }

// Model -> Listing
// controller chaining method will be the rest of the word after "scope"
public function scopefilter($query, array $filters){
        // dd($filters);
        if($filters['tag'] ?? false){
            // request() method is global
            $query->where('tags', 'like', '%' . request('tag'). '%'); 
        }
    }
```


### 3. Search Filter Using Model Controller
```php
// Inside ListingController.php
// Show all listings
    public function index(Request $request) {
        // dd($request);
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => Listing::latest()->filter(
                request(['tag', 'search'])
            )->get(),
        ]);
    }


// Listing Model
public function scopefilter($query, array $filters){
        // dd($filters);
        if($filters['tag'] ?? false){
            // request() method is global
            $query->where('tags', 'like', '%' . request('tag'). '%'); 
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search'). '%')
            ->orWhere('description', 'like', '%' . request('search'). '%')
            ->orWhere('tags', 'like', '%' . request('search'). '%');
        }
    }
```


### 4. Clockwork Package
Also Chrome Extension.
Install : composer require itsgoingd/clockwork
after the cohore extion and composer require, it should work out of the box


### 5. Create Listing Form
Adding Functionality Workflow > New Route -> New Controller Method -> New View
NB: Sending Form data over POST method requires @csrf directive inside form tag.

### 6. Validation, Request & Store Listing
docs: https://laravel.com/docs/9.x/requests && https://laravel.com/docs/9.x/validation
> The store function inside controller

```php
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

        return redirect('/');
    }
```

### 7. Mass Assignment Rule
For mass assaignment, it's required to whitelist entries by adding the $fillable protected array in the specific model
```php
protected $fillable = ['title', 'company', 'location', 'email', 'website', 'tags','description' ];
```

### 8. Flash Messages
```php
Session::flash('message', 'Listing Created');
// OR
return redirect('/')->with('message', 'Listing Created Successfully');

// And recieve the message from view or component
// Using session('key')
@if(session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3">
<p>
    {{session('message')}}
</p>
</div>
@endif
```

### 9. Alpine.js For Message Removal


### 10. Keep Old Data In Form


### 11. Pagination


### 12. File Upload


### 13. Edit Listing


### 14. Delete Listing


### 15. User Registration


### 16. Auth Links


### 17. User Logout


### 18. User Login


### 19. Auth & Guest Middleware


### 20. Relationships


### 21. Tinker Tinkering


### 22. Add Ownership to Listings


### 23. Manage Listings Page


### 24. User Authorization