@extends('layouts.app')

@section('content')
<div id="main-content" class="blog-page">
    <div class="container">
        <div class="row clearfix">
            @if (session('status'))
                @if (session('status') === 'error')
                    <div class="alert alert-danger" role="alert">
                        {{ session('message') }}
                    </div>
                @elseif (session('status') === 'success')
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
            @endif
        </div>
        <div class="row clearfix">
            @if (count($posts) < 1)
                <a href="{{ route('home') }}" id="first_post" class="btn btn-success text-white mt-5">
                    Create post your first post
                </a>
            @endif
            <div class="col-lg-8 col-md-12 left-box">
                {!! $posts->withQueryString()->links() !!}
                @foreach($posts as $key => $post)
                    <div class="card single_post">
                        <div class="body">
                            @if(auth()->user() && auth()->user()->id === $post->user->id)
                                <div class="footer">
                                    <form method="post" action="/posts/{{ $post->id }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete" />
                                        <div class="actions text-end">
                                            <input type="submit" id="delete-btn" class="btn btn-danger" value="Delete">
                                            <a class="btn btn-primary" href="{{ route('posts.edit', [$post->id]) }}">Edit</a>
                                        </div>
                                    </form>

                                </div>
                            @endif
                            <div class="row">
                                @if(isset($post->images[0]))
                                    <img class="d-block img-fluid w-100" src="{{ asset("storage/".$post->images[0]->title) }}">
                                @endif
                            </div>
                            <h3>{{ $post->title }}</h3>
                            <h4>Created by {{ $post->user->name }}</h4>
                            <p class="post_date">{{$post->created_at }}</p>
                            <p>{!! $post->short_description !!}...</p>
                            <a href="{{ route('posts.show', [$post->id]) }}" type="submit" id="read-btn" class="btn btn-success d-block">Read</a>
                            <a class="twitter-share-button d-block mt-5 text-end" href="https://twitter.com/intent/tweet?text={{ $post->title }}">Tweet</a>
                        </div>
                    </div>
                @endforeach
            </div>
            {!! $posts->withQueryString()->links() !!}
        </div>
    </div>
</div>
@endsection
{{--<script>--}}
{{--    $("#delete-btn").click(function (){--}}
{{--        console.log(123);--}}
{{--    })--}}
{{--</script>--}}
