<h1>Most recent</h1>
<ul>
    @foreach ($articles as $article)
        <li>{{$article->title}}
            <p>{{$article->sample}}</p>
        </li>
    @endforeach
</ul>