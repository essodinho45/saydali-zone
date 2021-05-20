@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('User Information')}}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="img-sq">
                                <img class="img-fluid rounded-circle m-2" src="{{ asset($user->logo_image) }}">
                            </div>
                        </div>
                        <div class="col-8">
                            <h1>
                                {{$user->f_name}}&nbsp;{{$user->s_name}}
                            </h1>
                            <hr>
                            @if($user->tel1 != null) <h5><i class="fas fa-phone mr-3"></i>{{$user->tel1}}&nbsp;@if($user->tel2 != null)- {{$user->tel2}} @endif </h5> @endif
                            @if($user->mob1 != null) <h5><i class="fas fa-mobile-alt mr-4"></i>{{$user->mob1}}&nbsp;@if($user->mob2 != null)- {{$user->mob2}} @endif </h5> @endif
                            @if($user->fax1 != null) <h5><i class="fas fa-fax mr-3"></i>{{$user->fax1}}&nbsp;@if($user->fax2 != null)- {{$user->fax2}} @endif </h5> @endif
                            <h5><i class="fas fa-at mr-3"></i>{{$user->email}}&nbsp;@if($user->email2 != null)- {{$user->email2}} @endif </h5>
                            <h5><i class="fas fa-map-marker-alt mr-4"></i>{{$user->itsCountry->ar_name}}&nbsp;-&nbsp;{{$user->itsCity->ar_name}}@if($user->region != null)&nbsp;-&nbsp;{{$user->region}}@endif @if($user->address != null)&nbsp;-&nbsp;{{$user->address}}@endif </h5>
                        </div>

                    </div>
                    @auth
                    @if($user->user_category_id == 2 && Auth::user()->category->id == 0)
                    <hr>
                    <form method="POST" action="/addDist/{{$user->id}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="dist">{{__("Distributor")}} *</label>
                                <div class="col-md-6">
                                    <select class="form-control w-100" id="dist" class="form-control @error('dist') is-invalid @enderror" name="dist" value="{{ old('dist') }}" required>
                                        @foreach($dists as $dist)
                                        <option value="{{$dist->id}}">{{ $dist->f_name }}&nbsp; @if($dist->s_name){{$dist->s_name}}@endif </option>
                                        @endforeach
                                    </select>
                                    @error('dist')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    @if(Auth::user()->category->id == 0)
                    <hr>
                        @if($user->email_verified_at == null)
                            <a class="btn btn-info float-right mx-1" id="verBtn{{$user->id}}" href="#" onclick="verUsrAjax({{$user->id}})">{{__('Verify')}}</a>
                        @endif
                        @if($user->user_category_id != 0)
                            @if($user->freezed == false)
                                <a class="btn btn-danger float-right mx-1" id="frzUsrBtn{{$user->id}}" href="#" onclick="frzUsrAjax({{$user->id}})">{{__('Freeze')}}</a>
                            @elseif($user->freezed == true)
                                <a class="btn btn-secondary float-right mx-1" id="unfrzUsrBtn{{$user->id}}" href="#" onclick="unfrzUsrAjax({{$user->id}})">{{__('Unfreeze')}}</a>
                            @endif
                            @if($user->items->count()==0
                            && $user->ordersFromUser->count()==0
                            && $user->ordersToUser->count()==0
                            && $user->cartsFromUser->count()==0
                            && $user->cartsToUser->count()==0
                            && $user->posts->count()==0
                            && $user->offers->count()==0
                            && $user->quantities->count()==0
                            && $user->baskets->count()==0)
                                <form action="{{route('deleteUser',['id' => $user->id])}}" method="POST" class="d-inline-block float-right mx-1">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger mx-1" type="submit">
                                        {{__("Delete")}}
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endif
                    @if((Auth::user()->category->id == 1 || Auth::user()->category->id == 2) && $user->parents->contains(Auth::user()->id))
                        <hr>
                        @if(Auth::user()->category->id == 1)
                            @if($user->category->id == 2)
                                @if (!$user->parents->isEmpty())
                                    @if(!$user->parents->where('id',Auth::user()->id)->first()->pivot->verified)                                    
                                        <a class="btn btn-secondary float-right mx-1" id="verifyBtn{{$user->id}}" href="#" onclick="verifyRelAjax({{$user->id}})">{{__('Verify')}}</a>
                                    @else
                                        <a class="btn btn-secondary btn-disabled disabled float-right mx-1" href="#">{{__('Verified')}}</a>
                                    @endif
                                    @if(!$user->parents->where('id',Auth::user()->id)->first()->pivot->freezed)
                                        <a class="btn btn-danger float-right mx-1" id="freezeBtn{{$user->id}}" href="#" onclick="freezeRelAjax({{$user->id}}, true)">{{__('Freeze')}}</a>
                                    @else
                                        <a class="btn btn-info float-right mx-1" id="freezeBtn{{$user->id}}" href="#" onclick="freezeRelAjax({{$user->id}}, false)">{{__('Unfreeze')}}</a>
                                    @endif
                                @endif
                            @endif
                        @endif
                        @if(Auth::user()->category->id == 2)
                            @if($user->category->id == 3)
                                @if (!$user->parents->isEmpty())
                                    @if(!$user->parents->where('id',Auth::user()->id)->first()->pivot->verified)
                                        <a class="btn btn-secondary float-right mx-1" id="verifyBtn{{$user->id}}" href="#" onclick="verifyRelAjax({{$user->id}})">{{__('Verify')}}</a>
                                    @else
                                        <a class="btn btn-secondary btn-disabled disabled float-right mx-1" href="#">{{__('Verified')}}</a>
                                    @endif
                                    @if(!$user->parents->where('id',Auth::user()->id)->first()->pivot->freezed)
                                        <a class="btn btn-danger float-right mx-1" id="freezeBtn{{$user->id}}" href="#" onclick="freezeRelAjax({{$user->id}}, true)">{{__('Freeze')}}</a>
                                    @else
                                        <a class="btn btn-info float-right mx-1" id="freezeBtn{{$user->id}}" href="#" onclick="freezeRelAjax({{$user->id}}, false)">{{__('Unfreeze')}}</a>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                    @if( in_array(Auth::user()->category->id, [2,3,4]))                            
                    <hr>
                        @if(Auth::user()->category->id == 4)
                            @if($user->category->id != 5)
                                @if (!$user->children->isEmpty() && $user->children->contains('id', Auth::user()->id))
                                    @if(!$user->children->where('id',Auth::user()->id)->first()->pivot->freezed)
                                        <a class="btn btn-danger float-right mx-1" id="freezeBtn{{$user->id}}" href="#" onclick="freezeRelAjax({{$user->id}}, true)">{{__('Freeze')}}</a>
                                    @else
                                        <a class="btn btn-info float-right mx-1" id="freezeBtn{{$user->id}}" href="#" onclick="freezeRelAjax({{$user->id}}, false)">{{__('Unfreeze')}}</a>
                                    @endif
                                @else
                                    <a class="btn btn-secondary float-right mx-1" id="addBtn{{$user->id}}" href="#" onclick="addParentAjax({{$user->id}})">{{__('Add')}}</a>
                                @endif
                            @endif
                        @endif
                        @if(Auth::user()->category->id == 2)
                            @if($user->category->id == 1)
                                @if (!$user->children->isEmpty() && $user->children->contains('id', Auth::user()->id))
                                    @if(!$user->children->where('id',Auth::user()->id)->first()->pivot->verified)
                                        <a class="btn btn-secondary btn-disabled disabled float-right mx-1" href="#">{{__('Requested')}}</a>
                                    @else
                                        <a class="btn btn-secondary btn-disabled disabled float-right mx-1" href="#">{{__('Verified')}}</a>
                                    @endif
                                @else
                                    <a class="btn btn-secondary float-right mx-1" id="reqBtn{{$user->id}}" href="#" onclick="reqRelAjax({{$user->id}})">{{__('Request')}}</a>
                                @endif
                            @endif
                        @endif
                        @if(Auth::user()->category->id == 3)
                            @if($user->category->id == 2)
                                @if (!$user->children->isEmpty() && $user->children->contains('id', Auth::user()->id))
                                    @if(!$user->children->where('id',Auth::user()->id)->first()->pivot->verified)
                                        <a class="btn btn-secondary btn-disabled disabled float-right mx-1" href="#">{{__('Requested')}}</a>
                                    @else
                                        <a class="btn btn-secondary btn-disabled disabled float-right mx-1" href="#">{{__('Verified')}}</a>
                                    @endif
                                @else
                                    <a class="btn btn-secondary float-right mx-1" id="reqBtn{{$user->id}}" href="#" onclick="reqRelAjax({{$user->id}})">{{__('Request')}}</a>
                                @endif
                            @endif
                        @endif
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
