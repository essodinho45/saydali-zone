@extends('layouts.app')
@section('content')
    @auth
        <div class="row m-0 col-12 mt-3">
            <div class="col-md-8 offset-md-2 p-4">
                <h3 class="w-50 d-inline-block">{{ __('Items') }}&nbsp;{{ __('By Agent') }}
                    <select id="reciever_id" class="form-control form-control-sm" name="reciever_id" value=""
                        onchange="agentPageChange(this)" required>
                        <option value="0">{{ __('all') }}</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" @if ($agent->id == $agent_id) selected @endif>
                                {{ $agent->f_name }}&nbsp;@if ($agent->s_name != null)
                                    {{ $agent->s_name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </h3>
                @if (Auth::user()->user_category_id == 6 || Auth::user()->user_category_id == 1 || Auth::user()->user_category_id == 4)
                    <button class="btn btn-success float-right" type="submit"
                        onclick="window.location='{{ route('importItems') }}'">
                        {{ __('Import from Excel') }}
                    </button>
                    <button class="btn btn-info float-right mx-2" type="submit"
                        onclick="window.location='{{ route('createItem') }}'">
                        {{ __('Create Item') }}
                    </button>
                @elseif(Auth::user()->user_category_id == 5)
                    <button class="btn btn-info float-right mx-2" type="submit" onclick="sendAllToCart()">
                        {{ __('Send All to Cart') }}
                    </button>
                @endif
                @if (Auth::user()->user_category_id == 6 || Auth::user()->user_category_id == 2 || Auth::user()->user_category_id == 3)
                    <button class="btn btn-secondary float-right" type="submit"
                        onclick="window.location='{{ route('offers') }}'">
                        {{ __('Offers') }}
                    </button>
                @endif
                <hr>
                <div class="table-responsive-md">
                    <table class="table table-hover table-sm table-bordered nowrap mt-2" id="ItemsTable">
                        <thead>
                            <tr>
                                <th scope="col" class="no_srch">#</th>
                                <th scope="col" data-priority="1">{{ __('Name') }}</th>
                                <th scope="col" data-priority="1">{{ __('Producer') }}</th>
                                <th scope="col" class="no_srch">{{ __('Price') }}</th>
                                <th scope="col" class="no_srch">{{ __('Customer Price') }}</th>
                                <th scope="col" class="no_srch">{{ __('Type') }}</th>
                                <th scope="col" class="d-none">{{ __('Composition') }}</th>
                                <th scope="col" class="d-none">{{ __('Barcode') }}</th>
                                <th scope="col" class="d-none">{{ __('Usage') }}</th>
                                <th scope="col" class="d-none">{{ __('Properties') }}</th>
                                @if (Auth::user()->user_category_id == 5)
                                    <th scope="col" class="no_srch" data-priority="1">{{ __('Quantity') }}</th>
                                    {{-- <th scope="col" class="no_srch" data-priority="1">{{__('Agent')}}</th> --}}
                                @endif
                                <th scope="col" class="no_srch" data-priority="1">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr @if ($item->isFreezedByUser(Auth::user()->id)) class='table-danger' @endif>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->company->f_name }}</td>
                                    <td>{{ round($item->price, 2) }}</td>
                                    <td>{{ round($item->customer_price, 2) }}</td>
                                    <td>
                                        @if ($item->type != null)
                                            {{ $item->type->ar_name }}
                                        @endif
                                    </td>
                                    <td class="d-none">{{ $item->composition }}</td>
                                    <td class="d-none">{{ $item->barcode }}</td>
                                    <td class="d-none">{{ $item->descr1 }}</td>
                                    <td class="d-none">{{ $item->properties }}</td>
                                    @if (Auth::user()->user_category_id == 5)
                                        <td>
                                            <input type="number" placeholder="0" id="quantity{{ $item->id }}"
                                                min="0" class="form-control form-control-sm q_inp"
                                                name="quantity{{ $item->id }}" value="0"
                                                onchange="quantityChange({{ $item->id }})" required>
                                        </td>
                                        {{-- <td>
                            <select id="reciever_id{{$item->id}}" class="form-control form-control-sm" name="reciever_id{{$item->id}}" value="" onchange="agentChange({{$item->id}})" required>
                                <option disabled>{{__('please select quantity first')}}</option>
                            </select>
                        </td> --}}
                                    @endif
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{ route('showItem', ['id' => $item->id]) }}"
                                            title="{{ __('Show') }}"><i class="fas fa-eye"></i></a>
                                        @if (Auth::user()->user_category_id == 6 || Auth::user()->id == $item->user_id)
                                            <a class="btn btn-secondary btn-sm"
                                                href="{{ route('editItem', ['id' => $item->id]) }}"
                                                title="{{ __('Edit') }}"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('deleteItem', ['id' => $item->id]) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm" type="submit"
                                                    title='{{ __('Delete') }}'>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @elseif (Auth::user()->user_category_id == 5)
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#sender_remark" title="{{ __('Insert Sender Remark') }}"
                                                onclick="sendItemsToCart({{ $item->id }}, false)">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary disabled btn-sm"
                                                title="{{ __('Add to Cart') }}"
                                                onclick="ajaxSendtoCart({{ $item->id }}, false)" disabled
                                                id="i_btn{{ $item->id }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm" onclick="sendItemsToCart({{$item->id}}, false)" title="{{__('Add to Cart')}}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button> --}}
                                            {{-- <a class="btn btn-danger btn-sm" href="{{ route('deleteItem', ['id'=>$item->id]) }}">{{__('Delete')}}</a> --}}
                                        @endif
                                        @if (
                                            (Auth::user()->user_category_id == 2 ||
                                                Auth::user()->user_category_id == 3 ||
                                                Auth::user()->user_category_id == 4) &&
                                                !$item->isFreezedByUser(Auth::user()->id))
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="freezeItemByAgent({{ $item->id }}, true)"
                                                title="{{ __('Freeze') }}">
                                                <i class="far fa-stop-circle"></i>
                                            </button>
                                        @elseif(
                                            (Auth::user()->user_category_id == 2 ||
                                                Auth::user()->user_category_id == 3 ||
                                                Auth::user()->user_category_id == 4) &&
                                                $item->isFreezedByUser(Auth::user()->id))
                                            <button type="button" class="btn btn-info btn-sm"
                                                onclick="freezeItemByAgent({{ $item->id }}, false)"
                                                title="{{ __('Unfreeze') }}">
                                                <i class="far fa-stop-circle"></i>
                                            </button>
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
                                <th scope="col">{{ __('Company') }}</th>
                                <th scope="col">{{ __('Price') }}</th>
                                <th scope="col">{{ __('From Date') }}</th>
                                <th scope="col">{{ __('To Date') }}</th>
                                @if (Auth::user()->user_category_id == 5)
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    {{-- <th scope="col">{{__('Agent')}}</th> --}}
                                @endif
                                <th scope="col">{{ __('Actions') }}</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($baskets as $basket)
                                <tr data-toggle="collapse" class="clickable"
                                    data-target="#collapseBItems{{ $basket->id }}" aria-expanded="false"
                                    aria-controls="collapseBItems{{ $basket->id }}">
                                    <th scope="row" rowspan="2">{{ $basket->id }}</th>
                                    <td>{{ $basket->user->f_name }}</td>
                                    <td>{{ round($basket->price, 2) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($basket->from_date)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($basket->to_date)) }}</td>
                                    {{-- <td>@if ($offer->discount != null){{$offer->discount}}@endif</td>
                            <td>@if ($offer->quant != null){{$offer->quant}}@endif</td>
                            <td>@if ($offer->freeItem != null){{$offer->freeItem->name}}@endif</td>
                            <td>@if ($offer->free_quant != null){{$offer->free_quant}}@endif</td> --}}
                                    @if (Auth::user()->user_category_id == 5)
                                        <td>
                                            <input type="number" placeholder="0" id="b_quantity{{ $basket->id }}"
                                                min="0" class="form-control form-control-sm"
                                                name="b_quantity{{ $basket->id }}" value="0"
                                                onchange="quantityChange({{ $basket->id }}, true)" required>
                                        </td>
                                        {{-- <td>
                                <select id="b_reciever_id{{$basket->id}}" class="form-control form-control-sm" name="b_reciever_id{{$basket->id}}" value="" required>
                                    <option disabled>{{__('please select quantity first')}}</option>
                                </select>
                            </td> --}}
                                    @endif
                                    <td>
                                        @if (Auth::user()->user_category_id == 5)
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#sender_remark" title="{{ __('Insert Sender Remark') }}"
                                                onclick="sendItemsToCart({{ $basket->id }}, true)">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary disabled btn-sm"
                                                title="{{ __('Add to Cart') }}"
                                                onclick="ajaxSendtoCart({{ $basket->id }}, true)" disabled
                                                id="b_btn{{ $basket->id }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm" onclick="sendItemsToCart({{$basket->id}}, true)" title="{{__('Add to Cart')}}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button> --}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td @if (Auth::user()->user_category_id == 5) colspan="7" @else colspan="5" @endif>
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
            {{-- <div class="col-md-2 bg-transparent text-lightkiwi h-100">
            @if (count($ads2) > 0)
            @foreach ($ads2 as $ads)
                <img src="..{{$ads->image_url}}" class="w-100 h-100 mb-2 rounded">
            @endforeach
            @else
                <img src="../images/e3lan/defad2-1.jpg" class="w-100 h-100 mb-2 rounded">
                <img src="../images/e3lan/defad2-2.jpg" class="w-100 h-100 mb-2 rounded">
            @endif
        </div> --}}
        </div>

        <!-- Modal -->
        <div class="modal fade" id="sender_remark" tabindex="-1" role="dialog" aria-labelledby="sender_remarkLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sender_remarkLabel">{{ __('Add to Cart') }}"</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <input type="hidden" id="reciever_id"> --}}
                        <input type="hidden" id="quantity">
                        <input type="hidden" id="basket">
                        <input type="hidden" id="item">
                        <label for="sender_remark_txt">{{ __('Sender Remark') }}</label>
                        <textarea id="sender_remark_txt" class="form-control w-100"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-primary"
                            onclick="ajaxSendtoCart()">{{ __('Add to Cart') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection
@section('scripts')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/table.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/fixedHeader.bootstrap4.min.js') }}"></script>
    <link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        thead input {
            width: 100%;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#ItemsTable thead tr').clone(true).appendTo('#ItemsTable thead');
            $('#ItemsTable thead tr:eq(1) th').each(function(i) {
                var hide = '';
                if ($(this).hasClass('no_srch'))
                    hide = 'd-none'
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control form-control-sm ' + hide +
                    '" placeholder="' + title + '" />');
                var attr = $(this).attr('data-priority');

                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if (!(typeof attr !== typeof undefined && attr !== false) && !$(this).hasClass('d-none')) {
                    $(this).addClass('d-none d-lg-table-cell');
                }

                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#ItemsTable').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                "info": false,
                "oLanguage": {
                    "sSearch": "<i class='fas fa-search'></i>"
                }
            });
            tablesFunc('ItemsTable');
            $('select').select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        });

        function agentPageChange(sel) {
            // console.log($("#reciever_id").val());
            window.location.href = "./" + sel.value;
        }

        function formatState(opt) {
            if (!opt.id) {
                return opt.text;
            }

            var optimage = $(opt.element).attr('logo_image');
            console.log(optimage)
            if (!optimage) {
                return opt.text;
            } else {
                var $opt = $(
                    '<span><img src="' + optimage + '" width="24px" class="mr-2" /> ' + opt.text + '</span>'
                );
                return $opt;
            }
        };

        function quantityChange(id, isBasket) {
            if (!isBasket) {
                // $("#reciever_id"+id).find('option').remove();
                // $.each( data, function( key) {
                // var o = new Option(data[key].f_name, data[key].id);
                // var sname = (data[key].s_name == null) ? '' : data[key].s_name ;
                // /// jquerify the DOM object 'o' so we can use the html method
                // $(o).html(data[key].f_name + " " + sname);
                // $(o).attr('logo_image', data[key].logo_image);
                // $("#reciever_id"+id).append(o);
                // agentChange(id);});
                $('#i_btn' + id).removeAttr('disabled').removeClass('disabled');
            } else {
                // console.log(data);
                // $("#b_reciever_id"+id).find('option').remove();
                // var sname = (data.s_name == null) ? '' : data.s_name ;
                // var o = new Option(data.f_name, data.id);
                // /// jquerify the DOM object 'o' so we can use the html method
                // $(o).html(data.f_name + " " + sname);
                // $(o).attr('logo_image', data[key].logo_image);
                // $("#b_reciever_id"+id).append(o);
                $('#b_btn' + id).removeAttr('disabled').removeClass('disabled');
            }
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            //     });

            // $.ajax({
            // type:'POST',
            // url:'/cart/postItem',
            // data:{id: id, isBasket: isBasket},
            // success:function(data){

            //     },
            //     error:function(error){
            //         console.log(error);
            //     }
            // });
        }
        //   function agentChange(item){
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //         });

        //         $.ajax({
        //         type:'POST',
        //         url:'/cart/postItemAgent',
        //         data:{id: $("#reciever_id"+item).val(), item: item},
        //         success:function(data){
        //             console.log(data);
        //             if(data.length > 0){
        //                 if(data[0].discount>0)
        //                     var title = ""+ data[0].discount+ " %" + " | " + data[0].quant;
        //                 else if(data[0].free_quant>0)
        //                     var title = ""+ data[0].quant + " + " + data[0].free_quant;
        //                 $("#reciever_id"+item).parent().parent().addClass('table-success');
        //                 $("#reciever_id"+item).parent().parent().attr('data-toggle',"tooltip").attr('title', title);
        //                 $('[data-toggle="tooltip"]').tooltip();
        //                 }
        //         },
        //         error:function(error){
        //             console.log(error);
        //         }
        //     });
        //   }
        function freezeItemByAgent(item, freeze) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/items/freeze',
                data: {
                    id: item,
                    freeze: freeze
                },
                success: function(data) {
                    console.log(data);
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function sendItemsToCart(item, isBasket) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#basket').val(isBasket);
            $('#item').val(item);
            if (!isBasket) {
                // $('#reciever_id').val($('#reciever_id'+item).val());
                $('#quantity').val($('#quantity' + item).val());
            } else {
                // $('#reciever_id').val($('#b_reciever_id'+item).val());
                $('#quantity').val($('#b_quantity' + item).val());
            }
        }

        function ajaxSendtoCart(item = null, isBasket) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (item == null) {
                quantity = $('#quantity').val();
                item = $('#item').val();
                isBasket = $('#basket').val();
                reciever_id = $('#reciever_id').val();
                sender_remark = $('#sender_remark_txt').val();
            } else {
                sender_remark = null;
                if (isBasket) {
                    quantity = $('#b_quantity' + item).val();
                    reciever_id = $('#b_reciever_id').val();
                } else {
                    quantity = $('#quantity' + item).val();
                    reciever_id = $('#reciever_id').val();
                }
            }
            if (quantity > 0) {
                $.ajax({
                    type: 'POST',
                    url: '/addToCart',
                    data: {
                        item_id: item,
                        isBasket: isBasket,
                        reciever_id: reciever_id,
                        quantity: quantity,
                        sender_remark: sender_remark
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function sendAllToCart() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            objects = [];
            $.each($('.q_inp'), function() {
                id = this.id.substr(8);
                if (this.value > 0) {
                    var obj = {
                        id: id,
                        quant: this.value,
                        reciever: $("#reciever_id").val()
                    };
                    objects.push(obj);
                }
                console.log(objects);
            });
            if (objects.length > 0) {
                console.log('1');
                console.log(objects);
                $.ajax({
                    type: 'POST',
                    url: '/addAllItemsToCart',
                    data: {
                        objects: objects
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endsection
