@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h1 style="margin-bottom:1rem; text-align:center">Login</h1>
    <p class="text-sm">Use your club member credentials or ask the super-admin to create your account.</p>

    <form action="{{ route('login.post') }}" method="post" class="stack" style="margin-top:1.5rem;">
        @csrf
        <label>
            Email
            <input type="email" name="email" class="input" value="{{ old('email') }}" required autocomplete="email" />
        </label>
        <label>
            Password
            <input type="password" name="password" class="input" required autocomplete="current-password" />
        </label>
        <label class="inline-list" style="align-items:center; gap:8px;">
            <input type="checkbox" name="remember" value="1" /> Remember me
        </label>

        <button type="submit" class="button button-primary">Login</button>
    </form>
@endsection
