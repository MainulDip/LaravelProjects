<h1> {{$heading}}</h1>
@unless (count($listings) == 0)

@foreach ($listings as $listing) 
    <h2>{{$listing['title']}}</h2>
    <p>{{$listing['description']}}</p>
@endforeach

@else
<h2>No Listing Found</h2>
@endunless

