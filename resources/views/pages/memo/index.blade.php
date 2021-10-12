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
            </tr>
            @forelse ($dispositions as $key => $disposition)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$disposition->mail->entry_date}} / {{$disposition->mail->number}}</td>
              <td>{{$disposition->mail->sender}}</td>
              <td>{{$disposition->mail->regarding}}</td>
              <td>{{$disposition->created_at->format('d M Y')}}</td>
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
