<card>
    <section role="articles-samples-list">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="flex-fill p-2">
                <h5 class="d-inline text-primary m-0">
                    Articole in legatura cu acest nod
                </h5>
                <label for="filters" class="cursor-pointer text-primary"> filtre </label>
            </div>
            <template p-can-create="\App\Article::class">
                <a class="btn btn-sm btn-primary ms-auto" :href="$to_form">
                    <i class="fas fa-file-medical"></i> Adauga articol
                </a>                
            </template>
        </div>
        
        <template p-if="!empty($articles)">
            <input type="checkbox" id="filters" class="checked:next-hidden-show" {{ request()->query() ? 'checked' : '' }} hidden>
            <div role="filters" class="hidden">
                @include('components.articles-filters')
            </div>
        </template>
        
        <div p-if="!empty($articles)" role="articles-list" class="p-2">
            <template></template>
            @foreach ($articles as $article)
                @include('components.article-sample', ['articles' => $articles])
                <hr class="my-4">
            @endforeach
        </div>
        <figure p-else class="mb-2 p-2 text-center">
            <img src="/assets/no-data-icon-68.png">
            <p class="px-1 h5"> Niciun articol gasit </p>
        </figure>
    </section>
</card>