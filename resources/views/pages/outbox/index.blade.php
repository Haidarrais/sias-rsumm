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
                <button class="btn btn-primary" id="addOutbox">
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
                        @foreach ($outboxes as $key => $outbox)
                        <tr>
                            @php
                            $dispStatus = $outbox->disposition->where('user_id', Auth::user()->id)->where('is_disposition', 1)->first();
                            $dispStatusNA = $inbox->disposition->where('user_id', Auth::user()->id)->where('is_disposition', 0)->first();
                            if ($outbox->status == 0) {
                            $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top"
                                title="Pending(dalam peninjauan direktur)" style="color:#ffa426;font-size:20px"></i>';
                            }elseif ($outbox->status == 1) {
                            $status = '<i class="fas fa-times-circle" data-toggle="tooltip" data-placement="top"
                                title="Ditolak" style="color:#fc544b;font-size:20px"></i>';
                            }elseif ($outbox->status == 2) {
                            $status = '<i class="fas fa-check-circle" data-toggle="tooltip" data-placement="top"
                                title="Diterima" style="color:#47c363;font-size:20px"></i>';
                            }elseif ($outbox->status == 3) {
                                $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top"
                                title="Pending(dalam peninjauan wakil direktur)" style="color:#ffa426;font-size:20px"></i>';
                            }elseif ($outbox->status == 4) {
                                $status = '<i class="fas fa-clock" data-toggle="tooltip" data-placement="top"
                                title="Pending(dalam peninjauan kabid)" style="color:#ffa426;font-size:20px"></i>';
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
                            <td>
                                @role('pimpinan')
                                @if ($outbox->status == 0)
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary"
                                        onclick="detOutbox({{$outbox->id}})">Detail</button>
                                    <button type="button" class="btn btn-success"
                                        onclick="disOutbox({{$outbox->id}})">Disposisi</button>
                                </div>
                                    @else
                                    <span class="badge badge-success">Anda Sudah Melakukan Disposisi</span>
                                    @endif
                                    @endrole
                                    @role('wakilpimpinan')
                                    @if ($dispStatusNA && !$dispStatus)
                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        <button type="button" class="btn btn-primary"
                                        onclick="detOutbox({{$outbox->id}})">Detail</button>
                                        <button type="button" class="btn btn-success"
                                        onclick="disOutbox({{$outbox->id}})">Disposisi</button>
                                    </div>

                                    @elseif ($dispStatus)
                                    <span class="badge badge-success">Anda Sudah Melakukan Disposisi</span>
                                    @endif
                                    @endrole
                                    @role('kabid')
                                    @if ($dispStatusNA && !$dispStatus)
                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        <button type="button" class="btn btn-primary"
                                        onclick="detOutbox({{$outbox->id}})">Detail</button>
                                        <button type="button" class="btn btn-success"
                                        onclick="disOutbox({{$outbox->id}})">Disposisi</button>
                                    </div>

                                    @elseif ($dispStatus)
                                    <span class="badge badge-success">Anda Sudah Melakukan Disposisi</span>
                                    @endif
                                    @endrole
                                    @role('admin')
                                    <form action="{{ route('outbox.destroy', $outbox->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-info"
                                                onclick="detOutbox({{$outbox->id}})"><i
                                                    class="fas fa-file-pdf"></i></button>
                                            <button type="button" class="btn btn-warning"
                                                onclick="editOutbox({{$outbox->id}})"><i class="far fa-edit"></i></button>
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </div>

                                    </form>
                                    @endrole
                                {{-- modal_edit{{$key}} --}}
                                {{-- <button
                                    onclick="alert('modal_edit{{$key}}'); document.getElementById('modal_edit{{$key}}').classList.toggle('show')"><i
                                        class="far fa-edit"></i></button> --}}
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
{{-- START OF MODAL EDIT and ADD --}}
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Surat Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('outbox.store')}}" method="POST" id="form-add-outbox-data"
                enctype="multipart/form-data">
                <input type="text" class="form-control" name="user_id" value="{{Auth::id()}}" hidden>
                <input type="text" name="_method" id="form_method" value="POST" hidden>
                <input type="text" class="form-control" name="outbox_origin" value="{{Auth::user()->name}}" hidden>
                @csrf
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="">Nomor Agenda</label>
                        <input type="text" class="form-control @error('journal_id') is-invalid @enderror"
                            value="{{ old('journal_id') }}" id="form_journal_id" name="journal_id" autofocus>
                        @error('journal_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Nomor Surat</label>
                        <input type="text" class="form-control @error('outbox_number') is-invalid @enderror"
                            value="{{ old('outbox_number') }}" id="form_outbox_number" name="outbox_number">
                        @error('outbox_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Sumber Surat</label>
                        <input type="text" class="form-control @error('sender') is-invalid @enderror"
                            value="{{ old('sender') }}" id="form_sender" name="sender">
                        @error('sender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Tujuan Surat</label>
                        <input type="text" class="form-control @error('destination') is-invalid @enderror"
                            value="{{ old('destination') }}" id="form_destination" name="destination">
                        @error('destination')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Perihal</label>
                        <input type="text" class="form-control @error('regarding') is-invalid @enderror"
                            value="{{ old('regarding') }}" id="form_regarding" name="regarding">
                        @error('regarding')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Tanggal Surat Diterima</label>
                        <input type="date" class="form-control @error('entry_date') is-invalid @enderror"
                            value="{{ old('entry_date') }}" id="form_entry_date" name="entry_date">
                        @error('entry_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">File Surat (.pdf)</label>
                        <input type="file" class="form-control-file @error('uploadfile') is-invalid @enderror"
                            value="{{ old('uploadfile') }}" name="uploadfile">
                        @error('uploadfile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <span id="form_issue_file"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Jenis Surat</label>
                        <select name="type" id="type_add"
                            class="form-control js-example-basic-single @error('type') is-invalid @enderror"
                            value="{{ old('type') }}">
                            <option value="" selected disabled>Pilih Jenis Surat</option>
                            @foreach ($types as $key => $type )
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes') }}"
                            name="notes" id="form_notes"></textarea>
                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
{{-- END OF MODAL EDIT and ADD --}}
<div class="modal fade" id="modal_disposition" tabindex="-1" role="dialog" aria-labelledby="modal_disposition"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-set-resiLabel">Disposisi Surat Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('disposition.store')}}" method="POST" id="form-add-outbox-data"
                enctype="multipart/form-data">
                <input type="text" class="form-control" name="surat_id" id="form_mail_id" hidden>
                @csrf
                <div class="modal-body row">
                    <!-- <input type="text" class="form-control" name="tujuan"> -->
                    <div class="form-group col-md-12">
                        <label for="">Disposisikan ke</label>
                        <!-- <label for="">Jenis Surat</label> -->
                        <select name="tujuan[]" id="select_tujuan" class="form-control js-example-basic-single" multiple="multiple"
                            data-placeholder="Pilih tujuan disposisi" data-allow-clear="true">
                            @role('pimpinan')
                            @foreach ($wadirs as $key => $wadir )
                            <option value="{{$wadir->id}}">{{$wadir->name}}</option>
                            @endforeach
                            @endrole
                            @role('wakilpimpinan')
                            @foreach ($kabids as $key => $kabid )
                            <option value="{{$kabid->id}}">{{$kabid->name}}</option>
                            @endforeach
                            @endrole
                            @role('kabid')
                            @foreach ($employees as $key => $employee )
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                            @endrole
                        </select>
                        <input type="text" name="tujuans" id="value_tujuan" hidden>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Catatan</label>
                        <textarea class="form-control" name="catatan"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="urgency">Urgensi Disposisi</label>
                        <select name="urgency" class="form-control" id="urgency">
                            <option value="1">Penting</option>
                            <option value="2">Rahasia</option>
                            <option value="3">Segera</option>
                            <option value="4">Biasa</option>
                        </select>
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

{{-- START OF MODAL DETAIL PDF --}}
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
{{-- END OF MODAL DETAIL PDF --}}
@endsection
@section('script')
@if($errors->any())
<script>
    $(document).ready(function() {
        $('#modal_tambah').modal('show');
    });
</script>
@endif
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
</script>
<script>
    $('#addOutbox').on('click', () => {
        $('#modal_tambah').modal('show')
    });
    $(document).ready(function(){
        $('#select_tujuan').on('change', function(){
            $('#value_tujuan').val($(this).val());
        })
    })
    function detOutbox(id) {
        //index = id;
        //console.log(index);
        var url = "{{route('outbox.show', ":id ")}}";
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
    function editOutbox(id) {
        index = id;
        console.log(index);
        var url = "{{route('outbox.edit', ":id ")}}";
        url = url.replace(":id", id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#modal_tambah').modal('show')
                $("#modal_title").html('Modal Edit')
                $("#form_method").val("PATCH")
                $("#form_journal_id").val(data.data.journal_id)
                $("#form_outbox_number").val(data.data.number)
                $("#form_sender").val(data.data.sender)
                $("#form_destination").val(data.data.destination)
                $("#form_regarding").val(data.data.regarding)
                $("#form_entry_date").val(data.data.entry_date)
                $("#type_add").val(data.data.type_id)
                $("#form_issue_file").html(data.data.file)
                $("#form_issue_file").each(function(){
                    $(this).text($(this).text().substring(0,8)+"...pdf");
                });
                $("#form_notes").val(data.data.notes)
                $("#form_entry_date").prop("disabled", true)
                var formAction = "{{route('outbox.update', ":id")}}";
                formAction = formAction.replace(':id', id);
                $("#form-add-outbox-data").attr("action", formAction);
            },
        });
    }
    function disOutbox(id) {
        $('#modal_disposition').modal('show')
        $("#form_mail_id").val(id)
    }
</script>
@foreach ($outboxes as $key => $outbox)
<script>
    $('#editOutbox'+ {{$key}}).on('click', () => {
          $('#modal_edit'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@foreach ($outboxes as $key => $outbox)
<script>
    $('#dispositionOutbox'+ {{$key}}).on('click', () => {
          $('#modal_disposition'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@foreach ($outboxes as $key => $outbox)
<script>
    $('#detailOutbox'+ {{$key}}).on('click', () => {
          $('#modal_detail'+ {{$key}}).modal('show')
        });
</script>
@endforeach
@endsection
