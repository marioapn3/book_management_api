<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\ListBookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        try {
            $books = $this->bookService->getAllData();
            $data = ListBookResource::collection($books);
            return response()->json([
                'data' => $data,
                'message' => 'Books retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to retrieve books',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $book = $this->bookService->store($request);
            return response()->json([
                'data' => ListBookResource::make($book),
                'message' => 'Book created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to create book',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $book = $this->bookService->getDataById($id);
            return response()->json([
                'data' => ListBookResource::make($book),
                'message' => 'Book retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to retrieve book',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $book = $this->bookService->update(
                $id,
                $request
            );
            return response()->json([
                'data' => ListBookResource::make($book),
                'message' => 'Book updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to update book',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $this->bookService->destroy($id);
            return response()->json([
                'data' => null,
                'message' => 'Book deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to delete book',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
