@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>The latest favorite photos:</h1>
            <div class="gallery">
                @foreach ($photos as $photo)
                    <div class="gallery-panel">
                            <img src="{{ $photo->thumbnailUrl }}"/>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
