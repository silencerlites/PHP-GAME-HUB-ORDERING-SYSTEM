@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-shell">

    <div class="auth-card card border-0">

        {{-- ICON --}}
        <div class="auth-icon">
            <i class="bi bi-person-plus-fill"></i>
        </div>

        {{-- TITLE --}}
        <h1 class="fw-black text-center">
            Create Player
        </h1>

        <p class="text-secondary text-center">
            Register a customer account to order games.
        </p>

        {{-- REGISTER FORM --}}
        <form
            method="POST"
            action="{{ route('register.submit') }}"
            class="mt-4"
        >
            @csrf

            {{-- NAME --}}
            <div class="mb-3">

                <label
                    for="name"
                    class="form-label fw-semibold"
                >
                    Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control form-control-lg
                           @error('name') is-invalid @enderror"
                    required
                    autofocus
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

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

            {{-- CONFIRM PASSWORD --}}
            <div class="mb-4">

                <label
                    for="password_confirmation"
                    class="form-label fw-semibold"
                >
                    Confirm Password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control form-control-lg"
                    required
                >

            </div>

            {{-- REGISTER BUTTON --}}
            <button
                type="submit"
                class="btn btn-game w-100 btn-lg"
            >
                Create Account
            </button>

        </form>

        {{-- LOGIN LINK --}}
        <div class="text-center mt-4">

            Already registered?

            <a
                href="{{ route('login') }}"
                class="fw-bold text-danger"
            >
                Login
            </a>

        </div>

    </div>

</div>
@endsection