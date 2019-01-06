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
                'link'  => config('laravel-translation.languages_index'),
                'name'  => 'Languages',
            ],
            [
                'link'  => '#',
                'name'  => 'add new language',
            ]
        ]
    ])
@endsection

@section('header')
    @parent

@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">

            {{-- RESULT TABLE --}}
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Language : {{ $lang->name }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.trans.lang.update', $lang) }}" method="POST">
                        {{ csrf_field() }}

                        @include('LaraTrans::Layouts.text-field',[
                            'name'              => 'display_name',
                            'type'              => 'text',
                            'value'             => $lang->display_name,
                            'required'          => 'true',
                            'parentInputClass'  => 'col-md-4',
                            'label'             => [
                                'value' => 'Display Name',
                            ],
                        ])

                        @include('LaraTrans::Layouts.switch',[
                            'load'          => 'true',
                            'parentClass'   => 'form-group',
                            'checked'       => $lang->status ? 'checked' : '',
                            'name'          => 'status',
                            'text'          => 'Active',
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