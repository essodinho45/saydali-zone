@extends('layouts.app')

@section('content')
<div class="d-none">{{$totalprice = 0}}</div>
<div class="container py-4">
    @auth
        <h2>{{__("Order")}}</h2>            
        <small class="text-muted">{{__('Order Number')}}: {{$order->id}} - {{ $order->created_at->format('d/m/Y') }}&nbsp; {{ $order->created_at->format('H:i:s') }}</small>
        @if(Auth::user()->user_category_id == 0 || Auth::user()->id == $order->reciever->id)
        <button class="btn btn-secondary float-right" onclick="printPage()" id="prtbtn">
            <i class="fas fa-print"></i>
        </button>
        @endif
        <br>
            <div class="p-2">
                <div>
                    <div class="row col-12 p-0">
                        <div class="col-md-3">
                            <h6>{{__('Sender')}}</h6>
                            <p>
                                {{$order->sender->f_name}} {{$order->sender->s_name}}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>{{__('Reciever')}}</h6>
                            <p>
                                {{$order->reciever->f_name}} {{$order->reciever->s_name}}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>{{__('Sender Address')}}</h6>
                            <p>
                                {{$order->sender->itsCountry->ar_name}}, {{$order->sender->itsCity->ar_name}}, @if($order->sender->region != null) {{$order->sender->region}}, @endif @if($order->sender->address != null) {{$order->sender->address}} @endif .
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>{{__('Sender Phone')}}</h6>
                            <p>
                                {{$order->sender->mob1}} @if($order->sender->tel1 != null) - {{$order->sender->tel1}} @endif
                            </p>
                        </div>
                    </div>
                    <hr>
                    <h6>{{__('Items')}}</h6>
                    <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered mt-2" id="ItemsTable">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('Name')}}</th>
                                        <th scope="col">{{__('Producer')}}</th>
                                        <th scope="col">{{__('Price')}}</th>
                                        <th scope="col">{{__('Type')}}</th>
                                        <th scope="col">{{__('Quantity')}}</th>
                                        <th scope="col">{{__('Free Quantity')}}</th>
                                        <th scope="col">{{__('Total Price')}}</th>
                                        <th scope="col">{{__('Discounted Price')}}</th>
                                        {{-- <th scope="col">{{__('Actions')}}</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <th scope="row" rowspan="2">{{$item->id}}</th>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->company->f_name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->type->ar_name}}</td>
                                            <td>{{$item->pivot->quantity}}</td>
                                            <td>{{$item->pivot->free_quant}}</td>
                                            <td>{{$item->pivot->quantity * $item->price}} {{__("S.P.")}}</td>
                                            <td>{{$item->pivot->price}} {{__("S.P.")}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{__('Sender Remark')}}: {{$item->pivot->sender_remark}}</td>
                                            <td colspan="3">{{__('Reciever Remark')}}: {{$item->pivot->reciever_remark}}</td>
                                            <td colspan="2" id="trow">
                                                @if(Auth::user()->id == $order->reciever->id && $order->verified_at == null && $item->pivot->verified_at == null)
                                                    <a class="btn btn-sm btn-secondary" title="{{__('Insert Reciever Remark')}}" href="#" onclick="openVerItModal({{$order->id}},{{$item->id}})"><i class="fas fa-comment"></i></a>
                                                    <a id="verOrdItmBtn{{$order->id}}{{$item->id}}" class="btn btn-sm btn-secondary" href="#" onclick="verItemInOrder({{$order->id}},{{$item->id}})">{{__('Verify')}}</a>
                                                @elseif($order->verified_at == null && $item->pivot->verified_at != null)
                                                    <a class="btn btn-sm btn-secondary disabled" href="#">{{__('Verified')}}</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach($order->baskets as $item)
                                        <tr data-toggle="collapse" class="clickable" data-target="#collapseBItems{{$item->id}}" aria-expanded="false" aria-controls="collapseBItems{{$item->id}}">
                                            <th scope="row">{{$item->id}}</th>
                                            <td>{{__('Basket')}}</td>
                                            <td>{{$item->user->f_name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$item->pivot->quantity}}</td>
                                            <td></td>
                                            <td>{{$item->pivot->quantity * $item->price}} {{__("S.P.")}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">
                                                <div class="collapse" id="collapseBItems{{$item->id}}">
                                                    @foreach ($item->items as $itemm)
                                                        {{$itemm->name ." ". $itemm->type->ar_name ." ". $itemm->titer}} : <b>{{$itemm->pivot->quantity}}</b>
                                                    <br>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- <div class="d-none">{{$totalprice += $qBasket->where('basket_id',$item->id)->first()->quantity * $item->price}}</div> --}}
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    <hr>
                    <div class="row col-12 p-0 pt-2">
                        <div class="col-6">
                            <h6>{{__('Sender Remark')}}</h6>
                            @if($order->remark != 'null')
                                <p>{{$order->remark}}</p>
                            @endif
                        </div>
                        <div class="col-6">
                            <h6>{{__('Reciever Remark')}}</h6>
                            @if($order->reciever_remark != 'null')
                                <p>{{$order->reciever_remark}}</p>
                            @endif
                        </div>
                    </div>
                    {{-- <h6>{{__('Reciever Remark')}}</h6>
                    <p class="mb-4">
                        {{$order->reciever_remark}}
                    </p> --}}
                    <h4>{{__('Total Price')}}</h4>
                    <h6>
                        {{$order->price}} {{__('S.P.')}}
                    </h6>
                </div>
            </div>
            <div class="mb-4" id="btns">
                @if (Auth::user()->user_category_id == 0 || Auth::user()->id == $order->sender->id || Auth::user()->id == $order->reciever->id)                    
                            @if(Auth::user()->id == $order->reciever->id && $order->verified_at == null)
                            <form action="{{route('verifyOrder',['id' => $order->id])}}" method="POST" class="ml-1 float-right" id="verForm">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-secondary" type="submit">
                                        {{__("Verify Order")}}
                                </button>
                            </form>
                            <button class="btn btn-secondary float-right" data-toggle="modal" title={{__("Insert Reciever Remark")}} data-target="#sender_remark">
                                <i class="fas fa-comment"></i>
                            </button>
                            @elseif($order->verified_at != null)
                                <a class="btn btn-secondary disabled float-right" href="#">{{__('Verified')}}</a>
                            @endif
                            @if (Auth::user()->id == 0)
                                <form action="{{route('deleteOrder',['id' => $order->id])}}" method="POST" class="float-right">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger" type="submit">
                                                {{__("Delete Order")}}
                                        </button>
                                </form>
                            @endif
                    </form>
                @endif
            </div>
    @endauth
