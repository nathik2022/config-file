@extends('layouts.app')

@section('title',"Config file JSON")

@section('content')
<div class="row">
    <div class="col-8">
        <h3>Your JSON Array</h3>
        <pre>{{ $json_pretty }}</pre>
    </div>
</div>
<div class="row">
    <div class="col">
        <form class="d-inline"  id="searchJ" action="{{ route('files.search',['file'=>$file->id]) }}" method="POST">
            @csrf
            <input type="text" id="search" name="search" placeholder="search value">
            <input type="submit" value="{{ __('Search File') }}" class="btn btn-outline-primary">
        </form> 
    </div>
</div>
<script type="text/javascript">
    // $('#searchJ').submit(function (event) {
    //     event.preventDefault();
    //     var search = $("#search").val();
    // });
</script>
@endsection