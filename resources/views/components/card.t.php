<div class="card" :class="!empty($class) ? $class : ''">
  <h5 class="card-header" p-if="!empty($header)">{{ $header }}</h5>
  <div class="card-body">
    <h5 class="card-title" p-if="!empty($title)">{{ $title }}</h5>
    <slot></slot>
  </div>
</div>