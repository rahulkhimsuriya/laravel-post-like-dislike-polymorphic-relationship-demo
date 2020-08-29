@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @forelse($posts as $post)
            @include('posts._post', ['post' => $post])
        @empty
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">No Posts</div>

                <div class="card-body">
                    There're not posts in database.
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
