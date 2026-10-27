<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
        ]);

        $borrowing = DB::transaction(function () use ($validated, $request) {
            $book = Book::whereKey($validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stock < 1) {
                throw ValidationException::withMessages([
                    'book_id' => ['This book is out of stock.'],
                ]);
            }

            $book->decrement('stock');

            return Borrowing::create([
                'user_id' => $request->user()->id,
                'book_id' => $book->id,
                'borrowed_at' => now()->toDateString(),
                'due_at' => now()->addDays(7)->toDateString(),
            ]);
        });

        return response()->json([
            'message' => 'Book borrowed successfully',
            'data' => $borrowing,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
