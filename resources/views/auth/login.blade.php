@extends('layouts.app')

@section('content')
    <main>
        <div class="card">
            <h1 class="text-center text-3xl">{{ __('Login') }}</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">{{ __('E-Mail Address') }}</label>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="email" type="email" class="w-full border border-gray-100 mb-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                <label for="password">{{ __('Password') }}</label>


                <input id="password" type="password" class="w-full border border-gray-100 mb-4 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
                <div>
                    <button type="submit" class="button mt-4 mr-4">
                        {{ __('Login') }}
                    </button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>




            </form>
        </div>
    </main>

@endsection
