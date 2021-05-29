@extends('layouts.app')

@section('content')

<div class="container py-4">
            <h3 class="w-75 d-inline-block">{{__('Items')}}</h3>
            @auth
                {{-- @if (Auth::user()->user_category_id != 5)
                <button class="btn btn-info float-right" type="submit" onclick="window.location='{{route('createPost')}}'">
                    {{__("Create Post")}}
                </button>
                @endif --}}
            @endauth
                <div class="p-2">
                    @foreach ($items as $item) 
                    <div class="card mb-3 NewsCard" onclick="window.location='/items/{{$item->id}}'">
                        <div class="row no-gutters mh-200">
                            <div class="col-4">
                            @if ($item->image != null && $item->image != '')
                                <img src="{{ asset($item->image) }}" class="card-img w-50 py-4" alt="...">                                    
                            @endif
                            </div>
                            <div class="col-6">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->name}}</h5>
                                <p class="card-text">{{$item->company->f_name}}</p>
                            {{-- <p class="card-text"><small class="text-muted">{{ __('Last updated') }} {{ $post->updated_at->diffForHumans() }}</small></p> --}}
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- {{ $items->links() }} --}}
</div>

@endsection