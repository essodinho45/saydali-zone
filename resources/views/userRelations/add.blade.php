@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Add Distributor')}} {{__('to')}} {{ $ag->f_name }}&nbsp;@if($ag->s_name){{$ag->s_name}}@endif</div>

                <div class="card-body">
                    @auth
                    <form method="POST" action="/addDist/{{$ag->id}}" enctype="multipart/form-data">
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
                        {{-- <div class="alert alert-success" role="alert">
                                @if(session('message') != null)
                                    {{session('message')}} 
                                    <br>
                                @endif
                                {{__('Welcome')}} {{Auth::user()->f_name}} {{Auth::user()->s_name}} , {{__('you\'re logged in')}}.
                        </div> --}}
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
