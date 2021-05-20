@extends('layouts.app')

@section('content')

<div class="container py-4">
            <h2>{{$post->title}}</h2>            
            <small class="text-muted">{{ __('Last updated') }} {{ $post->updated_at->diffForHumans() }}</small>
            <br>
                <div class="p-2">
                    <div>
                        <p>
                            {{$post->content}}
                        </p>
                        <span>{{ __('Posted By: ') }}<i>{{$post->author->f_name}}&nbsp;{{$post->author->s_name}}</i> .</span>
                    </div>
                    {{-- @foreach ($posts as $post)
                    <div class="card mb-3">
                        <div class="row no-gutters mh-200">
                            <div class="col-md-4">
                            <img src="{{ asset($post->author->logo_image) }}" class="card-img w-50 py-4" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$post->author->f_name}}</h5>
                                <p class="card-text">{{$post->title}}</p>
                            <p class="card-text"><small class="text-muted">{{ __('Last updated') }} {{ $post->updated_at->diffForHumans() }}</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach --}}
                </div>
                @auth
                    @if (Auth::user()->user_category_id == 0 || Auth::user()->id == $post->author->id)
                        <form action="{{route('deletePost',['id' => $post->id])}}" method="POST" class="mt-2 float-right">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <a class="btn btn-secondary" href="{{ route('editPost', ['id'=>$post->id]) }}">{{__('Edit')}}</a>
                                <button class="btn btn-danger" type="submit">
                                    {{__("Delete Post")}}
                                </button>
                        </form>
                    @endif
                @endauth
</div>

@endsection