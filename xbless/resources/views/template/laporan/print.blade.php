<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-print.css')}}" rel="stylesheet">
	<title>Print Laporan Rekap Posyandu</title>
    <style type="text/css" media="print">
  @page { size: landscape; }
</style>
</head>
<body onload="window.print();">
  <div class="wrapper">
    <section class="section_print">
      <div class="row">
        <div class="col-md-12">
            <h3 style="margin-top:3mm;text-align:center; vertical-align: middle"> <br>
            <h3 style="margin-top:3mm;text-align:center; vertical-align: middle"> <br>
                <b>LAPORAN POSYANDU</b></h3>
            <h6 style="margin-top:-4mm;text-align:center; vertical-align: middle"> <br>
                <b>DARI TANGGAL {{strtoupper(date('d M Y',strtotime($filter_tgl_start)))}} - {{strtoupper(date('d M Y',strtotime($filter_tgl_end)))}}</b> </h6>
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-md-12">
      <table class="table-print" style="margin-bottom: 5px!important">
      <thead>
        <tr class="two-strips-top">
          <th style="text-align : left; display: table-cell; vertical-align: middle;">No</th>
          <th style="text-align : left; display: table-cell; vertical-align: middle;">Kabupaten</th>
          <th style="text-align : left; display: table-cell; vertical-align: middle;">Puskesmas</th>
          <th style="text-align : left; display: table-cell; vertical-align: middle;">Kader</th>
          <th style="text-align : left; display: table-cell; vertical-align: middle;">Posyandu</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $key=>$value)

          <tr class="two-strips-bottom">
              <td>{!! $key+1 !!}</td>
              <td>{!! $value->kabupaten !!}</td>
              <td style="text-align : left; display: table-cell; vertical-align: middle;">{!! $value->puskesmas !!}</td>
              <td style="text-align : left; display: table-cell; vertical-align: middle;">{!! $value->kader !!}</td>
              <td style="text-align : left; display: table-cell; vertical-align: middle;">{!! $value->posyandu !!}</td>
          </tr>
        @endforeach
      </tbody>
      </table>
      </div>
      </div>
      <i>Printed date : <?php echo date("d M Y") ?> </i>
    </section>
  </div>
</body>
</html>
