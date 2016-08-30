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
                    <li class="list-group-item active"><a href="{{ route('panel.getLoan') }}">Loan Book(s)</a></li>
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
                    <li class="list-group-item"><a href="{{ route('panel.getReports') }}">Library Reports</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getConfiguration') }}">System Configuration</a></li>
                </ul>
            </div>
            <div class="nine columns">
                <div class="banner">Loan Book(s)</div>
                @if(session()->has('global_status'))
                    @if(session()->get('global_status') == 'Success')
                        <?php $class = ' success'; ?>
                    @elseif(session()->get('global_status') == 'Warning')
                        <?php $class = ' warning'; ?>
                    @else
                        <?php $class = ' danger'; ?>
                    @endif

                    <div class="alert{{ $class }}">{{ session()->get('global_message') }}</div>
                @endif
                <form data-form="search-borrower-form">
                    <div class="input-block">
                        {!! Form::label('searchKeyword', 'Search User:') !!}
                        {!! Form::text('searchKeyword', null, array('style' => 'margin-right: 5px; vertical-align: middle;', 'placeholder' => 'Enter User I.D. Number Here', 'required' => 'required', 'autofocus' => 'autofocus')) !!}
                        {!! Form::submit('Search', array('class' => 'btn btn-orange', 'style' => 'vertical-align: middle; height: 38px !important;')) !!}
                    </div>
                </form>
                <div id="borrowers-table-block"></div>
            </div>
        </div>
    </div>
    <div id="loan-book-modal" class="modal">
        <div class="modal-container" style="margin-left: -35%; width: 70%;">
            <div class="modal-header">Loan Book(s)</div>
            <div class="modal-body">
                <form data-form="search-book-form">
                    <div class="input-block">
                        {!! Form::label('searchKeyword', 'Search Book:') !!}
                        {!! Form::text('searchKeyword', null, array('style' => 'margin-right: 5px; vertical-align: middle;', 'placeholder' => 'Enter Keyword Here', 'required' => 'required', 'autofocus' => 'autofocus')) !!}
                        {!! Form::submit('Search', array('class' => 'btn btn-orange', 'style' => 'vertical-align: middle; height: 38px !important;')) !!}
                    </div>
                </form>
                <div id="books-table-block"></div>
            </div>
        </div>
    </div>
    <div id="book-info-modal" class="modal">
        <div class="modal-container">
            <div class="modal-header">Book Information</div>
            <div class="modal-body"></div>
        </div>
    </div>
    <div id="confirmation-modal" class="modal">
        <div class="modal-container">
            <div class="modal-header">Loan Book(s)</div>
            <div class="modal-body"></div>
            <div class="modal-footer text-right">
                <button class="btn btn-orange btn-sm" data-button="yes-button">Yes</button>&nbsp;<button class="btn btn-orange btn-sm" data-button="no-button">No</button>
            </div>
        </div>
    </div>
    <div id="loader-modal" class="modal">
        <div class="modal-container">
            <div class="modal-header"></div>
            <div class="modal-body">
                <div class="text-center gap-top gap-bottom">
                    <span class="fa fa-spinner fa-4x fa-pulse"></span>
                    <div class="gap-top">
                        Now Searching... Please Wait...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="done-modal" class="modal">
        <div class="modal-container">
            <div class="modal-header">Loan Book(s)</div>
            <div class="modal-body"></div>
        </div>
    </div>
@stop

@section('post_ref')
    <script src="/js/panel.loan.js"></script>
@stop