@extends('auth.template')

@section('content')
    <div>
        <div>
            <div>
                <div>
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <h1>{{ $error }}</h1>
                        @endforeach
                    @endif
                    @error('email')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div>
                        <p>Sign into your account</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div>
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="Email address">
                                @error('email')
                                <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="***********">
                                @error('password')
                                <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input name="login" id="login" type="submit" value="Login">
                        </form>
                        <a href="#!">Forgot password?</a>
                        <p >Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                        <nav>
                            <a href="#!">Terms of use.</a>
                            <a href="#!">Privacy policy</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
@endsection
