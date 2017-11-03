@component('mail::message')
# Welcome to Profile Voyage

Hey, you recently registered to **Profile Voyage**! Are you ready to share your online presence?

@component('mail::button', ['url' => $url])
Confirm Email
@endcomponent

Thanks,<br>
Profile Voyage

<br>

*Having trouble clicking the button? {{ $url }}.*
@endcomponent
