<div class="form-group row mb-3">
    <label :for="$id ?? $name" class="control-label col-sm-3">
        {{ $label ?? $name ?? '' }}
    </label>
    <div class="col-sm-9">
        <slot>
            <input p-if="$type == 'checkbox'" type="checkbox" p-checked="$value">
            <input p-else :type="$type" :id="$id ?? $name" p-bind="$this->attrs" class="form-control">
        </slot>
        <p p-if="isset($error) && $error" class="text-danger">{{ $error }}</p>
    </div>
</div>
