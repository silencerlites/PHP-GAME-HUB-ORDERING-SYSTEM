@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container py-5">

    <div class="row g-4">

        {{-- USERS LIST --}}
        <div class="col-lg-8">

            <span class="section-kicker">
                ACCOUNTS
            </span>

            <h1 class="fw-black">
                Customers & Staff
            </h1>

            {{-- FILTER --}}
            <form
                method="GET"
                class="filter-bar my-4"
            >
                <input
                    type="text"
                    class="form-control"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search name/email"
                >

                <select
                    class="form-select"
                    name="role"
                >
                    <option value="">
                        All roles
                    </option>

                    <option
                        value="staff"
                        @selected(request('role') === 'staff')
                    >
                        Staff
                    </option>

                    <option
                        value="customer"
                        @selected(request('role') === 'customer')
                    >
                        Customer
                    </option>
                </select>

                <button
                    type="submit"
                    class="btn btn-dark"
                >
                    Filter
                </button>

            </form>

            {{-- USERS TABLE --}}
            <div class="table-card">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($users as $user)

                                <tr>

                                    {{-- USER --}}
                                    <td>
                                        <strong>
                                            {{ $user->name }}
                                        </strong>

                                        <div class="small text-secondary">
                                            {{ $user->email }}
                                        </div>
                                    </td>

                                    {{-- ROLE --}}
                                    <td>
                                        {{ ucfirst($user->role) }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td>

                                        <span
                                            class="status
                                            {{ $user->status === 'active'
                                                ? 'status-completed'
                                                : 'status-cancelled' }}"
                                        >
                                            {{ ucfirst($user->status) }}
                                        </span>

                                    </td>

                                    {{-- ACTION --}}
                                    <td class="text-end">

                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.toggle', $user) }}"
                                            data-confirm="Change this account status?"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-dark"
                                            >
                                                {{ $user->status === 'active'
                                                    ? 'Deactivate'
                                                    : 'Activate' }}
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- PAGINATION --}}
            @if($users->hasPages())

                <div class="mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>

            @endif

        </div>


        {{-- CREATE STAFF --}}
        <div class="col-lg-4">

            <div class="summary-card">

                <h4 class="fw-black">
                    Create Staff
                </h4>

                <p class="text-secondary small">
                    Staff can process orders but cannot manage administrator accounts.
                </p>

                <form
                    method="POST"
                    action="{{ route('admin.users.staff.store') }}"
                >
                    @csrf

                    {{-- NAME --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Name
                        </label>

                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name') }}"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
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

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            minlength="8"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="btn btn-game w-100"
                    >
                        Create Staff
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
@endsection