<div {{$attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6'])}}>
{{$slot}}
<h1>Other than slot: {{$something}}</h1>
</div>