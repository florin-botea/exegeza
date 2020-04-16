<form role="filters" method="GET" class="flex flex-wrap md:flex-no-wrap bg-gray-300 p-2 pr-0">
    <div class="pr-2 w-full sm:w-auto">
        <label for="keyword" class="block"> cuvant cheie </label>
        <input name="keyword" value="{{ request()->query('keyword') }}" id="keyword" class="input-w-full" type="text">
    </div>
    <div class="pr-2 w-full sm:w-auto">
        <label for="author" class="block"> autor </label>
        <input name="author" value="{{ request()->query('author') }}" id="author" class="input-w-full" type="text">
    </div>
    <div class="pr-2 w-full sm:w-auto">
        <label for="cite" class="block"> citat din </label>
        <input name="cite" value="{{ request()->query('cite') }}" id="cite" class="input-w-full" type="text">
    </div>
    <div class="pr-2 w-full sm:w-auto">
        <label for="language" class="block"> language </label>
        <select name="language" id="language" class="input-w-full px-0">
            <option value="" selected> toate </option>
            @foreach ($languages as $language)
                <option value="{{ $language }}" {{ request()->query('language') == $language ? 'selected' : '' }}>{{ $language }}</option>
            @endforeach
        </select>
    </div>
    <div class="pr-2 flex w-full sm:w-auto">
        <div class="pr-2 flex-1">
            <label for="sort" class="block"> sort </label>
            <select name="sort" id="sort" class="input-w-full px-0">
                <option value="date-desc" {{ request()->query('sort', 'date-desc') == 'date-desc' ? 'selected' : '' }}> date desc </option>
                <option value="date-asc" {{ request()->query('sort') == 'date-asc' ? 'selected' : '' }}> date asc </option>
            </select>
        </div>
        @can('publish articles')
        <div class="flex flex-col">
            <label role="spacer" class="invisible">foo</label>
            <input name="public" value="false" id="filter-published" class="input-w-full" type="checkbox" hidden>
            <div class="flex-1 flex items-center" id="filter-published-labels">
                <label for="filter-published" id="unpublished" title="unpublished"><i class="fas fa-user-alt-slash"></i></label>
                <label for="filter-published" id="published" title="published"><i class="fas fa-user"></i></label>
            </div>
        </div>
        @endcan
        <button class="self-end rounded bg-purple-800 text-white font-bold hover:bg-purple-900" type="submit"> 
            <span class="invisible">|</span>
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>