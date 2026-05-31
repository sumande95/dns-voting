@extends('layouts.app')

@section('title', 'Voting Results')

@section('content')
    <h1>Voting Results</h1>
    <p class="text-sm">Detailed vote counts and vote history for the club election.</p>

    <section style="margin-top:1.5rem;">
        <h2>Vote counts by position</h2>
        @foreach($positions as $position)
            <div class="card" style="margin-top:1rem;">
                <h3>{{ $position->name }}</h3>
                <table class="table">
                    <thead>
                        <tr><th>Candidate</th><th>Votes</th></tr>
                    </thead>
                    <tbody>
                        @foreach($position->candidates as $candidate)
                            <tr>
                                <td>{{ $candidate->display_name }}</td>
                                <td>{{ $candidate->votes->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </section>

    <section style="margin-top:2rem;">
        <h2>Full voting history</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Position</th>
                    <th>Candidate</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($votes as $vote)
                    <tr>
                        <td>{{ $vote->voter->name }}</td>
                        <td>{{ $vote->position->name }}</td>
                        <td>{{ $vote->candidate->display_name }}</td>
                        <td>{{ $vote->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No voting history yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
