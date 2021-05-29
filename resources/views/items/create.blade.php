@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-lightkiwi">{{ __('Add Item') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storeItem') }}" id="newItemForm" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-8 offset-md-2">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-first-tab" data-toggle="tab" href="#nav-first" role="tab" aria-controls="nav-first" aria-selected="true">{{__("First Language")}}</a>
                                    <a class="nav-item nav-link" id="nav-lang2-tab" data-toggle="tab" href="#nav-lang2" role="tab" aria-controls="nav-lang2" aria-selected="false">{{__("Second Language")}}</a>
                                </div>
                            </nav>
                        </div>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-first" role="tabpanel" aria-labelledby="nav-first-tab">
                                    @if (Auth::user()->user_category_id == 0)
                                    <div class="form-group row">
                                            <label class="col-md-3 text-right" for="user_id">{{__("Company")}} *</label>
                                            <div class="col-md-6">
                                                <select class="form-control" id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}">
                                                    {{-- <option value="" selected disabled>{{ __('Item Type') }}</option> --}}
                                                    @foreach ($comps as $comp)
                                                    <option value="{{$comp->id}}" @if(old('user_id') == $comp->id) selected @endif>{{ $comp->f_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="item_type_id">{{__("Item Type")}}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="item_type_id" class="form-control @error('item_type_id') is-invalid @enderror" name="item_type_id" value="{{ old('item_type_id') }}">
                                                {{-- <option value="" selected disabled>{{ __('Item Type') }}</option> --}}
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}">{{ $type->ar_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_type_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                </div>
            
                                    <div class="form-group row">
                                            <label class="col-md-3 text-right" for="name">{{__("Name")}} *</label>
                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="image">{{__("Image")}}</label>
                                        <div class="col-md-6">
                                                <input type="file" class="form-control-file" name="image" id="image">
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                            <label class="col-md-3 text-right" for="barcode">{{__("Barcode")}}</label>
                                            <div class="col-md-6">
                                                <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ old('barcode') }}">
                
                                                @error('barcode')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                            <label class="col-md-3 text-right" for="composition">{{__("Composition")}}</label>
                                            <div class="col-md-6">
                                                <textarea id="composition" class="form-control @error('composition') is-invalid @enderror" name="composition" form="newItemForm">{{ old('composition') }}</textarea>                
                                                @error('composition')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="dosage">{{__("Dosage")}}</label>
                                        <div class="col-md-6">
                                            <textarea id="dosage" class="form-control @error('dosage') is-invalid @enderror" name="dosage" form="newItemForm">{{ old('dosage') }}</textarea>                
            
                                            @error('dosage')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="descr1">{{__("Description 1")}}</label>
                                        <div class="col-md-6">
                                                <textarea id="descr1" class="form-control @error('descr1') is-invalid @enderror" name="descr1" form="newItemForm">{{ old('descr1') }}</textarea>                
                
                                                @error('descr1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="descr2">{{__("Description 2")}}</label>
                                        <div class="col-md-6">
                                                <textarea id="descr2" class="form-control @error('descr2') is-invalid @enderror" name="descr2" form="newItemForm">{{ old('descr2') }}</textarea>
            
                                                @error('descr2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        
                                        <label class="col-md-3 text-right" for="price">{{__("Price")}} * / {{ __('Customer Price') }}</label>
                                        <div class="col-md-3">
                                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required placeholder="{{__("Price")}}">
                
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
            
                                            <div class="col-md-3">
                                                <input id="customer_price" type="number" class="form-control @error('customer_price') is-invalid @enderror" name="customer_price" value="{{ old('customer_price') }}" placeholder="{{__("Customer Price")}}">
                
                                                @error('customer_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="titer">{{__("Titer")}}</label>
                                        <div class="col-md-6">
                                                <input id="titer" type="number" class="form-control @error('titer') is-invalid @enderror" name="titer" value="{{ old('titer') }}">
                
                                                @error('titer')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="properties">{{__("Properties")}}</label>
                                        <div class="col-md-6">
                                                <textarea id="properties" class="form-control @error('properties') is-invalid @enderror" name="properties" form="newItemForm">{{ old('properties') }}</textarea>
                                                @error('properties')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="package">{{__("Package")}}</label>
                                        <div class="col-md-6">
                                                <textarea id="package" class="form-control @error('package') is-invalid @enderror" name="package" form="newItemForm">{{ old('package') }}</textarea>
                
                                                @error('package')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="storage">{{__("Storage")}}</label>
                                        <div class="col-md-6">
                                                <textarea id="storage" class="form-control @error('storage') is-invalid @enderror" name="storage" form="newItemForm">{{ old('storage') }}</textarea>

                                                @error('storage')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-lang2" role="tabpanel" aria-labelledby="nav-lang2-tab">            
                                    <div class="form-group row">
                                            <label class="col-md-3 text-right" for="name_en">{{__("Name")}} ({{__("Second Language")}})</label>
                                            <div class="col-md-6">
                                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}">
                
                                                @error('name_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                            <label class="col-md-3 text-right" for="composition_en">{{__("Composition")}} ({{__("Second Language")}})</label>
                                            <div class="col-md-6">
                                                <textarea id="composition_en" class="form-control @error('composition_en') is-invalid @enderror" name="composition_en" form="newItemForm">{{ old('composition_en') }}</textarea>
                
                                                @error('composition_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="dosage_en">{{__("Dosage")}} ({{__("Second Language")}})</label>
                                        <div class="col-md-6">
                                            <textarea id="dosage_en" class="form-control @error('dosage_en') is-invalid @enderror" name="dosage_en" form="newItemForm">{{ old('dosage_en') }}</textarea>                
            
                                            @error('dosage_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="descr1_en">{{__("Description 1")}}  ({{__("Second Language")}})</label>
                                        <div class="col-md-6">
                                                <textarea id="descr1_en" class="form-control @error('descr1_en') is-invalid @enderror" name="descr1_en" form="newItemForm">{{ old('descr1_en') }}</textarea>
                
                                                @error('descr1_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="descr2_en">{{__("Description 2")}} ({{__("Second Language")}})</label>
                                        <div class="col-md-6">
                                                <textarea id="descr2_en" class="form-control @error('descr2_en') is-invalid @enderror" name="descr2_en" form="newItemForm">{{ old('descr2_en') }}</textarea>
                
                                                @error('descr2_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="properties_en">{{__("Properties")}} ({{__("Second Language")}})</label>
                                        <div class="col-md-6">
                                                <textarea id="properties_en" class="form-control @error('properties_en') is-invalid @enderror" name="properties_en" form="newItemForm">{{ old('properties_en') }}</textarea>
                                                @error('properties_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="package_en">{{__("Package")}} ({{__("Second Language")}})</label>

                                        <div class="col-md-6">
                                                <textarea id="package_en" class="form-control @error('package_en') is-invalid @enderror" name="package_en" form="newItemForm">{{ old('package_en') }}</textarea>                
                
                                                @error('package_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label class="col-md-3 text-right" for="storage_en">{{__("Storage")}} ({{__("Second Language")}})</label>
                                        <div class="col-md-6">
                                                <textarea id="storage_en" class="form-control @error('storage_en') is-invalid @enderror" name="storage_en" form="newItemForm">{{ old('storage_en') }}</textarea>
                
                                                @error('storage_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-lightkiwi">
                                    {{ __('Save Item') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
