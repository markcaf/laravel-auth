@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('created'))
            <div class="col-12 alert alert-success">
                "{{ session('created') }}" has been successfully created.
            </div>
        @endif

        @if (session('edited'))
            <div class="col-12 alert alert-success">
                "{{ session('edited') }}" has been successfully edited.
            </div>
        @endif
        
        <h2 class="my-3">{{ $post->title }}</h2>

        <div class="row">
            <div class="col-4">
                <img class="img-fluid" src="{{ $post->post_image }}" alt="{{ $post->title }}">
            </div>
            <div class="col-8">
                <p>{{ $post->post_content }}</p>
                <p><strong>Author:</strong> {{ $post->author }}</p>
                <p><strong>Post Date:</strong> {{ $post->post_date }}</p>
            </div>
        </div>
    </div>
@endsection
