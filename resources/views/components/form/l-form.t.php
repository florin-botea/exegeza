<form :action="$action" :method="in_array($method, ['post', 'put']) ? 'post' : 'get'" encrypt="multipart/form-data" p-bind="$_attrs">
  <input name="_method" :value="$method" hidden>
  <csrf/>
  <slot></slot>
</form>