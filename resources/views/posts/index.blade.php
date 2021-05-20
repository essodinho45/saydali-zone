@extends('layouts.app')

@section('content')

<div class="container py-4">
            <h3 class="w-75 d-inline-block">{{__('News')}}</h3>
            @auth
                @if (Auth::user()->user_category_id != 5)
                <button class="btn btn-info float-right" type="submit" onclick="window.location='{{route('createPost')}}'">
                    {{__("Create Post")}}
                </button>
                @endif
            @endauth
                <div class="p-2">
                    @foreach ($posts as $post) 
                    <div class="card mb-3 NewsCard" onclick="window.location='/news/{{$post->id}}'">
                        <div class="row no-gutters mh-200">
                            <div class="col-4">
                            <img src="{{ asset($post->author->logo_image) }}" class="card-img w-50 py-4" alt="...">
                            </div>
                            <div class="col-6">
                            <div class="card-body">
                                <h5 class="card-title">{{$post->author->f_name}}&nbsp;{{$post->author->s_name}}</h5>
                                <p class="card-text">{{$post->title}}</p>
                            <p class="card-text"><small class="text-muted">{{ __('Last updated') }} {{ $post->updated_at->diffForHumans() }}</small></p>
                            </div>
                            </div>
                            @auth
                                <div class="col-2">
                                    @if (Auth::user()->user_category_id == 0 || Auth::user()->id == $post->author->id)
                                        <a class="btn btn-secondary" href="{{ route('editPost', ['id'=>$post->id]) }}" style="margin-top:40%">{{__('Edit')}}</a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $posts->links() }}
</div>

@endsection