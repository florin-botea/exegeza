@extends('layouts.dev')

@section('content')de editat
    <div class="bg-gray-300 p-2">
        <h1 class="text-lg font-bold underline">bible-versions/</h1>
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
                <form method="post">@csrf
                <tr>
                    <td>{{ $bible->id }}</td>
                    <td><input type="number" name="index" value="{{ $bible->index }}" placeholder="index" class="w-16"></td>
                    <td><input type="text" name="name" value="{{ $bible->name }}" placeholder="name" class="input-w-full"></td>
                    <td><input type="text" name="alias" value="{{ $bible->alias }}" placeholder="alias" class="input-w-full"></td>
                    <td><input type="text" name="slug" value="{{ $bible->slug }}" placeholder="slug" class="input-w-full"></td>
                    <td><input type="text" name="language" value="{{ $bible->language->value }}" placeholder="language" class="input-w-full"></td>
                    <td><input type="checkbox" name="public" value="1" class="mx-4" {{ $bible->public ? 'checked' : null }}></td>
                    <td><button type="submit" name="_method" value="put" formaction="{{ route('bible-versions.update', [$bible->id]) }}"> Update </button></td>
                    <td><button type="submit" name="_method" value="delete" formaction="{{ route('bible-versions.destroy', [$bible->id]) }}"> Delete </button></td>
                    <td><a href="/dev/bible-versions/{{$bible->id}}/books" class="pl-2 text-blue-600 hover:text-blue-400 font-semibold"> __books/ </a></td>
                </tr>
                </form>
                @endforeach
            </tbody>
            <tfoot>
                <form action="{{ route('bible-versions.store') }}" method="post">@csrf
                <tr>
                    <td colspan="10">---</td> 
                </tr>
                <tr>
                    <th colspan="2">Add book</th>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="number" name="index" value="{{ old('index') }}" placeholder="index" class="w-16"></td>
                    <td><input type="text" name="name" value="{{ old('name') }}" placeholder="name" class="input-w-full"></td>
                    <td><input type="text" name="alias" value="{{ old('alias') }}" placeholder="alias" class="input-w-full"></td>
                    <td><input type="text" name="slug" value="{{ old('slug') }}" placeholder="slug" class="input-w-full"></td>
                    <td><input type="text" name="language" value="{{ old('language') }}" placeholder="language" class="input-w-full"></td>
                    <td><input type="checkbox" name="public" value="1" {{ old('public') ? 'checked' : null }} class="mx-4"></td>
                    <td><button type="submit"> Create </button></td>
                </tr>
                </form>
            </tfoot>
        </table>
    </div>
@endsection