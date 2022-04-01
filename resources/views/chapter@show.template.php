<extends template="layouts/app"/>

<card>
    <nav>
      <ul class="pagination pagination-sm flex-wrap">
        <li p-if="$prev" class="page-item mb-1 me-1">
          <a class="page-link" :href="$prev['href']" :title="$prev['name']" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li p-foreach="$chapters as $ch" class="page-item mb-1 me-1" :class="$chapter->index == $ch->index ? 'active' : ''"><a class="page-link" :href="$ch->url" :title="$ch->name">{{ $ch->index }}</a></li>
        <li p-if="$next" class="page-item mb-1 me-1">
          <a class="page-link" :href="$next['href']" :title="$next['name']" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    
    <div class="list-group">
      <a p-foreach="$verses as $verse" class="list-group-item list-group-item-action list-group-flush">
        {{ $verse->index }}. {{ $verse->text }}
      </a>
    </div>
    <div class="d-flex flex-wrap justify-content-between py-2">
        <a p-if="$prev" :href="$prev['href']" class="btn btn-sm btn-outline-secondary m-1">&lt; {{ $prev['name'] }}</a>
        <span p-else></span>
        <a p-if="$next" :href="$next['href']" class="btn btn-sm btn-outline-primary m-1">{{ $next['name'] }} &gt;</a>
    </div>
</card>