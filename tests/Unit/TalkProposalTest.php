<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\TalkProposal;
use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TalkProposalTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function it_has_a_speaker()
    {
        $user = User::factory()->create();
        $talkProposal = TalkProposal::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $talkProposal->speaker->id);
    }

    public function it_can_have_reviews()
    {
        $talkProposal = TalkProposal::factory()->create();
        $review = Review::factory()->create(['talk_proposal_id' => $talkProposal->id]);

        $this->assertCount(1, $talkProposal->reviews);
        $this->assertEquals($review->id, $talkProposal->reviews->first()->id);
    }

    public function it_can_have_tags()
    {
        $talkProposal = TalkProposal::factory()->create();
        $tag = Tag::create(['name' => 'Technology']);

        $talkProposal->tags()->attach($tag);

        $this->assertTrue($talkProposal->tags->contains($tag));
    }

}
