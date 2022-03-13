<nav aria-label="breadcrumb" p-if="!empty($links)">
  <ol class="breadcrumb m-0">
    <li class="breadcrumb-item" p-foreach="$links as $link">
      <a p-if="isset($link['href'])" :href="$link['href']">{{ $link['name'] }}</a>
      <span p-else>{{ $link['name'] }}</span>
    </li>
  </ol>
</nav>