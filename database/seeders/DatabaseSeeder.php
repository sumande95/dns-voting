<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@club.local',
            'password' => bcrypt('AdminPass123!'),
            'role' => 'super-admin',
        ]);

        $members = User::factory()->count(5)->create()->each(function ($member) {
            $member->role = 'member';
            $member->save();
        });

        $positions = collect(['President', 'Vice President', 'Sports Head', 'Culture Head']);

        $positions->each(function ($name) {
            Position::create(['name' => $name]);
        });

        Position::all()->each(function ($position, $index) use ($members) {
            Candidate::create([
                'name' => "Candidate A for {$position->name}",
                'position_id' => $position->id,
                'member_id' => $members->random()->id,
            ]);

            Candidate::create([
                'name' => "Candidate B for {$position->name}",
                'position_id' => $position->id,
                'member_id' => null,
            ]);
        });
    }
}
