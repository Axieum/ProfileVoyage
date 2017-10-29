@if (Session::has('message'))
    <div class="{{ Route::is(['login', 'register', 'password.reset', 'password.request']) ?: 'container' }} notification is-{{ Session::get('status') }}">
        <button class="delete"></button>
        <p>{{ Session::get('message') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="notification is-danger">
        <button class="delete"></button>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
