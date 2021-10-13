@extends('layouts.dashboard')
@section('title')

@if (Request::path() != '/')
@php
$paths = explode('/', Request::path());
$len = count($paths)-1;
echo ucfirst($paths[$len]);
@endphp
@else
Dashboard
@endif
@endsection
@section('header')
Laporan
@endsection
@section('content')
<!-- Main Content -->
<div class="section-body">
  <div class="card">
    <div class="card-header">
      <h4>Laporan</h4>
      <div class="card-header-action">
        <!-- <div class="d-flex"> -->
        <div class="row">
          <div class="form-group col-md-5">
            <label>Tgl Awal</label>
              <!-- <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div> -->
              <input id="tgl_mulai" placeholder="masukkan tanggal Awal" type="text" class="form-control datepicker" aria-describedby="basic-addon1" name="tgl_awal">
          </div>
          <div class="form-group col-md-5">
            <label>Tgl Akhir</label>
              <!-- <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon2">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div> -->
              <input aria-describedby="basic-addon2" id="tgl_akhir" placeholder="masukkan tanggal Akhir" type="text" class="form-control datepicker" name="tgl_akhir">
          </div>
          <div class="form-group col-md-2 mt-auto">
            <button class="btn btn-primary form-control" id="filter">
              <!-- <i class="fas fa-plus"></i> -->
              <span>Filter</span>
            </button>
          </div>
        </div>
        <!-- </div> -->
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-md">
          <tbody>
            <tr>
              <th>No</th>
              <th>Agenda</th>
              <th>No Surat</th>
              <th>Sumber Surat</th>
              <th>Tujuan Surat</th>
              <th>Perihal</th>
              <th>Tgl Terima</th>
              <th>Jenis Surat</th>
              <th>Status</th>
            </tr>
            @foreach ($mails as $key => $mail)
            <tr>
              @php
              if ($mail->status == 0) {
              $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="Pending" style="color:#ffa426;font-size:20px"></i>';
              }elseif ($mail->status == 1) {
              $status = '<i class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Ditolak" style="color:#fc544b;font-size:20px"></i>';
              }elseif ($mail->status == 2) {
              $status = '<i class="fas fa-check-circle" data-toggle="tooltip" data-placement="top" title="Diterima" style="color:#47c363;font-size:20px"></i>';
              }
              @endphp
              <td>{{$key+1}}</td>
              <td>{{$mail->journal_id}}</td>
              <td>{{$mail->number}}</td>
              <td>{{$mail->sender}}</td>
              <td>{{$mail->destination}}</td>
              <td>{{$mail->regarding}}</td>
              <td>{{$mail->entry_date}}</td>
              <td>{{$mail->type->name ?? ''}}</td>
              <td>{!!$status!!}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer text-right" modal-part>
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
          <li class="page-item">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script id="he">
  $(document).ready(function() {
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
    $("#tgl_mulai").on('changeDate', function(selected) {
      var startDate = new Date(selected.date.valueOf());
      $("#tgl_akhir").datepicker('setStartDate', startDate);
      if ($("#tgl_mulai").val() > $("#tgl_akhir").val()) {
        $("#tgl_akhir").val($("#tgl_mulai").val());
      }
    });
  });
</script>
@endsection
