@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Super Admin Dashboard</h1>
    <p class="text-sm">Manage members, positions, candidates and view club voting results.</p>

    <section style="margin-top:1.5rem;">
        <h2>Quick stats</h2>
        <div class="grid-cols-3" style="margin-top:1rem;">
            <div class="card">
                <strong>Members</strong>
                <div>{{ $members->count() }}</div>
            </div>
            <div class="card">
                <strong>Positions</strong>
                <div>{{ $positions->count() }}</div>
            </div>
            <div class="card">
                <strong>Candidates</strong>
                <div>{{ $candidates->count() }}</div>
            </div>
        </div>
    </section>

    <section style="margin-top:2rem;">
        <h2>Add new member</h2>
        <form action="{{ route('admin.members.store') }}" method="post" class="stack" style="margin-top:1rem;">
            @csrf
            <label>Name <input type="text" name="name" class="input" required /></label>
            <label>Email <input type="email" name="email" class="input" required /></label>
            <label>Password <input type="password" name="password" class="input" required minlength="8" /></label>
            <button type="submit" class="button button-primary">Create member</button>
        </form>
    </section>

    <section style="margin-top:2rem;">
        <h2>Add new position</h2>
        <form action="{{ route('admin.positions.store') }}" method="post" class="stack" style="margin-top:1rem;">
            @csrf
            <label>Position name <input type="text" name="name" class="input" required /></label>
            <button type="submit" class="button button-primary">Add position</button>
        </form>
    </section>

    <section style="margin-top:2rem;">
        <h2>Add new candidate</h2>
        <p class="text-sm">Enter one candidate name per line to add multiple candidates at once for the same position.</p>
        <form action="{{ route('admin.candidates.store') }}" method="post" class="stack" style="margin-top:1rem;">
            @csrf
            <label>Candidate names
                <textarea name="names" class="input" rows="4" placeholder="Candidate One\nCandidate Two\nCandidate Three" required></textarea>
            </label>
            <label>Position
                <select name="position_id" class="select" required>
                    <option value="">Choose position</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit" class="button button-primary">Add candidate(s)</button>
        </form>
    </section>

    <section style="margin-top:2rem;">
        <h2>Latest votes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Position</th>
                    <th>Candidate</th>
                    <th>Voted at</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentVotes as $vote)
                    <tr>
                        <td>{{ $vote->voter->name }}</td>
                        <td>{{ $vote->position->name }}</td>
                        <td>{{ $vote->candidate->display_name }}</td>
                        <td>{{ $vote->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No votes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section style="margin-top:2rem;">
        <a href="{{ route('admin.results') }}" class="button button-sec">View full voting results</a>
    </section>
@endsection
