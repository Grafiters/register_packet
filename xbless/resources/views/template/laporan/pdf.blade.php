<!DOCTYPE html>
<html>
    <head>
        <title>CETAK LAPORAN REKAP</title>
        <style type="text/css">

        .text-center {
            text-align: center
        }
        .text-right {
            text-align: right
        }

        </style>

    </head>
    <body>
<htmlpageheader name="MyHeader1">
<br/>
<h3 style="margin-top: 10px;text-align: center;"> LAPORAN REKAP</h3>
<h6 style="margin-bottom: 0;text-align: center;"> DARI TANGGAL {{strtoupper(date('d M Y',strtotime($filter_tgl_start)))}} - {{strtoupper(date('d M Y',strtotime($filter_tgl_end)))}}</h6>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" cellspacing="0" cellpadding="3">

    <thead>
        <tr>
            <th width="6%" style="border: 0.5px solid #000;">No</th>
            <th style="text-align: left;border: 0.5px solid #000;">Kabupaten</th>
            <th style="text-align: left;border: 0.5px solid #000;">Puskesmas</th>
            <th style="text-align: left;border: 0.5px solid #000;">Kader</th>
            <th style="text-align: left;border: 0.5px solid #000;">Posyandu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $no => $value)
        <tr>
            <td width="6%" style="border: 0.5px solid #000;text-align: center;" valign="top" >{{$no + 1}}</td>
            <td valign="top" style='border: 0.5px solid #000;text-align:left;'>{{$value->kabupaten}}</td>
            <td valign="top" style='border: 0.5px solid #000;text-align:left;'>{{$value->puskesmas}}</td>
            <td valign="top" style='border: 0.5px solid #000;text-align:left;'>{{$value->kader}}</td>
            <td valign="top" style='border: 0.5px solid #000;text-align:left;'>{{$value->posyandu}}</td>
        </tr>
        @endforeach
        @for($i=1;$i<2;$i++)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

        </tr>
        @endfor
    </tbody>
</table>
<i>Printed date : <?php echo date("d M Y") ?> </i>
</div>
</body>
</html>
