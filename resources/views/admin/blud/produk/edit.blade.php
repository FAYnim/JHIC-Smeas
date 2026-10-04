@extends('admin.layout')

@section('title', 'Edit Produk BLUD')
@section('page-title', 'Edit Produk BLUD')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.produk-blud.update', $produk) }}" class="rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        @include('admin.blud.produk._form')
    </form>
@endsection
