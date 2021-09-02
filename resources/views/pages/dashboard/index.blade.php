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
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-inbox"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Surat Masuk</h4>
          </div>
          <div class="card-body">
            {{$inboxes->count()}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="far fa-paper-plane"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Surat Keluar</h4>
          </div>
          <div class="card-body">
            0
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="far fa-file"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Tipe Surat</h4>
          </div>
          <div class="card-body">
            {{$types->count()}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-circle"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Jumlah Unit</h4>
          </div>
          <div class="card-body">
            39
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
