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
Jenis Surat
@endsection
@section('content')
<div class="card">
    <div class="card-header">
      <h4>Data Surat Masuk</h4>
      <div class="card-header-action">
        <button class="btn btn-primary" id="addType">
          <i class="fas fa-plus"></i>
          <span>Tambah Jenis Surat</span>
        </button>
      </div>
    </div>
    <div class="card-body p-2">
        <div class="table-responsive">
          <table class="table table-striped table-md">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Surat</th>
                <th style="text-align: center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($types as $key => $type)
              <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$type->name}}</td>
                    <td>
                        <form action="{{ route('type.destroy', $type->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('modal')
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-set-resiLabel">Tambah Jenis Surat Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('type.store')}}" method="POST" id="form-add-type-data" enctype="multipart/form-data">
          @csrf
          <div class="modal-body row">
            <div class="form-group col-md-12">
              <label for="">Nama Jenis Surat</label>
              <input type="text" class="form-control" name="name">
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
  $('#addType').on('click', () => {
          $('#modal_tambah').modal('show')
        });
</script>
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
</script>
@endsection
