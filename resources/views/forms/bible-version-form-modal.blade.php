@php
    $bible = $bible ?? ['id'=>null, 'index'=>null, 'name'=>null, 'alias'=>null, 'language'=>['value'=>null], 'public'=>false];
    $next_index = $next_index ?? 1;
@endphp
<div class="modal fade show" id="bible-version-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $bible['id'] ? 'Edit version' : 'Add version' }}</h3>
            </div>
            <div class="modal-body">
                @form(['action'=>$bible['id'] ? route('bible-versions.update', $bible->id) : route('bible-versions.store')])
                    <input name="_form" value="bible" hidden>
                    @number(['name'=>"index", 'placeholder'=>'index', 
                        'value'=> old('_form') === 'bible' ? old('index') : $bible['index'] ?? $next_index,
                        'error'=> old('_form') === 'bible' ? $errors->first('index') : null
                    ])
                    @text(['name'=>"name", 'placeholder'=>'name',
                        'value'=> old('_form') === 'bible' ? old('name') : $bible['name'],
                        'error'=> old('_form') === 'bible' ? $errors->first('name') : null
                    ])
                    @text(['name'=>"alias", 'placeholder'=>'alias',
                        'value'=> old('_form') === 'bible' ? old('alias') : $bible['alias'],
                        'error'=> old('_form') === 'bible' ? $errors->first('alias') : null
                    ])
                    @text(['name'=>"language", 'placeholder'=>'language', 'inputClass'=>'autocomplete-input', 'data'=>['endpoint'=>'/api/languages'],
                        'value'=> old('_form') === 'bible' ? old('language') : $bible['language']['value'],
                        'error'=> old('_form') === 'bible' ? $errors->first('language') : null
                    ])
                    @checkbox(['name'=>"public", 'label'=>'public',
                        'checked'=> old('_form') === 'bible' ? old('public') : $bible['public'],
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