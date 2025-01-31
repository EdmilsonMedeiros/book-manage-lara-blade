<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $books = Book::all();
        $authors = Author::all();

        return view('dashboard.index', compact('books', 'authors'));
    }
}
