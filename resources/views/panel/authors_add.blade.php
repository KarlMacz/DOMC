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
                    <li class="list-group-item"><a href="{{ route('panel.getLoan') }}">Loan Material(s)</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getReserved') }}">Reserved Material(s)</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getReceive') }}">Receive Material(s)</a></li>
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
                {!! Form::open(array('route' => array('panel.postAdd', $what))) !!}
                    <div class="input-block">
                        {!! Form::label('authorFirstName', 'First Name:') !!}
                        {!! Form::text('authorFirstName', null, array('class' => 'u-full-width', 'placeholder' => 'Enter First Name Here', 'required' => 'required', 'autofocus' => 'autofocus')) !!}
                    </div>
                    <div class="input-block">
                        {!! Form::label('authorMiddleName', 'Middle Name:') !!}
                        {!! Form::text('authorMiddleName', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Middle Name Here')) !!}
                    </div>
                    <div class="input-block">
                        {!! Form::label('authorLastName', 'Last Name:') !!}
                        {!! Form::text('authorLastName', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Last Name Here', 'required' => 'required')) !!}
                    </div>
                    <div class="input-block text-right">
                        {!! Form::submit('Add Author', array('class' => 'btn btn-orange')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('post_ref')
    <script src="/js/panel.faculties.js"></script>
@stop