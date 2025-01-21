<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\TalkProposal;
use Illuminate\Http\Request;
use App\Events\ReviewSubmitted;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TalkProposal $proposal)
    {
        return view('reviews.create', compact('proposal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TalkProposal $proposal)
    {
        //
        $validated = $request->validate([
            'comments' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);




        $review = Review::create([
            'reviewer_id' => auth()->id(),
            'talk_proposal_id' => $proposal->id,
            'comments' => $validated['comments'],
            'rating' => $validated['rating'],
        ]);

        $proposal->update(['status' => 'approved']);

        event(new ReviewSubmitted($review, $proposal));

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    public function getReviewers()
    {
        // Fetch distinct reviewers based on their reviews
        $reviewers = User::whereHas('reviews')
                         ->with('reviews')  // Optionally, load reviews for each reviewer
                         ->get();

        return response()->json($reviewers);
    }

    public function getReviewsForProposal($proposalId)
    {
        // Fetch the proposal with its associated reviews
        $proposal = TalkProposal::with('reviews')->findOrFail($proposalId);

        // Return the reviews associated with the proposal
        return response()->json($proposal);
    }
}
