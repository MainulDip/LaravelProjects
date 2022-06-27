## Laravel Quick Docs:
After the setup with composer.

### Routing:

1. routes/web.php
    It's for web + frontend routing

```php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function(){
    return response("Hello World", 200)
    -> header('Content-Type', 'text/plain')
    -> header('foo', 'bar');
});

// http://localhost:8000/post/12
Route::get('/post/{id}', function($id){
    // ddd($id); // die and dump and debug
    return response('Post '. $id);
}) -> where('id', '[0-9]+'); // checking url params by regex

// localhost:8000/search?name=SomeName&city=Where
Route::get('/search', function (Request $request) {
    echo $request->name . " " . $request->city;
    dd($request);
});
```

2. routes/api.php
    API focused routing

```php
    // localhost:8000/api/posts
Route::get('/posts', function(){
    return response()->json([
        'posts' => [
            [
                'title' => 'Fist Post',
                'body' => 'Some Description First'
            ],
            [
                'title' => 'Second Post',
                'body' => 'Second Description'
            ]
        ]
    ]);
});
```
3. channels.php
4. console.php

### Sending Data From Route to View:
```php
// routes/web.php
Route::get('/', function () {
    return view('listing', [
        'heading' => 'Latest Listing',
        'Listings' => [
            [
                'id' => 1,
                'title' => 'Listing One',
                'description' => 'Some Description Goes here',
            ],
            [
                'id' => 2,
                'title' => 'Listing Two',
                'description' => 'Second Description Goes here',
            ],
        ],
    ]);
});

// resources/views/listing.php
<h1> <?php echo $heading; ?> </h1>
<?php foreach ($listings as $listing): ?>
    <h2><?php echo $listing['title']; ?> </h2>
    <p><?php echo $listing['description']; ?> </p>
<?php endforeach; ?>

// Utilizing blade templating to reduce extra markup
// resources/views/listing.blade.php
<h1> {{$heading}}</h1>
@foreach ($listings as $listing) 
    <h2>{{$listing['title']}}</h2>
    <p>{{$listing['description']}}</p>
@endforeach
// directive starts with @ sign
// there is also @php raw php @endphp
```


### Blade Templating:
```php
@if(count($listing) == 0)
<p> No Listing Found </p>
@endif

// unless directive
@unless (count($listings) == 0)

@foreach ($listings as $listing) 
    <h2>{{$listing['title']}}</h2>
    <p>{{$listing['description']}}</p>
@endforeach

@else
<h2>No Listing Found</h2>
@endunless
```

### Model/Database Mapper:
Laravel use Eloqoent ORM (Object Relational Mapper with database)
Model Name Should Be Singular

```php
// Defining Model Manualy
namespace App\Models;

class Listing
{
    public static function all()
    {
        return [
            [
                'id' => 1,
                'title' => 'Listing One',
                'description' => 'Some Description Goes here',
            ],
            [
                'id' => 2,
                'title' => 'Listing Two',
                'description' => 'Second Description Goes here',
            ],
        ];
    }

    public static function find($id)
    {
        $listings = self::all();

        foreach ($listings as $listing) {
            if ($listing['id'] == $id) {
                return [$listing];
            }
        }
    }
}

// Using Model
use App\Models\Listing;
// call the method (static)
'listings' => Listing::all()
'listings' => Listing::find($id)
```


### Migration: Table name singular
To create a table named "listings" in database/migrations queue
> php artisan make:migration create_listings_table || Table name "plural + lowercase"

```bash
php artisan migrate || migrate:fresh
```

### Seeding & Factory:
To quickly create Fake data for testing. Uncomment "\App\Models\User::factory(10)->create();" From database/seeders/DatabaseSeeder.php and run
> php artisan db:seed || This will populate the database user table

Note: factory method is comming from database/factories/UserFactory.php
Delete the seed/factory data: php artisan migrate:refresh
Migrate with seed/factory data: php artisan migrate --seed

### Automatic Model Creation:
```bash
php artisan make:model Listing
```
NB: Model is Singular and Capitalize

### Add Fake Data Using Seed:
```php
// database/seeders/DatabaseSeeder.php
\App\Models\User::factory(10)->create();
Listing::create(
    [
        'title' => 'Laravel Senior Developer', 
        'tags' => 'laravel, javascript',
        'company' => 'Acme Corp',
        'location' => 'Boston, MA',
        'email' => 'email1@email.com',
        'website' => 'https://www.acme.com',
        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam minima et illo reprehenderit quas possimus voluptas repudiandae cum expedita, eveniet aliquid, quam illum quaerat consequatur! Expedita ab consectetur tenetur delensiti?'
    ]
);
```
> Then run "php artisan migrate:refresh --seed"

### Factory:
cmd: php artisan make:factory ListingFactory || this will create a ListingFactory class inside database/factories

