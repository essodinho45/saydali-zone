@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateUser',['id' => $user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{ Form::hidden('user_category_id',$user->user_category_id,array('id'=>'user_category_id')) }}

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="offer_type">{{__("Name")}} *</label>
                            <div class="col-md-6">
                                    <input id="f_name" type="text" class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ $user->f_name }}" required>
    
                                    @error('f_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        @if($user->user_category_id != 1)
                        <div class="form-group row" id="s_name_div">
                            <label class="col-md-3 text-right" for="s_name">{{__("Second Name")}}</label>
                            <div class="col-md-6">
                                    <input id="s_name" type="text" class="form-control @error('s_name') is-invalid @enderror" name="s_name" value="{{ $user->s_name }}">
    
                                    @error('s_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        @endif

                        @if($user->user_category_id != 1)
                        <div class="form-group row" id="s_name_div">
                            <label class="col-md-3 text-right" for="commercial_name">{{__("Commercial Name")}}</label>
                            <div class="col-md-6">
                                    <input id="commercial_name" type="text" class="form-control @error('commercial_name') is-invalid @enderror" name="commercial_name" value="{{ $user->commercial_name }}">
    
                                    @error('commercial_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="offer_type">{{__("E-Mail Address")}} *</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="offer_type">{{__("User Name")}} *</label>
                            <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        @if($user->user_category_id == 5)
                        <div class="form-group row" id="licence_number_div">
                                <label class="col-md-3 text-right" for="offer_type">{{__("Licence Number")}} *</label>
                                <div class="col-md-6">
                                    <input id="licence_number" type="text" class="form-control @error('licence_number') is-invalid @enderror" name="licence_number" value="{{ $user->licence_number }}">
    
                                    @error('licence_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            {{-- <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label> --}}
                                <label class="col-md-3 text-right" for="offer_type">{{__("Country")}} *</label>
                                <div class="col-md-6">
                                <select class="form-control" id="country" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{ $country->ar_name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            
                                <label class="col-md-3 text-right" for="offer_type">{{__("Region")}} * / {{ __('City') }}</label>
                                <div class="col-md-3">
                                <select class="form-control" id="city" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{ $city->ar_name }}</option>
                                    @endforeach
                                </select>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                                <div class="col-md-3">
                                    <input id="region" type="text" class="form-control @error('region') is-invalid @enderror" name="region" value="{{ $user->region }}">
    
                                    @error('region')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="offer_type">{{__("Address")}}</label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $user->address }}">
    
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        
                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="offer_type">{{__("Telephone 1")}}\2</label>
                                <div class="col-md-3">
                                    <input id="tel1" type="text" class="form-control @error('tel1') is-invalid @enderror" name="tel1" value="{{ $user->tel1 }}">
    
                                    @error('tel1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="col-md-3">
                                    <input id="tel2" type="text" class="form-control @error('tel2') is-invalid @enderror" name="tel2" value="{{ $user->tel2 }}">
    
                                    @error('tel2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
    
                                <label class="col-md-3 text-right" for="offer_type">{{__("Mobile 1")}}\2</label>
                                <div class="col-md-3">
                                    <input id="mob1" type="text" class="form-control @error('mob1') is-invalid @enderror" name="mob1" value="{{ $user->mob1 }}">
    
                                    @error('mob1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="col-md-3">
                                    <input id="mob2" type="text" class="form-control @error('mob2') is-invalid @enderror" name="mob2" value="{{ $user->mob2 }}">
    
                                    @error('mob2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">        
                                <label class="col-md-3 text-right" for="offer_type">{{__("Fax 1")}}\2</label>
                                <div class="col-md-3">
                                    <input id="fax1" type="text" class="form-control @error('fax1') is-invalid @enderror" name="fax1" value="{{ $user->fax1 }}" placeholder="{{ __('Fax 1') }}">

                                    @error('fax1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <input id="fax2" type="text" class="form-control @error('fax2') is-invalid @enderror" name="fax2" value="{{ $user->fax2 }}" placeholder="{{ __('Fax 2') }}">

                                    @error('fax2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
    
                                <label class="col-md-3 text-right" for="offer_type">{{__("E-Mail Address 2")}}</label>
                                <div class="col-md-6">
                                    <input id="email2" type="email" class="form-control @error('email2') is-invalid @enderror" name="email2" value="{{ $user->email2 }}" autocomplete="email">
    
                                    @error('email2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="logo_image">{{__("Image")}}</label>
                                <div class="col-md-6">
                                     <input type="file" class="form-control-file" name="logo_image" id="logo_image">
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Save User') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
