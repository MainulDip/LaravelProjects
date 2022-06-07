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
// Defining Model
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


### Artisan Commands:
