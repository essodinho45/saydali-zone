@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Change Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updatePassword') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="curPass">{{__("Current Password")}} *</label>
                            <div class="col-md-6">
                                    <input id="curPass" type="password" class="form-control @error('curPass') is-invalid @enderror" name="curPass" required>
    
                                    @error('curPass')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="newPass">{{__("New Password")}} *</label>
                            <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 text-right" for="newPassCfrm">{{__("New Password Confirm")}} *</label>
                            <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
    
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Save') }}
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
<script>
    // function pwtt(x)
    // {
    // }
$(document).ready(function() {
    $('#password').tooltip({'trigger':'focus', 'title': '8 حروف أو أكثر'});
  });
</script>
@endsection