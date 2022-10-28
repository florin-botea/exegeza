@php
    if (isset($name) && isset($error) && $error === '') {
        $error = $errors->first($name);
    }
    $value = isset($value) ? $value : '';
@endphp
<div class="form-group row mb-3">
    <label :for="$id ?? $name ?? ''" class="control-label col-sm-3">
        {{ $label ?? $name ?? '' }}
    </label>
    <div class="col-sm-9">
        <img p-if="!empty($preview) && $type == 'file'" :src="$value ?? ''" class="img-fluid pb-2">
        <slot>
            <input p-if="$type == 'file'" type="file" :id="$id ?? $name ?? ''" :name="$name" :value="$value" p-bind="$_attrs" class="form-control" :class="!empty($preview) ? 'preview' : ''">
            <textarea p-elseif="$type == 'textarea'" :id="$id ?? $name ?? ''" :name="$name" :value="$value" p-bind="$_attrs" class="form-control">{{ $value ?? '' }}</textarea>
            <input p-elseif="$type == 'checkbox'" type="checkbox" :name="$name" :value="$value" p-checked="$value">
            <input p-else :type="$type" :id="$id ?? $name ?? ''" :name="$name" :value="$value" p-bind="$_attrs" class="form-control">
        </slot>
        <p p-if="isset($error) && $error" class="text-danger">{{ $error }}</p>
    </div>
</div>

<script id="moveMe">
$(document).on("change", 'input[type="file"].preview', function() {
    const [file] = this.files
    if (file) {
       $(this).prev("img").attr("src", URL.createObjectURL(file));
    }
});
</script>

<?php return function($node, $eh) {
    $script = $node->querySelector('#moveMe')->detach()->removeAttribute('id');
    $eh->on('parsed', 'layouts/app', function($dom) use ($script) {
        $dom->querySelector('body')->appendChild($script);
    });
} ?>