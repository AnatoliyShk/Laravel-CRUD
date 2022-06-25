@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create post') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
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
                    <form method="post" action="{{ route('posts.store') }}" class="post-form" enctype="multipart/form-data">
                        @csrf
                        <input class="mb-4 form-control" type="text" name="title" placeholder="Enter title to your post">
                        <textarea id="mytextarea" name="description" placeholder="Hello, this is my post"></textarea>
                        <div class="actions text-end pt-3">
                            <input type="file" class="my-pond" name="image[]" accept="image/png, image/jpeg, image/jpg" multiple/>
                            <input class="btn btn-success" type="submit" value="create">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
