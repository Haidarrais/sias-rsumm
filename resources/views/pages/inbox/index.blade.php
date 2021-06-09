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
Surat Masuk
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
                @php
                    if ($inbox->status == 0) {
                        $status = '<div class="badge badge-secondary">Pending</div>';
                    }elseif ($inbox->status == 1) {
                        $status = '<div class="badge badge-warning">Dalam Review</div>';
                    }elseif ($inbox->status == 2) {
                        $status = '<div class="badge badge-success">Diterima/div>';
                    }elseif ($inbox->status == 3) {
                        $status = '<div class="badge badge-danger">Ditolak/div>';
                    }
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$inbox->journal_id}}</td>
                <td>{{$inbox->inbox_number}}</td>
                <td>{{$inbox->sender}}</td>
                <td>{{$inbox->regarding}}</td>
                <td>{{$inbox->entry_date}}</td>
                <td>{{$inbox->inbox_origin}}</td>
                <td>{!!$status!!}</td>
                <td>
                    <a href="#" class="btn btn-success">Detail</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('delete-inbox').submit();" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                    <form id="delete-inbox" action="{{ route('inbox.destroy', $inbox->id) }}" method="POST" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                    <a href="#" class="btn btn-warning"><i class="far fa-edit"></i></a></td>
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
@section('modal')
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-set-resiLabel">Tambah Surat Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('inbox.store')}}" method="POST" id="form-add-inbox-data">
                <input type="text" class="form-control" name="user_id" value="{{Auth::id()}}" hidden>
                <input type="text" class="form-control" name="inbox_origin" value="{{Auth::user()->name}}" hidden>
                @csrf
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="">Nomor Agenda</label>
                        <input type="text" class="form-control" name="journal_id">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Nomor Surat</label>
                        <input type="text" class="form-control" name="inbox_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Pengirim</label>
                        <input type="text" class="form-control" name="sender">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Perihal</label>
                        <input type="text" class="form-control" name="regarding">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Tanggal Surat Diterima</label>
                        <input type="date" class="form-control" name="entry_date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Example file input</label>
                        <input type="file" class="form-control-file" name="file">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Notes</label>
                        <textarea class="form-control" name="notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
  <script>
        $('#addInbox').on('click', () => {
            $('#modal_tambah').modal('show')
        });
    </script>
@endsection
