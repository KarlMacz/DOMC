@extends('template')

@section('content')
    <div class="navbar fixed-top shadow">
        <div class="navbar-content">
            <div class="navbar-element title">De Ocampo Memorial College</div>
            <div class="u-pull-right">
                <a href="{{ route('main.getOpac') }}" class="navbar-element">OPAC</a>
                <a href="{{ route('panel.getIndex') }}" class="navbar-element active">Control Panel</a>
                @if(session()->has('username'))
                    <div class="dropdown">
                        <a class="navbar-element dropdown-toggle">
                            @if(strlen(session()->get('middle_name')) > 1)
                                {{ session()->get('first_name') . ' ' . substr(session()->get('middle_name'), 0, 1) . '. ' . session()->get('last_name') }}
                            @else
                                {{ session()->get('first_name') . ' ' . session()->get('last_name') }}
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('main.getLogout') }}">Logout</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="main-container" class="container-fluid">
        <div class="row">
            <div class="three columns">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ route('panel.getIndex') }}">Home</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'materials') }}">Manage Materials</a></li>
                    <li class="list-group-item active"><a href="{{ route('panel.getManage', 'authors') }}">Manage Authors</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'publishers') }}">Manage Publishers</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'students') }}">Manage Students</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'faculties') }}">Manage Faculties</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'settings') }}">System Settings</a></li>
                </ul>
            </div>
            <div class="nine columns">
                <div class="banner">Manage Authors</div>
                <table id="authors-table" class="u-full-width">
                    <thead>
                        <tr>
                            <th>Author's Name</th>
                            <th width="25%"></th>
                        </tr>
                        <tbody>
                            @foreach($authors as $author)
                                <tr>
                                    <td>
                                        @if(strlen($author->Author_Middle_Name) > 1)
                                            {{ $author->Author_First_Name . ' ' . substr($author->Author_Middle_Name, 0, 1) . '. ' . $author->Author_Last_Name }}
                                        @else
                                            {{ $author->Author_First_Name . ' ' . $author->Author_Last_Name }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(strlen(session()->has('username')))
                                            <a href="{{ route('panel.getEdit', array($what, $author->Author_ID)) }}" class="btn-orange btn-sm">Edit</a>
                                            <a href="{{ route('panel.getDelete', array($what, $author->Author_ID)) }}" class="btn-red btn-sm">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('post_ref')
    <script src="/js/panel.authors.js"></script>
@stop