@extends('layouts.app')

@section('content')
    @auth
        <div class="container py-4">
            <h3 class="w-75 d-inline-block">{{ __('Orders') }}</h3>
            @if (Auth::user()->user_category_id != 1)
                <hr>
                <div class="table-responsive-md">
                    <table class="table table-hover table-sm table-bordered nowrap mt-2" id="OrdersTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                @if (Auth::user()->user_category_id == 5)
                                    <th scope="col">{{ __('Reciever Name') }}</th>
                                @else
                                    <th scope="col">{{ __('Sender Name') }}</th>
                                @endif
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Time') }}</th>
                                <th scope="col">{{ __('Verified') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->id }}</th>
                                    @if (Auth::user()->user_category_id == 5)
                                        <td>{{ $order->reciever->f_name }} {{ $order->reciever->s_name }}</td>
                                    @else
                                        <td>{{ $order->sender->f_name }} {{ $order->sender->s_name }}</td>
                                    @endif
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="cvrt2tz">{{ $order->created_at->format('H:i:s') }}</td>
                                    <td>
                                        @if ($order->verified_at != null)
                                            {{ $order->verified_at->format('d/m/Y') }}
                                        @else
                                            @foreach ($order->items as $item)
                                                @if ($item->pivot->verified_at != null)
                                                    {{ __('partially verified at') }}:
                                                    {{ date('d/m/Y', strtotime($item->pivot->verified_at)) }}
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('showOrder', ['id' => $order->id]) }}">{{ __('Show') }}</a>
                                    @if (Auth::user()->id == 6)
                                        <form action="{{ route('deleteOrder', ['id' => $order->id]) }}" method="POST"
                                            class="d-inline-block">
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
    </div>
    @endif
@endauth
@endsection

@section('scripts')
<script src="{{ asset('js/table.min.js') }}"></script>
<script src="{{ asset('js/fixedHeader.bootstrap4.min.js') }}"></script>
<link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet">
<script>
    $(document).ready(function() {
        $('#OrdersTable').DataTable({
            fixedHeader: true,
            order: [[2, 'desc'], [3, 'desc']],
            "info": false,
            "oLanguage": {
                "sSearch": "<i class='fas fa-search'></i>"
            }
        });
        $(".cvrt2tz").each(function() {
            $(this).html(toLocalTime($(this).text()));
        });
        tablesFunc('OrdersTable');
    });
</script>
@endsection
