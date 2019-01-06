<div class="{{ isset($parentInputClass) ? $parentInputClass : 'col-lg-4' }}">

    {{-- IF THE INPUT TEXT HAS LABEL--}}
    @if( isset($label) )
        <label class="{{ isset($labelClass) ? $labelClass : '' }} label-control" for="{{ $name }}">{{ $label['value'] }}</label>
        @if(isset($required) and $required == true)
            <span class="red">*</span>
        @endif
    @endif

    @if( $type == 'textarea')
        <textarea class="form-control" id="{{ $name }}" name="{{ $name }}" rows="3" placeholder="{{ isset($placeHolder) ? $placeHolder : 'توضیح' }}">{{ isset($value) && $value != '' ? $value : old( $name ) }}</textarea>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            class="form-control {{ isset($class) ? $class : '' }}"
            placeholder="{{  $placeHolder ?? ''  }}"
            name="{{ $name }}"
            value="{{ isset($value) && $value != '' ? $value : old( $name ) }}"
            {{ isset($required) && $required == 'true' ? 'required' : '' }}
        >
    @endif

</div>



@section('footer')
    @parent
    @if( $type == 'textarea' && ( isset( $ckeditor ) && $ckeditor  && $ckeditor != '' )  )
        <script src="{{ asset('laravel-translation/vendors/ckeditor/ckeditor.js') }}"></script>
        <script>
            $(document).ready(function () {
                CKEDITOR.replace('{{ $name }}');
            })

            CKEDITOR.editorConfig = function( config ) {
                // Define changes to default configuration here. For example:
                config.language = "{{ $lang ?? 'en' }}";
                config.contentsLangDirection = "{{ $direction ?? 'ltr' }}";
                // config.uiColor = '#AADC6E';
                config.allowedContent = true;
                config.extraPlugins = 'content';
            };

        </script>
    @endif

    @if( isset( $slugify ) && $slugify != '' && $slugify )
        <script>
            $(document).on('focusout', 'input[name="{{ $name }}"], .slugify', function(event){
                $(this).val(slugify($(this).val()));
            });

            function slugify(text)
            {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/\(+/g, '-')           // Convert ( to -
                    .replace(/[^\w\-\/]+/g, '')     // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
                ;
            }
        </script>
    @endif

@endsection