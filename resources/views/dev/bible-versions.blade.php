@extends('layouts.dev')

@section('content')
    <div class="">
        <h1>bible-versions/</h1>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>index</th>
                    <th>name</th>
                    <th>alias</th>
                    <th>slug</th>
                    <th>language</th>
                    <th>public</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bibles as $bible)
                <tr>
                    <td>{{ $bible->id }}</td>
                    <td><input type="number" name="index" value="{{ $bible->index }}" placeholder="index" class="w-16"></td>
                    <td><input type="text" name="name" value="{{ $bible->name }}" placeholder="name" class=""></td>
                    <td><input type="text" name="alias" value="{{ $bible->alias }}" placeholder="alias" class=""></td>
                    <td><input type="text" name="slug" value="{{ $bible->slug }}" placeholder="slug" class=""></td>
                    <td><input type="text" name="language" value="{{ $bible->language->value }}" placeholder="language" class=""></td>
                    <td><input type="checkbox" name="public" class="mx-4"></td>
                    <td><button>Update</button></td>
                    <td><button>Delete</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection