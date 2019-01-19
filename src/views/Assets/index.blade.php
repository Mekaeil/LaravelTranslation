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
                'name'  => 'Assets',
            ]
        ]
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <a class="btn btn-primary left"  href="{{ route('admin.trans.assets.create') }}">
                Add New Asset
                <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;
            </a>

            {{-- FILTERING --}}
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

                        @if( Request::get('lang')  )
                            <a href="{{ route(config('laravel-translation.base_word_index')) }}" class="btn removeFilter btn-warning left">
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

            {{-- RESULT TABLE --}}
            <div class="x_panel">
                <div class="x_title">
                    <h2>Base Words List</h2>
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
                                <th>Key Name</th>
                                <th>Value Name</th>
                                <th>Locale</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $asset->lang_id }}</td>
                                    <td>{{ $asset->type }}</td>
                                    <td>{{ $asset->where }}</td>
                                    <td>{{ $asset->source }}</td>
                                    <td>
                                        <a href="{{ route('admin.trans.assets.edit', $asset) }}" class="btn btn-sm btn-default">
                                            Edit
                                        </a>

                                        @include('LaraTrans::Layouts.modal',[
                                            'title'     => 'Assets Translation',
                                            'action'    => route('admin.trans.assets.delete.confirm', $asset),
                                            'method'    => 'DELETE',
                                            'id'        => 'DeleteAsset_'. $asset->id,
                                            'confirm'   => 'Delete',
                                            'btnClass'  => 'btn btn-danger btn-sm left',
                                            'button'    => 'Delete',
                                            'content'   => 'Are you sure? you want to delete this asset : '. $asset->source ,
                                        ])
                                    </td>
                                </tr>
                            @endforeach
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