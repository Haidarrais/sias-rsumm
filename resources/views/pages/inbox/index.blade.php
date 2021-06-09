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
@section('content')
<!-- Main Content -->
<div class="section-body">
  
  <div class="card">
    <div class="card-header">
      <h4>Data Surat Masuk</h4>
      <div class="card-header-action">
        <button class="btn btn-primary" id="addInbox">
          <i class="fas fa-plus"></i>
          <span>Tambah Surat</span>
        </button>
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
              <th>Pengirim</th>
              <th>Perihal</th>
              <th>Tgl Terima</th>
              <th>Sumber Surat</th>
              <th>Status</th>
              <th style="text-align: center">Action</th>
            </tr>
            @foreach ($inboxes as $key => $inbox)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$inbox->journal_id}}</td>
              <td>{{$inbox->inbox_number}}</td>
              <td>{{$inbox->sender}}</td>
              <td>{{$inbox->regarding}}</td>
              <td>{{$inbox->entry_date}}</td>
              <td>{{$inbox->inbox_origin}}</td>
              <td>{{$inbox->status}}</td>
              <td>
                <a href="#" class="btn btn-success">Detail</a>
                <a href="#" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                <a href="#" class="btn btn-warning"><i class="far fa-edit"></i></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-asu-part">aaaaaaaaaaaan</div>
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
  <script>
      $('#addInbox').fireModal({
          title: 'My Modal',
          body: 'Hello, dude!',
          submit: true,
          body:'#formAddInbox',
          buttons: [
            {
              text: 'Close',
              class: 'btn btn-secondary',
              handler: function(current_modal) {
              $.destroyModal(current_modal);
              }
            }
          ]
        });
    </script>
@endsection