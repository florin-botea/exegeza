<form :action="$action" :method="$method">
  <csrf/>
  <slot></slot>
</form>