@extends('layouts.app')

@section('content')
@auth
    <div class="container py-4">
            @if(\Route::currentRouteName() == 'companies')        
                <h3 class="w-75 d-inline-block">{{__('Companies')}}</h3>
            @endif
            <hr>
        <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm mt-2" id="parentsTable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('Name')}}</th>
                <th scope="col">{{__('Second Name')}}</th>
                <th scope="col">{{__('Country')}}</th>
                <th scope="col">{{__('Region')}}</th>
                <th scope="col">{{__('City')}}</th>
                <th scope="col">{{__('Telephone 1')}}</th>
                <th scope="col">{{__('E-Mail Address')}}</th>
                <th scope="col">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($availableParents as $parent)
                <tr>
                    <th scope="row">{{$parent->id}}</th>
                    <td>{{$parent->f_name}}</td>
                    <td>{{$parent->s_name}}</td>
                    <td>{{$parent->itsCountry->ar_name}}</td>
                    <td>{{$parent->itsCity->ar_name}}</td>
                    <td>{{$parent->region}}</td>
                    <td>{{$parent->tel1}}</td>
                    <td>{{$parent->email}}</td>
                    <td>
                        <a class="btn btn-secondary btn-sm" href="/showUsr/{{$parent->id}}">{{__('Show')}}</a>
                        @if(Auth::user()->category->id == 4)
                            @if($parent->category->id != 5)
                                @if (!$parent->children->isEmpty() && $parent->children->contains('id', Auth::user()->id))
                                    @if(!$parent->isFreezed)
                                        <a class="btn btn-danger btn-sm" id="freezeBtn{{$parent->id}}" href="#" onclick="freezeRelAjax({{$parent->id}}, true)">{{__('Freeze')}}</a>
                                    @else
                                        <a class="btn btn-info btn-sm" id="freezeBtn{{$parent->id}}" href="#" onclick="freezeRelAjax({{$parent->id}}, false)">{{__('Unfreeze')}}</a>
                                    @endif
                                @else
                                <a class="btn btn-secondary btn-sm" id="addBtn{{$parent->id}}" href="#" onclick="addParentAjax({{$parent->id}})">{{__('Add')}}</a>
                                @endif
                            @endif
                        @endif
                        @if(Auth::user()->category->id == 2)
                            @if($parent->category->id == 1)
                                @if (!$parent->children->isEmpty() && $parent->children->contains('id', Auth::user()->id))
                                    @if(!$parent->isVerified)
                                        <a class="btn btn-secondary btn-sm btn-disabled disabled" href="#">{{__('Requested')}}</a>
                                    @else
                                        <a class="btn btn-secondary btn-sm btn-disabled disabled" href="#">{{__('Verified')}}</a>
                                    @endif
                                @else
                                    <a class="btn btn-secondary btn-sm" id="reqBtn{{$parent->id}}" href="#" onclick="reqRelAjax({{$parent->id}})">{{__('Request')}}</a>
                                @endif
                            @endif
                        @endif
                        @if(Auth::user()->category->id == 3)
                            @if($parent->category->id == 2)
                                @if (!$parent->children->isEmpty() && $parent->children->contains('id', Auth::user()->id))
                                    @if(!$parent->isVerified)
                                        <a class="btn btn-secondary btn-sm btn-disabled disabled" href="#">{{__('Requested')}}</a>
                                    @else
                                        <a class="btn btn-secondary btn-sm btn-disabled disabled" href="#">{{__('Verified')}}</a>
                                    @endif
                                @else
                                    <a class="btn btn-secondary btn-sm" id="reqBtn{{$parent->id}}" href="#" onclick="reqRelAjax({{$parent->id}})">{{__('Request')}}</a>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach        
            </tbody>
        </table>
    </div>
    </div>
    @endauth

@endsection
@section('scripts')
<script src="{{ asset('js/table.min.js') }}"></script>
<script src="{{ asset('js/fixedHeader.bootstrap4.min.js') }}"></script>
<link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet">
<script>
    $(document).ready(function() {
      $('#parentsTable').DataTable({fixedHeader: true, 
                "info":     false,
                "oLanguage": {"sSearch": "<i class='fas fa-search'></i>"}
            });
        tablesFunc('parentsTable');
    });
</script>
@endsection