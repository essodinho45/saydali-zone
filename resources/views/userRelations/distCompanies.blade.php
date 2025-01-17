@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Companies') }}
                    </div>
                    <div class="card-body">
                        @auth
                            <form method="POST" action="/addCompsToDist/{{ $dist->id }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 text-right" for="dist">{{ __('Distributor') }} *</label>
                                    <div class="col-md-6">
                                        <select class="form-control w-100" id="dist"
                                            class="form-control @error('dist') is-invalid @enderror" name="dist"
                                            value="{{ old('dist') }}" disabled required>
                                            <option value="{{ $dist->id }}">{{ $dist->f_name }}&nbsp; @if ($dist->s_name)
                                                    {{ $dist->s_name }}
                                                @endif
                                            </option>
                                        </select>
                                        @error('dist')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 text-right" for="comps">{{ __('Company') }} *</label>
                                    <div class="col-md-6">
                                        <select class="form-control w-100" id="comps" name="comps[]"
                                            class="form-control @error('comps') is-invalid @enderror" name="comps"
                                            value="{{ old('comps') }}" multiple>
                                            @foreach ($comps as $comp)
                                                <option value="{{ $comp->id }}"
                                                    @if (in_array($comp->id, $selected)) selected @endif>{{ $comp->f_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('comps')
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
                        @endauth
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
    </script>
@endsection
