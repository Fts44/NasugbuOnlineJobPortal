<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $filename }}</title>
</head>
<body>
<style>
        * {
            font-size: 16px;
            font-family: 'Times', Verdana, Tahoma, "DejaVu Sans", sans-serif;
        }
        .c{
            text-align:center;
        }
        .r{
            text-align:right;
        }
        table, td, th {
            border: 1px solid black;
        }
        table tr th {
            text-align:center;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
        .nb {
            border: none;
        }
        .ns {
            border-left: none;
            border-right: none;
        }
        .nbt{
            border-top: none;
        }
        .nbl{
            border-left: none;
        }
        .nbr{
            border-right: none;
        }
        .nbb{
            border-bottom: none;
        }
        .ws{
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .wt{
            border-top: 1px solid black;
        }
        .wb{
            border-bottom: 1px solid black;
        }
        .tu{
            text-transform: uppercase;
        }
        td {
            height: 18px;
        }
        .u {
            text-decoration: underline;
        }
        .chck { 
            font-family: DejaVu Sans, sans-serif;
        }
        input[type=checkbox]:before { font-family: DejaVu Sans; font-size: 20px; }
        input[type=checkbox] { display: inline; }
    </style>

    <table class="nb" cellpadding="2">
        <thead class="nb">
            <tr class="nb">
                @for($i=1; $i<=50; $i++)
                    <th class="nb" style="width: 2%"></th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="15" class="r nb">
                    <img src="{{ 'storage/profile_picture/'.$d->biz_logo }}" alt="" style="width: 50px;">   
                </td>
                <td colspan="20" class="c nb">
                    {{ $d->biz_name }} <br> 
                    {{ $d->biz_brgy.', '.$d->biz_mun.', '.$d->biz_prov }}<br>
                    {{ 'Contacts: '.$d->biz_phone.'/ '.$d->biz_tel }} <br>
                </td>
                <td colspan="15" class="l nb">
                    <img src="{{ 'image/logo.png' }}" alt="" style="width: 50px;">
                </td>
            </tr>
            <tr>
                <td colspan="50" class="nb">
                    <div style="height: 80px;">

                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="50" class="l nb">
                    Dear {{ (($d->aa_sex) ? 'Mr. ' : 'Ms. ').$d->aa_firstname.' '.(($d->aa_middlename) ? $d->aa_middlename[0].'. ' : ' ').$d->aa_lastname.', ' }}
                </td>
            </tr>
            <tr>
                <td colspan="50" class="nb">
                    <div style="height: 20px;">

                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="50" class="l nb">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                     This is to inform you that you are now scheduled for an interview on {{ date_format(date_create($d->ja_datetime),'F d, Y h:i a') }} at {{ $d->biz_brgy.', '.$d->biz_mun.', '.$d->biz_prov.' '.$d->biz_landmark }}. We are expecting you to be there. Thank you.
                </td>
            </tr>
            <tr>
                <td colspan="50" class="nb">
                    <div style="height: 40px;">

                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="50" class="l nb">
                    Sincerely, <br>
                    {{ (($d->ae_sex) ? 'Mr. ' : 'Ms. ').$d->ae_firstname.' '.(($d->ae_middlename) ? $d->ae_middlename[0].'. ' : ' ').$d->ae_lastname.', ' }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>