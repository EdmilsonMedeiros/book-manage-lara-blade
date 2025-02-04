<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                "status" => true,
                "books" => Book::all()
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'title.required'            => 'O título é obrigatório',
            'title.max'                 => 'O título não pode ter mais que 255 caracteres',
            'author_id.required'        => 'O autor é obrigatório', 
            'publish_date.required'     => 'O ano de publicação é obrigatório',
            'publish_date.date'         => 'O ano deve ser uma data',
            'publish_date.max'          => 'O ano não pode ser maior que o ano atual',
            'description.string'        => 'A descrição deve ser um texto',
            'cover.mimes'               => 'O arquivo precisa ser PNG ou JPG',
            'cover.max'                 => 'O tamanho limite do arquivo é 2MB',
        ];

        try {
            $validated = $request->validate([
                'title'             => 'required|string|max:255',
                'description'       => 'required|string',
                'author_id'         => 'required',
                'publish_date'      => 'required|date',
                'description'       => 'nullable|string',
                'cover'             => 'nullable|mimes:jpg,jpeg,png|max:2048'
            ], $messages);

            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $path = ImageHelper::resizeImage($file);
                $validated['cover'] = $path;
            }
            
            $book = Book::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Book successfully created',
                'book' => $book
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            if(!$book){
                return response()->json([
                    "status" => false,
                    "message" => "Book not found"
                ], 404);
            }

            return response()->json([
                "status" => true,
                "book" => $book
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $book = Book::find($request->id);

        if(!$book){
            return response()->json([
                'status' => false,
                'message' => 'Book not found'
            ], 404);
        }

        $messages = [
            'title.max'                 => 'O título não pode ter mais que 255 caracteres',
            'publish_date.date'         => 'O ano deve ser uma data',
            'publish_date.max'          => 'O ano não pode ser maior que o ano atual',
            'description.string'        => 'A descrição deve ser um texto',
            'cover.mimes'               => 'O arquivo precisa ser PNG ou JPG',
            'cover.max'                 => 'O tamanho limite do arquivo é 2MB',
        ];

        try {
            $validated = $request->validate([
                'title'             => 'nullable|string|max:255',
                'description'       => 'nullable|string',
                'author_id'         => 'nullable',
                'publish_date'      => 'nullable|date',
                'cover'             => 'nullable|mimes:jpg,jpeg,png|max:2048'
            ], $messages);

            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $path = ImageHelper::resizeImage($file);
                $validated['cover'] = $path;
            } else {
                unset($validated['cover']);
            }

            $book->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Book successfully updated',
                'book' => $book
            ], 200);

        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();
            
            return response()->json([
                "status" => true,
                "message" => "Book deleted successfully"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Error deleting book: " . $e->getMessage()
            ], 500);
        } 
    }
}
