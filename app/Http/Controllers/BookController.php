<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('books.index', [
            'books' => Book::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->title)]);
        $validateData = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:books',
            'author' => 'required',
            'publisher' => 'required',
            'category' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);
        if ($request->has('image')) {
            $imageName = $validateData['slug'] . '.' . $request->image->extension();
            $validateData['image_name'] = $imageName;
            $request->file('image')->storeAs('book-images', $imageName);
        }
        Book::create($validateData);
        return redirect('/books')->with('success', 'Book has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', [
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->merge(['slug' => Str::slug($request->title)]);
        $validateData = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:books,slug,' . $book->id,
            'author' => 'required',
            'publisher' => 'required',
            'category' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);
        $book->update($validateData);
        return redirect('/books')->with('success', 'Book has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Book::destroy($book->id);
        return redirect('/books')->with('success', 'Book has been deleted successfully');
    }
}