Write factory method for ListingFactory inside database/factories/Listingfactory.php
```php
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'tags' => 'laravel, api, backend',
            'company' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(7)
        ];
    }
}
```
Then call the factory method from inside run method of database/seeders/DatabaseSeeder.php
```php
Listing::factory(7)->create();
```
Then run: php artisan migrate:refresh --seed

### Layout Creation:
To maintain no-repetation (DRY), laravel use @yield(), @extends(), @section directives as follow.
```php
@yield('content') // inside layout.blade.php
```
```php
// inside other view files
@extends('layout') // this to mark as layout.blade.php file's extender

@section('content') // between this is marked as content for @yield('content) section
@endsection
```

### Partials in View:
Partials are another way of including chunk of blade code into another view

```bash
# creating partials inside resources/view
mkdir partials && cd partials && touch _filename.blade.php
# convention is to prefix partials name with "_" underscore
# put any html php or blade code there and 
```

### Route Model Binding:
Minimize boilerplate code using Eloquents "Route Model Binding"
```php
// Single Listing without Route Model Binding
Route::get('/listing/{id}', function ($id) {
    $single_listing = Listing::find($id);

    if ($single_listing) {
        return view('listing', [
            'heading' => 'Latest Listing',
            'listing' => $single_listing,
        ]);
    } else {
        abort('404');
    }
});

// Using Route Model Binding Single Listing
Route::get('/listing/{listing}', function(Listing $listing){
    // get's url param {listing} should match actions function's param variable (Model $listing)
    return view('listing', [
        'heading' => 'Latest Listing',
        'listing' => $listing
    ]);
});
```

### Eloquont Model Collection:
> $listing['title'] could be $listing->title

### Global helpers:
asset helper : {{asset('images/logo.png')}}
> https://laravel.com/docs/9.x/helpers

### Componets, slot and Props Binding:
create manually inside resources/views/components directory or to create class based component use "php artisan make:component ComponentName" or withind subdirectories "php artisan make:component Forms/Input"

for anonymous component use "php artisan make:component forms.input --view", The command above will create a Blade file at resources/views/components/forms/input.blade.php which can be rendered as a component via <x-forms.input />.

components are automatically discovered within the app/View/Components directory and resources/views/components directory, so no component registration is required. But outside this directories, need registering in App/Providers/AppServiceProvider.php 's boot method.
Docs: https://laravel.com/docs/9.x/blade#components
```php
# create component folders and put our required props inside @props directive
@props(['propsname'])
// ...php/blade code
```
Including Component:
```php
@foreach ($listings as $listing)
 <x-listing-card :listing="$listing" />
 # for passing variable use ":" colon before propsname (variable binding)
@endforeach
```


### Component inside Component || Slot and Other:
Note: attributes merging
```php
// component of container component
<div {{$attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6'])}}>
{{$slot}}
<h1>Other than slot: {{$something}}</h1>
</div>


// listing-card || Componetn container
<x-card>
    <x-slot name="something">
        Hello {{-- this will the value of the $something --}}
    </x-slot>
    <x-slot name="slot"> {{-- this is optional as its the default senario --}}
    <div>
        This div will be replaced with the $slot variable
    </div>
</x-card>

// from view we can use card component separately
<x-component-name class="class will me merged">

// also we can use listing-card component which also includes the card component. Pass props, etc
<x-listing-card :listing="$listing" />

```

### Controlller:
"php artisan make:controller ControllerName" will create the controller class into app/Http/Controllers . The naming convension is CamelCase

```php
// route to controller

// All Listings
Route::get('/', [ListingController::class, 'index']);

// Single Listing Route Model Binding Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// app/Http/Controllers/ListingController.php
class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listings', [
            'heading' => 'Latest Listing',
            'listings' => Listing::all(),
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listing', [ // if views in subfolder then use "." for navigating like "directory.filename"
            'heading' => 'Latest Listing',
            'listing' => $listing
        ]);
    }
}
```

### Dependancy Injection Inside Controller:
```php
public function index(Request $request) {
        dd($request);
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => Listing::all(),
        ]);
    }
```

### Custom Model Function:
```php
// Controller Function
// Show all listings
    public function index(Request $request) {
        // dd($request);
        return view('listings.index', [
            'heading' => 'Latest Listing',
            'listings' => Listing::latest()->filter(
                request(['tag'])
            )->get(),
        ]);
    }

// Model -> Listing
public function scopefilter($query, array $filters){
        // dd($filters);
        if($filters['tag'] ?? false){
            // request() method is global
            $query->where('tags', 'like', '%' . request('tag'). '%'); 
        }
    }
```
NB: See docs for model method chaining or whatever like this

> Next: See the LaravelMinDoc2.md or official docs and also Relational Models