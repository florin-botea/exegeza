@php
    $chapter = $chapter ?? ['id'=>null, 'index'=>null, 'name'=>null];
    $next_index = $next_index ?? 1;
@endphp
<div class="modal fade show" id="chapter-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $chapter['id'] ? 'Edit chapter' : 'Add chapter' }}</h3>
            </div>
            <div class="modal-body">
                @form(['action'=>$chapter['id'] ? route('bible-versions.books.chapters.edit', [$bible->id, $bible->book->id, $chapter->id]) : route('bible-versions.books.chapters.store', [$bible->id, $bible->book->id] )])
                    <input name="_form" value="chapter" hidden>
                    @number(['name'=>'index', 'placeholder'=>'index',
                        'value'=> old('_form') === 'chapter' ? old('index') : ($chapter['index'] ?? $next_index),
                        'error'=> old('_form') === 'chapter' ? $errors->first('index') : null
                    ])
                    @text(['name'=>'name', 'placeholder'=>'name',
                        'value'=> old('_form') === 'chapter' ? old('name') : $chapter['name'],
                        'error'=> old('_form') === 'chapter' ? $errors->first('name') : null
                    ])
                    <div class="">
                        <label for="add_verses" class="m-0 align-self-start">Adauga si versete</label>
                        <input type="checkbox" name="add_verses" id="add_verses" class="checked:next-hidden-show" {{old('add_verses') ? 'checked' : ''}}>
                        <div class="hidden">
                            @text(['name'=>'regex', 'placeholder'=>'regex', 'id'=>'js-preview-verses_regex',
                                'value'=> old('_form') === 'chapter' ? old('regex') : '',
                                'error'=> old('_form') === 'chapter' ? $errors->first('regex') : null
                            ])
                            @textarea(['name'=>'verses', 'placeholder'=>'verses', 'attrs'=>['rows=5'], 'id'=>'js-preview-verses_verses',
                                'value'=> old('_form') === 'chapter' ? old('verses') : '',
                                'error'=> old('_form') === 'chapter' ? $errors->first('verses') : null
                            ])
                            <button type="button" class="btn btn-secondary" id="js-preview-verses-action">
                                Previzualizeaza
                            </button>
                            <section class="previewForVerses" id="js-preview-verses-container">
                                
                            </section>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                    @if($chapter['id']??false)
                        @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'btn-danger', 'text'=>'Delete' ])
                        @submit(['name'=>'_method', 'value'=>'put', 'class'=>'ml-2 btn-success', 'text'=>'Update' ])
                        @else
                        @submit(['class'=>'ml-2 btn-primary', 'text'=>'Add'])
                    @endif
                    </div>
                @endform
            </div>
        </div>
    </div>
</div>