<div class="loading-list" data-baseurl="/api/articles?bible=1&book=1">
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
                <input name="author" class="js-articleFilter form-control" placeholder="Autor">
            </div>
            <div class="form-group mx-1 col-md">
                <select name="language" class="js-articleFilter form-control">
                    <option value="default">language</option>
                    <option value="all">---</option>
                    @foreach ($languages??[] as $language)
                    <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mx-1 col-md">
                <select name="confession" class="js-articleFilter form-control">
                    <optgroup label="Confesiune">
                        <option value="all">toate confesiunile</option>
                        @foreach ($confessions??[] as $confession)
                        <option value="{{ $confession }}">{{ $confession }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="form-group mx-1 col-md">
                <select name="sort" class="js-articleFilter form-control">
                    <option value="date-asc">Data postarii - crescator:</option>
                    <option value="date-desc">Data postarii - descrescator:</option>
                </select>
            </div>
        </div>
    </div>

    <div class="list-content">

    </div>

    <div class="display-flex justify-content-center">
        <Loading v-show="loading" :error="error" class="mx-auto"/>
    </div>
</div>