<table style="margin-top:20px;">
    <tr>
        <td colspan='6' style="text-align: center;" ><b><h3> LAPORAN REKAP KADER POSYANDU</h3> </b></td>
    </tr>
    <tr>
        <td colspan='6' style="text-align: center"><b><h3>{{ strtoupper($filter_kabupaten) }}</h3></b></td>
    </tr>
    @if($filter_puskesmas != "all")
    <tr>
        <td colspan='6' style="text-align: center"><b><h3>{{ strtoupper($filter_puskesmas) }}</h3></b></td>
    </tr>
    @endif
    <tr>
        <td colspan='6' style="text-align: center;" ><b><h6>DARI TANGGAL {{strtoupper(date('d M Y',strtotime($filter_tgl_start)))}} - {{strtoupper(date('d M Y',strtotime($filter_tgl_end)))}}</h6></b>
    </td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th style="border: 1px solid #000;">No</th>
            <th style="text-align: left; border: 1px solid #000;">Kabupaten</th>
            <th style="text-align: left;border: 1px solid #000;">Puskesmas</th>
            <th style="text-align: left;border: 1px solid #000;">Kader</th>
            <th style="text-align: left;border: 1px solid #000;">Posyandu</th>
            <th style="text-align: left;border: 1px solid #000;">Link Sertifikat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $no => $value)

        <tr>
            <td style="border: 1px solid #000;text-align: center;" valign="top" >{{$no + 1}}</td>
            <td style="border: 1px solid #000;text-align: left;">{!! $value->kabupaten !!}</td>
            <td style='border: 1px solid #000;text-align:left;'>{{$value->puskesmas}}</td>
            <td style='border: 1px solid #000;text-align:left;'>{{$value->kader}}</td>
            <td style='border: 1px solid #000;text-align:left;'>{{$value->posyandu}}</td>
            <td style='border: 1px solid #000;text-align:left;'>{{$value->link}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<table>
    <tr>
        <td colspan='10' style="text-align: left;" ><i>Printed date : <?php echo date("d M Y") ?> </i></td>
    </tr>
</table>
