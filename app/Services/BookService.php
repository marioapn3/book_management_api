<?php

namespace App\Services;

use App\Models\Book;
use Exception;

class BookService
{
    public function getAllData()
    {
        $books = Book::all();
        return $books;
    }

    public function getDataById($id)
    {
        $book = Book::find($id);
        if (!$book) {
            throw new Exception("Book not found");
        }
        return $book;
    }

    public function store($request)
    {
        $inputs = $request->only('title', 'author', 'category', 'description');
        $fileService = new FileService();
        if ($request->hasFile('image')) {
            $image = $fileService->uploadFile($request->file('image'), 'books');
            $inputs['image'] = $image;
        }
        $book = Book::create($inputs);
        return $book;
    }

    public function update($id, $request)
    {
        $fileService = new FileService();

        $book = Book::find($id);

        if (!$book) {
            throw new \Exception("Book not found");
        }

        if ($book->image) {
            $fileService->removeFile($book->image);
        }

        $inputs = $request->only('title', 'author', 'category', 'description');

        if ($request->hasFile('image')) {

            $image = $fileService->uploadFile($request->file('image'), 'books');
            $inputs['image'] = $image;
        }

        $book->update($inputs);

        return $book;
    }

    public function destroy($id)
    {
        $fileService = new FileService();

        $book = Book::find($id);

        if (!$book) {
            throw new \Exception("Book not found");
        }

        $fileService->removeFile($book->image);

        $book->delete();

        return $book;
    }
}
