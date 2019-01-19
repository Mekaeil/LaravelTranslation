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
                'link'  => config('laravel-translation.assets_index'),
                'name'  => 'Assets',
            ],
            [
                'link'  => '#',
                'name'  => 'Add new asset',
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
                    <h2>Add New Asset</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.trans.assets.store') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="row">
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
                                'selected'          => '',
                                'load'              => 'true',
                            ])

                            @include('LaraTrans::Layouts.select-field',[
                                'label' => [
                                    'value' => "Select Asset Type",
                                ],

                                'name'              => 'type',
                                'id'                => 'asset',
                                'placeholderSelect' => 'Select Asset Type',
                                'class'             => 'form-control',
                                'parentInputClass'  => 'col-md-4',
                                'labelClass'        => 'col-md-12',
                                'list'              => $types,
                                'selected'          => '',
                                'load'              => 'false',
                            ])

                            @include('LaraTrans::Layouts.select-field',[
                                'label' => [
                                    'value' => "Select Path Type",
                                ],

                                'name'              => 'path_type',
                                'id'                => 'asset',
                                'placeholderSelect' => 'Select Path Type',
                                'class'             => 'form-control',
                                'parentInputClass'  => 'col-md-4',
                                'labelClass'        => 'col-md-12',
                                'list'              => $pathType,
                                'selected'          => 'asset',
                                'load'              => 'false',
                            ])
                        </div>

                        <div class="row">
                            @include('LaraTrans::Layouts.select-field',[
                                'label' => [
                                    'value' => "Where we use it?!",
                                ],

                                'name'              => 'where',
                                'id'                => 'asset',
                                'placeholderSelect' => 'Select Path Type',
                                'class'             => 'form-control',
                                'parentInputClass'  => 'col-md-4',
                                'labelClass'        => 'col-md-12',
                                'list'              => $positionAssets,
                                'selected'          => '',
                                'load'              => 'false',
                            ])

                            @include('LaraTrans::Layouts.text-field',[
                                 'name'              => 'source',
                                 'type'              => 'textarea',
                                 'value'             => old('source'),
                                 'placeHolder'       => 'Src/href,...',
                                 'required'          => 'true',
                                 'parentInputClass'  => 'col-md-12',
                                 'label'      => [
                                     'value'  => 'Source',
                                 ],
                            ])

                            @include('LaraTrans::Layouts.switch',[
                                'load'          => 'true',
                                'parentClass'   => 'form-group',
                                'checked'       => 'checked',
                                'name'          => 'status',
                                'text'          => 'Active',
                            ])

                        </div>


                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-success" >
                                <i class="fa fa-save"></i>
                                <span>Add Asset</span>
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