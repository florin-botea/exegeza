@php
    $book = $book ?? ['id'=>null, 'index'=>null, 'name'=>null, 'alias'=>null, 'type'=>null];
    $next_index = $next_index ?? 1;
@endphp
<div class="modal fade show" id="book-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $book['id'] ? 'Edit book' : 'Add book' }}</h3>
            </div>
            <div class="modal-body">
                @form(['action'=>$book['id'] ? route('bible-versions.books.edit', [$bible->id, $book->id]) : route('bible-versions.books.store', $bible->id)])
                    <input name="_form" value="book" hidden>
                    @number(['name'=>'index', 'placeholder'=>'index',
                        'value'=> old('_form') === 'book' ? old('index') : $book['index'],
                        'error'=> old('_form') === 'book' ? $errors->first('index') : null
                    ])
                    @text(['name'=>'name', 'placeholder'=>'name',
                        'value'=> old('_form') === 'book' ? old('name') : $book['name'],
                        'error'=> old('_form') === 'book' ? $errors->first('name') : null
                    ])
                    @text(['name'=>'alias', 'placeholder'=>'alias',
                        'value'=> old('_form') === 'book' ? old('alias') : $book['alias'],
                        'error'=> old('_form') === 'book' ? $errors->first('alias') : null
                    ])
                    @select(['name'=>'type', 'options'=>['tip'=>null, 'VT'=>'vt', 'NT'=>'nt', 'altele'=>'altele'], 
                        'value'=> old('_form') === 'book' ? old('type') : $book['type'],
                        'error'=> old('_form') === 'book' ? $errors->first('type') : null
                    ])
                    @if($book['id']??false)
                        @submit(['name'=>'_method', 'value'=>'put', 'class'=>'btn-success', 'text'=>'Update' ])
                        @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'ml-2 btn-danger', 'text'=>'Delete' ])
                        @else
                        @submit(['class'=>'ml-2 btn-primary', 'text'=>'Add'])
                    @endif
                @endform
            </div>
        </div>
    </div>
</div>