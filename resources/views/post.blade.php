@extends('layouts.app')

@section('content')
    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="card-body">
                            <a class="btn btn-close" href="{{ route('posts.index') }}"></a>
                            <h3>{{$post->title}}</h3>
                            <div class="img-post d-flex">
                                @foreach($post->images as $key => $image)
                                    <div class=" @if($key === 0) w-100 @else w-25 @endif m-2 text-end">
                                        <img class="d-flex img-fluid w-100" src="{{ asset("storage/".$image->title) }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="footer">
                                <div class="row pt-3">
                                    {!! $post->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
