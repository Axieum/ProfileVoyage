@if (Session::has('message'))
    <div class="{{ Route::is(['login', 'register', 'password.reset', 'password.request']) ?: 'container' }} notification is-fixed is-{{ Session::get('status') }}">
        <button class="delete"></button>
        <p>{{ Session::get('message') }}</p>
    </div>
@endif
