@component('mail::message')

@component('mail::panel')
# Welcome to Profile Voyage

<center>Hey, you recently registered to <b>profilevoyage.com</b>! <br>Are you ready to share your online presence with the world?</center>

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Confirm Email
@endcomponent

@endcomponent

Thanks,<br>
Profile Voyage

<br>
*Don't recall doing this? Just ignore this email - you won't hear from us again.*
@endcomponent
