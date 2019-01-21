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
                'name'  => 'Languages',
            ]
        ]
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">


            <a class="btn btn-primary left"  href="{{ route('admin.trans.lang.create') }}">
                Create New
                <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;
            </a>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Languages List</h2>
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
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Status</th>
                                <th>Default</th>
                                <th>Direction</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($languages as $language)
                                <tr class="{{ $language->default ? 'success' : '' }}">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $language->name }}</td>
                                    <td>{{ $language->display_name }}</td>
                                    <td>{{ $language->status ? 'Active' : 'Deactive' }}</td>
                                    <td>{{ $language->default ? 'Default' : '--' }}</td>
                                    <td>{{ $language->direction }}</td>
                                    <td>
                                        @include('LaraTrans::Layouts.modal',[
                                            'title'     => 'Set Language As Default',
                                            'action'    => route('admin.trans.lang.set.as.default', $language),
                                            'method'    => 'POST',
                                            'id'        => 'DefaultLang_'. $language->name,
                                            'confirm'   => 'Set Default',
                                            'btnClass'  => 'btn btn-warning btn-sm left',
                                            'button'    => 'Set Default',
                                            'content'   => 'Are you sure? you want to set this language as default : '. $language->name ,
                                        ])

                                        <a href="{{ route('admin.trans.lang.edit', $language) }}" class="btn btn-sm btn-default">
                                            Edit
                                        </a>

                                        @include('LaraTrans::Layouts.modal',[
                                            'title'     => 'Delete Language',
                                            'action'    => route('admin.trans.lang.confirm.delete', $language),
                                            'method'    => 'DELETE',
                                            'id'        => 'DeleteLang_'. $language->name,
                                            'confirm'   => 'Delete',
                                            'btnClass'  => 'btn btn-danger btn-sm left',
                                            'button'    => 'Delete',
                                            'content'   => 'Are you sure? you want to delete : '. $language->name ,
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