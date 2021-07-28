@extends('layouts.app')

@section('content')
@auth
<div class="container py-4">
    <h3 class="w-75 d-inline-block">{{__('Favourite Distributors')}}</h3>
    @if (Auth::user()->user_category_id == 5)
    <button class="btn btn-secondary float-right" type="submit" onclick="window.location='{{route('addFav')}}'">
        {{__("Add Favourite Distributor")}}
    </button>
    <hr>
    <div class="table-responsive-md">
    <table class="table table-hover table-sm table-bordered nowrap mt-2" id="FavAgTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Distributor Name')}}</th>
            <th scope="col">{{__('Company')}}</th>
            <th scope="col">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($agents as $agent) 
            <tr>
                <th scope="row">{{$agent->id}}</th>
                <td>{{$agent->f_name}}&nbsp;{{$agent->s_name}}</td>
                <td><!-- كمل بالبيت -->
                        {{$agent->username}}
                </td>
                <td>
                    <a class="btn btn-secondary btn-sm" href="/showUsr/{{$agent->id}}">{{__('Show')}}</a>
                    <form action="{{route('removeFavAg',['id' => $agent->id, 'comp_id'=>$agent->pivot->comp_id])}}" method="POST" class="d-inline-block">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm" type="submit" title='{{__("Delete")}}'>
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
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
      $('#FavAgTable').DataTable({ fixedHeader: true, "info":     false,
      "oLanguage": {"sSearch": "<i class='fas fa-search'></i>"}
    });
      tablesFunc('FavAgTable');
    });
</script>
@endsection