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
        @role('admin')
        <button class="btn btn-primary" id="addInbox">
          <i class="fas fa-plus"></i>
          <span>Tambah Surat</span>
        </button>
        @endrole
      </div>
    </div>
    <div class="card-body p-2">
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
                    <th style="text-align: center">Action</th>
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
              <td>
                @role('pimpinan')
                @if ($inbox->status != 2)
                  <a href="#" class="btn btn-success" id="detailInbox{{$key}}">Detail</a>
                  <a href="#" class="btn btn-success" id="dispositionInbox{{$key}}">Disposisi</a>
                @endif
                @endrole
                @role('admin')
                <form action="{{ route('inbox.destroy', $inbox->id) }}" method="POST">
                  <a href="#" class="btn btn-success" onclick="setIndex({{$inbox->id}})">Detail</a>
                  <a href="#" class="btn btn-warning" id="editInbox{{$key}}"><i class="far fa-edit"></i></a>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                </form>
                @endrole
                {{-- modal_edit{{$key}} --}}
                {{-- <button onclick="alert('modal_edit{{$key}}'); document.getElementById('modal_edit{{$key}}').classList.toggle('show')"><i class="far fa-edit"></i></button> --}}
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
        <h5 class="modal-title" id="modal-set-resiLabel">Tambah Surat Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('inbox.store')}}" method="POST" id="form-add-inbox-data" enctype="multipart/form-data">
        <input type="text" class="form-control" name="user_id" value="{{Auth::id()}}" hidden>
        <input type="text" class="form-control" name="inbox_origin" value="{{Auth::user()->name}}" hidden>
        @csrf
        <div class="modal-body row">
          <div class="form-group col-md-6">
            <label for="">Nomor Agenda</label>
            <input type="text" class="form-control" name="journal_id" autofocus>
          </div>
          <div class="form-group col-md-6">
            <label for="">Nomor Surat</label>
            <input type="text" class="form-control" name="inbox_number">
          </div>
          <div class="form-group col-md-6">
            <label for="">Sumber Surat</label>
            <input type="text" class="form-control" name="sender">
          </div>
          <div class="form-group col-md-6">
            <label for="">Tujuan Surat</label>
            <input type="text" class="form-control" name="destination">
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
            <label for="">File Surat</label>
            <input type="file" class="form-control-file" name="uploadfile">
          </div>
          <div class="form-group col-md-6">
            <label for="">Jenis Surat</label>
            <select name="type" id="type_add" class="form-control">
              <option value="" selected disabled>Pilih Jenis Surat</option>
              @foreach ($types as $key => $type )
              <option value="{{$type->id}}">{{$type->name}}</option>
              @endforeach
            </select>
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

@foreach ($inboxes as $key => $inbox)
<div class="modal fade" id="modal_disposition{{$key}}" tabindex="{{$key}}" role="dialog" aria-labelledby="modal_disposition{{$key}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-set-resiLabel">Disposisi Surat Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('disposition.store')}}" method="POST" id="form-add-inbox-data" enctype="multipart/form-data">
        <input type="text" class="form-control" name="surat_id" value="{{$inbox->id}}" hidden>
        @csrf
        <div class="modal-body row">
            <!-- <input type="text" class="form-control" name="tujuan"> -->
            <div class="form-group col-md-12">
              <label for="">Disposisikan ke</label>
              <!-- <label for="">Jenis Surat</label> -->
              <select name="tujuan" id="" class="form-control">
                <option value="" selected disabled>Pilih Divisi / Bagian</option>
                @foreach ($divisions as $key => $division )
                <option value="{{$division->id}}">{{$division->name}}</option>
                @endforeach
                </select>
            </div>
          <div class="form-group col-md-12">
            <label for="">Catatan</label>
            <textarea class="form-control" name="catatan"></textarea>
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
@endforeach

@foreach ($inboxes as $key => $inbox)
<div class="modal fade" id="modal_edit{{$key}}" tabindex="{{$key}}" role="dialog" aria-labelledby="modal_edit{{$key}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-set-resiLabel">Edit Surat Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('inbox.update', $inbox->id) }}" method="POST" id="form-add-inbox-data" enctype="multipart/form-data">
        <input type="text" class="form-control" name="user_id" value="{{Auth::id()}}" hidden>
        <input type="text" class="form-control" name="inbox_origin" value="{{Auth::user()->name}}" hidden>
        @csrf
        @method("PATCH")
        <div class="modal-body row">
          <div class="form-group col-md-6">
            <label for="">Nomor Agenda</label>
            <input type="text" class="form-control" name="journal_id" value="{{$inbox->journal_id}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Nomor Surat</label>
            <input type="text" class="form-control" name="inbox_number" value="{{$inbox->number}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Pengirim</label>
            <input type="text" class="form-control" name="sender" value="{{$inbox->sender}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Tujuan Surat</label>
            <input type="text" class="form-control" name="destination" value="{{$inbox->destination}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Perihal</label>
            <input type="text" class="form-control" name="regarding" value="{{$inbox->regarding}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Tanggal Surat Diterima</label>
            <input type="date" class="form-control" name="entry_date" value="{{$inbox->entry_date}}">
          </div>
          <div class="form-group col-md-6">
            @php
            $splitName = explode('.', $inbox->file );
            $exe = $splitName[count($splitName)-1];
            @endphp
            <label for="">Example file input</label>
            <input type="file" class="form-control-file" name="uploadfile" value="{{ url('upload/surat-masuk/', $inbox->file) }}">
            <span>{{substr($inbox->file, 0, 4). '~.' . $exe  }}</span>
          </div>
          <div class="form-group col-md-6">
            <label for="">Jenis Surat</label>
            <select name="type" id="type_add" class="form-control">
              @foreach ($types as $key => $type )
              <option value="{{$type->id}}" @if($type->id == $inbox->type_id) selected @endif>{{$type->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="">Notes</label>
            <textarea class="form-control" name="notes">{{$inbox->notes}}</textarea>
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
@endforeach

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="height: 80%;">
    <div class="modal-content" style="height: 80%;">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-set-resiLabel">Detail Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: calc(100% - 120px);">
        <div class="container-fluid" style="height:100%;">
          <div id="pdfview" class="col-md-12" style="height:100%;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
</script>
<script>
    $('#addInbox').on('click', () => {
        $('#modal_tambah').modal('show')
    });
    function setIndex(id) {
        //index = id;
        //console.log(index);
        var url = "{{route('inbox.show', ":id ")}}";
        url = url.replace(":id", id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#modal_detail').modal('show')
                if (PDFObject.supportsPDFs) {
                PDFObject.embed(`{{asset('/upload/surat-masuk/')}}`+'/'+data.data.file, "#pdfview", {
                    height: "100%",
                    pdfOpenParams: {
                    view: 'FitV',
                    page: '2'
                    }
                });
                console.log("Yay, this browser supports inline PDFs.");
                } else {
                console.log("Boo, inline PDFs are not supported by this browser");
                }
            },
        });
    }
</script>
@foreach ($inboxes as $key => $inbox)
<script>
  $('#editInbox'+ {{$key}}).on('click', () => {
          $('#modal_edit'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@foreach ($inboxes as $key => $inbox)
<script>
  $('#dispositionInbox'+ {{$key}}).on('click', () => {
          $('#modal_disposition'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@foreach ($inboxes as $key => $inbox)
<script>
  $('#detailInbox'+ {{$key}}).on('click', () => {
          $('#modal_detail'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@endsection
