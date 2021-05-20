@extends('layouts.app')

@section('content')
@auth
    <div class="container py-4">
            <h3 class="w-75 d-inline-block">{{__('Manage Users')}}</h3>
            <button class="btn btn-primary float-right" type="submit" onclick="window.location='{{route('createUserForm')}}'">
                {{__("Create User")}}
            </button>
            <hr>
            <div class="table-responsive">
        <table class="table table-hover table-sm table-bordered nowrap mt-2" id="usersTable">
            <thead>
            <tr>
                <th scope="col" class="no_srch">#</th>
                <th scope="col">{{__('Name')}}</th>
                <th scope="col">{{__('Username')}}</th>
                <th scope="col">{{__('Country')}}</th>
                <th scope="col">{{__('Region')}}</th>
                <th scope="col" class="no_srch">{{__('Telephone 1')}}</th>
                <th scope="col" class="no_srch">{{__('E-Mail Address')}}</th>
                <th scope="col">{{__('Category')}}</th>
                <th scope="col" class="no_srch">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr @if($user->freezed == true) class='table-danger' @endif >
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->f_name}}&nbsp;{{$user->s_name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->itsCountry->ar_name}}</td>
                    <td>{{$user->itsCity->ar_name}}</td>
                    <td>{{$user->tel1}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{__($user->category->name)}}</td>
                    <td>
                        @if($user->email_verified_at == null)
                            <a class="btn btn-info btn-sm" id="verBtn{{$user->id}}" href="#" onclick="verUsrAjax({{$user->id}})">{{__('Verify')}}</a>
                        @endif
                        @if($user->user_category_id != 0)
                            <a class="btn btn-secondary btn-sm" href="/showUsr/{{$user->id}}">{{__('Show')}}</a>
                            @if($user->freezed == false)
                                <a class="btn btn-danger btn-sm" id="frzUsrBtn{{$user->id}}" href="#" onclick="frzUsrAjax({{$user->id}})">{{__('Freeze')}}</a>
                            @elseif($user->freezed == true)
                                <a class="btn btn-secondary btn-sm" id="unfrzUsrBtn{{$user->id}}" href="#" onclick="unfrzUsrAjax({{$user->id}})">{{__('Unfreeze')}}</a>
                            @endif
                            @if($user->items->count()==0
                            && $user->ordersFromUser->count()==0
                            && $user->ordersToUser->count()==0
                            && $user->cartsFromUser->count()==0
                            && $user->cartsToUser->count()==0
                            && $user->posts->count()==0
                            && $user->offers->count()==0
                            && $user->quantities->count()==0
                            && $user->baskets->count()==0)
                                <form action="{{route('deleteUser',['id' => $user->id])}}" method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        {{__("Delete")}}
                                    </button>
                                </form>
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
<link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
<script>
    $(document).ready(function() {
        $('#usersTable thead tr').clone(true).appendTo( '#usersTable thead' );
            $('#usersTable thead tr:eq(1) th').each( function (i) {
                var hide= '';
                if($(this).hasClass('no_srch'))
                    hide = 'd-none'
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control form-control-sm '+hide+'" placeholder="'+title+'" />' );
                var attr = $(this).attr('data-priority');

                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if (!(typeof attr !== typeof undefined && attr !== false) && !$(this).hasClass('d-none')) {
                    $(this).addClass('d-none d-lg-table-cell');
                }
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
      $('#usersTable').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                "info":     false,
                "oLanguage": {"sSearch": "<i class='fas fa-search'></i>"}
            } );
            tablesFunc('usersTable');
    });
</script>
@endsection