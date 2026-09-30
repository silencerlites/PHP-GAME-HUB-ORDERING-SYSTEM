@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-shell">

    <div class="auth-card card border-0">

        {{-- ICON --}}
        <div class="auth-icon">
            <i class="bi bi-controller"></i>
        </div>

        {{-- TITLE --}}
        <h1 class="fw-black text-center">
            Player Login
        </h1>

        <p class="text-secondary text-center">
            Continue your GameHub session.
        </p>

        {{-- LOGIN FORM --}}
        <form
            method="POST"
            action="{{ route('login.submit') }}"
            class="mt-4"
        >
            @csrf

            {{-- EMAIL --}}
            <div class="mb-3">

                <label
                    for="email"
                    class="form-label fw-semibold"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control form-control-lg
                           @error('email') is-invalid @enderror"
                    required
                    autofocus
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">

                <label
                    for="password"
                    class="form-label fw-semibold"
                >
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control form-control-lg
                           @error('password') is-invalid @enderror"
                    required
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- REMEMBER ME --}}
            <div class="form-check mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    value="1"
                    id="remember"
                    @checked(old('remember'))
                >

                <label
                    class="form-check-label"
                    for="remember"
                >
                    Remember me
                </label>

            </div>

            {{-- LOGIN BUTTON --}}
            <button
                type="submit"
                class="btn btn-game w-100 btn-lg"
            >
                Start Session
            </button>

        </form>

        {{-- REGISTER LINK --}}
        <div class="text-center mt-4">

            New player?

            <a
                href="{{ route('register') }}"
                class="fw-bold text-danger"
            >
                Create an account
            </a>

        </div>

    </div>

</div>
@endsection