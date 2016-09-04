<!DOCTYPE html>
<html lang="en">
<head>
    <title>De Ocampo Memorial College</title>
    <style>
        * {
            font-family: 'Helvetica', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: thin;
        }

        .pagenum:before {
            content: counter(page);
        }

        .table {
            border: 1px solid #2c8700;
            border-spacing: none;
        }

        .table thead > tr {
            background: #2c8700;
            color: white;
            font-size: 0.85em;
        }

        .table tbody > tr:nth-child(even) {
            background: white;
        }

        .table tbody > tr:nth-child(odd) {
            background: #eee;
        }

        .table th, .table td {
            padding: 5px 10px;
            box-sizing: border-box;
        }

        .table td {
            font-size: 0.75em;
        }

        .header {
            margin-bottom: 50px;
            text-align: center;
        }

        .footer {
            border-top: 1px solid #222;
            color: #777;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .no-margin {
            margin: 0;
        }

        .full-width {
            width: 100%;
        }

        .gap-top {
            margin-top: 5px;
        }

        .gap-bottom {
            margin-bottom: 5px;
        }

        .gap-left {
            margin-left: 5px;
        }

        .gap-right {
            margin-right: 5px;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .logo {
            height: 65px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" src="img/logo.png">
        <h1 class="no-margin">De Ocampo Memorial College</h1>
        <h3 class="no-margin">Library User List Report</h3>
    </div>
    <div class="footer">
        <script type="text/php">
            if(isset($pdf)) {
                $font = Font_Metrics::get_font('helvetica', '');
                $pageText = 'Page {PAGE_NUM} of {PAGE_COUNT}';
                $x = $pdf->get_width() - Font_Metrics::get_text_width($pageText, $font, 7) + 52;
                $y = $pdf->get_height() - 32;
                $pdf->page_text($x, $y, $pageText, $font, 7, array(.467, .467, .467));
                $pdf->page_text(37, $y, 'This is a system generated report.', $font, 7, array(.467, .467, .467));
            }
        </script>
    </div>
    <div class="body">
        <h6 class="no-margin text-right gap-bottom">Date Range: {{ date('F d, Y', strtotime($from)) }} - {{ date('F d, Y', strtotime($to)) }}</h6>
        <table class="table full-width gap-bottom">
            <thead>
                <tr>
                    <th width="25%">User ID</th>
                    <th width="35%">Name</th>
                    <th width="25%">Birth Date</th>
                    <th width="15%">Type</th>
                </tr>
            </thead>
            <tbody>
                @if($users)
                    @foreach($users as $user)
                        @if($user->Account_Type == 'Student')
                            <?php
                                $birthDate = date('F d, Y', strtotime($user->Student_Birth_Date));
                            ?>
                            @if(strlen($user->Student_Middle_Name) > 1)
                                <?php
                                    $name = $user->Student_First_Name . ' ' . substr($user->Student_Middle_Name, 0, 1) . '. ' . $user->Student_Last_Name;
                                ?>
                            @else
                                <?php
                                    $name = $user->Student_First_Name . ' ' . $user->Student_Last_Name;
                                ?>
                            @endif
                        @else
                            <?php
                                $birthDate = date('F d, Y', strtotime($user->Faculty_Birth_Date));
                            ?>
                            @if(strlen($user->Faculty_Middle_Name) > 1)
                                <?php
                                    $name = $user->Faculty_First_Name . ' ' . substr($user->Faculty_Middle_Name, 0, 1) . '. ' . $user->Faculty_Last_Name;
                                ?>
                            @else
                                <?php
                                    $name = $user->Faculty_First_Name . ' ' . $user->Faculty_Last_Name;
                                ?>
                            @endif
                        @endif
                        <tr>
                            <td class="text-center">{{ $user->Account_Username }}</td>
                            <td class="text-center">{{ $name }}</td>
                            <td class="text-center">{{ $birthDate }}</td>
                            <td class="text-center">{{ $user->Account_Type }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No data available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        <div class="text-right">Total number of users registered: {{ count($users) }}</div>
    </div>
</body>
</html>