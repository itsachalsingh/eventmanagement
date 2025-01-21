<?php

namespace App\Http\Controllers;

use App\Models\TalkProposal;
use App\Models\RevisionHistory;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class TalkProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proposals = TalkProposal::with('tags')->get();
        $tags = Tag::all();
        return view('proposals.index', compact('proposals', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'tags' => 'nullable|string',  // Tags input should be a string
        ]);

        // Handle the file upload if a file is provided
        $filePath = $request->file('file') ? $request->file('file')->store('proposals', 'public') : null;

        // Create the TalkProposal record
        $proposal = TalkProposal::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'user_id' => auth()->id(),
        ]);


         // Process the tags and convert them into an array
         if ($request->has('tags') && !empty($validated['tags'])) {
            // Split tags by commas and trim any extra spaces
            $tagsArray = array_map('trim', explode(',', $validated['tags']));

            // Check if each tag exists in the database, and if not, create it
            $tagIds = [];
            foreach ($tagsArray as $tag) {
                // Create the tag if it doesn't exist
                $tagRecord = \Spatie\Tags\Tag::firstOrCreate(['name' => $tag]);
                $tagIds[] = $tagRecord->id;
            }

            // Attach the tags to the proposal (syncWithoutDetaching to keep existing ones)
            $proposal->tags()->syncWithoutDetaching($tagIds);
        }

        // Redirect with a success message
        return redirect()->route('proposals.index')->with('success', 'Proposal submitted successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TalkProposal $talkProposal)
    {

        return view('proposals.show', compact('talkProposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TalkProposal $talkProposal)
    {
        //
        return view('proposals.edit', compact('talkProposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TalkProposal $talkProposal)
    {


        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string', // Tags as a string
            'file' => 'nullable|mimes:pdf|max:10240', // File validation (optional PDF)
        ]);

        // Update the proposal fields
        $talkProposal->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Ensure tags are synced after the model is saved
        if ($request->tags) {
            // Convert the comma-separated string into an array
            $tags = explode(',', $request->tags);

            // Sync tags with the proposal (this will add or remove tags)
            $talkProposal->syncTags($tags);
        }

        // Handle file upload (optional)
        if ($request->hasFile('file')) {
            // Store the uploaded file
            $filePath = $request->file('file')->store('proposals', 'public');
            // Update the file path in the proposal record
            $talkProposal->update(['file_path' => $filePath]);
        }

        // Redirect back to the proposals list with a success message
        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TalkProposal $talkProposal)
    {
        //
        $talkProposal->delete();

        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    public function restore($id)
    {
        $talkProposal = TalkProposal::withTrashed()->findOrFail($id);

        // Restore the proposal
        $talkProposal->restore();

        return redirect()->route('proposals.index')->with('success', 'Proposal restored successfully.');
    }

    public function getStatistics()
    {
        // Total number of proposals
        $totalProposals = TalkProposal::count();

        // Average rating of all proposals (assuming reviews exist)
        $averageRating = TalkProposal::whereHas('reviews')
                                     ->withAvg('reviews', 'rating')
                                     ->get()
                                     ->avg('reviews_avg_rating');



        return response()->json([
            'total_proposals' => $totalProposals,
            'average_rating' => $averageRating,
        ]);
    }
}
