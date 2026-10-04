@extends('admin.layout')

@section('title', 'Tambah Produk BLUD')
@section('page-title', 'Tambah Produk BLUD')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.produk-blud.store') }}" class="rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @include('admin.blud.produk._form')
    </form>
@endsection
