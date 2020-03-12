@extends('layouts.dev')

@php
    use \App\Helpers\Form;
@endphp

@section('content')
    <div class="bg-gray-300 p-2">
        <h1 class="text-lg font-bold underline">bible-versions/</h1>
        <table class="w-full">
            <thead>
                <tr>
                    <th>id</th>
                    <th>index</th>
                    <th>name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bible->book->chapters as $chapter)
                <form method="post">
                    @csrf
                    <input name="form_id" value="{{ $chapter->id }}" hidden>
                    <tr>
                        <td>{{ $chapter->id }}</td>
                        <td><input name="index" type="number" value="{{ Form::value($chapter->id,'index',$chapter->index) }}" placeholder="index" class="w-16"></td>
                        <td><input name="name" type="text" value="{{ Form::value($chapter->id,'name',$chapter->name) }}" placeholder="name" class="input-w-full"></td>
                        <td><button type="submit" name="_method" value="put" formaction="{{ route('bible-versions.books.chapters.update', [$bible->id, $bible->book->id, $chapter->id]) }}"> Update </button></td>
                        <td><button type="submit" name="_method" value="delete" formaction="{{ route('bible-versions.books.chapters.destroy', [$bible->id, $bible->book->id, $chapter->id]) }}"> Delete </button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="5">
                            <input name="add_verses" {{ Form::checked($chapter->id,'add_verses') }} type="checkbox" class="checked:next-hidden-show"> add verses
                            <div class="hidden">
                                <input name="regex" value="{{ Form::value($chapter->id,'regex') }}" type="text" class="block input-w-full">
                                <textarea name="verses" value="{{ Form::value($chapter->id,'verses') }}" class="mt-2 input-w-full"></textarea>
                            </div>
                        </td>
                    </tr>
                </form>
                @endforeach
            </tbody>
            <tfoot>
                <form method="post">
                    @csrf
                    <input name="form_id" value="0" hidden>
                    <tr>
                        <td colspan="5">---</td> 
                    </tr>
                    <tr>
                        <th colspan="5">Add chapter</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input name="index" value="{{ Form::value(0,'index') }}" placeholder="index" class="w-16" type="number"></td>
                        <td class="w-full"><input name="name" value="{{ Form::value(0,'name') }}" placeholder="name" class="input-w-full" type="text"></td>
                        <td><button name="_method" value="post" formaction="{{ route('bible-versions.books.chapters.store', [$bible->id, $bible->book->id]) }}" type="submit"> Create </button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="5">
                            <input name="add_verses" {{ Form::checked(0,'add_verses') }} type="checkbox" class="checked:next-hidden-show"> add verses
                            <div class="hidden">
                                <input name="regex" value="{{ Form::value(0,'regex') }}" type="text" class="block input-w-full">
                                <textarea name="verses" class="mt-2 input-w-full">{{ Form::value(0,'verses') }}</textarea>
                                <div class="flex justify-end">
                                    <button type="submit" name="_method" value="post" formaction="/verses-preview"> Preview </button>
                                </div>
                                @if (session('verses_preview'))
                                    <div class="">
                                        @foreach (session('verses_preview') as $i => $verse)
                                            <p>{{ ($i+1).'. '.$verse }}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                </form>
            </tfoot>
        </table>
    </div>
@endsection