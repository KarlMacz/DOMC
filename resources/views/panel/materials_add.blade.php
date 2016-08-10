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
                    <li class="list-group-item active"><a href="{{ route('panel.getManage', 'materials') }}">Manage Books</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'authors') }}">Manage Authors</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'publishers') }}">Manage Publishers</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'students') }}">Manage Students</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'faculties') }}">Manage Faculties</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'librarians') }}">Manage Librarians</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'holidays') }}">Manage Holidays</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getReports') }}">Library Reports</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getConfiguration') }}">System Configuration</a></li>
                </ul>
            </div>
            <div class="nine columns">
                <div class="banner">Manage Books - Add</div>
                {!! Form::open(array('route' => array('panel.postAdd', $what))) !!}
                    <div class="row">
                        <div class="eight columns">
                            <div class="row">
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialTitle', 'Book Title:') !!}
                                        {!! Form::text('materialTitle', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Book Title Here', 'required' => 'required', 'autofocus' => 'autofocus')) !!}
                                    </div>
                                </div>
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialCollectionType', 'Collection Type:') !!}
                                        <select name="materialCollectionType" class="u-full-width" required>
                                            <option value="" selected disabled>Select a collection type...</option>
                                            <option value="Book">Book</option>
                                            <option value="Magazine">Magazine</option>
                                            <option value="Newspaper">Newspaper</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialISBN', 'ISBN:') !!}
                                        {!! Form::text('materialISBN', null, array('class' => 'u-full-width', 'placeholder' => 'Enter ISBN Here', 'onkeyup' => 'isISBN(this)', 'required' => 'required')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialCallNumber', 'Call Number:') !!}
                                        {!! Form::text('materialCallNumber', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Call Number Here', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialLocation', 'Location:') !!}
                                        {!! Form::text('materialLocation', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Location Here', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialCopyrightYear', 'Copyright Year:') !!}
                                        {!! Form::text('materialCopyrightYear', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Copyright Year Here', 'maxlength' => '4', 'onkeyup' => 'isNumeric(this)', 'required' => 'required')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="four columns">
                                    <div class="input-block">
                                        {!! Form::label('materialCopies', 'Number of Copies:') !!}
                                        {!! Form::number('materialCopies', null, array('class' => 'u-full-width', 'placeholder' => 'Enter Number of Copies Here', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="eight columns">
                                    <div class="input-block">
                                        {!! Form::label('publisher', 'Publisher:') !!}
                                        <select name="publisher" class="u-full-width" required>
                                            <option value="" selected disabled>Select a publisher...</option>
                                            <option value="">[None]</option>
                                            @foreach($publishers as $publisher)
                                                <option value="{{ $publisher->Publisher_ID }}">{{ $publisher->Publisher_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="four columns">
                            <div class="text-right">
                                <label for="" class="u-pull-left">Author(s):</label>
                                <button class="btn btn-green btn-sm" data-button="add-author-button">Add Author</button>
                            </div>
                            <div id="authors-block" class="block" style="overflow-y: scroll; max-height: 300px;">
                                <div class="input-block">
                                    <div class="u-three-four-width">
                                        <select name="authors[]" class="u-full-width" required>
                                            <option value="" selected disabled>Select an author...</option>
                                            @foreach($authors as $author)
                                                @if(strlen($author->Author_Middle_Name) > 1)
                                                    <option value="{{ $author->Author_ID }}">{{ $author->Author_First_Name . ' ' . substr($author->Author_Middle_Name, 0, 1) . '. ' . $author->Author_Last_Name }}</option>
                                                @else
                                                    <option value="{{ $author->Author_ID }}">{{ $author->Author_First_Name . ' ' . $author->Author_Last_Name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-block text-right gap-top">
                        {!! Form::submit('Add Book', array('class' => 'btn btn-orange')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('post_ref')
    <script>
        var authorsList = '<?php echo base64_encode(json_encode($authors)); ?>';
    </script>
    <script src="/js/panel.materials.js"></script>
@stop