@extends('layouts.app')

@section('title',"Config Files")

@section('content')
@forelse ($files as $key => $file )
<div class="row mb-3"> 
    <div class="col-8">
        <h3>
            <a class="h3 text-success fw-bold" href="{{ route('files.show',['file' => $file->id]) }}">{{ $file->title }}</a>
        </h3>
        <p class="text-muted">
         {{ __('Added') }} {{ $file->created_at->diffForHumans() }}   
        </p>
    </div>
    <div class="col-4">
        <form class="d-inline" action="{{ route('files.destroy',['file' => $file->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="{{ __('Delete File') }}" class="btn btn-danger">
        </form>         
    </div>
</div>
@empty
<div class="row mb-3 mt-3">
    <div class="col">
        <p class="h4 text-danger fw-bold align-content-center">{{ __('No configs file available.') }}</p>
    </div>
</div>
@endforelse

@endsection
