@extends('layouts.app')

@section('content')
    @auth
        <div class="container py-4">
                <form action="{{route('storePost')}}" method="POST">
                        @csrf
                        <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                                <label for="content">{{__('Content')}}</label>
                                <textarea class="form-control" rows="5" id="content" name="content"></textarea>
                        </div>
                        <!-- Input tags go here -->
                        <button class="btn btn-info" type="submit">
                            {{__("Save Post")}}
                        </button>
                </form>
                {{-- <form action="{{route('deletePost',['id' => $post->id])}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger" type="submit">
                            {{__("Delete Post")}}
                        </button>
                </form> --}}
        </div>
    @endauth
@endsection