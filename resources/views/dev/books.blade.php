@extends('layouts.dev')

@section('content')
    <div class="bg-gray-300 p-2">
        <h1 class="text-lg font-bold underline">
            <a href="/dev/bible-versions/" class="text-blue-600 hover:text-blue-400">bible-versions/</a>{{ $bible->name }}_({{ $bible->id }})/books/
        </h1>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>index</th>
                    <th>name</th>
                    <th>alias</th>
                    <th>slug</th>
                    <th>type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bible->books as $book)
                <form method="post">@csrf
                <tr>
                    <td>{{ $book->id }}</td>
                    <td><input name="index" type="number" value="{{ $book->index }}" placeholder="index" class="w-16"></td>
                    <td><input name="name" type="text" value="{{ $book->name }}" placeholder="name" class="input-w-full"></td>
                    <td><input name="alias" type="text" value="{{ $book->alias }}" placeholder="alias" class="input-w-full"></td>
                    <td><input name="slug" type="text" value="{{ $book->slug }}" placeholder="slug" class="input-w-full"></td>
                    <td>
                        <select name="type">
                            <option default disabled>type</option>
                            <option value="vt" {{ $book->type == 'vt' ? 'selected' : null }}>VT</option>
                            <option value="nt" {{ $book->type == 'nt' ? 'selected' : null }}>NT</option>
                            <option value="altele" {{ $book->type == 'altele' ? 'selected' : null }}>altele</option>
                        </select>
                    </td>
                    <td><button type="submit" name="_method" value="put" formaction="{{ route('bible-versions.books.update', [$bible->id, $book->id]) }}"> Update </button></td>
                    <td><button type="submit" name="_method" value="delete" formaction="{{ route('bible-versions.books.destroy', [$bible->id, $book->id]) }}"> Delete </button></td>
                    <td><a href="/dev/bible-versions/{{$bible->id}}/books/{{$book->id}}/chapters" class="pl-2 text-blue-600 hover:text-blue-400 font-semibold"> __chapters/ </a></td>
                </tr>
                </form>
                @endforeach
            </tbody>
            <tfoot>
                <form action="{{ route('bible-versions.books.store', [$bible->id]) }}" method="post">@csrf
                <tr>
                    <td colspan="9">---</td> 
                </tr>
                <tr>
                    <th colspan="2">Add book</th>
                </tr>
                <tr>
                    <td></td>
                    <td><input name="index" type="number" value="{{ old('index') }}" placeholder="index" class="w-16"></td>
                    <td><input name="name" type="text" value="{{ old('name') }}" placeholder="name" class="input-w-full"></td>
                    <td><input name="alias" type="text" value="{{ old('alias') }}" placeholder="alias" class="input-w-full"></td>
                    <td><input name="slug" type="text" value="{{ old('slug') }}" placeholder="slug" class="input-w-full"></td>
                    <td>
                        <select name="type">
                            <option default hidden disabled {{old('type') ? null : 'selected'}}>type</option>
                            <option value="vt" {{ old('type') == 'vt' ? 'selected' : null }}>VT</option>
                            <option value="nt" {{ old('type') == 'nt' ? 'selected' : null }}>NT</option>
                            <option value="altele" {{ old('type') == 'altele' ? 'selected' : null }}>altele</option>
                        </select>
                    </td>
                    <td><button type="submit"> Create </button></td>
                </tr>
                </form>
            </tfoot>
        </table>
    </div>
@endsection