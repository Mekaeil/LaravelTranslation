<div class="{{ isset($parentInputClass) ? $parentInputClass : 'col-md-4' }}">

    {{-- IF THE INPUT TEXT HAS LABEL--}}
    @if( isset($label) )
        <label class="{{ isset($labelClass) ? $labelClass : '' }} label-control" for="{{ $name }}">{{ $label['value'] }}</label>
        @if(isset($required) and $required == true)
            <span class="red">*</span>
        @endif
    @endif


    <select
            name="{{ isset($name) ? $name : 'selection' }}"
            class="selectpicker form-control "
            id="{{ $id ?? '' }}"
            data-style="btn-{{ isset($style) && $style != '' ? $style : '' }}"
            title="{{ isset($placeholderSelect) ? $placeholderSelect : 'Choose ...' }}"
            data-live-search="{{ isset($liveSearch) && $liveSearch ? 'true' : '' }}"
            {{ isset($disabled) && $disabled ? ' disabled ' : '' }} {{ isset($multiple) && $multiple ? " multiple " : '' }}
    >
        @php
            $isArray = isset($selected) ? is_array($selected) : false;

            $keyVal = $keyValue ?? 'key';
        @endphp

        @foreach( $list as $key => $value )

            @if( $isArray )
                @php( $select = isset($selected) && in_array( $key, $selected ) ? 'selected' : '' )
            @else
                @php( $select = isset($selected) && $selected == $key ? 'selected' : '' )
            @endif

            <option value="{{ ${$keyVal} }}" data-tokens="{{ $key }}" {{ $select }}>{{ $value }}</option>
        @endforeach
    </select>

</div>


@section('header')
    @parent

    @if(!isset($load) || ( isset($load) && $load == 'true' ))
        <link rel="stylesheet" href="{{ asset('laravel-translation/vendors/bootstrap-select/bootstrap-select.min.css') }}" >
    @endif
@endsection

@section('footer')
    @parent

    @if(!isset($load) || ( isset($load) && $load == 'true' ))
        <script src="{{ asset('laravel-translation/vendors/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endif

@endsection