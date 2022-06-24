@extends('layouts.app')

@section('content')
    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="card-body">
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
                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul class="list-unstyled">
                                        @foreach($errors->all() as $error)
                                            <li> {{ $error }} </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <a class="btn btn-close" href="{{ route('posts.index') }}"></a>
                            <div class="img-post d-flex">
                                @foreach($post->images as $key => $image)
                                    <div class="w-25 m-2 text-end">
                                        <img class="d-flex img-fluid w-100" src="{{ asset("storage/".$image->title) }}">
                                        <form method="post" action="/images/{{ $image->id }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <input type="submit" class="btn btn-close text-end" value=""/>
                                        </form>
                                    </div>
                                @endforeach
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
                                        <input type="file" class="my-pond" name="image[]" accept="image/png, image/jpeg, image/jpg" multiple>
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
