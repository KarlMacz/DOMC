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
                <table id="loan-table" class="u-full-width">
                    <thead>
                        <tr>
                            <th>Call Number</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Author(s)</th>
                            <th>Available Copies</th>
                            <th></th>
                        </tr>
                        <tbody>
                            @foreach($works_materials as $material)
                                <?php $isFirst = true; ?>
                                <tr>
                                    <td>{{ $material->Material_Call_Number }}</td>
                                    <td>{{ $material->Material_Title }}</td>
                                    <td>{{ $material->Material_ISBN }}</td>
                                    <td>
                                        @foreach($works_authors as $author)
                                            @if($author->Material_ID == $material->Material_ID)
                                                @if($isFirst)
                                                    <?php $isFirst = false; ?>
                                                @else
                                                    <br>
                                                @endif

                                                @if(strlen($author->Author_Middle_Name) > 1)
                                                    {{ $author->Author_First_Name . ' ' . substr($author->Author_Middle_Name, 0, 1) . '. ' . $author->Author_Last_Name }}
                                                @else
                                                    {{ $author->Author_First_Name . ' ' . $author->Author_Last_Name }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <?php $reserved_count = 0; $loaned_count = 0; ?>
                                        @foreach($reserved_materials as $reserved_material)
                                            @if($reserved_material->Material_ID == $material->Material_ID)
                                                <?php $reserved_count++; ?>
                                            @endif
                                        @endforeach
                                        @foreach($loaned_materials as $loaned_material)
                                            @if($loaned_material->Material_ID == $material->Material_ID)
                                                <?php $loaned_count++; ?>
                                            @endif
                                        @endforeach
                                        <?php $newMaterialCount = $material->Material_Copies - $reserved_count - $loaned_count; ?>
                                        {{ ($newMaterialCount > 0 ? $newMaterialCount : 0) }}
                                    </td>
                                    <td class="text-center">
                                        @if(strlen(session()->has('username')))
                                            @if($newMaterialCount > 0)
                                                <a data-button="loan-button" data-var-id="{{ $material->Material_ID }}" data-var-title="{{ $material->Material_Title }}" class="btn btn-orange btn-sm">Loan</a>
                                            @endif
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
    <div class="modal">
        <div class="modal-container">
            <div class="modal-header">Loan Book(s)</div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'panel.postLoan', 'class' => 'no-margin')) !!}
                    {!! Form::hidden('arg0', 'f6614d9e3adf79e5eecc16a5405e8461') !!}
                    {!! Form::hidden('arg1', '') !!}
                    <div class="input-block">
                        {!! Form::label('', 'Book to Borrow:') !!}
                        <div id="input-material-title" class="content"></div>
                    </div>
                    <div class="input-block">
                        {!! Form::label('authorFirstName', 'Borrower\'s Name:') !!}
                        <select name="arg2" class="u-full-width" required>
                            <option value="" selected disabled>Select a borrower...</option>
                            @foreach($accounts as $account)
                                @if($account->Account_Type == 'Faculty')
                                    <?php $facultyAccount = $faculty_accounts::where('Faculty_ID', $account->Account_Owner)->first(); ?>
                                    @if(strlen($facultyAccount->Faculty_Middle_Name) > 1)
                                        <option value="{{ $account->Account_Username }}">{{ $facultyAccount->Faculty_First_Name . ' ' . substr($facultyAccount->Faculty_Middle_Name, 0, 1) . '. ' . $facultyAccount->Faculty_Last_Name }}</option>
                                    @else
                                        <option value="{{ $account->Account_Username }}">{{ $facultyAccount->Faculty_First_Name . ' ' . $facultyAccount->Faculty_Last_Name }}</option>
                                    @endif
                                @elseif($account->Account_Type == 'Librarian')
                                    <?php $librarianAccount = $librarian_accounts::where('Librarian_ID', $account->Account_Owner)->first(); ?>
                                    @if(strlen($librarianAccount->Librarian_Middle_Name) > 1)
                                        <option value="{{ $account->Account_Username }}">{{ $librarianAccount->Librarian_First_Name . ' ' . substr($librarianAccount->Librarian_Middle_Name, 0, 1) . '. ' . $librarianAccount->Librarian_Last_Name }}</option>
                                    @else
                                        <option value="{{ $account->Account_Username }}">{{ $librarianAccount->Librarian_First_Name . ' ' . $librarianAccount->Librarian_Last_Name }}</option>
                                    @endif
                                @elseif($account->Account_Type == 'Student')
                                    <?php $studentAccount = $student_accounts::where('Student_ID', $account->Account_Owner)->first(); ?>
                                    @if(strlen($studentAccount->Student_Middle_Name) > 1)
                                        <option value="{{ $account->Account_Username }}">{{ $studentAccount->Student_First_Name . ' ' . substr($studentAccount->Student_Middle_Name, 0, 1) . '. ' . $studentAccount->Student_Last_Name }}</option>
                                    @else
                                        <option value="{{ $account->Account_Username }}">{{ $studentAccount->Student_First_Name . ' ' . $studentAccount->Student_Last_Name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Loan', array('class' => 'btn btn-orange btn-sm')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('post_ref')
    <script src="/js/panel.loan.js"></script>
@stop