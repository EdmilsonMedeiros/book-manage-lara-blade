<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index(){
        $books = Book::all();
        $authors = Author::wherestate(true)->get();

        return view('dashboard.index', compact('books', 'authors'));
    }
}
