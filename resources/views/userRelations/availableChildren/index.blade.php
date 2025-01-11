@extends('layouts.app')

@section('content')
    @auth
        <div class="container py-4">
            @if (\Route::currentRouteName() == 'distributors')
                <h3 class="w-75 d-inline-block">{{ __('Distributors') }}</h3>
                @if (Auth::user()->category->id == 2)
                    <button class="btn btn-primary float-right" type="submit"
                        onclick="window.location='{{ route('createUserForm') }}'">
                        {{ __('Create Distributor') }}
                    </button>
                @endif
            @elseif(\Route::currentRouteName() == 'agents')
                <h3 class="w-75 d-inline-block">{{ __('Agents') }}</h3>
                @if (Auth::user()->category->id == 1)
                    <button class="btn btn-primary float-right" type="submit"
                        onclick="window.location='{{ route('createUserForm') }}'">
                        {{ __('Create Agent') }}
                    </button>
                @endif
            @elseif(\Route::currentRouteName() == 'pharmacists')
                <h3 class="w-75 d-inline-block">{{ __('Pharmacists') }}</h3>
                @if (Auth::user()->category->id == 3)
                    <button class="btn btn-primary float-right" type="submit"
                        onclick="window.location='{{ route('createUserForm') }}'">
                        {{ __('Create Pharmacist') }}
                    </button>
                @endif
            @endif
            <hr>
            <div class="table-responsive-md">
                <table class="table table-hover table-bordered table-sm mt-2" id="childrenTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Second Name') }}</th>
                            <th scope="col">{{ __('Country') }}</th>
                            <th scope="col">{{ __('Region') }}</th>
                            <th scope="col">{{ __('City') }}</th>
                            <th scope="col">{{ __('Telephone 1') }}</th>
                            <th scope="col">{{ __('E-Mail Address') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availableChildren as $child)
                            @if (\Route::currentRouteName() == 'distributors' && $child->category->id != 3)
                                @continue
                            @elseif(\Route::currentRouteName() == 'pharmacists' && $child->category->id != 5)
                                @continue
                            @endif
                            @if ($child->category->id != 4 && $child->parents->contains('id', Auth::user()->id))
                                <tr @if ($child->isFreezed) class='table-danger' @endif>
                                    <th scope="row">{{ $child->id }}</th>
                                    <td>{{ $child->f_name }}</td>
                                    <td>{{ $child->s_name }}</td>
                                    <td>{{ $child->itsCountry->ar_name }}</td>
                                    <td>{{ $child->itsCity->ar_name }}</td>
                                    <td>{{ $child->region }}</td>
                                    <td>{{ $child->tel1 }}</td>
                                    <td>{{ $child->email }}</td>
                                    <td>
                                        <a class="btn btn-secondary btn-sm"
                                            href="/showUsr/{{ $child->id }}">{{ __('Show') }}</a>
                                        @if (Auth::user()->category->id == 1)
                                            @if ($child->category->id == 2)
                                                @if (!$child->parents->isEmpty())
                                                    @if (!$child->isVerified)
                                                        <a class="btn btn-secondary btn-sm" id="verifyBtn{{ $child->id }}"
                                                            href="#"
                                                            onclick="verifyRelAjax({{ $child->id }})">{{ __('Verify') }}</a>
                                                    @else
                                                        <a class="btn btn-secondary btn-sm btn-disabled disabled"
                                                            href="#">{{ __('Verified') }}</a>
                                                    @endif
                                                    <a class="btn btn-danger btn-sm @if ($child->isFreezed) d-none @endif"
                                                        id="freezeBtn{{ $child->id }}" href="#"
                                                        onclick="freezeRelAjax({{ $child->id }}, true)">{{ __('Freeze') }}</a>
                                                    <a class="btn btn-info btn-sm @if (!$child->isFreezed) d-none @endif"
                                                        id="unfreezeBtn{{ $child->id }}" href="#"
                                                        onclick="freezeRelAjax({{ $child->id }}, false)">{{ __('Unfreeze') }}</a>
                                                @endif
                                            @endif
                                        @endif
                                        @if (Auth::user()->category->id == 2)
                                            @if ($child->category->id == 3)
                                                @if (!$child->parents->isEmpty())
                                                    @if (!$child->isVerified)
                                                        <a class="btn btn-secondary btn-sm" id="verifyBtn{{ $child->id }}"
                                                            href="#"
                                                            onclick="verifyRelAjax({{ $child->id }})">{{ __('Verify') }}</a>
                                                    @else
                                                        <a class="btn btn-secondary btn-sm btn-disabled disabled"
                                                            href="#">{{ __('Verified') }}</a>
                                                    @endif
                                                    <a class="btn btn-danger btn-sm @if ($child->isFreezed) d-none @endif"
                                                        id="freezeBtn{{ $child->id }}" href="#"
                                                        onclick="freezeRelAjax({{ $child->id }}, true)">{{ __('Freeze') }}</a>
                                                    <a class="btn btn-info btn-sm @if (!$child->isFreezed) d-none @endif"
                                                        id="unfreezeBtn{{ $child->id }}" href="#"
                                                        onclick="freezeRelAjax({{ $child->id }}, false)">{{ __('Unfreeze') }}</a>
                                                @endif
                                            @endif
                                        @endif
                                        {{-- @if ($child->category->id != 5)
                            @if (!$child->parents->isEmpty() && $child->parents->contains('id', Auth::user()->id))
                                @if (!$child->isFreezed)
                                    <a class="btn btn-danger btn-sm" id="freezeBtn{{$child->id}}" href="#" onclick="freezeRelAjax({{$child->id}}, true)">{{__('Freeze')}}</a>
                                @else
                                    <a class="btn btn-info btn-sm" id="freezeBtn{{$child->id}}" href="#" onclick="freezeRelAjax({{$child->id}}, false)">{{__('Unfreeze')}}</a>
                                @endif
                            @else
                            <a class="btn btn-secondary btn-sm" id="addBtn{{$child->id}}" href="#" onclick="addChildAjax({{$child->id}})">{{__('Add')}}</a>
                            @endif
                        @endif --}}
                                    </td>
                                </tr>
                            @endif
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
            $('#childrenTable').DataTable({
                fixedHeader: true,
                "info": false,
                "oLanguage": {
                    "sSearch": "<i class='fas fa-search'></i>"
                }
            });
            tablesFunc('childrenTable');
        });
    </script>
@endsection
