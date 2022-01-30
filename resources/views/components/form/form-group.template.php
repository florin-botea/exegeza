<div class="md:flex md:items-center mb-6">
    <div class="md:w-1/3">
        <label :for="$id" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
            {{ $label ?? $name ?? '' }}
        </label>
    </div>
    <div class="md:w-2/3">
        <slot>
            <input :type="$type" :id="$id" p-bind="$_attrs" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500">
        </slot>
        <p p-if="isset($error) && $error" class="text-error">{{ $error }}</p>
    </div>
</div>
