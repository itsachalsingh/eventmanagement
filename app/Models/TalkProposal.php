<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;  // Import the HasTags trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RevisionHistory;  // Make sure to import the RevisionHistory model
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class TalkProposal extends Model
{
    use HasTags, SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'file_path', 'user_id'];

    protected $dates = ['deleted_at'];

    public function speaker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function revisions()
    {
        return $this->hasMany(RevisionHistory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

      /**
     * Automatically log revisions when the talk proposal is created or updated.
     */
    public static function boot()
    {
        parent::boot();

        // Log revision history when a proposal is created
        static::created(function ($talkProposal) {
            $user = Auth::user();  // Ensure that the user is authenticated
            if ($user) {
                $changes = $talkProposal->getAttributes();  // Get all attributes as this is a new creation
                $changeDescription = [];

                foreach ($changes as $key => $value) {
                    $changeDescription[] = "{$key} set to '{$value}'";  // Record the initial values
                }

                // Create a revision entry with the description of changes
                RevisionHistory::create([
                    'talk_proposal_id' => $talkProposal->id,
                    'modified_by' => $user->id,
                    'changes' => json_encode($changeDescription),
                ]);
            }
        });

        // Log revision history when a proposal is updated
        static::updated(function ($talkProposal) {
            $user = Auth::user();  // Ensure that the user is authenticated
            if ($user) {
                $changes = $talkProposal->getDirty();  // Get the changed attributes
                $changeDescription = [];

                foreach ($changes as $key => $value) {
                    $original = $talkProposal->getOriginal($key);  // Get the original value
                    $changeDescription[] = "{$key} changed from '{$original}' to '{$value}'";  // Record the changes
                }

                // Create a revision entry with the description of changes
                RevisionHistory::create([
                    'talk_proposal_id' => $talkProposal->id,
                    'modified_by' => $user->id,
                    'changes' => json_encode($changeDescription),
                ]);
            }
        });
    }
}
