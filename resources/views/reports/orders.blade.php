@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if (Auth::user()->user_category_id != 5)
    <div class="row justify-content-center">
        <div class="col-md-8" id="FavAgForm">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Orders Report') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('updateOrdersReport') }}" enctype="multipart/form-data">
                        @csrf
                        @if(Auth::user()->user_category_id == 0 || Auth::user()->user_category_id == 2)
                        <div class="form-group row">                            
                            {{-- <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label> --}}
                            @if(Auth::user()->user_category_id == 0)
                            <label class="col-md-3 text-right" for="agent">{{__("Agent")}} *</label>
                            @else
                            <label class="col-md-3 text-right" for="agent">{{__("Distributor")}} *</label>
                            @endif
                                <div class="col-md-6">
                                    <select class="form-control" id="agentFavAg" class="form-control @error('agent') is-invalid @enderror" name="agent" value="{{ old('agent') }}">
                                        @foreach ($agents as $agent)
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
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3" for="from_date">{{__("From Date")}}</label>
                                <div class="col-md-3">
                                        <input id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}">

                                        @error('from_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                
                                <label class="col-md-3" for="to_date">{{__("To Date")}}</label>
                                <div class="col-md-3">
                                        <input id="to_date" type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date" value="{{ old('to_date') }}">

                                        @error('to_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Update Report') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
        <div class="col-12 mt-4 table-responsive">
        <table class="table table-hover table-sm table-bordered nowrap" id="OrdersTable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('Sender Name')}}</th>
                <th scope="col">{{__('Reciever Name')}}</th>
                <th scope="col">{{__('Date')}}</th>
                <th scope="col">{{__('Time')}}</th>
                <th scope="col">{{__('Price')}}</th>
                {{-- <th scope="col">{{__('Verified')}}</th> --}}
                <th scope="col">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order) 
                <tr>
                    <th scope="row">{{$order->id}}</th>
                    <td>{{$order->sender->f_name}} {{$order->sender->s_name}}</td>
                    <td>{{$order->reciever->f_name}} {{$order->reciever->s_name}}</td>
                    <td>{{$order->created_at->format('d/m/Y')}}</td>
                    <td class="cvrt2tz">{{$order->created_at->format('H:i:s')}}</td>
                    <td>{{round($order->price,2)}}</td>
                    {{-- <td>@if($order->verified_at!=null){{$order->verified_at->format('d/m/Y')}}@else - @endif</td> --}}
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('showOrder', ['id'=>$order->id]) }}">{{__('Show')}}</a>                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <div class="mt-4" id="totalCount">
        <h3>{{__('Total Price')}} :&nbsp; {{round($orders->sum('price'), 2)}}&nbsp;{{__('S.P.')}}</h3>
        <h5>{{__('Orders Count')}} :&nbsp; {{$orders->count()}}</h5>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/table.min.js') }}"></script>
<script src="{{ asset('js/fixedHeader.bootstrap4.min.js') }}"></script>
<link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet">
<script>
    // function pwtt(x)
    // {
    // }
$(document).ready(function() {
    $('select').select2();
    $('#OrdersTable').DataTable({
        fixedHeader: true,
        "info":     false,
        "oLanguage": {"sSearch": "<i class='fas fa-search'></i>"},
         dom: 'Bfrtip', 
    buttons: [
            {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .attr('dir','rtl')
                        .append('<div style="margin-top: 20px;">'+$('#totalCount').html()+'</div>');
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
 
                    $(win.document.body).find('td:last-child').addClass( 'd-none' );
                    $(win.document.body).find('th:last-child').addClass( 'd-none' );
                }
            } 
        ]});
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        tablesFunc('OrdersTable');
  });

</script>
@endsection
