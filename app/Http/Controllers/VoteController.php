<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    protected function authorizeMember()
    {
        if (!auth()->check() || auth()->user()->role !== 'member') {
            abort(403);
        }
    }

    public function showBallot()
    {
        $this->authorizeMember();

        $user = auth()->user();
        $positions = Position::with('candidates')->get();
        $votedPositions = Vote::where('voter_id', $user->id)->pluck('position_id')->toArray();

        return view('member.vote', compact('positions', 'user', 'votedPositions'));
    }

    public function submitVote(Request $request)
    {
        $this->authorizeMember();

        $user = auth()->user();
        $data = $request->validate([
            'votes' => ['required', 'array'],
            'votes.*' => ['required', 'exists:candidates,id'],
        ]);

        $positions = Position::with('candidates')->get();
        $created = 0;

        foreach ($data['votes'] as $positionId => $candidateId) {
            if (Vote::where('voter_id', $user->id)->where('position_id', $positionId)->exists()) {
                continue;
            }

            $position = $positions->firstWhere('id', (int) $positionId);
            if (! $position) {
                continue;
            }

            Vote::create([
                'voter_id' => $user->id,
                'candidate_id' => $candidateId,
                'position_id' => $position->id,
            ]);

            $created++;
        }

        if ($created === 0) {
            return back()->with('warning', 'You have already voted for all selected positions or no valid candidate was chosen.');
        }

        return redirect()->route('member.history')->with('success', 'Your vote has been submitted successfully.');
    }

    public function history()
    {
        $this->authorizeMember();

        $user = auth()->user();
        $votes = Vote::where('voter_id', $user->id)->with(['candidate', 'position'])->orderByDesc('created_at')->get();

        return view('member.history', compact('votes', 'user'));
    }
}
