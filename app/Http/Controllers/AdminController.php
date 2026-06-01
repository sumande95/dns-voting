<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected function authorizeAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'super-admin') {
            abort(403);
        }
    }

    public function dashboard()
    {
        $this->authorizeAdmin();

        $positions = Position::with('candidates')->get();
        $candidates = Candidate::with('position')->get();
        $members = User::where('role', 'member')->get();
        $voteCounts = Vote::with(['position', 'candidate'])->get()->groupBy('position.name');
        $recentVotes = Vote::with(['voter', 'candidate', 'position'])->latest()->limit(20)->get();

        return view('admin.dashboard', compact('positions', 'candidates', 'members', 'voteCounts', 'recentVotes'));
    }

    public function results()
    {
        $this->authorizeAdmin();

        $positions = Position::with(['candidates.votes', 'candidates.member'])->get();
        $voters = User::where('role', 'member')->with(['votes.candidate', 'votes.position'])->get();
        $votes = Vote::with(['voter', 'candidate', 'position'])->orderByDesc('created_at')->get();

        return view('admin.results', compact('positions', 'voters', 'votes'));
    }

    public function storeMember(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'member',
        ]);

        return back()->with('success', 'Member added successfully.');
    }

    public function storePosition(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:positions,name'],
        ]);

        Position::create($data);

        return back()->with('success', 'Position added successfully.');
    }

    public function storeCandidate(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'names' => ['required', 'string'],
            'position_id' => ['required', 'exists:positions,id'],
        ]);

        $names = array_filter(array_map('trim', preg_split('/[\r\n]+/', $data['names'])));

        foreach ($names as $name) {
            Candidate::create([
                'name' => $name,
                'position_id' => $data['position_id'],
            ]);
        }

        $count = count($names);
        return back()->with('success', "{$count} candidate(s) added successfully.");
    }
}
