@extends('layouts.app')

@section('title', 'DNS Voting System')

@section('content')
    <h1>Club Voting System</h1>
    <p class="text-sm">Secure voting for president, vice-president, sports-head, and other club roles.</p>

    <div class="stack" style="margin-top:1.5rem;">
        <a href="{{ route('login') }}" class="button button-primary">Login to Vote</a>
        <!-- <a href="{{ route('admin.dashboard') }}" class="button button-sec">Admin Dashboard</a> -->
    </div>

    <!-- <section style="margin-top:2rem;">
        <div class="card">
            <h2>Quick start</h2>
            <ul>
                <li>Super-admin can add members, positions, candidates, and review vote history.</li>
                <li>Members log in and select their preferred candidate for each role.</li>
                <li>Vote history is stored and easy to review with clear results.</li>
            </ul>
        </div>
    </section> -->
@endsection
