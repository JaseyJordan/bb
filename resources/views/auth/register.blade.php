@extends('layouts.app')

@section('content')
    <main>
        <div class="card">
            <h1 class="text-center text-3xl">{{ __('Register') }}</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="my-4"><label for="name" class="">{{ __('Name') }}</label></div>

                <input id="name" type="text" class="w-full border border-gray-100 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="my-4"><label for="email">{{ __('E-Mail Address') }}</label></div>

                <input id="email" type="email" class="w-full border border-gray-100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="my-4"><label for="password">{{ __('Password') }}</label></div>

                <div class="my-4"><input id="password" type="password" class="w-full border border-gray-100 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"></div>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <div class="mb-4"><label for="password-confirm">{{ __('Confirm Password') }}</label></div>


                <div class="my-4"><input id="password-confirm" type="password" class="w-full border border-gray-100" name="password_confirmation" required autocomplete="new-password"></div>


                <button type="submit" class="button">
                    {{ __('Register') }}
                </button>

            </form>
    </main>



@endsection
