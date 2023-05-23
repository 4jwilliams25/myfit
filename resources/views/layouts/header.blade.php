<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyFit</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>
    {{-- @vite('resources/css/app.css') --}}
</head>

@if (Auth::user())

<nav>
    <ul>
        <h3>MyFit</h3>

        <li>
            <a 
                href="/"
                class="{{ request()->is('/') ? 'active' : '' }}"
            >
                Home
            </a>
        </li>
        <li>
            <a 
                href="{{ url('diary') }}"
                class="{{ request()->is('diary') ? 'active' : '' }}"
            >
                My Diary
            </a>
        </li>
        <li>
            <a 
                href="{{ url('mystuff') }}"
                class="{{ request()->is('mystuff') ? 'active' : '' }}"
            >
                My Stuff
            </a>
        </li>
        <li>
            <a 
                href="{{ url('groceries/' . Auth::user()->id) }}"
                class="{{ request()->is('groceries/' . Auth::user()->id) ? 'active' : '' }}"
            >
                My Groceries
            </a>
        </li>

        <h3>
            Welcome {{ Auth::user()->name}}
        </h3>

        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
</nav>
@else
<nav>
    <ul>
        <h3>MyFit</h3>

        <li>
            <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('login-form').submit();">Login</a>
        </li>
    </ul>

    <form id="login-form" action="{{ route('login') }}" method="POST">
        @csrf
    </form>
</nav>
@endif