<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TalkProposalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Get all reviewers
Route::get('/reviewers', [ReviewController::class, 'getReviewers']);

// Get reviews for a particular talk proposal
Route::get('/talk-proposals/{proposal}/reviews', [ReviewController::class, 'getReviewsForProposal']);

// Get statistics about talk proposals
Route::get('/talk-proposals/statistics', [TalkProposalController::class, 'getStatistics']);
