@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8" id="FavAgForm">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Add Favourite Distributor') }}</div>
                @if (Auth::user()->user_category_id == 5)
                <div class="card-body">
                    <form method="POST" action="{{ route('createFavAg') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">                            
                            {{-- <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label> --}}
                            <label class="col-md-3 text-right" for="company">{{__("Company")}} *</label>                            
                                <div class="col-md-6">
                                    <select class="form-control" id="companyFavAg" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}">
                                        @foreach ( $comps as $comp)
                                            <option value="{{$comp->id}}">{{$comp->f_name}}</option>                                            
                                        @endforeach
                                    </select>
                                    @error('company')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="form-group row">                            
                            {{-- <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label> --}}
                            <label class="col-md-3 text-right" for="agent">{{__("Agent")}} / {{__('Distributor')}} *</label>                            
                                <div class="col-md-6">
                                    <select class="form-control" id="agentFavAg" class="form-control @error('agent') is-invalid @enderror" name="agent" value="{{ old('agent') }}">
                                        @foreach ( $agents as $agent)
                                            <option value="{{$agent->id}}">{{$agent->f_name}}&nbsp;{{$agent->s_name}}</option>                                            
                                        @endforeach
                                    </select>
                                    @error('agent')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Add Favourite Distributor') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
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

  $('#companyFavAg').on('change', function() {
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });

      var comp = this.value;
      
      $('#agentFavAg').find('option').remove();
        
      $.ajax({
           type:'POST',
           url:'/ajaxFavAgRequest',
           data:{comp:comp},
           success:function(data){
            console.log(data);
            $.each( data, function( key) {
              var o = new Option(data[key].f_name+" "+data[key].s_name, data[key].id);
              /// jquerify the DOM object 'o' so we can use the html method
              $(o).html(data[key].f_name+" "+data[key].s_name);
              $("#agentFavAg").append(o);
            });
           }
      });
  });
</script>
@endsection
