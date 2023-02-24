@extends('layouts.app')

@section('title',"File upload")


@section('content')
<form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="title">{{ __('Title') }}</label>
        <input id="title" type="text" name="title" class="form-control" value="">
    </div>
    <div class="form-group">
        <label for="config">{{ __('Upload Config Files') }}</label>
        <input id="config" type="file" name="config" class="form-control-file">
    </div>
    <div>
        <input type="submit" value="{{ __('Upload') }}" class="btn btn-primary btn-block">
    </div>
    {{-- @error
    @enderror --}}
    @if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
        
</form>



@endsection