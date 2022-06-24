@extends('layouts.app')

@section('content')
    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="card-body">
                            <a class="btn btn-close" href="{{ route('posts.index') }}"></a>
                            <div class="img-post">
                                <img class="d-block img-fluid w-100" src="{{ asset("storage/".$post->image) }}">
                            </div>
                            <form method="post" action="{{ route('posts.update', [$post->id]) }}" class="post-form" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="footer">
                                    <div class="row pt-3">
                                        <label>Title</label>
                                        <input class="form-control" type="text" name="title" value="{{$post->title}}">
                                    </div>
                                    <div class="row pt-3">
                                        <label>Description</label>
                                        <textarea id="mytextarea" name="description" placeholder="Hello, this is my post">{{$post->description}}</textarea>
                                    </div>
                                    <div class="actions text-end pt-5">
                                        <input type="file" class="my-pond" name="image" accept="image/png, image/jpeg, image/jpg"/>
                                        <input class="btn btn-success" type="submit" value="update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
