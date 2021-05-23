@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12 d-none" id="register_type">
            <div class="card-deck">
                <div class="card bg-lightkiwi" id="phCard">
                        <div class="card-header"><h3>{{ __('Pharmacist') }}</h3></div>
        
                        <div class="card-body">
                                <img class="w-100 p-4" src="{{ asset('images/pill.png') }}">
                        </div>
                </div>
                <div class="card bg-lightkiwi" id="adCard">
                        <div class="card-header"><h3>{{ __('Agent/Distrbutor') }}</h3></div>
        
                        <div class="card-body">
                                <img class="w-100 p-4" src="{{ asset('images/first-aid-kit.png') }}">
                        </div>
                </div>
                <div class="card bg-lightkiwi" id="coCard">
                        <div class="card-header"><h3>{{ __('Company') }}</h3></div>
        
                        <div class="card-body">
                                <img class="w-100 p-4" src="{{ asset('images/hospital.png') }}">
                        </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-8" id="register_form">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Register') }}</div>

                <div class="card-body">
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <form method="POST" @if(\Route::currentRouteName() == 'register') action="{{ route('register') }}" @else action="{{ route('createUser') }}" @endif enctype="multipart/form-data">
                        @csrf
                        @auth
                            @if(!(Auth::user()->category->id == 2 || Auth::user()->category->id == 1))
                                {{Form::hidden('user_category_id','1',array('id'=>'user_category_id'))}}
                            @else
                                @if(Auth::user()->category->id == 1)
                                    {{Form::hidden('user_category_id','2',array('id'=>'user_category_id'))}}
                                @endif
                                @if(Auth::user()->category->id == 2)
                                    {{Form::hidden('user_category_id','3',array('id'=>'user_category_id'))}}
                                @endif
                            @endif
                        @endauth
                        <div class="form-group row" id="category_div">                            
                            {{-- <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label> --}}
                            <label class="col-md-3 text-right" for="user_category_id">{{__("Category")}} *</label>                            
                            @guest
                            {{Form::hidden('user_category_id','1',array('id'=>'user_category_id'))}}
                                <div class="col-md-6">
                                    <select class="form-control" id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" onchange="catChange()">
                                        <option value="1" @if(old('category') == 1) selected @endif>{{ __('Company') }}</option>
                                        <option value="2" @if(old('category') == 2) selected @endif>{{ __('Agent') }}</option>
                                        {{-- <option value="3" @if(old('category') == 3) selected @endif>{{ __('Distrbutor') }}</option> --}}
                                        <option value="4" @if(old('category') == 4) selected @endif>{{ __('Free Distrbutor') }}</option>
                                        <option value="5" @if(old('category') == 5) selected @endif>{{ __('Pharmacist') }}</option>
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endguest
                            @auth
                                @if(!(Auth::user()->category->id == 2 || Auth::user()->category->id == 1))
                                <div class="col-md-6">
                                    <select class="form-control" id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" onchange="catChange(true)">
                                        <option value="1" @if(old('category') == 1) selected @endif>{{ __('Company') }}</option>
                                        <option value="2" @if(old('category') == 2) selected @endif>{{ __('Agent') }}</option>
                                        <option value="3" @if(old('category') == 3) selected @endif>{{ __('Distrbutor') }}</option>
                                        <option value="4" @if(old('category') == 4) selected @endif>{{ __('Free Distrbutor') }}</option>
                                        <option value="5" @if(old('category') == 5) selected @endif>{{ __('Pharmacist') }}</option>
                                        <option value="0" @if(old('category') == 0) selected @endif>{{ __('Admin') }}</option>
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @else
                                <div class="col-md-6">
                                    <select class="form-control disabled" id="category" class="form-control" name="category" disabled>
                                        @if(Auth::user()->category->id == 1)
                                        <option value="2">{{ __('Agent') }}</option>
                                        @endif
                                        @if(Auth::user()->category->id == 2)
                                        <option value="3">{{ __('Distrbutor') }}</option>
                                        @endif
                                    </select>
                                </div>
                                @endif
                            @endauth
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="f_name">{{__("Name")}} *</label>
                                <div class="col-md-6">
                                    <input id="f_name" type="text" class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ old('f_name') }}" required>
    
                                    @error('f_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        
                        <div class="form-group row @auth @if(!(Auth::user()->category->id == 2 || Auth::user()->category->id == 1)) d-none @endif @endauth" id="s_name_div">
                            <label class="col-md-3 text-right" for="s_name">{{__("Second Name")}}</label>
                            <div class="col-md-6">
                                    <input id="s_name" type="text" class="form-control @error('s_name') is-invalid @enderror" name="s_name" value="{{ old('s_name') }}">
    
                                    @error('s_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row @auth @if(!(Auth::user()->category->id == 2 || Auth::user()->category->id == 1)) d-none @endif @endauth" id="commercial_name_div">
                            <label class="col-md-3 text-right" for="commercial_name">{{__("Commercial Name")}}</label>
                            <div class="col-md-6">
                                    <input id="commercial_name" type="text" class="form-control @error('commercial_name') is-invalid @enderror" name="commercial_name" value="{{ old('commercial_name') }}">
    
                                    @error('commercial_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="email">{{__("E-Mail Address")}} *</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="user">{{__("User Name")}} *</label>
                            <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        
                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="password">{{__("Password")}} *</label>
                            <div class="col-md-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            <div class="col-md-3">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                            </div>
                        </div>
                        @guest
                            <div class="form-group row d-none" id="licence_number_div">
                                <label class="col-md-3 text-right" for="licence_number">{{__("Licence Number")}} *</label>
                                <div class="col-md-6">
                                        <input id="licence_number" type="text" class="form-control @error('licence_number') is-invalid @enderror" name="licence_number" value="{{ old('licence_number') }}">
        
                                        @error('licence_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                        @endguest
                        @auth
                            @if(!(Auth::user()->category->id == 2 || Auth::user()->category->id == 1))
                            <div class="form-group row d-none" id="licence_number_div">
                                <label class="col-md-3 text-right" for="licence_number">{{__("Licence Number")}} *</label>
                                <div class="col-md-6">
                                        <input id="licence_number" type="text" class="form-control @error('licence_number') is-invalid @enderror" name="licence_number" value="{{ old('licence_number') }}">
        
                                        @error('licence_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                            @endif
                        @endauth

                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="country">{{__("Country")}} *</label>
                                <div class="col-md-6">
                                    <select class="form-control w-100" id="country" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required>
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
                                <label class="col-md-3 text-right" for="city">{{__("Region")}} *</label>
                                <div class="col-md-3">
                                    <select class="form-control  w-100" id="city" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required>
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
                                    <input id="region" type="text" class="form-control @error('region') is-invalid @enderror" name="region" value="{{ old('region') }}" placeholder="{{ __('City') }}">
    
                                    @error('region')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="address">{{__("Address")}}</label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
    
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        
                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="tel1">{{__("Telephone 1")}}\2</label>
                                <div class="col-md-3">
                                    <input id="tel1" type="text" class="form-control @error('tel1') is-invalid @enderror" name="tel1" value="{{ old('tel1') }}" placeholder="{{ __('Telephone 1') }}">
    
                                    @error('tel1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="col-md-3">
                                    <input id="tel2" type="text" class="form-control @error('tel2') is-invalid @enderror" name="tel2" value="{{ old('tel2') }}" placeholder="{{ __('Telephone 2') }}">
    
                                    @error('tel2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
    
                                <label class="col-md-3 text-right" for="mob1">{{__("Mobile 1")}}* \2</label>
                                <div class="col-md-3">
                                    <input id="mob1" type="text" class="form-control @error('mob1') is-invalid @enderror" name="mob1" value="{{ old('mob1') }}" placeholder="{{ __('Mobile 1') }} *" required>
    
                                    @error('mob1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="col-md-3">
                                    <input id="mob2" type="text" class="form-control @error('mob2') is-invalid @enderror" name="mob2" value="{{ old('mob2') }}" placeholder="{{ __('Mobile 2') }}">
    
                                    @error('mob2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
    
                                <label class="col-md-3 text-right" for="fax1">{{__("Fax 1")}}\2</label>
                                <div class="col-md-3">
                                    <input id="fax1" type="text" class="form-control @error('fax1') is-invalid @enderror" name="fax1" value="{{ old('fax1') }}" placeholder="{{ __('Fax 1') }}">
    
                                    @error('fax1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="col-md-3">
                                    <input id="fax2" type="text" class="form-control @error('fax2') is-invalid @enderror" name="fax2" value="{{ old('fax2') }}" placeholder="{{ __('Fax 2') }}">
    
                                    @error('fax2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
    
                                <label class="col-md-3 text-right" for="email2">{{__("E-Mail Address 2")}}</label>
                                <div class="col-md-6">
                                    <input id="email2" type="email" class="form-control @error('email2') is-invalid @enderror" name="email2" value="{{ old('email2') }}" autocomplete="email">
    
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
                        @auth
                        <div class="form-group row d-none" id="company_div">
                            <label class="col-md-3 text-right" for="company">{{__("Company")}}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="company" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}">
                                    @foreach ($comps as $comp)
                                        <option value="{{$comp->id}}" @if(old('company') == $comp->id) selected @endif>{{$comp->f_name}}</option>
                                    @endforeach
                                </select>
                                @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                            
                        <div class="form-group row d-none" id="agent_div">
                            <label class="col-md-3 text-right" for="agent">{{__("Agent")}}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="agent" class="form-control @error('agent') is-invalid @enderror" name="agent" value="{{ old('agent') }}">
                                    @foreach ($agents as $agent)
                                        <option value="{{$agent->id}}" @if(old('agent') == $agent->id) selected @endif>{{$agent->f_name}}&nbsp;@if($agent->s_name!=null){{$agent->s_name}} @endif </option>
                                    @endforeach
                                </select>
                                @error('agent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                            
                        @endauth

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Register') }}
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

@section('scripts')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    // function pwtt(x)
    // {
    // }
$(document).ready(function() {
    catChange();
    $('select').select2();
    $('#password').tooltip({'trigger':'focus', 'title': '8 حروف أو أكثر'});

  });
</script>
@endsection
