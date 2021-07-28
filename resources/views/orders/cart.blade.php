@extends('layouts.app')
@section('content')
@auth
    <div class="container py-4">
            <h3 class="w-75 d-inline-block">{{__('Cart')}}</h3>
            <hr>
        @foreach ($carts->groupBy('reciever_id') as $cart)
        <div class="mb-4">
          <div class="row">
                  <img class="img-fluid rounded-circle mx-2 mb-4" width="36px" src="{{ asset($cart->first()->reciever->logo_image) }}">
                  <h4>{{__("Reciever")}} : {{$cart->first()->reciever->f_name}} {{$cart->first()->reciever->s_name}}</h4>
          </div>
          <div class="table-responsive-md">
          <table class="table table-hover table-sm table-bordered mt-2" id="CartTable">
              <thead>
              <tr>
                  <th scope="col">#</th>
                  <th scope="col">{{__('Item')}}</th>
                  <th scope="col">{{__('Producer')}}</th>
                  <th scope="col">{{__('Quantity')}}</th>
                  <th scope="col">{{__('Free Quantity')}}</th>
                  <th scope="col">{{__('Price')}}</th>
                  <th scope="col">{{__('Actions')}}</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($cart as $item)
                  <tr @if($item->is_basket) data-toggle="collapse" class="clickable" data-target="#collapseBItems{{$item->id}}" aria-expanded="false" aria-controls="collapseBItems{{$item->id}}" @endif>
                      <th scope="row" @if($item->is_basket) rowspan="2" @endif >{{$item->id}}</th>
                      <td>@if($item->is_basket){{__("Basket")}}@else{{$item->item->name}}@endif</td>
                      <td>{{$item->item->company->f_name}}</td>
                      <td>{{$item->quantity}}</td>
                      <td>@if(!$item->is_basket){{$item->free_quant}}@endif</td>
                      <td>{{round($item->price,2)}}</td>
                      <td>
                        <form action="{{route('deleteCart',['id' => $item->id])}}" method="POST" class="d-inline-block">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm" type="submit">
                            {{__("Delete")}}
                        </button>
                        </form>
                      </td>
                  </tr>
                  @if($item->is_basket)
                  <tr>
                    <td colspan="6">
                        <div class="collapse" id="collapseBItems{{$item->id}}">
                            @foreach ($baskets->where('id',$item->item_id)->first()->items as $itemm)                            
                                    {{$itemm->name ." ". $itemm->type->ar_name ." ". $itemm->titer}} : <b>{{$itemm->pivot->quantity}}</b>
                                <br>
                            @endforeach
                        </div>
                    </td>
                  </tr>
                  @endif
                  @endforeach
              </tbody>
          </table>
        </div>
            <a class="btn btn-secondary" href="#" title="{{__('Insert Sender Remark')}}" onclick="showModal({{$cart->first()->reciever->id}})"><i class="fas fa-comment"></i></a>
            <a class="btn btn-secondary" href="#" onclick="storeOrderAjax({{$cart->first()->reciever->id}})">{{__('Send Order')}}</a>
        </div>
        @endforeach
        @if($carts->count()!=0)
          <a class="btn btn-secondary float-right" href="#" onclick="storeOrderAjax()">{{__('Send All Orders')}}</a>
        @endif
    </div>
        <!-- Modal -->
        <div class="modal fade" id="sender_remark" tabindex="-1" role="dialog" aria-labelledby="sender_remarkLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="sender_remarkLabel">{{__('Add to Cart')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="reciever">
                  <label for="remark">{{__('Sender Remark')}}</label>
                  <textarea id="remark" class="form-control w-100"></textarea>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="button" class="btn btn-primary" onclick="storeOrderAjax()">{{__('Send Order')}}</button>
              </div>
          </div>
          </div>
      </div>
    @endauth
@endsection

@section('scripts')
<script src="{{ asset('js/table.min.js') }}"></script>
<link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
<script>
  function showModal(id)
  {
    $('#reciever').val(id);
    $('#sender_remark').modal('show');
  }
  function storeOrderAjax(reciever = null)
  {
    if(reciever == null)
      reciever = $('#reciever').val();
    remark = $('#remark').val();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type:'POST',
      url:"{{route('storeOrder')}}",
      data:{reciever:reciever, remark:remark},
      success:function(data){
        console.log(data);
        location.href = "/orders";
      },
       error:function(error){
        console.log(error);
       }
   });    
  }
  $(document).ready(function() {
            $('#CartTable').DataTable({fixedHeader: true, 
                "info":     false,
                "oLanguage": {"sSearch": "<i class='fas fa-search'></i>"}
              });
        tablesFunc('CartTable');

          } );
</script>
@endsection
