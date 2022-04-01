<extends template="layouts/app"/>

<card>
    <div class="list-group">
      <a p-foreach="$chapters as $chapter" :href="$chapter->url" class="list-group-item list-group-item-action list-group-flush">
        Cap. {{ $chapter->index }}: {{ $chapter->name }}
      </a>
    </div>
</card>