<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use function App\Helpers\remember;

class AuthorController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $authors = remember('authors', 60, Author::with('books')->get());
        $authors = Cache::remember('authors', 60, function () {
            return Author::with('books')->get();
        });

        return $this->response('success', 'get authors', $authors, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        try {
            $item = new Author;

            $item->name = $request->name;
            $item->age = $request->age;

            if($request->has('books_ids')) {
                $item->books()->attach($request->book_ids);
            }

            $item->save();

            Cache::forget('authors');

            return $this->response('success', 'author created',$item, 200);
        } catch (\Throwable $th) {
            return $this->response('error', 'author can not created',$th, 400);
        }
    }

    public function storeReview (Author $author, Request $request) {
        Log::error($request);

        $review = $author->reviews()->create([
            'user_id' => $request->user_id,
            'review' => $request->review,
        ]);

        return $this->response('success', 'review on author created' ,$review, 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        try {
            $item = Author::find($author);

            Cache::forget('authors');

            return $this->response('success', 'get author', $item, 200);
        } catch (\Throwable $th) {
            return $this->response('error', 'can not get author', $th, 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        try {
            $item = Author::find($author->id);

            $item->name = $request->name;
            $item->age = $request->age;

            if($request->has('books_ids')) {
                $item->books()->sync($request->book_ids);
            }

            $item->save();

            Cache::forget('authors');

            return $this->response('success', 'author updated',$item, 200);
        } catch (\Throwable $th) {
            return $this->response('error', 'author can not updated',$th, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        Author::destroy($author->id);

        Cache::forget('authors');

        return $this->response('success', 'author deleted',null, 400);
    }
}
