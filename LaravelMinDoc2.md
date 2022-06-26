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
```php
<input ... value="{{old('name')}}"/>

<textarea ...>
{{old('description')}}
</textarea>
```

### 11. Pagination
```php
// inside controller's index function use paginate()
    public function index(Request $request) {
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => Listing::latest()->filter(
                request(['tag', 'search'])
            )->paginate(2),
        ]);


// Showing Page Link
{{$listings->links()}}

```

NB: For custom pagination publish the specefic vendor using "php arisan vendor:publish" and select. Look docs for more info

### 12. File Upload
In controller if called "$request->file('logo')->store()", it will store the file inside storage/app directory and return the storage location path as string.
> Change ./config/filesystem.php to apply custom file storage or making public

```php
// make html for acceptable for fie upload by using multipart tag
// then edit the listing migration table and add
$table->string('logo')->nullable();

// then from controller check if file exists then store the file
if($request->hasFile('logo')){
    $formFields['logo'] = $request->file('logo')->store('logos', 'public');
}

// Show image from view or component

src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/no-image.png') }}"
```
Check if file in storage folder as the filesystem.php config file

> To make ./storage directories file public, need to run "php artisan storage:link"

### 13. Edit Listing
```php
// as html doesn't support PUT request, laravel use @method directives

@csrf
@method('PUT')

// Then in router, we can receive the put request
Route::put('/listings/{listing}', [ListingController::class, 'update'])


// Update to accept file size more than 2MB on php.ini
```



### 14. Delete Listing
```php
<form method="POST" class="" action="/listings/{{$listing->id}}">
    @csrf
    @method('DELETE') 
    <button>Delete</button>
</form>

// then add route
// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

// then add controller method
// Delete Listing
public function destroy(Listing $listing){
    // dd($listing);
    $listing->delete();
    return redirect('/')->with('message', 'Listing Deleted Successfully');
}
```

### 15. User Registration
Laravel comes with a User Model, we just need to make the UserController by "php artisan make:controller UserController"

```php
// make changes in route to accept request
// Show Register Create Form
Route::get('/register', [UserController::class, 'create']);

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Receive routes from controller
class UserController extends Controller
{
    // Show Register From
    public function create(Request $request){
        // dd($request);
        return view('users.register');
    }

    // Store new user
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        
        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User Created and logged in');
    }
}

// Make necessery form on view
```

### 16. Auth Links
```php
// Welcome message to login user in view
@auth
Welcome {{auth()->user()->name}}
@else
// Show not logged-in message
@endauth

```


### 17. User Logout
```php
    public function logout(User $user, Request $request){
        // auth()->logout();
        auth()->logout($user);

        $request->session()->invalidate();
        $request->session()->regenerate();
        
        return redirect('/')->with('message', 'User Logged Out');
    }
```

### 18. User Login
```php
    // Authentication for login
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You\'re logged in');
        }

        return back()->withErrors(['email'=>'Invalid'])->onlyInput('email');
    }
```

### 19. Auth & Guest Middleware
```php
// make a route authentication protected
Route::get('/listings/create',[ListingController::class, 'create'])->middleware('auth');

// create a 'login' named route that can be redirected by app/Http/middleware/Authenticate.php
Route::get('/login', [UserController::class, 'login'])->name('login');

// Using guest middleware prevent logged in users access in login, register and other routes
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
```
middleware/Authenticate.php can be customized

> Modify app/Providers/RouteServiceProvider.php to change the app's default home route config by changing to "public const HOME = '/';"


### 20. Relationships


### 21. Tinker Tinkering


### 22. Add Ownership to Listings


### 23. Manage Listings Page


### 24. User Authorization 