<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/post.css">
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
            <div class="col-lg-8 col-md-12 left-box">
                {!! $posts->withQueryString()->links() !!}
                @foreach($posts as $key => $post)
                    <div class="card single_post">
                        <div class="body">
                            <div class="img-post">
                                <img class="d-block img-fluid w-100" src="{{ asset("storage/".$post->image) }}">
                            </div>
                            <h3>{{ $post->title }}</h3>
                            <h4>Created by {{ $post->user['name'] }}</h4>
                            <p class="post_date">{{$post->created_at }}</p>
                            <p>{!! $post->description !!}</p>
                            @if(auth()->user() && auth()->user()->id === $post->user->id)
                                <div class="footer">
                                        <form method="post" action="/posts/{{ $post->id }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <div class="actions text-end">
                                                <input type="submit" id="delete-btn" class="btn btn-danger" value="delete">
                                                <a class="btn btn-primary" href="{{ route('posts.edit', [$post->id]) }}">Edit</a>
                                            </div>
                                        </form>
                                </div>
                            @endif
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
