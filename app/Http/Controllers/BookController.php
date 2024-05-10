<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Jobs\SendEmailJob;
use App\Models\Book;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use function App\Helpers\remember;

class BookController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Cache::remember('books', 60, function () {
            return Book::with('authors')->get();
        });

        return $this->response('success', 'get books', $books, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        try {
            $item = new Book;

            $item->title = $request->title;
            $item->price = $request->price;

            if($request->has('authors_ids')) {
                $item->authors()->attach($request->author_ids->authors_id);
            }

            $item->save();

            $user = User::find(auth()->id());

            SendEmailJob::dispatch($user);

            Cache::forget('books');

            return $this->response('success', 'book created',$item, 200);
        } catch (\Throwable $th) {
            return $this->response('error', 'book can not created',$th, 400);
        }
    }

    /**
     * Display the specified resource.
     */

    public function storeReview (Book $book, Request $request) {
        $review = $book->reviews()->create([
            'user_id' => $request->user_id,
            'review' => $request->review,
        ]);

        return $this->response('success', 'review on book created' ,$review, 200);
    }
    public function show(Book $book)
    {
        try {
            $item = Book::find($book);

            return $this->response('success', 'get book', $item, 200);
        } catch (\Throwable $th) {
            return $this->response('error', 'can not get book', $th, 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $item = Book::find($book->id);

            $item->title = $request->title;
            $item->price = $request->price;

            if($request->has('authors_ids')) {
                $item->authors()->sync($request->author_ids);
                foreach ($item->authors as $author) {
                    $author->save();
                }
            }

            $item->save();

            Cache::forget('books');

            return $this->response('success', 'book updated',$item, 200);
        } catch (\Throwable $th) {
            return $this->response('error', 'book can not updated',$th, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Book::destroy($book->id);

        Cache::forget('books');

        return $this->response('success', 'book deleted',null, 400);
    }
}
