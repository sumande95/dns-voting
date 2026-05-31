@extends('layouts.app')

@section('title', 'Vote Now')

@section('content')
    <h1>Vote for your club leaders</h1>
    <p class="text-sm">Choose one candidate per position. Once your vote is recorded, it is final for that position.</p>

    <form action="{{ route('member.vote.submit') }}" method="post" class="stack" style="margin-top:1.5rem;">
        @csrf

        @foreach($positions as $position)
            <div class="card">
                <h3>{{ $position->name }}</h3>
                @if(in_array($position->id, $votedPositions))
                    <p class="text-sm">You have already voted for this position.</p>
                    <div class="badge">Voted</div>
                @endif
                <div class="stack" style="margin-top:1rem;">
                    @foreach($position->candidates as $candidate)
                        <label style="display:flex; gap:12px; align-items:center;">
                            <input type="radio" name="votes[{{ $position->id }}]" value="{{ $candidate->id }}" {{ in_array($position->id, $votedPositions) ? 'disabled' : '' }} />
                            {{ $candidate->display_name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="button button-primary">Submit vote</button>
    </form>

    <section style="margin-top:2rem;">
        <a href="{{ route('member.history') }}" class="button button-sec">View my vote history</a>
    </section>
@endsection
