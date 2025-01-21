<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\TalkProposalController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:reviewer'])->group(function(){
    Route::get('reviewer/dashboard', [ReviewerController::class, 'index'])->name('reviewer.dashboard'); // Reviewer dashboard

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/create/{proposal}', [ReviewController::class, 'create'])->name('create'); // Show review form
        Route::post('/store/{proposal}', [ReviewController::class, 'store'])->name('store'); // Submit a review
    });

});

Route::middleware(['auth'])->group(function () {

    // Speaker Routes
    Route::prefix('proposals')->name('proposals.')->group(function () {
        Route::get('/', [TalkProposalController::class, 'index'])->name('index'); // List all proposals for a speaker
        Route::get('/create', [TalkProposalController::class, 'create'])->name('create'); // Show proposal submission form
        Route::post('/', [TalkProposalController::class, 'store'])->name('store'); // Submit a new proposal
        Route::get('{talkProposal}/edit', [TalkProposalController::class, 'edit'])->name('edit'); // Edit a proposal
        Route::put('{talkProposal}', [TalkProposalController::class, 'update'])->name('update'); // Update a proposal
        Route::delete('/delete/{talkProposal}', [TalkProposalController::class, 'destroy'])->name('destroy'); // Delete a proposal
        Route::get('/{talkProposal}', [TalkProposalController::class, 'show'])->name('show');
    });


});

require __DIR__.'/auth.php';
