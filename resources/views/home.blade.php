@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-2 bg-transparent text-lightkiwi h-100">
            @if(count($ads1) > 0)
            @foreach ($ads1 as $ads)
                <img src="..{{$ads->image_url}}" class="w-100 h-100 mb-2 rounded"> 
            @endforeach
            @else
                <img src="../images/e3lan/defad1-1.png" class="w-100 h-100 mb-2 rounded">
                <img src="../images/e3lan/defad1-2.jpg" class="w-100 h-100 mb-2 rounded">
            @endif
        </div>
        {{-- <div class="col-md-2 p-4 bg-navyblue text-lightkiwi">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div> --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Dashboard')}}</div>

                <div class="card-body">
                    @auth
                        <div class="alert alert-success" role="alert">
                                @if(session('message') != null)
                                    {{session('message')}} 
                                    <br>
                                @endif
                                {{__('Welcome')}} {{Auth::user()->f_name}} {{Auth::user()->s_name}} , {{__('you\'re logged in')}}.
                        </div>
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('items') }}" role="button"><i class="fas fa-pills mr-2"></i>{{__('Items')}}</a>
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('editUser', ['id'=>Auth::user()->id]) }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('My Account')}}</a>
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('editPassword') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Change Password')}}</a>
                    @if(Auth::user()->category->id == 1)
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('agents') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Agents')}}</a>
                    @endif
                    {{-- @if(Auth::user()->category->id == 3)
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('agentsDist') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Agents')}}</a>
                    @endif --}}
                    @if(Auth::user()->category->id == 2)
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('distributors') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Distributors')}}</a>
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('pharmacists') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Pharmacists')}}</a>
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('companies') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Companies')}}</a>
                    @endif
                    @if(Auth::user()->category->id == 4)
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('companies') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Companies')}}</a>
                    @endif
                    @if(Auth::user()->category->id == 5)
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('showFav') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Favourite Distributors')}}</a>
                    @endif
                    @if(Auth::user()->category->id == 0)
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('allUsers') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Manage Users')}}</a>
                    <a class="btn btn-lg btn-lightkiwi mb-1" href="{{ route('ads') }}" role="button"><i class="fas fa-user-circle mr-2"></i>{{__('Manage Ads')}}</a>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="col-md-2 bg-transparent text-lightkiwi h-100">
            @if(count($ads2) > 0)
            @foreach ($ads2 as $ads)
                <img src="..{{$ads->image_url}}" class="w-100 h-100 mb-2 rounded"> 
            @endforeach
            @else
                <img src="../images/e3lan/defad2-1.jpg" class="w-100 h-100 mb-2 rounded">
                <img src="../images/e3lan/defad2-2.jpg" class="w-100 h-100 mb-2 rounded">
            @endif
        </div>
        {{-- <div class="col-md-2 p-4 bg-navyblue text-lightkiwi">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div> --}}
    </div>
</div>
@endsection
