@extends('LaraTrans::Layouts.master')

@section('dir','ltr')

@section('header')
    @parent

@endsection


@section('breadcrumb')
    @include('LaraTrans::Layouts.breadcrumb', [
        'lists' => [
            [
                'link'  => '#',             // route like : admin.panel
                'name'  => 'dashboard',
            ],
            [
                'link'  => config('laravel-translation.base_word_index'),
                'name'  => 'Base Words',
            ],
            [
                'link'  => '#',
                'name'  => 'Edit Words',
            ]
        ]
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">


            {{-- RESULT TABLE --}}
            <div class="x_panel">
                <div class="x_title">
                    <h2>Create New Base Words</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.trans.base.update', $trans) }}" method="POST">
                        {{ csrf_field() }}

                        @include('LaraTrans::Layouts.text-field',[
                            'name'       => 'key',
                            'type'       => 'text',
                            'value'      => $trans->key,
                            'required'   => 'true',
                            'slugify'           => 'true',
                            'parentInputClass'  => 'col-md-8',
                            'label'      => [
                                'value' => 'Key Name',
                            ],
                        ])

                        @include('LaraTrans::Layouts.select-field',[
                            'label' => [
                                'value' => "Select Language",
                            ],

                            'name'              => 'lang',
                            'id'                => 'locale',
                            'placeholderSelect' => 'Select Languages',
                            'class'             => 'form-control',
                            'parentInputClass'  => 'col-md-4',
                            'labelClass'        => 'col-md-12',
                            'list'              => $languages,
                            'selected'          => $trans->lang,
                            'load'              => 'true',
                        ])


                        @include('LaraTrans::Layouts.text-field',[
                            'name'              => 'value',
                            'type'              => 'textarea',
                            'value'             => $trans->value,
                            'placeHolder'       => 'value ...',
                            'required'          => 'true',
                            'ckeditor'          => true,
                            'parentInputClass'  => 'col-md-12',

                            'label'      => [
                                'value'  => 'Value',
                            ],
                        ])

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-success" >
                                <i class="fa fa-save"></i>
                                <span>Save</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection


@section('footer')
    @parent

@endsection