<div class="loading-list" id="js_articlesList">
    <div class="list-content">
        @foreach ($articles as $article)
        @php
            $article_url = $article->published_by ? route('articles.show', $article->slug) : route('pending-articles.show', $article->id);
        @endphp
        <article class="list-item" id="list-item-{{ $article->id }}" data-id="{{ $article->id }}">
            <header class="d-flex flex-wrap justify-content-between">
                <a class="h2 w-100 text-dark" href="{{  $article_url }}">{{ $article->title }}</a>
                @if ($article->relationLoaded('bible'))
                <aside class="">{{ $article->bible->alias }} / {{$article->bible->book->name}}{{$article->chapter_index ? ', '.$article->chapter_index : ''}}</aside>
                @endif
                <span role="float-right" style="visibility:hidden">p</span>
                <a class="">{{ $article->author->name }}</a>
                {{-- if translation of, include here --}}
            </header>
            <div class="">
                {!! $article->sample ?? substr($article->content, 0, 500) !!}
                <a href="{{ $article_url }}"> ...read more</a>
            </div>
        </article>
        @endforeach
    </div>
    <a class="load-next" data-next_page_url="foo"></a>
</div>

