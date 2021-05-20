@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8" id="ads_form">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Create Ad') }}</div>

                <div class="card-body">
                    <form method="POST" id="adForm"  action="{{ route('storeAds') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="user_id">{{__("User")}}</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}">
                                        {{-- <option value="" selected disabled>{{ __('Item Type') }}</option> --}}
                                        @foreach ($usrs as $comp)
                                            <option value="{{$comp->id}}" @if(old('user_id') == $comp->id) selected @endif>{{ $comp->f_name }} &nbsp; @if($comp->s_name != null){{$comp->s_name}}@endif</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group row">                            
                            {{-- <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label> --}}
                            <label class="col-md-3 text-right" for="category">{{__("Position")}} *</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="position" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}">
                                        <option value="1">{{ __('Home Page') }}</option>
                                        <option value="3">{{ __('Control Panel') }} 1</option>
                                        <option value="4">{{ __('Control Panel') }} 2</option>
                                        <option value="5">{{ __('Items') }} 1</option>
                                        <option value="6">{{ __('Items') }} 2</option>
                                    </select>
                                    @error('position')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-3 text-right" for="from_date">{{__("From Date")}}</label>
                                <div class="col-md-6">
                                        <input id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}">

                                        @error('from_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                        </div>
                        <div class="form-group row">                                
                                <label class="col-md-3 text-right" for="to_date">{{__("To Date")}}</label>
                                <div class="col-md-6">
                                        <input id="to_date" type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date" value="{{ old('to_date') }}">

                                        @error('to_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                        </div>

                        <div id="e3img" class="form-group row" style="display: none;">
                                <label class="col-md-3 text-right" for="ad_image">{{__("Image")}}</label>
                                <div class="col-md-6">
                                     <input type="file" class="form-control-file" name="ad_image" id="ad_image">
                                </div>
                        </div>

                        <div id="e3txt" class="form-group row">                                
                                <label class="col-md-3 text-right" for="text">{{__("Text")}}</label>
                                <div class="col-md-6">
                                        <textarea class="form-control" rows="3" id="text" name="text" form="adForm"></textarea>

                                        @error('text')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                        </div>

                        <div class=" form-check offset-md-3">
                            <input class="form-check-input" name="keep" type="checkbox" id="keep"/>
                            <label class="form-check-label" for="keep">
                              {{__("Keep ad after end of date")}}
                            </label>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3 mt-2">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Create Ad') }}
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
    $('select').select2();
  });
  $('#position').on('change', function() {
    if(this.value == 1)
    {
        $('#e3txt').show();
        $('#e3img').hide();
    }
    else{
        $('#e3txt').hide();
        $('#e3img').show();
    }
});
</script>
@endsection
