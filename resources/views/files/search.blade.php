@extends('layouts.app')

@section('title','Search Result')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <p class="h3 text-bold">{{ __('Your JSON Array:') }}</p>
            <pre>{{ $json_pretty }}</pre>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <p class="h3 text-bold">{{ __('Your Search String:') }}</p>
            <p class="h4 text-bold">{{ $search_string }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="h3 text-bold">{{ __('Your Search Result:') }}</p>
            <p class="h4 text-bold font-italic">{{$search_result }}</p>
        </div>
    </div>
</div>


@endsection