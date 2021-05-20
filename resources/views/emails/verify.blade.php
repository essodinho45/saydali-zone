@component('mail::message')
# {{__('Verified')}}

{{__('Your email has benn verified, thanks for joining SaydaliZone')}}

@component('mail::button', ['url' => 'saydalizone.alkhazensoft.net'])
{{__('Visit Us')}}
@endcomponent

@endcomponent
