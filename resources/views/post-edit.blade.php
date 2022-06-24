<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/post.css">
@extends('layouts.app')

@section('content')
    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="card-body">
                            <a class="btn btn-close" href="{{ route('home') }}"></a>
                            <div class="img-post">
                                <img class="d-block img-fluid w-100" src="{{ asset("storage/".$post->image) }}">
                            </div>
                            <form method="POST" action="{{ route('posts.update', [$post->id]) }}" class="post-form" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="footer">
                                    <div class="row pt-3">
                                        <label>Title</label>
                                        <input type="text" name="title" value="{{$post->title}}">
                                    </div>
                                    <div class="row pt-3">
                                        <label>Description</label>
                                        <textarea id="description" name="description" >{{$post->description}}</textarea>
                                    </div>
                                    <div class="actions text-end pt-5">
                                        <input type="file" name="image" accept="image/png, image/jpeg">
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
    <script>
        tinymce.init({
            selector: 'description'
        });
    </script>
@endsection
