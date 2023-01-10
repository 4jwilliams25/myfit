@extends('auth.template')

@section('content')
    <div>
        <div>
            <div>
                <div>
                    <div>
                        <p>Register a new account</p>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div>
                                <label for="name">Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                            </div>
                            @error('name')
                            <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div>
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email address">
                                @error('email')
                                <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                                @error('password')
                                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label for="password">Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                            </div>
                            <input name="register" id="register" type="submit" value="Register">
                        </form>
                        <a href="#!">Forgot password?</a>
                        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                        <nav>
                            <a href="#!">Terms of use.</a>
                            <a href="#!">Privacy policy</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
