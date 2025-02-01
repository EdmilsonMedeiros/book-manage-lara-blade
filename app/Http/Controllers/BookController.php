<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
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
            $filename = date('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('covers', $filename, 'public');
            $validated['cover'] = $path;
        }
        
        try{
            Book::create($validated);
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Livro cadastrado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $messages = [
            'title.required'            => 'O título é obrigatório',
            'title.max'                 => 'O título não pode ter mais que 255 caracteres',
            'author_id.required'        => 'O autor é obrigatório', 
            'publish_date.required'     => 'O ano de publicação é obrigatório',
            'publish_date.date'         => 'O ano deve ser uma data',
            'publish_date.max'          => 'O ano não pode ser maior que o ano atual',
            'description.string'        => 'A descrição deve ser um texto'
        ];

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'author_id'         => 'required',
            'publish_date'      => 'required|date',
            'description'       => 'nullable|string',
        ], $messages);

        try {
            $book->update($validated);
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return redirect()->back()->with('success', 'Livro excluído com sucesso.');
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Algo deu errado: ' . $e->getMessage());
        }
    }
}
