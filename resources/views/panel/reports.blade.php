@extends('template')

@section('content')
    @foreach($configs as $config)
        <?php
            switch($config['name']) {
                case 'reservation':
                    $reservation = $config['value'];

                    break;
                default:
                    break;
            }
        ?>
    @endforeach
    <div class="navbar fixed-top shadow">
        <div class="navbar-content">
            <a href="{{ route('main.getIndex') }}" class="navbar-element-brand">
                <div class="navbar-element logo"><img src="/img/logo.png"></div>
                <div class="navbar-element title">De Ocampo Memorial College</div>
            </a>
            <div class="u-pull-right">
                <a href="{{ route('main.getAbout') }}" class="navbar-element">About Us</a>
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
                            <li><a href="{{ route('main.getAccountInfo') }}">Account Information</a></li>
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
                    <li class="list-group-item"><a href="{{ route('panel.getLoan') }}">Loan Book(s)</a></li>
                    @if(isset($reservation) && $reservation == 'Show')
                        <li class="list-group-item"><a href="{{ route('panel.getReserved') }}">Reserved Book(s)</a></li>
                    @endif
                    <li class="list-group-item"><a href="{{ route('panel.getReceive') }}">Receive Book(s)</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'materials') }}">Manage Books</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'authors') }}">Manage Authors</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'publishers') }}">Manage Publishers</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'users') }}">Manage Users</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'librarians') }}">Edit Accounts</a></li>
                    <!-- <li class="list-group-item"><a href="{{ route('panel.getManage', 'holidays') }}">Manage Holidays</a></li> -->
                    <li class="list-group-item active"><a href="{{ route('panel.getReports') }}">Library Reports</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getConfiguration') }}">System Configuration</a></li>
                </ul>
            </div>
            <div class="nine columns">
                <div class="banner">Library Reports</div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="six columns">
                        <div class="panel">
                            <div class="panel-header">Generate Loan Report</div>
                            <div class="panel-body">
                                {!! Form::open(array('route' => array('panel.postReports', 'loan_report'))) !!}
                                    <div class="row">
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('from', 'From:') !!}
                                                {!! Form::text('from', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('to', 'To:') !!}
                                                {!! Form::text('to', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-block text-right">
                                        {!! Form::submit('Generate', array('class' => 'btn btn-orange')) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="six columns">
                        <div class="panel">
                            <div class="panel-header">Generate Reservation Report</div>
                            <div class="panel-body">
                                {!! Form::open(array('route' => array('panel.postReports', 'reservation_report'))) !!}
                                    <div class="row">
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('from', 'From:') !!}
                                                {!! Form::text('from', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('to', 'To:') !!}
                                                {!! Form::text('to', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-block text-right">
                                        {!! Form::submit('Generate', array('class' => 'btn btn-orange')) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="six columns">
                        <div class="panel">
                            <div class="panel-header">Generate Book Report</div>
                            <div class="panel-body">
                                {!! Form::open(array('route' => array('panel.postReports', 'material_report'))) !!}
                                    <div class="row">
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('from', 'From:') !!}
                                                {!! Form::text('from', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('to', 'To:') !!}
                                                {!! Form::text('to', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-block text-right">
                                        {!! Form::submit('Generate', array('class' => 'btn btn-orange')) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="six columns">
                        <div class="panel">
                            <div class="panel-header">Generate Top Report</div>
                            <div class="panel-body">
                                {!! Form::open(array('route' => array('panel.postReports', 'top_report'))) !!}
                                    <div class="row">
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('from', 'From:') !!}
                                                {!! Form::text('from', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                        <div class="six columns">
                                            <div class="input-block">
                                                {!! Form::label('to', 'To:') !!}
                                                {!! Form::text('to', null, array('class' => 'u-full-width', 'placeholder' => 'yyyy-mm-dd', 'maxlength' => '10', 'onkeyup' => 'isDate(this)', 'required' => 'required')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-block text-right">
                                        {!! Form::submit('Generate', array('class' => 'btn btn-orange')) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop