@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="w-75 d-inline-block">{{ __('Offers') }}</h3>
        @auth
            @if (in_array(Auth::user()->user_category_id, [
                    Constants::ADMIN,
                    Constants::COMPANY,
                    Constants::AGENT,
                    Constants::DISTRIBUTOR,
                ]))
                <button class="btn btn-info float-right" type="submit" onclick="window.location='{{ route('createOffer') }}'">
                    {{ __('Create Offer') }}
                </button>
            @endif
        @endauth

        <div class="table-responsive-md">
            <table class="table table-hover table-sm table-bordered nowrap mt-2" id="offersTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Company') }}</th>
                        <th scope="col">{{ __('Item') }}</th>
                        <th scope="col">{{ __('Discount') }} %</th>
                        <th scope="col">{{ __('Quantity') }}</th>
                        <th scope="col">{{ __('Free Item') }}</th>
                        <th scope="col">{{ __('Free Quantity') }}</th>
                        <th scope="col">{{ __('From Date') }}</th>
                        <th scope="col">{{ __('To Date') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offers as $offer)
                        <tr>
                            <th scope="row">{{ $offer->id }}</th>
                            <td>{{ $offer->user->f_name }}</td>
                            <td>{{ $offer->item->name }}</td>
                            <td>
                                @if ($offer->discount != null)
                                    {{ $offer->discount }} %
                                @endif
                            </td>
                            <td>
                                @if ($offer->quant != null)
                                    {{ $offer->quant }}
                                @endif
                            </td>
                            <td>
                                @if ($offer->freeItem != null)
                                    {{ $offer->freeItem->name }}
                                @endif
                            </td>
                            <td>
                                @if ($offer->free_quant != null)
                                    {{ $offer->free_quant }}
                                @endif
                            </td>
                            <td>{{ date('d-m-Y', strtotime($offer->from_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($offer->to_date)) }}</td>
                            <td>
                                {{-- <a class="btn btn-primary btn-sm" href="{{ route('showOffer', ['id'=>$offer->id, 'type'=>1]) }}">{{__('Show')}}</a> --}}
                                @if (Auth::user()->user_category_id == 6 || Auth::user()->id == $offer->user_id)
                                     <a class="btn btn-secondary btn-sm" href="{{ route('editOffer', ['id'=>$offer->id, 'type'=>1]) }}">{{__('Edit')}}</a>
                                    <form action="{{ route('deleteOffer', ['id' => $offer->id, 'type' => 1]) }}"
                                        method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <h3 class="w-75 d-inline-block">{{ __('Baskets') }}</h3>
        <div class="table-responsive-md">
            <table class="table table-hover table-sm table-bordered nowrap mt-2 accordion" id="basketsTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Company') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                        <th scope="col">{{ __('From Date') }}</th>
                        <th scope="col">{{ __('To Date') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($baskets as $basket)
                        <tr data-toggle="collapse" class="clickable" data-target="#collapseBItems{{ $basket->id }}"
                            aria-expanded="false" aria-controls="collapseBItems{{ $basket->id }}">
                            <th scope="row" rowspan="2">{{ $basket->id }}</th>
                            <td>{{ $basket->name }}</td>
                            <td>{{ $basket->user->f_name }}</td>
                            <td>{{ round($basket->price, 2) }}</td>
                            <td>{{ date('d-m-Y', strtotime($basket->from_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($basket->to_date)) }}</td>
                            {{-- <td>@if ($offer->discount != null){{$offer->discount}}@endif</td>
                        <td>@if ($offer->quant != null){{$offer->quant}}@endif</td>
                        <td>@if ($offer->freeItem != null){{$offer->freeItem->name}}@endif</td>
                        <td>@if ($offer->free_quant != null){{$offer->free_quant}}@endif</td> --}}
                            <td>
                                {{-- <a class="btn btn-primary btn-sm" href="{{ route('showOffer', ['id'=>$basket->id, 'type'=>2]) }}">{{__('Show')}}</a> --}}
                                @if (Auth::user()->user_category_id == 6 || Auth::user()->id == $basket->user_id)
                                     <a class="btn btn-secondary btn-sm" href="{{ route('editOffer', ['id'=>$basket->id, 'type'=>2]) }}">{{__('Edit')}}</a>
                                    <form action="{{ route('deleteOffer', ['id' => $basket->id, 'type' => 2]) }}"
                                        method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                            {{-- <td>
                            <a class="btn btn-primary" >
                                <i class="fas fa-plus"></i>
                            </a>
                        </td> --}}
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="collapse" id="collapseBItems{{ $basket->id }}">
                                    @foreach ($basket->items as $item)
                                        {{ $item->name . ' ' . $item->type->ar_name . ' ' . $item->titer }} :
                                        <b>{{ $item->pivot->quantity }}</b>
                                        <br>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/table.min.js') }}"></script>
    <script src="{{ asset('js/fixedHeader.bootstrap4.min.js') }}"></script>
    <link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet">

    <script>
        $(document).ready(function() {
            $('#offersTable').DataTable({
                fixedHeader: true,
                "info": false,
                "oLanguage": {
                    "sSearch": "<i class='fas fa-search'></i>"
                }
            });
            tablesFunc('offersTable');
        });
    </script>
@endsection
