@extends('layouts.app')

@section('title',"Merge JSON files")

@section('content')
    <form class="d-inline" action="{{ route('files.mergeFiles') }}" onSubmit="return checkifclicked()" method="POST">
        @csrf
        @forelse ($files as $key => $file )
        <div class="row mb-3"> 
            <div class="col">
                <div class="form-check">
                    <input name="fileId[]" class="form-check-input" type="checkbox" value="{{$file->id}}" id="mergeCheckBox{{$file->id}}">
                    <label class="form-check-label" for="flexCheckDefault">
                        {{ $file->title }}
                    </label>
                </div>
            </div>
        </div>
        @empty
        <div class="row mb-3 mt-3">
            <div class="col">
                <p class="h4 text-danger fw-bold align-content-center">{{ __('No configs file avilable.') }}</p>
            </div>
        </div>
        @endforelse
        @if (count($files)>1)
        <div class="row mb-3 mt-3">
            <input type="text" id="title" name="title" required placeholder="Merged file title">
        </div>
        <div class="row mb-3 mt-3">
            <input type="submit" value="{{ __('Merge Files') }}" class="btn btn-outline-info">
        </div>    
        @endif      
    </form> 
@endsection

<script type="text/javascript">
    function checkifclicked()
    {
        var checkboxs=document.getElementsByName("fileId");
        var okay=false;
        if($('input[type="checkbox"]:checked').length == 2){
            okay=true; 
        }
        if(!okay){
            alert("Please check at least two checkbox");
            return false;
        }
    }
</script>