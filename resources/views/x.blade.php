<meta name="csrf-token" content="{{ csrf_token() }}">
@php
dump(headers_list(), session()->all());
@endphp
<form action="/login" method="post">
    @csrf
    <button type="submit">submit</button>
</form>