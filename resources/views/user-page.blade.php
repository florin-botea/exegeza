@extends('layouts.main')

@section('content')
<main>
    <ul class="bg-gray-400 flex flex-wrap mb-4 pt-2">
        <li>
            <a class="ml-1 px-2 py-1 md:rounded-t-md font-medium {{ request()->route()->getName() == 'users.show' ? 'font-bold text-lg bg-white' : 'bg-gray-200' }}" 
            href="{{ route('users.show', [$user->id]) }}"> Profile </a>
        </li>
        @can('update', $user)
        <li>
            <a class="ml-1 px-2 py-1 md:rounded-t-md font-medium {{ request()->route()->getName() == 'users.edit' ? 'font-bold text-lg bg-white' : 'bg-gray-200' }}"
            href="{{ route('users.edit', [$user->id]) }}"> Edit profile </a>
        </li>
        @endcan
        @can('update', $user)
        <li>
            <a class="ml-1 px-2 py-1 md:rounded-t-md font-medium {{ request()->route()->getName() == 'users.options' ? 'font-bold text-lg bg-white' : 'bg-gray-200' }}"
            href="#"> Options </a>
        </li>
        @endcan
        @can('delete', $user)
        <li>
            <a class="ml-1 px-2 py-1 md:rounded-t-md font-medium {{ request()->route()->getName() == 'users.danger-zone' ? 'font-bold text-lg bg-white' : 'bg-gray-200' }}"
            href="{{ route('users.danger-zone', [$user->id]) }}"> Danger zone </a>
        </li>
        @endcan
    </ul>

    @yield('tab')
</main>
@endsection