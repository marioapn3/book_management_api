<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\ListBookResource;
use App\Models\Book;
use App\Services\BookService;
use App\Services\ApiResponseService;
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
            return ApiResponseService::success($data, 'Books retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve books', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $book = $this->bookService->store($request);
            return ApiResponseService::success(ListBookResource::make($book), 'Book created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to create book', 500, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $book = $this->bookService->getDataById($id);
            return ApiResponseService::success(ListBookResource::make($book), 'Book retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve book', 500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $book = $this->bookService->update($id, $request);
            return ApiResponseService::success(ListBookResource::make($book), 'Book updated successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to update book', 500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->bookService->destroy($id);
            return ApiResponseService::success(null, 'Book deleted successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to delete book', 500, $e->getMessage());
        }
    }
}
