@php
    $output = $output ?? [];
    $warnings = $output['validation_warnings'] ?? [];
    $_errors = $output['validation_errors'] ?? [];
    $user_details = $output['user_details'] ?? [];
@endphp
<html>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="document_confirmare">
            <button type="submit">Submit</button>
        </form>
        @if (isset($output['memory_used']))
            used memory {{ $output['memory_used'] }}
        @endif

        @if (isset($output['result']))
            <form action="/download" method="post">
                @csrf
                <button type="submit" name="filename" value="{{$output['result']}}">Download</button>
            </form>
        @endif

        @if (!is_array($output))
        <p style="color:red">{{$output}}</p>
        @endif

        @foreach ($user_details as $detail => $val)
            <p>{{$detail}} = {{$val}}</p>
        @endforeach
        <br>
        <br>
        @foreach ($warnings as $warn)
            <p style="color:grey">{{$warn['text']}}</p>
        @endforeach
        <br>
        <br>
        @foreach ($_errors as $err)
            <p style="color:red">{{$err['text']}}</p>
        @endforeach
    </body>
</html>