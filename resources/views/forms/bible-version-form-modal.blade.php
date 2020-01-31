@php
    $bible = $bible ?? new \App\BibleVersion();
    $bible->index = $bible->index ?? $next_index ?? 1;
    $form = new \App\Helpers\Form('bible', $bible);
    $language = $bible->language ? $bible->language->value : null;
@endphp
<div class="modal fade show" id="bible-version-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $bible['id'] ? 'Edit version' : 'Add version' }}</h3>
            </div>
            <div class="modal-body">
                @form(['action'=>$bible['id'] ? route('bible-versions.update', $bible->id) : route('bible-versions.store')])
                    <input name="form_id" value="bible" hidden>
                    @number(['name'=>"index", 'placeholder'=>'index', 
                        'value'=> $form->value('index'),
                        'error'=> $errors->bible->first('index')
                    ])
                    @text(['name'=>"name", 'placeholder'=>'name',
                        'value'=> $form->value('name'),
                        'error'=> $errors->bible->first('name')
                    ])
                    @text(['name'=>"alias", 'placeholder'=>'alias',
                        'value'=> $form->value('alias'),
                        'error'=> $errors->bible->first('alias')
                    ])
                    @text(['name'=>"language", 'placeholder'=>'language', 'inputClass'=>'autocomplete-input', 'data'=>['endpoint'=>'/api/languages'],
                        'value'=> $form->value('language', $language),
                        'error'=> $errors->bible->first('language')
                    ])
                    @checkbox(['name'=>"public", 'label'=>'public',
                        'checked'=> $form->value('public'),
                    ])
                    <div class="d-flex justify-content-end">
                    @if($bible['id']??false)
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