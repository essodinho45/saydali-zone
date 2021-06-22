@extends('layouts.app')

@section('content')

<div class="container py-4 text-center">
            <h2>{{$item->name}}</h2>            
            <small class="text-muted"> @if($item->type != null) {{ $item->type->ar_name }}&nbsp; @endif @if($item->titer != null) {{ $item->titer }}&nbsp;{{__('mg')}} @endif </small>
            <hr>
                <div class="p-2">
                    <div>
                        @if($item->composition)
                        <h6>{{__('Composition')}}</h6>
                        <p>
                            {{$item->composition}}
                        </p>
                        @endif
                        @if($item->dosage)
                        <h6>{{__('Dosage')}}</h6>
                        <p>
                            {{$item->dosage}}
                        </p>
                        @endif
                        @if($item->descr1)
                        <h6>{{__('Description 1')}}</h6>
                        <p>
                            {{$item->descr1}}
                        </p>
                        @endif
                        @if($item->properties != null)
                        <h6>{{__('Properties')}}</h6>
                        <p>
                            {{$item->properties}}
                        </p>
                        @endif
                        @if($item->descr2 != null)
                        <h6>{{__('Description 2')}}</h6>
                        <p>
                            {{$item->descr2}}
                        </p>
                        @endif
                        @if($item->package != null)
                        <h6>{{__('Package')}}</h6>
                        <p>
                            {{$item->package}}
                        </p>
                        @endif
                        @if($item->storage != null)
                        <h6>{{__('Storage')}}</h6>
                        <p>
                            {{$item->storage}}
                        </p>
                        @endif
                        <hr>
                        <div class="row col-12">
                            <div class="col-md-3">
                            <h6>{{__('Price')}}</h6>
                            <p>
                                {{round($item->price, 2)}} {{__('S.P.')}}
                            </p>
                            </div>
                            <div class="col-md-3">
                            @if($item->customer_price != null)
                            <h6>{{__('Customer Price')}}</h6>
                            <p>
                                {{round($item->customer_price, 2)}} {{__('S.P.')}}
                            </p>
                            @endif
                            </div>
                            <div class="col-md-3 offset-md-3">
                                <span>{{ __('Produced By: ') }}<i>{{$item->company->f_name}}</i> .</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @auth
                    @if (Auth::user()->user_category_id == 0 || Auth::user()->id == $item->company->id)
                        <form action="{{route('deleteItem',['id' => $item->id])}}" method="POST" class="my-2 float-right">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <a class="btn btn-secondary" href="{{ route('editItem', ['id'=>$item->id]) }}">{{__('Edit')}}</a>
                                <button class="btn btn-danger" type="submit">
                                    {{__("Delete Item")}}
                                </button>
                        </form>
                    @elseif(Auth::user()->user_category_id == 5)
                    <div class="row">
                        <div class="col-md-4">
                            <label for="quantity{{$item->id}}" class="float-left text-left">{{__('Quantity')}}</label>
                            <input type="number" placeholder="0" id="quantity{{$item->id}}" min="0" class="form-control form-control" name="quantity{{$item->id}}" value="0" onchange="quantityChange({{$item->id}})" required>
                        </div>
                        <div class="col-md-4">
                            <label for="reciever_id{{$item->id}}" class="float-left text-left">{{__('Reciever')}}</label>
                            <select id="reciever_id{{$item->id}}" class="form-control form-control" name="reciever_id{{$item->id}}" value="" required>
                                <option disabled>{{__('please select quantity first')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sender_remark_txt" class="float-left text-left">{{__('Sender Remark')}}</label>
                            <textarea id="sender_remark_txt" class="form-control w-100" rows="1"></textarea>
                        </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-primary disabled btn mt-2 float-right"  onclick="ajaxSendtoCart({{$item->id}}, false)" disabled id="i_btn{{$item->id}}">
                            {{__('Add to Cart')}}
                        </button>
                    </div>
                    </div>
                    @endif
                @endauth
</div>
@endsection

@section('scripts')
<script>
function ajaxSendtoCart(item = null, isBasket){
    isBasket = false;
    sender_remark = $('#sender_remark_txt').val();
    quantity = $('#quantity'+item).val();
    reciever_id = $('#reciever_id'+item).val();
if(quantity>0){
    $.ajax({
    type:'POST',
    url:'/addToCart',
    data:{item_id: item,
        isBasket: isBasket,
        reciever_id: reciever_id,
        quantity: quantity, 
        sender_remark: sender_remark},
    success:function(data){
        console.log(data);
        location.reload();
    },
    error:function(error){
        console.log(error);
    }
});}
}
function quantityChange(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });

                $.ajax({
                type:'POST',
                url:'/cart/postItem',
                data:{id: id, isBasket: false},
                success:function(data){
                        console.log(data);
                        $("#reciever_id"+id).find('option').remove();
                        $.each( data, function( key) {
                        var o = new Option(data[key].f_name, data[key].id);
                        var sname = (data[key].s_name == null) ? '' : data[key].s_name ;
                        /// jquerify the DOM object 'o' so we can use the html method
                        $(o).html(data[key].f_name + " " + sname);
                        $("#reciever_id"+id).append(o);
                        });
                        $('#i_btn'+id).removeAttr('disabled').removeClass('disabled');                  
                },
                error:function(error){
                    console.log(error);
                }
            });  
          }
</script>
@endsection