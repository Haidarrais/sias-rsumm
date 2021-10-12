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
Surat Keluar
@endsection
@section('content')
<!-- Main Content -->
<div class="section-body">

  <div class="card">
    <div class="card-header">
      <h4>Data Surat Keluar</h4>
      <div class="card-header-action">
        @role('admin')
        <button class="btn btn-primary" id="addInbox">
          <i class="fas fa-plus"></i>
          <span>Tambah Surat</span>
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
            @foreach ($outboxes as $key => $outbox)
            <tr>
              @php
              if ($outbox->status == 0) {
              $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="Pending" style="color:#ffa426;font-size:20px"></i>';
              }elseif ($outbox->status == 1) {
              $status = '<i class="fas fa-check-circle" data-toggle="tooltip" data-placement="top" title="Diterima" style="color:#47c363;font-size:20px"></i>';
              }elseif ($outbox->status == 2) {
              $status = '<i class="fas fa-times-circle" data-toggle="tooltip" data-placement="top" title="Ditolak" style="color:#fc544b;font-size:20px"></i>';
              }
              @endphp
              <td>{{$key+1}}</td>
              <td>{{$outbox->journal_id}}</td>
              <td>{{$outbox->number}}</td>
              <td>{{$outbox->sender}}</td>
              <td>{{$outbox->destination}}</td>
              <td>{{$outbox->regarding}}</td>
              <td>{{$outbox->entry_date}}</td>
              <td>{{$outbox->type->name}}</td>
              <td>{!!$status!!}</td>
              <td>
                <a href="#" class="btn btn-success" id="detailInbox{{$key}}">Detail</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-inbox').submit();" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                <form id="delete-inbox" action="{{ route('inbox.destroy', $outbox->id) }}" method="POST" style="display: none;">
                  @method('DELETE')
                  @csrf
                </form>
                {{-- modal_edit{{$key}} --}}
                <a href="#" class="btn btn-warning" id="editInbox{{$key}}"><i class="far fa-edit"></i></a>
                {{-- <button onclick="alert('modal_edit{{$key}}'); document.getElementById('modal_edit{{$key}}').classList.toggle('show')"><i class="far fa-edit"></i></button> --}}
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
        <h5 class="modal-title" id="modal-set-resiLabel">Tambah Surat Keluar</h5>
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

@foreach ($outboxes as $key => $outbox)
<div class="modal fade" id="modal_edit{{$key}}" tabindex="{{$key}}" role="dialog" aria-labelledby="modal_edit{{$key}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-set-resiLabel">Edit Surat Keluar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('inbox.update', $outbox->id) }}" method="POST" id="form-add-inbox-data" enctype="multipart/form-data">
        <input type="text" class="form-control" name="user_id" value="{{Auth::id()}}" hidden>
        <input type="text" class="form-control" name="inbox_origin" value="{{Auth::user()->name}}" hidden>
        @csrf
        @method("PATCH")
        <div class="modal-body row">
          <div class="form-group col-md-6">
            <label for="">Nomor Agenda</label>
            <input type="text" class="form-control" name="journal_id" value="{{$outbox->journal_id}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Nomor Surat</label>
            <input type="text" class="form-control" name="inbox_number" value="{{$outbox->number}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Pengirim</label>
            <input type="text" class="form-control" name="sender" value="{{$outbox->sender}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Tujuan Surat</label>
            <input type="text" class="form-control" name="destination" value="{{$outbox->destination}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Perihal</label>
            <input type="text" class="form-control" name="regarding" value="{{$outbox->regarding}}">
          </div>
          <div class="form-group col-md-6">
            <label for="">Tanggal Surat Diterima</label>
            <input type="date" class="form-control" name="entry_date" value="{{$outbox->entry_date}}">
          </div>
          <div class="form-group col-md-6">
            @php
            $splitName = explode('.', $outbox->file );
            $exe = $splitName[count($splitName)-1];
            @endphp
            <label for="">Example file input</label>
            <input type="file" class="form-control-file" name="uploadfile" value="{{ url('upload/surat-masuk/', $outbox->file) }}">
            <span>{{substr($outbox->file, 0, 4). '~.' . $exe  }}</span>
          </div>
          <div class="form-group col-md-6">
            <label for="">Jenis Surat</label>
            <select name="type" id="type_add" class="form-control">
              @foreach ($types as $key => $type )
              <option value="{{$type->id}}" @if($type->id == $outbox->type_id) selected @endif>{{$type->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="">Notes</label>
            <textarea class="form-control" name="notes">{{$outbox->notes}}</textarea>
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

@foreach ($outboxes as $key => $outbox)
<div class="modal fade" id="modal_detail{{$key}}" tabindex="{{$key}}" role="dialog" aria-labelledby="modal_detail{{$key}}" aria-hidden="true">
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
          <script>
            if (PDFObject.supportsPDFs) {
              PDFObject.embed("{{asset('upload/surat-masuk/' . $outbox->file)}}", "#pdfview", {
                height: "400px",
                pdfOpenParams: {
                  view: 'FitV',
                  page: '2'
                }
              });
              console.log("Yay, this browser supports inline PDFs.");
            } else {
              console.log("Boo, inline PDFs are not supported by this browser");
            }
          </script>
        </div>
      </div>
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
@foreach ($outboxes as $key => $outbox)
<script>
  $('#editInbox' + {
    {
      $key
    }
  }).on('click', () => {
    $('#modal_edit' + {
      {
        $key
      }
    }).modal('show')
  });
</script>
@endforeach
@foreach ($outboxes as $key => $outbox)
<script>
  $('#detailInbox' + {
    {
      $key
    }
  }).on('click', () => {
    $('#modal_detail' + {
      {
        $key
      }
    }).modal('show')
  });
</script>
@endforeach
@endsection