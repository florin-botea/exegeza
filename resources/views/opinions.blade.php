@extends('layouts.main')

@section('content')
    <div class="">
        <section role="comments" class="{{ auth()->user() ? '' : '_unauthenticated' }} px-6 mb-6 bg-gray-100" id="comments-container" data-src="/comments?app=1">

        </section>
        <hr class="my-2">
    </div>
@endsection