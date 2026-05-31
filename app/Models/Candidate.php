<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position_id',
        'member_id',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    public function getDisplayNameAttribute()
    {
        return $this->name ?: $this->member?->name ?: 'Candidate';
    }
}
