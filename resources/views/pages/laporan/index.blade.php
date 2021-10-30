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
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="true">Surat Masuk</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="outbox-tab" data-toggle="tab" href="#outbox" role="tab" aria-controls="outbox" aria-selected="false">Surat Keluar</a>
        </li>
      </ul>
    <div class="card-header">
      <h4>Laporan</h4>
      <div class="card-header-action">
        <!-- <div class="d-flex"> -->
        <div class="row">
          <div class="form-group col-md-5">
            <label class="ml-2">Tanggal Awal</label>
              <!-- <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div> -->
              <input id="tgl_mulai" placeholder="masukkan tanggal Awal" type="text" class="form-control datepicker" aria-describedby="basic-addon1" name="tgl_awal">
          </div>
          <div class="form-group col-md-5">
            <label class="ml-2">Tanggal Akhir</label>
              <!-- <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon2">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div> -->
              <input aria-describedby="basic-addon2" id="tgl_akhir" placeholder="masukkan tanggal Akhir" type="text" class="form-control datepicker" name="tgl_akhir">
          </div>
          <div class="form-group col-md-2 mt-auto">
            <button class="btn btn-primary" id="filter">
              <!-- <i class="fas fa-plus"></i> -->
              <span>Filter</span>
            </button>
          </div>
        </div>
        <!-- </div> -->
      </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="card-body p-1 tab-pane fade show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <thead>
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
                    </thead>
                    <tbody>
                    @foreach ($inboxes as $key => $inbox)
                    <tr>
                    @php
                    if ($inbox->status == 0) {
                    $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="Pending" style="color:#ffa426;font-size:20px"></i>';
                    }elseif ($inbox->status == 1) {
                    $status = '<i class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Ditolak" style="color:#fc544b;font-size:20px"></i>';
                    }elseif ($inbox->status == 2) {
                    $status = '<i class="fas fa-check-circle" data-toggle="tooltip" data-placement="top" title="Diterima" style="color:#47c363;font-size:20px"></i>';
                    }
                    @endphp
                    <td>{{$key+1}}</td>
                    <td>{{$inbox->journal_id}}</td>
                    <td>{{$inbox->number}}</td>
                    <td>{{$inbox->sender}}</td>
                    <td>{{$inbox->destination}}</td>
                    <td>{{$inbox->regarding}}</td>
                    <td>{{$inbox->entry_date}}</td>
                    <td>{{$inbox->type->name ?? ''}}</td>
                    <td>{!!$status!!}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <div class="card-body p-1 tab-pane fade" id="outbox" role="tabpanel" aria-labelledby="outbox-tab">
            <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
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
                </thead>
                <tbody>
                @foreach ($outboxes as $key => $outbox)
                <tr>
                    @php
                    if ($outbox->status == 0) {
                    $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="Pending" style="color:#ffa426;font-size:20px"></i>';
                    }elseif ($outbox->status == 1) {
                    $status = '<i class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Ditolak" style="color:#fc544b;font-size:20px"></i>';
                    }elseif ($outbox->status == 2) {
                    $status = '<i class="fas fa-check-circle" data-toggle="tooltip" data-placement="top" title="Diterima" style="color:#47c363;font-size:20px"></i>';
                    }
                    @endphp
                    <td>{{$key+1}}</td>
                    <td>{{$outbox->journal_id}}</td>
                    <td>{{$outbox->number}}</td>
                    <td>{{$outbox->sender}}</td>
                    <td>{{$outbox->destination}}</td>
                    <td>{{$outbox->regarding}}</td>
                    <td>{{$outbox->entry_date}}</td>
                    <td>{{$outbox->type->name ?? ''}}</td>
                    <td>{!!$status!!}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
</script>
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
