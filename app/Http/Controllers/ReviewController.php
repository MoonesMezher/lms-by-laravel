<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ResponseTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        $reviews = Review::with('reviewable', 'user')->get();

        return $this->response('success', 'get reviews', $reviews, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $review->update([
            'review' => $request->review,
        ]);

        return $this->response('success', 'review updated', $review, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id && !auth()->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $review->delete();

        return $this->response('success', 'review deleted', $review, 200);
    }
}
