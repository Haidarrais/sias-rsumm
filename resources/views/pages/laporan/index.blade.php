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
      <h4>Data Surat Masuk</h4>
      <div class="card-header-action">

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
