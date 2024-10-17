@extends('layouts.main')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p class="text-muted">Published at: {{ Carbon::parse($post->published_at ?? $post->created_at)->format('d-m-Y') }}</p>

        <div class="content">
            {!! nl2br(e($post->content)) !!}
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
    </div>
@endsection
