@component('mail::message')
# Confirm your Profile Voyage Email

Please confirm your account to gain access to the amazing features of **Profile Voyage**

@component('mail::button', ['url' => $url])
Confirm Email
@endcomponent

Thanks,<br>
Profile Voyage

<br>

*Having trouble clicking the button? {{ $url }}.*
@endcomponent
