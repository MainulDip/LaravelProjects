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