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
                'link'  => '#',
                'name'  => 'Module Sentences',
            ]
        ]
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">


            <div class="clearfix">
                <div class="x_panel">

                    <form action="{{ route('admin.trans.base.index') }}" method="GET">

                        @include('LaraTrans::Layouts.select-field',[
                            'label' => [
                                'value' => "Select Language",
                            ],

                            'name'              => 'lang',
                            'id'                => 'changeLocale',
                            'placeholderSelect' => 'Select Languages',
                            'class'             => 'form-control',
                            'parentInputClass'  => 'col-md-3',
                            'labelClass'        => 'col-md-12',
                            'list'              => $languages,
                            'selected'          => Request::get('lang') ?? '',
                            'load'              => 'true',
                        ])

                        @if( Request::get('lang') || Request::get('module') )
                            <a href="{{ route('admin.trans.base.index') }}" class="btn removeFilter btn-warning left">
                                Reset Filter
                            </a>
                        @endif

                        <button type="submit" class="btn filter btn-info col-md-2 left m-t-20">
                            <span class="fa fa-filter"></span>
                            Filter
                        </button>

                    </form>

                </div>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Module Sentences List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Module</th>
                                <th>Locale</th>
                                <th>Data</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5">Comming Soon ...</td>
                            </tr>
                            {{--@foreach($words as $word)--}}
                                {{--<tr>--}}
                                    {{--<th scope="row">{{ $loop->iteration }}</th>--}}
                                    {{--<td>{{ $word->key }}</td>--}}
                                    {{--<td>{{ $word->value }}</td>--}}
                                    {{--<td>{{ $word->locale }}</td>--}}
                                    {{--<td>--}}
                                        {{-- TO DO --}}
                                        {{--...--}}
                                        {{--<a href="#" class="btn btn-default">--}}
                                            {{--Edit--}}
                                        {{--</a>--}}
                                        {{--<a href="#" class="btn btn-danger">--}}
                                            {{--Delete--}}
                                        {{--</a>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @parent

@endsection