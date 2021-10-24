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
Divisi
@endsection
@section('content')
<!-- Main Content -->
<div class="section-body">

  <div class="card">
    <div class="card-header">
      <h4>Unit / Divisi</h4>
      <div class="card-header-action">
        @role('admin')
        <button class="btn btn-primary" id="addInbox">
          <i class="fas fa-plus"></i>
          <span>Tambah Unit</span>
        </button>
        @endrole
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-md">
          <tbody>
            <tr>
              <th>No</th>
              <th>Nama Unit</th>
              <th>Kode Unik Unit</th>
              @role('admin')
              <th style="text-align: center">Action</th>
              @endrole
            </tr>
            @foreach ($divisions as $key => $division)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$division->name}}</td>
              <td>{{$division->leader}}</td>
              <td>
                @role('admin')
                <form action="{{ route('division.destroy', $division->id) }}" method="POST">
                  <a href="#" class="btn btn-success" id="detailInbox{{$key}}">Detail</a>
                  <a href="#" class="btn btn-warning" id="editInbox{{$key}}"><i class="far fa-edit"></i></a>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                </form>
                @endrole
              </td>
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
        <h5 class="modal-title" id="modal-set-resiLabel">Tambah Divisi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('division.store')}}" method="POST" id="form-add-inbox-data" enctype="multipart/form-data">
        @csrf
        <div class="modal-body row">
          <div class="form-group col-md-6">
            <label for="">Nama bagian</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Pimpinan</label>
            <input type="text" class="form-control" name="leader" value="{{old('leader')}}">
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

@foreach ($divisions as $key => $division)
<div class="modal fade" id="modal_edit{{$key}}" tabindex="{{$key}}" role="dialog" aria-labelledby="modal_edit{{$key}}"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-set-resiLabel">Edit Surat Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('division.update', $division->id) }}" method="POST" id="form-add-inbox-data"
        enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        <div class="modal-body row">
          <div class="form-group col-md-6">
            <label for="">Nama bagian</label>
            <input type="text" class="form-control" name="name" value="{{$division->name}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Nomor Surat</label>
            <input type="text" class="form-control" name="leader" value="{{$division->leader}}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection
@section('script')
<script>
  $('#addInbox').on('click', () => {
          $('#modal_tambah').modal('show')
        });
</script>
@foreach ($divisions as $key => $division)
<script>
  $('#editInbox'+ {{$key}}).on('click', () => {
          $('#modal_edit'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@foreach ($divisions as $key => $division)
<script>
  $('#dispositionInbox'+ {{$key}}).on('click', () => {
          $('#modal_disposition'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@foreach ($divisions as $key => $division)
<script>
  $('#detailInbox'+ {{$key}}).on('click', () => {
          $('#modal_detail'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@endsection
