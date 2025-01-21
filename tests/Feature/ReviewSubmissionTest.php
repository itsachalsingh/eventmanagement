<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TalkProposal;
use App\Models\Review;
use App\Models\User;

class ReviewSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function a_reviewer_can_submit_a_review_for_a_proposal()
    {
        $this->actingAs(User::factory()->create());

        $talkProposal = TalkProposal::factory()->create();
        $reviewData = [
            'comments' => 'Great talk!',
            'rating' => 4.5,
        ];

        $response = $this->post(route('reviews.store', $talkProposal), $reviewData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Review submitted successfully.');

        $this->assertDatabaseHas('reviews', $reviewData);
    }
}
