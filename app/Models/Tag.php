<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends Model
{
    //

    public function talkProposals()
    {
        return $this->morphedByMany(TalkProposal::class, 'taggable');
    }

}
