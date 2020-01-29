@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('sections.bible-search')
        </div>
        <div class="col-md-8">
            @yield('main')
        </div>
    </div>
@endsection