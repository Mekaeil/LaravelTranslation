
<div class="{{ $parentClass ?? '' }}">
    <label>
        <input type="checkbox" name="{{ $name }}" class="js-switch btn-sm" {{ $checked ?? '' }} {{ $disabled ?? '' }} />
        {{ $text ?? 'Switch' }}
    </label>
</div>


@section('header')
    @parent

    @if(isset($load) && $load == 'true')
        <link href="{{ asset('laravel-translation/vendors/switchery/switchery.min.css') }}" rel="stylesheet">
    @endif

@endsection


@section('footer')
    @parent

    @if(isset($load) && $load == 'true')
        <script src="{{ asset('laravel-translation/vendors/switchery/switchery.min.js') }}"></script>
    @endif

@endsection