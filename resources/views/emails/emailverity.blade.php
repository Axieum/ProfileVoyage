@component('mail::message')

@component('mail::panel')
# Confirm your Profile Voyage Email

<center>Please confirm your account to gain access to the amazing features of <b>Profile Voyage</b></center>

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Confirm Email
@endcomponent

@endcomponent

Thanks,<br>
Profile Voyage

<br>
*Don't recall doing this? Just ignore this email - you won't hear from us again.*
@endcomponent
