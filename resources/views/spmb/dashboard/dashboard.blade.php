@extends('spmb.dashboard.layout')

@section('page-title', 'Dashboard')

@section('content')
    <div class="dash-card">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 py-1">
            <a href="{{ route('spmb.biodata') }}" class="btn-navy">
                <x-lucide-user-plus />
                Lengkapi Biodata
            </a>
            <a href="{{ route('spmb.dokumen') }}" class="btn-navy">
                <x-lucide-upload />
                Upload Dokumen
            </a>
            <a href="{{ route('spmb.bantuan') }}" class="btn-navy">
                <x-lucide-message-circle />
                Hubungi Panitia
            </a>
        </div>
    </div>
@endsection
