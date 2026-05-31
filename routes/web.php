<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/members', [AdminController::class, 'storeMember'])->name('admin.members.store');
Route::post('/admin/positions', [AdminController::class, 'storePosition'])->name('admin.positions.store');
Route::post('/admin/candidates', [AdminController::class, 'storeCandidate'])->name('admin.candidates.store');
Route::get('/admin/results', [AdminController::class, 'results'])->name('admin.results');

Route::get('/vote', [VoteController::class, 'showBallot'])->name('member.vote');
Route::post('/vote', [VoteController::class, 'submitVote'])->name('member.vote.submit');
Route::get('/vote/history', [VoteController::class, 'history'])->name('member.history');
