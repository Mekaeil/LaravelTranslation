@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (\Session::has("message"))
    <div class="col-md-12">
        <div class="alert alert-{{\Session::get("message")['type']}} }}">
            <em> {!! \Session::get("message")['text'] !!}</em>
        </div>
    </div>
@endif
