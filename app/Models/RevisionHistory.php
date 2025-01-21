<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisionHistory extends Model
{
    //
    protected $fillable = ['talk_proposal_id', 'changes', 'modified_by'];

    public function talkProposal()
    {
        return $this->belongsTo(TalkProposal::class);
    }

    public function speaker()
    {
        return $this->belongsTo(User::class, 'modified_by', 'id');
    }
}
