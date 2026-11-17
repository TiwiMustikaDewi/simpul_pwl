@extends('layouts.student')

@section('title', 'Status Pengisian Formulir Ulasan Alumni')

@push('styles')
<style>
    @media (max-width: 520px) {
        .btn-group-mobile {
            flex-direction: column !important;
            width: 100%;
        }
        .btn-group-mobile a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- PAGE HEADER (STANDAR MARGIN PORTAL MAHASISWA) -->
<div style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <a href="{{ route('mahasiswa.experiences.index') }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; color: #64748b; text-decoration: none; font-weight: 500; transition: color 0.15s ease;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#64748b'">
            <iconify-icon icon="lucide:arrow-left" width="14" height="14"></iconify-icon>
            <span>Direktori Ulasan Alumni</span>
        </a>
        <span style="font-size: 12px; color: #cbd5e1;">/</span>
        <span style="font-size: 12.5px; color: #2563eb; font-weight: 500;">Status Pengisian Formulir</span>
    </div>
    <h2 style="font-size: 22px; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;">
        Formulir Ulasan Pengalaman Alumni
    </h2>
    <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">
        Ketentuan akses dan panduan pengisian rekam jejak pengalaman Kuliah Praktik bagi mahasiswa jurusan Ilmu Komputer.
    </p>
</div>

<!-- PANEL UTAMA STATUS ELIGIBILITAS -->
<div class="panel" style="padding: 48px 32px; border-radius: 16px;">
    <div style="max-width: 640px; margin: 0 auto; text-align: center;">

        <!-- STATUS BADGE & ICON -->
        <div style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 14px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 20px; font-size: clamp(11px, 2.9vw, 12px); font-weight: 600; margin-bottom: 20px; max-width: 100%; line-height: 1.4;">
            <iconify-icon icon="lucide:lock" width="14" height="14" style="flex-shrink: 0;"></iconify-icon>
            <span>Akses Belum Terbuka &bull; Khusus Pasca Kelulusan Sidang (Tahap 5)</span>
        </div>

        <div style="width: 72px; height: 72px; margin: 0 auto 18px; border-radius: 50%; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #2563eb; display: grid; place-items: center; border: 1.5px solid #bfdbfe; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.12);">
            <iconify-icon icon="lucide:graduation-cap" width="36" height="36"></iconify-icon>
        </div>

        <h3 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin: 0 0 10px 0;">
            Formulir Ulasan Belum Dapat Diisi
        </h3>

        <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.65; max-width: 540px; margin: 0 auto 32px;">
            Pengisian formulir rekam jejak dan pengalaman alumni dirancang khusus bagi mahasiswa yang telah menyelesaikan seluruh tahapan Kuliah Praktik dan dinyatakan <strong>Lulus Sidang KP (Tahap 5)</strong>.
        </p>

        <!-- ACTION BUTTONS -->
        <div class="btn-group-mobile" style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('mahasiswa.experiences.index') }}" class="btn-brand">
                <iconify-icon icon="lucide:book-open" width="16" height="16"></iconify-icon>
                <span>Lihat Ulasan Alumni Lain</span>
            </a>
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn-outline-custom">
                <iconify-icon icon="lucide:arrow-left" width="16" height="16"></iconify-icon>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

    </div>
</div>
@endsection

