@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Users that have favorited the most in that week:</h1>
            <ul>
                @foreach ($users as $user)
                    <li>{{ $user->name }} - favorited <b>{{$user->favorite_count}}</b> photos</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
