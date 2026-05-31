@extends('layouts.app')

@section('title', 'Vote History')

@section('content')
    <h1>Your vote history</h1>
    <p class="text-sm">See the positions you voted for and the candidates you supported.</p>

    <table class="table" style="margin-top:1.5rem;">
        <thead>
            <tr>
                <th>Position</th>
                <th>Candidate</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($votes as $vote)
                <tr>
                    <td>{{ $vote->position->name }}</td>
                    <td>{{ $vote->candidate->display_name }}</td>
                    <td>{{ $vote->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">You have not voted yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <section style="margin-top:1.5rem;">
        <a href="{{ route('member.vote') }}" class="button button-sec">Back to ballot</a>
    </section>
@endsection
