@extends('layouts.app')

@section('content')
    @auth
    @if (Auth::user()->user_category_id == 0 || Auth::user()->id == $post->author->id)
        <div class="container py-4">
                <form action="{{route('updatePost',['id' => $post->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}">
                        </div>
                        <div class="form-group">
                                <label for="content">{{__('Content')}}</label>
                                <textarea class="form-control" rows="5" id="content" name="content">{{$post->content}}</textarea>
                        </div>
                        <!-- Input tags go here -->
                        <button class="btn btn-info" type="submit">
                            {{__("Update Post")}}
                        </button>
                </form>
                <form action="{{route('deletePost',['id' => $post->id])}}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger" type="submit">
                            {{__("Delete Post")}}
                        </button>
                </form>
        </div>
        @endif
    @endauth
@endsection