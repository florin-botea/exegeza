<h1>Most popular</h1>
<ul>
    @foreach ($articles as $article)
        <li>{{$article->title}} ({{$article->views_count}})</li>
    @endforeach
</ul>