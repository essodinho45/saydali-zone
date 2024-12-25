@extends('layouts.app')

@section('content')
    @auth
        <div class="container py-4">
            <h4>{{ __('please insert excel file in following form:') }}</h4>
            <br>
            <table class="table table-hover table-sm mt-2" id="ItemsTable">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Name') }} *</th>
                        <th scope="col">{{ __('Barcode') }}</th>
                        <th scope="col">{{ __('Composition') }}</th>
                        <th scope="col">{{ __('Dosage') }}</th>
                        <th scope="col">{{ __('Description 1') }}</th>
                        <th scope="col">{{ __('Description 2') }}</th>
                        <th scope="col">{{ __('Price') }} *</th>
                        <th scope="col">{{ __('Customer Price') }}</th>
                        <th scope="col">{{ __('Titer') }}</th>
                        <th scope="col">{{ __('Item Type') }} *</th>
                        <th scope="col">{{ __('Item Category') }}</th>
                        <th scope="col">{{ __('Properties') }}</th>
                        <th scope="col">{{ __('Package') }}</th>
                        <th scope="col">{{ __('Storage') }}</th>
                        {{-- <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Composition')}}</th>
                            <th scope="col">{{__('Dosage')}}</th>
                            <th scope="col">{{__('Description 1')}}</th>
                            <th scope="col">{{__('Descreption 2')}}</th>
                            <th scope="col">{{__('Properties')}}</th>
                            <th scope="col">{{__('Package')}}</th>
                            <th scope="col">{{__('Storage')}}</th>
                            @if (Auth::user()->category->id == 6)<th scope="col">{{__('Company')}}</th>@endif --}}
                    </tr>
                </thead>

                <tbody>
                    <tr style="font-size:0.8rem">
                        <td>{{ __('product name') }}</td>
                        <td>{{ __('product barcode') }}</td>
                        <td>{{ __('product composition') }}</td>
                        <td>{{ __('dosage of product') }}</td>
                        <td>{{ __('product indications') }}</td>
                        <td>{{ __('product side effects') }}</td>
                        <td>{{ __('price for pharmacist') }}</td>
                        <td>{{ __('price for customers') }}</td>
                        <td>{{ __('titer by milligrams') }}</td>
                        <td>{{ __('item type') }}</td>
                        <td>{{ __('item category') }}</td>
                        <td>{{ __('properties of product') }}</td>
                        <td>{{ __('product packaging') }}</td>
                        <td>{{ __('conditions of storage') }}</td>
                        {{-- <td>{{__("product name")}} ({{__('Second Language')}})</td>
                                <td>{{__("product composition")}} ({{__('Second Language')}})</td>
                                <td>{{__("product indications")}} ({{__('Second Language')}})</td>
                                <td>{{__("product side effects")}} ({{__('Second Language')}})</td>
                                <td>{{__("properties of product")}} ({{__('Second Language')}})</td>
                                <td>{{__("product packaging")}} ({{__('Second Language')}})</td>
                                <td>{{__("conditions of storage")}} ({{__('Second Language')}})</td>
                                <td>{{__("producer company")}}</td> --}}
                    </tr>
                </tbody>
            </table>
            <hr>
            <p>
                {{ __('Add the following fields afterwards for second language') }}:<br>
                <b>
                    {{ __('Name') }}<br>
                    {{ __('Composition') }}<br>
                    {{ __('Dosage') }}<br>
                    {{ __('Description 1') }}<br>
                    {{ __('Description 2') }}<br>
                    {{ __('Properties') }}<br>
                    {{ __('Package') }}<br>
                    {{ __('Storage') }}<br>
                </b>
            </p>
            @if (Auth::user()->category->id == 6)
                <p>{{ __('add company field last') }}</p>
            @endif
            <form action="{{ route('storeItems') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mt-4">
                    <div class="col-md-12">
                        <input type="file" class="form-control-file" name="items_file" id="items_file">
                    </div>
                </div>
                <!-- Input tags go here -->
                <button class="btn btn-info" type="submit">
                    {{ __('Import Items') }}
                </button>
            </form>
            <hr>
        </div>
    @endauth
@endsection
