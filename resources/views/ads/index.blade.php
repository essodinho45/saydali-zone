@extends('layouts.app')

@section('content')
<div class="container py-4">
            <h3 class="w-75 d-inline-block">{{__('Ads')}}</h3>
                <button class="btn btn-info float-right" type="submit" onclick="window.location='{{route('createAds')}}'">
                    {{__("Create Ad")}}
                </button>
        <div class="table-responsive-md">
            <table class="table table-hover table-sm table-bordered mt-2" id="adsTable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>{{__('User')}}</th>
                    <th>{{__('Category')}}</th>
                    <th>{{__('Position')}}</th>
                    <th>{{__('Image')}} / {{__('Text')}}</th>
                    <th>{{__('From Date')}}</th>
                    <th>{{__('To Date')}}</th>
                    <th>{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($ads as $ad) 
                    <tr>
                        <th scope="row">{{$ad->id}}</th>
                        <td> @if($ad->user != null) {{$ad->user->f_name}} &nbsp; @if($ad->user->s_name != null){{$ad->user->s_name}} @endif @endif</td>
                        <td> @if($ad->user != null) {{__($ad->user->category->name)}} @endif</td>
                        <td>
                        @if($ad->position == 1 || $ad->position == 2)    {{__('Home Page')}}
                        @elseif($ad->position == 3 || $ad->position == 4) {{__('Control Panel')}}
                        @elseif($ad->position == 5 || $ad->position == 6) {{__('Items')}}@endif
                        </td>
                        <td>
                        @if($ad->position == 1 || $ad->position == 2)    {{$ad->text}}
                        @else <img src="..{{$ad->image_url}}" class="mb-2 rounded e3img">@endif
                        </td>
                        <td>{{$ad->from_date}}</td>
                        <td>{{$ad->to_date}}</td>
                        <td>
                            <form action="{{route('deleteAds',['id' => $ad->id])}}" method="POST" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-sm" type="submit">
                                    {{__("Delete")}}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            <hr>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/table.min.js') }}"></script>
<link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
<script>
    $(document).ready(function() {
      $('#adsTable').DataTable({ fixedHeader: true,
                                "info": false,
                                "oLanguage": {"sSearch": "<i class='fas fa-search'></i>"}
                            });
    tablesFunc('adsTable');    
    } );
</script>
@endsection