</div>
<div class="modal fade" id="reciever_remark_item" tabindex="-1" role="dialog" aria-labelledby="reciever_remark_item_Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="reciever_remark_item_Label">{{__('Reciever Remark')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="order_item_id">
            <input type="hidden" id="item_id">
            <label for="reciever_remark_item_txt">{{__('Reciever Remark')}}</label>
            <textarea id="reciever_remark_item_txt" class="form-control w-100"></textarea>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="verItemInOrder()">{{__('Verify')}}</button>
        </div>
    </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="sender_remark" tabindex="-1" role="dialog" aria-labelledby="reciever_remarkLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="reciever_remarkLabel">{{__('Reciever Remark')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="order_id">
                <label for="reciever_remark_txt">{{__('Reciever Remark')}}</label>
                <textarea id="reciever_remark_txt" class="form-control w-100" onchange="addRem2form()"></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            <form action="{{route('verifyOrder',['id' => $order->id])}}" method="POST" class="mr-1 float-right" id="verForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="reciever_remark" name="reciever_remark">
                <button class="btn btn-secondary" type="submit">
                        {{__("Verify Order")}}
                </button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        
        function openVerItModal(ord,itm)
        {
            $('#order_item_id').val(ord);
            $('#item_id').val(itm);
            $('#reciever_remark_item').modal('show');
            
        }
        function addRem2form(){
            $('#reciever_remark').val($('#reciever_remark_txt').val());
        }
        function printPage(){
            $('#prtbtn').addClass('d-none');
            $('#btns').addClass('d-none');
            $('#trow').html('');
            window.print();
            return location.reload();
        }
    </script>
@endsection