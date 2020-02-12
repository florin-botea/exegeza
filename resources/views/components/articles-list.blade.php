<div class="loading-list" id="js_articlesList" data-baseurl="{{ $articles_list['base_url'] }}">
    <div class="list-filters">
        <h5 class="btn btn-sm btn-outline-warning cursor-pointer" data-toggle="collapse" data-target="#filters">Filtre:</h5>
        <div class="form-row mb-3 collapse" id="filters">
            <div class="form-group mx-1 col-md">
                <input name="keyword" class="list-filter form-control" placeholder="Cuvant cheie">
            </div>
            <div class="form-group mx-1 col-md">
                <input name="user" class="list-filter form-control" placeholder="User">
            </div>
            <div class="form-group mx-1 col-md">
                <input name="author" class="list-filter form-control" placeholder="Autor">
            </div>
            <div class="form-group mx-1 col-md">
                <select name="language" class="list-filter form-control">
                    <option value="default">language</option>
                    <option value="all">---</option>
                    @foreach ($languages??[] as $language)
                    <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mx-1 col-md">
                <select name="sort" class="list-filter form-control">
                    <option value="date-asc">Data postarii - crescator:</option>
                    <option value="date-desc">Data postarii - descrescator:</option>
                </select>
            </div>
        </div>
    </div>

    <div class="list-content">

    </div>
    <div class="loading-next">
        <div class="d-flex justify-content-center">
            @include('misc.loading_engines')
        </div>
    </div>
</div>