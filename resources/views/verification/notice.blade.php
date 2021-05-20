@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Please Verify')}}</div>

                <div class="card-body">
                    {{__("Your account is not verified yet, if it's not verified in 24 hours please contact our support.")}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
