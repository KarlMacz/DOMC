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
                    <li class="list-group-item active"><a href="{{ route('panel.getReserved') }}">Reserved Material(s)</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getReceive') }}">Receive Material(s)</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'materials') }}">Manage Materials</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'authors') }}">Manage Authors</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'publishers') }}">Manage Publishers</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'students') }}">Manage Students</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'faculties') }}">Manage Faculties</a></li>
                    <li class="list-group-item"><a href="{{ route('panel.getManage', 'settings') }}">System Settings</a></li>
                </ul>
            </div>
            <div class="nine columns">
                <div class="banner">Reserved Material(s)</div>
                <table id="reserved-table" class="u-full-width">
                    <thead>
                        <tr>
                            <th>Call Number</th>
                            <th>Title</th>
                            <th>Author(s)</th>
                            <th></th>
                        </tr>
                        <tbody>
                            @foreach($works_reservations as $reservation)
                                @foreach($works_materials as $material)
                                    @if($reservation->Material_ID == $material->Material_ID)
                                        <?php $isFirst = true; ?>
                                        <tr>
                                            <td>{{ $material->Material_Call_Number }}</td>
                                            <td>{{ $material->Material_Title }}</td>
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
                                                @if(strlen(session()->has('username')))
                                                    <a href="{{ route('panel.postLoan', $material->Material_ID) }}" class="btn btn-green btn-sm">Loan</a>
                                                @endif
                                            </td>
                                        </tr>

                                        @break
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('post_ref')
    <script src="/js/panel.reserved.js"></script>
@stop