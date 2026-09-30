@extends('layouts.app')

@section('title', 'Games')

@section('content')
<div class="container py-5">

    {{-- PAGE HEADER --}}
    <div class="page-head mb-4">
        <div>
            <span class="section-kicker">
                PLAYER STORE
            </span>

            <h1 class="fw-black">
                Choose a game
            </h1>

            <p class="text-secondary mb-0">
                Add titles to your cart and checkout when you are ready.
            </p>
        </div>
    </div>


    {{-- FILTER --}}
    <form
        method="GET"
        action="{{ route('customer.catalog') }}"
        class="filter-bar mb-4"
    >

        <input
            type="text"
            class="form-control"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search title or genre"
        >

        <select
            class="form-select"
            name="platform"
        >

            <option value="">
                All platforms
            </option>

            @foreach($platforms as $platform)

                <option
                    value="{{ $platform }}"
                    @selected(request('platform') === $platform)
                >
                    {{ $platform }}
                </option>

            @endforeach

        </select>

        <button
            type="submit"
            class="btn btn-game"
        >
            <i class="bi bi-search"></i>
            Filter
        </button>

        <a
            class="btn btn-outline-secondary"
            href="{{ route('customer.catalog') }}"
        >
            Reset
        </a>

    </form>


    {{-- GAME LIST --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">

        @forelse($games as $game)

            @include('partials.game-card', ['game' => $game])

        @empty

            <div class="col-12">

                <div class="empty-state">
                    <i class="bi bi-controller display-5"></i>

                    <h4 class="mt-3">
                        No games found
                    </h4>

                    <p class="text-secondary mb-0">
                        No games match your search.
                    </p>
                </div>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    @if($games->hasPages())

        <div class="mt-4">
            {{ $games->withQueryString()->links() }}
        </div>

    @endif

</div>
@endsection