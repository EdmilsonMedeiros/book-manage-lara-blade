<div class="modal fade" id="newBookModal{{isset($book) ? $book->id : ''}}" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="bookModalLabel">{{ isset($book) ? 'Editar Livro' : 'Novo Livro' }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ isset($book) ? route('books.update') : route('books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" 
                            value="{{ $book->title ?? old('title') }}"
                            placeholder="Digite o título do livro" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                            placeholder="Digite a descrição do livro" required>{{ $book->description ?? old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="publish_date" class="form-label">Data de Lançamento</label>
                        <input type="date" class="form-control" id="publish_date" name="publish_date" 
                            value="{{ isset($book) ? $book->publish_date : old('publish_date') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="author_id" class="form-label">Autor</label>
                        <select class="form-select" id="author_id" name="author_id" required>
                            <option value="">Selecione um autor</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" 
                                    {{ isset($book) && $book->author_id == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cover" class="form-label">Capa do Livro</label>
                        <input type="file" class="form-control" id="cover" name="cover" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
                        
                        <img id="imagePreview" 
                            src="{{ isset($book) && $book->cover ? asset('storage/' . $book->cover) : '#' }}" 
                            alt="Preview" 
                            style="max-width: 200px; margin-top: 10px; {{ isset($book) && $book->cover ? '' : 'display: none;' }}">
                    </div>
                    
                    <script>
                        function previewImage(event) {
                            const input = event.target;
                            const preview = document.getElementById('imagePreview');
                            preview.src = null;
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                    
                                reader.onload = function(e) {
                                    preview.style.display = 'none';
                                    preview.src = '';
                                    setTimeout(() => {
                                        preview.src = e.target.result;
                                        preview.style.display = 'block';
                                    }, 50);
                                };
                    
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                    
                    
                    


                </div>

                @isset($book)
                    <input name="id" value="{{$book->id}}" type="number" hidden>
                @endisset

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($book) ? 'Atualizar' : 'Salvar' }} <i class="bi bi-save"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>