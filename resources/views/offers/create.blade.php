@extends('layouts.app')
@if (in_array(Auth::user()->user_category_id, [
        Constants::ADMIN,
        Constants::COMPANY,
        Constants::AGENT,
        Constants::DISTRIBUTOR,
    ]))
    @section('content')
        @auth
            <div class="container py-4">
                <form action="{{ route('storeOffer') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3" for="offer_type">{{ __('Offer Type') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" id="offer_type"
                                class="form-control @error('offer_type') is-invalid @enderror" name="offer_type"
                                value="{{ old('offer_type') }}">
                                <option value="1">{{ __('Discount') }}</option>
                                <option value="2">{{ __('Addetional Quantity') }}</option>
                                <option value="3">{{ __('Basket') }}</option>
                            </select>
                            @error('offer_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-3" for="from_date">{{ __('From Date') }}</label>
                        <div class="col-md-3">
                            <input id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror"
                                name="from_date" value="{{ old('from_date') }}">

                            @error('from_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <label class="col-md-3" for="to_date">{{ __('To Date') }}</label>
                        <div class="col-md-3">
                            <input id="to_date" type="date" class="form-control @error('to_date') is-invalid @enderror"
                                name="to_date" value="{{ old('to_date') }}">

                            @error('to_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div id="offer">
                        <div class="form-group row">
                            <label class="col-md-3" for="item_id">{{ __('Item') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="item_id"
                                    class="form-control @error('item_id') is-invalid @enderror" name="item_id"
                                    value="{{ old('item_id') }}">
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->company->f_name }} -
                                            {{ $item->name }} {{ $item->titer }} {{ __('mg') }}</option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3" for="discount">{{ __('Discount') }} %</label>
                            <div class="col-md-6">
                                <input id="discount" type="number"
                                    class="form-control @error('discount') is-invalid @enderror" name="discount"
                                    value="{{ old('discount') }}">

                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3" for="quant">{{ __('Minimum quantity for offer') }}</label>
                            <div class="col-md-6">
                                <input id="quant" type="number" class="form-control @error('quant') is-invalid @enderror"
                                    name="quant" value="{{ old('quant') }}">

                                @error('quant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="display:none;">
                            <label class="col-md-3" for="free_item">{{ __('Free Item') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="free_item"
                                    class="form-control @error('free_item') is-invalid @enderror" name="free_item"
                                    value="{{ old('free_item') }}">
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} {{ $item->type->ar_name }}
                                            {{ $item->titer }} {{ __('mg') }} - {{ $item->company->f_name }}</option>
                                    @endforeach
                                </select>
                                @error('free_item')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="display:none;">
                            <label class="col-md-3" for="free_quant">{{ __('Free quantity') }}</label>
                            <div class="col-md-6">
                                <input id="free_quant" type="number"
                                    class="form-control @error('free_quant') is-invalid @enderror" name="free_quant"
                                    value="{{ old('free_quant') }}">

                                @error('free_quant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3" for="remark">{{ __('Remark') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="5" id="remark" name="remark"></textarea>

                                @error('remark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div id="basket" style="display:none;">
                        <div class="form-group row">
                            <label class="col-md-3" for="name">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <table class="table table-hover table-sm mt-2" id="ItemsTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Producer') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Customer Price') }}</th>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    <th scope="col">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->company->f_name }}</td>
                                        <td>{{ round($item->price, 2) }}</td>
                                        <td>{{ round($item->customer_price, 2) }}</td>
                                        <td>{{ $item->type->ar_name }}</td>
                                        <td><input id="item_quant_{{ $item->id }}" type="number" min="0"
                                                class="form-control w-50" name="item_quant_{{ $item->id }}"
                                                value="0"></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" id="addbtn{{ $item->id }}"
                                                href="#ItemsTable"
                                                onclick="addToBasket({{ $item->id }}, {{$item->price}})">{{ __('Add to Basket') }}</a>
                                            <a class="btn btn-danger btn-sm disabled" id="delbtn{{ $item->id }}"
                                                href="#ItemsTable"
                                                onclick="removeFromBasket({{ $item->id }}, {{$item->price}})">{{ __('Delete') }}</a>
                                            <input type="hidden" id="added{{ $item->id }}" value="false">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="form-group row">
                            <div class="col-12 mb-3">{{__('Original Price')}}: <b id="price_val">0</b></div>
                            <label class="col-md-3" for="price">{{ __('Basket Price') }}</label>
                            <div class="col-md-6">
                                <input id="price" type="number"
                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                    value="{{ old('price') }}">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                                        <label class="col-md-3" for="from_date">{{__("From Date")}}</label>
                                        <div class="col-md-3">
                                                <input id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}">

                                                @error('from_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>

                                        <label class="col-md-3" for="to_date">{{__("To Date")}}</label>
                                        <div class="col-md-3">
                                                <input id="to_date" type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date" value="{{ old('to_date') }}">

                                                @error('to_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                </div> --}}
                    <input type="hidden" name="basket_info" id="basket_info">
                    <button class="btn btn-info" type="submit">
                        {{ __('Save Offer') }}
                    </button>
                </form>
                {{-- <form action="{{route('deletePost',['id' => $post->id])}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger" type="submit">
                            {{__("Delete Post")}}
                        </button>
                </form> --}}
            </div>
        @endauth
    @endsection
    @section('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/table.min.js') }}"></script>
        <link href="{{ asset('css/table.min.css') }}" rel="stylesheet">
        <script>
            var basketItems = [];
            var originalPrice = 0;
            function addToBasket(id, price) {
                if ($('#added' + id).val() == 'false') {
                    console.log($('#added' + id).val());
                    var quant = $('#item_quant_' + id).val();
                    originalPrice += price * quant;
                    basketItems.push(id + "-" + quant);
                    console.log(basketItems);
                    $("#basket_info").val(basketItems);
                    $('#added' + id).val('true');
                    $('#addbtn' + id).addClass('disabled');
                    $('#delbtn' + id).removeClass('disabled');
                    $('#price_val').html(originalPrice);
                }
            }

            function removeFromBasket(id, price) {
                if ($('#added' + id).val() == 'true') {
                    console.log($('#added' + id).val());
                    var result = basketItems.find((item) => {
                        return item.startsWith(id+'-');
                    });
                    var index = basketItems.indexOf(result);
                    if (index !== -1) {
                        var quant = basketItems[index].split('-')[1];
                        originalPrice -= price * quant;
                        basketItems.splice(index, 1);
                    }
                    $("#basket_info").val(basketItems);
                    $('#added' + id).val('false');
                    $('#item_quant_' + id).val(0);
                    $('#delbtn' + id).addClass('disabled');
                    $('#addbtn' + id).removeClass('disabled');
                }
                $('#price_val').html(originalPrice);
            }
            $(document).ready(function() {
                // itemsOfferAjax();
                $('#ItemsTable').DataTable();
                $('#item_id').select2();
                $('#free_item').select2();
            });
            $('#offer_type').on('change', function() {
                if ($('#offer_type').val() == 3) {
                    $('#offer').hide();
                    $('#basket').show();
                } else {
                    $('#basket').hide();
                    $('#offer').show();
                    if ($('#offer_type').val() == 2) {
                        $("#discount").parent().parent().hide();
                        $("#free_item").parent().parent().show();
                        $("#free_quant").parent().parent().show();
                    } else {
                        $("#free_item").parent().parent().hide();
                        $("#free_quant").parent().parent().hide();
                        $("#discount").parent().parent().show();
                    }
                }
            });
        </script>
    @endsection
@endif
