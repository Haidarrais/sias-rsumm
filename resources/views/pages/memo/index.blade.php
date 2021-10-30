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
Memo
@endsection
@section('content')
<!-- Main Content -->
<div class="section-body">

  <div class="card">
    <div class="card-header">
      <h4>Memo</h4>

    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-md">
          <tbody>
            <tr>
              <th>No</th>
              <th>Tanggal Terima / No Agenda</th>
              <th>Sumber</th>
              <th>Perihal</th>
              <th>Tanggal Disposisi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
            @forelse ($dispositions as $key => $disposition)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$disposition->mail->entry_date??''}} / {{$disposition->mail->number??''}}</td>
                <td>{{$disposition->mail->sender??""}}</td>
                <td>{{$disposition->mail->regarding??''}}</td>
                <td>{{$disposition->created_at->format('d M Y')}}</td>
                <td>
                    @if ($disposition->status == 0)
                        <span class="badge badge-secondary">Belum Terkonfirmasi</span>
                    @else
                        <span class="badge badge-success">Terkonfirmasi</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-success p-1" onclick="detDisp({{$disposition->id}})">Detail Disposisi</button>
                    <a class="btn btn-info p-1" href="{{ route('update.status.disposisi', ['id'=>$disposition->id]) }}">Ubah Status</a>
                </td>
                    {{-- modal_edit{{$key}} --}}
                    {{-- <button onclick="alert('modal_edit{{$key}}'); document.getElementById('modal_edit{{$key}}').classList.toggle('show')"><i class="far fa-edit"></i></button> --}}
            </tr>

            @empty

            @endforelse
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
<div class="modal fade" id="modal_detail" tabindex="" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="height: 100%;">
      <div class="modal-content" style="height: 100%;">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Detail Surat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="height: calc(100% - 120px);">
          <div class="container-fluid" style="height:100%;">
            <div class="p-2">
                <h4>Pesan Memo</h4>
                <p id="pesan_memo"></p>
            </div>
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
    function detDisp(id) {
        //index = id;
        //console.log(index);
        var url = "{{route('disposition.show', ":id ")}}";
        url = url.replace(":id", id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#modal_detail').modal('show')
                $('#pesan_memo').html(data.data.catatan)
                if(data.data.file){
                if (PDFObject.supportsPDFs) {
                    PDFObject.embed(`{{asset('/upload/disposisi/')}}`+'/'+data.data.file, "#pdfview", {
                        height: "80%",
                        pdfOpenParams: {
                        view: 'FitV',
                        page: '2'
                        }
                    });
                    console.log("Yay, this browser supports inline PDFs.");
                    } else {
                    console.log("Boo, inline PDFs are not supported by this browser");
                    }
                }
            },
        });
    }
</script>
@endsection
