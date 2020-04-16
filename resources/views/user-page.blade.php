@extends('layouts.main')

@section('content')
<main>
    <ul role="tabs" class="flex px-4">
        <li class="bg-gray-200 border border-gray-400 border-r-2 border-b-2 rounded">
            <a href="{{ route('users.show', [$user->id]) }}" class="px-2 py-1"> Profile </a>
        </li>
        @can('update', $user)
        <li class="bg-gray-200 border border-gray-400 border-r-2 border-b-2 rounded">
            <a href="{{ route('users.edit', [$user->id]) }}" class="px-2 py-1"> Edit profile </a>
        </li>
        @endcan
    </ul>

    @yield('tab')
</main>
@endsection