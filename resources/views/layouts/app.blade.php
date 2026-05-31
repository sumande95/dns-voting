<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Voting System'))</title>
    <style>
        body { font-family: system-ui, sans-serif; margin:0; background:#f4f5f7; color:#111827; }
        .page { max-width:1100px; margin:0 auto; padding:24px; }
        .card { background:white; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 10px 30px rgba(15,23,42,.08); padding:24px; }
        .button { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; padding:.75rem 1.2rem; border:none; border-radius:10px; cursor:pointer; font-weight:600; }
        .button-primary { background:#1d4ed8; color:white; }
        .button-sec { background:#e5e7eb; color:#111827; }
        .input, .select, .textarea { width:100%; border:1px solid #d1d5db; border-radius:10px; padding:.85rem 1rem; background:white; color:#111827; }
        .input:focus, .select:focus, .textarea:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 4px rgba(59,130,246,.15); }
        .text-sm { font-size:.9rem; color:#6b7280; }
        .grid-cols-2 { display:grid; gap:24px; grid-template-columns:repeat(2,minmax(0,1fr)); }
        .grid-cols-3 { display:grid; gap:24px; grid-template-columns:repeat(3,minmax(0,1fr)); }
        .inline-list { display:flex; flex-wrap:wrap; gap:12px; margin:0; padding:0; list-style:none; }
        .badge { display:inline-flex; padding:.3rem .65rem; border-radius:999px; background:#e0f2fe; color:#0369a1; font-size:.8rem; }
        .table { width:100%; border-collapse:collapse; margin-top:1rem; }
        .table th, .table td { text-align:left; padding:.85rem 1rem; border-bottom:1px solid #e5e7eb; }
        .table th { background:#f9fafb; font-weight:700; }
        .error { background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:1rem; border-radius:10px; margin-bottom:1rem; }
        .success { background:#dcfce7; border:1px solid #bbf7d0; color:#166534; padding:1rem; border-radius:10px; margin-bottom:1rem; }
        .warning { background:#fef3c7; border:1px solid #fde68a; color:#92400e; padding:1rem; border-radius:10px; margin-bottom:1rem; }
        .topbar { display:flex; flex-wrap:wrap; justify-content:space-between; gap:12px; margin-bottom:24px; }
        .nav-link { color:#1f2937; text-decoration:none; font-weight:600; }
        .nav-link:hover { color:#1d4ed8; }
        .stack { display:flex; flex-direction:column; gap:12px; }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <div>
                <a href="{{ route('welcome') }}" class="nav-link">{{ config('app.name', 'Voting System') }}</a>
            </div>
            <div class="inline-list">
                @auth
                    <a href="{{ auth()->user()->role === 'super-admin' ? route('admin.dashboard') : route('member.vote') }}" class="nav-link">Dashboard</a>
                    <form action="{{ route('logout') }}" method="post" style="display:inline;">
                        @csrf
                        <button type="submit" class="button button-sec">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                @endauth
            </div>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="warning">{{ session('warning') }}</div>
        @endif
        @if($errors->any())
            <div class="error">
                <strong>Whoops! Something went wrong.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            @yield('content')
        </div>
    </div>
</body>
</html>
