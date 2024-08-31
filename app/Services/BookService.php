<?php

namespace App\Services;

use App\Models\Book;

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
        return $book;
    }

    public function store($request)
    {
        $book = Book::create($request->all());
        return $book;
    }

    public function update($id, $request)
    {
        $book = Book::find($id);
        $book->update($request->all());
        return $book;
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();
        return $book;
    }
}
