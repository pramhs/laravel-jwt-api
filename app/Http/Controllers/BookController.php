<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('auth:api');
    }
    
    public function createBook(Request $request)
    {
      $request->validate([
        'title' => 'required|string',
        'author' => 'required|string',
        'publisher' => 'required|string',
        ]);
        
      Book::create($request->all());
      return response()->json([
        'message' => 'book created successfully'
        ]);
    }
    
    public function listBook()
    {
      $books = Book::all();
      if($books->count() < 1) {
        return response()->json([
          'message' => 'there is no books'
        ]);
      }
      
      return response()->json([
        'message' => 'books found',
        'books' => $books
        ]);
    }
    
    public function singleBook($id)
    {
      $book = Book::find($id);
      if(!$book) {
        return response()->json([
          'message' => 'there is no book'
        ]);
      }
      
      return response()->json([
          'message' => 'book found',
          'book' => $book
        ]);
    }
    
    public function updateBook(Request $request, $id)
    {
      $book = Book::find($id);
      if(!$book) {
        return response()->json([
          'message' => 'there is no book'
        ]);
      }
      
      $book->title = !empty($request->title) ? $request->title : $book->title;
      $book->author = !empty($request->author) ? $request->author : $book->author;
      $book->publisher = !empty($request->publisher) ? $request->publisher : $book->publisher;
      $book->save();
      
      return response()->json([
          'message' => 'book edited successfully'
        ]);
    }
    
    public function deleteBook($id)
    {
      $book = Book::find($id);
      if(!$book) {
        return response()->json([
          'message' => 'there is no book'
        ]);
      }
      
      $book->delete();
      return response()->json([
          'message' => 'book deleted successfully'
        ]);
    }
}
