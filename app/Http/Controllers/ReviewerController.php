<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TalkProposal;
use Spatie\Tags\Tag;

class ReviewerController extends Controller
{
    //
    public function index()
    {


        $proposals = TalkProposal::with('tags')->get();
        return view('reviewers.dashboard', compact('proposals'));

    }

}
