@extends('layouts.admin')

@section('title', 'Pusat Notifikasi')

@push('styles')
<style>
    .notification-page { width: 100%; max-width: 1280px; margin: 8px auto 0; }
    .notification-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 22px; }
    .notification-breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; color: #64748b; font-size: 13px; }
    .notification-breadcrumb a { display: inline-flex; align-items: center; gap: 6px; color: #64748b; }
    .notification-breadcrumb a:hover { color: #2563eb; }
    .notification-breadcrumb > span:last-child { color: #2563eb; font-weight: 600; }
    .notification-title { margin: 0; color: #0f172a; font-size: 27px; font-weight: 700; line-height: 1.3; letter-spacing: -.4px; }
    .notification-description { margin: 6px 0 0; color: #64748b; font-size: 15px; line-height: 1.55; }
    .notification-read-all { flex: 0 0 auto; display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border: 1px solid #cbd5e1; border-radius: 30px; background: #fff; color: #334155; font: inherit; font-size: 12px; font-weight: 600; }
    .notification-read-all iconify-icon { color: #2563eb; }
    .notification-read-all:hover { border-color: #93c5fd; background: #f8fbff; }
    .notification-flash { margin-bottom: 14px; padding: 10px 14px; border: 1px solid #bbf7d0; border-radius: 10px; background: #f0fdf4; color: #166534; font-size: 12px; }
    .notification-tabs { display: flex; align-items: center; gap: 9px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #dbe3ee; }
    .notification-tab { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 24px; background: #f1f5f9; color: #334155; font-size: 13px; font-weight: 500; text-decoration: none; }
    .notification-tab.is-active { background: #2563eb; color: #fff; font-weight: 600; }
    .notification-tab-count { display: inline-flex; align-items: center; justify-content: center; min-width: 22px; height: 22px; padding: 0 6px; border-radius: 20px; background: #e2e8f0; color: #64748b; font-size: 11px; font-weight: 700; }
    .notification-tab.is-active .notification-tab-count { background: rgba(255,255,255,.25); color: #fff; }
    .notification-tab-count.is-unread { background: #ef4444; color: #fff; }
    .notification-list { display: grid; gap: 12px; }
    .notification-card { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; min-width: 0; padding: 18px 22px; border: 1px solid #bfdbfe; border-left: 4px solid #2563eb; border-radius: 16px; background: #f8fbff; }
    .notification-card.is-read { border-color: #e2e8f0; border-left-color: #cbd5e1; background: #fff; }
    .notification-card-main { display: flex; align-items: flex-start; gap: 14px; min-width: 0; flex: 1; }
    .notification-card-icon { display: grid; place-items: center; width: 44px; height: 44px; flex: 0 0 44px; margin-top: 2px; border-radius: 13px; background: #dbeafe; color: #2563eb; }
    .notification-card.is-read .notification-card-icon { background: #f1f5f9; color: #64748b; }
    .notification-card-content { min-width: 0; }
    .notification-card-title-row { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 4px; }
    .notification-card-title { margin: 0; color: #0f172a; font-size: 16px; font-weight: 600; line-height: 1.4; }
    .notification-new { padding: 3px 9px; border-radius: 14px; background: #dbeafe; color: #1d4ed8; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .notification-message { margin: 0 0 9px; color: #475569; font-size: 14px; line-height: 1.5; overflow-wrap: anywhere; }
    .notification-time { display: inline-flex; align-items: center; gap: 6px; color: #94a3b8; font-size: 12px; }
    .notification-actions { display: flex; align-items: center; gap: 7px; flex: 0 0 auto; }
    .notification-action-read { display: inline-flex; align-items: center; gap: 6px; padding: 7px 11px; border: 1px solid #cbd5e1; border-radius: 9px; background: #fff; color: #334155; font: inherit; font-size: 11px; }
    .notification-action-read iconify-icon { color: #2563eb; }
    .notification-action-read:hover { border-color: #93c5fd; background: #eff6ff; }
    .notification-action-delete { display: grid; place-items: center; width: 32px; height: 32px; border: 1px solid transparent; border-radius: 8px; background: transparent; color: #94a3b8; }
    .notification-action-delete:hover { border-color: #fecaca; background: #fef2f2; color: #ef4444; }
    .notification-empty { padding: 38px 20px; border: 1px solid #e2e8f0; border-radius: 16px; background: #fff; text-align: center; }
    .notification-empty-icon { display: grid; place-items: center; width: 50px; height: 50px; margin: 0 auto 12px; border-radius: 50%; background: #eff6ff; color: #2563eb; }
    .notification-empty h2 { margin: 0 0 6px; color: #0f172a; font-size: 17px; }
    .notification-empty p { max-width: 480px; margin: 0 auto; color: #64748b; font-size: 13px; line-height: 1.6; }
    .notification-pagination { margin-top: 16px; }

    @media (max-width: 900px) {
        .notification-page { margin-top: 6px; }
        .notification-title { font-size: 24px; }
        .notification-description { font-size: 14px; }
        .notification-card { padding: 16px 18px; }
        .notification-card-title { font-size: 15px; }
        .notification-message { font-size: 13px; }
    }
    @media (max-width: 650px) {
        .notification-heading { flex-direction: column; margin-bottom: 18px; }
        .notification-read-all { padding: 9px 13px; font-size: 11px; }
        .notification-tabs { gap: 7px; margin-bottom: 16px; padding-bottom: 10px; }
        .notification-tab { padding: 8px 13px; font-size: 12px; }
        .notification-card { flex-direction: column; gap: 12px; padding: 14px; border-radius: 14px; }
        .notification-card-main { gap: 10px; }
        .notification-card-icon { width: 38px; height: 38px; flex-basis: 38px; border-radius: 11px; }
        .notification-card-title { font-size: 14px; }
        .notification-message { font-size: 12px; }
        .notification-time { font-size: 11px; }
        .notification-actions { align-self: flex-end; }
    }
    @media (max-width: 420px) {
        .notification-title { font-size: 22px; }
        .notification-breadcrumb { font-size: 12px; }
        .notification-card-main { gap: 8px; }
        .notification-tab { padding: 8px 11px; }
        .notification-tab-count { min-width: 20px; height: 20px; font-size: 10px; }
    }
</style>
@endpush

@section('content')
<div class="notification-page">
    <div class="notification-heading">
        <div>
            <div class="notification-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="lucide:arrow-left" width="18" height="18" aria-hidden="true"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <span aria-hidden="true">/</span>
                <span>Pusat Notifikasi</span>
            </div>
            <h1 class="notification-title">Pusat Notifikasi &amp; Pemberitahuan</h1>
            <p class="notification-description">Pantau seluruh pengajuan baru dan riwayat perkembangan administrasi Kuliah Praktik.</p>
        </div>

        @if ($unreadCount > 0)
            <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                @csrf
                <button class="notification-read-all" type="submit">
                    <iconify-icon icon="lucide:check-check" width="20" height="20" aria-hidden="true"></iconify-icon>
                    <span>Tandai Semua Sudah Dibaca</span>
                </button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="notification-flash" role="status">{{ session('success') }}</div>
    @endif

    <nav class="notification-tabs" aria-label="Filter notifikasi">
        <a href="{{ route('admin.notifications.index', ['filter' => 'all']) }}"
           class="notification-tab {{ $currentFilter === 'all' ? 'is-active' : '' }}"
           @if ($currentFilter === 'all') aria-current="page" @endif>
            <span>Semua</span>
            <span class="notification-tab-count">{{ $totalCount }}</span>
        </a>
        <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
           class="notification-tab {{ $currentFilter === 'unread' ? 'is-active' : '' }}"
           @if ($currentFilter === 'unread') aria-current="page" @endif>
            <span>Belum Dibaca</span>
            <span class="notification-tab-count {{ $unreadCount > 0 ? 'is-unread' : '' }}">{{ $unreadCount }}</span>
        </a>
    </nav>

    @if ($notifications->isNotEmpty())
        <div class="notification-list">
            @foreach ($notifications as $notification)
                @php($notificationTime = $notification->created_at->copy()->timezone('Asia/Jakarta'))
                <article class="notification-card {{ $notification->is_read ? 'is-read' : '' }}">
                    <div class="notification-card-main">
                        <div class="notification-card-icon" aria-hidden="true">
                            <iconify-icon icon="{{ $notification->is_read ? 'lucide:bell' : 'lucide:bell-ring' }}" width="27" height="27"></iconify-icon>
                        </div>

                        <div class="notification-card-content">
                            <div class="notification-card-title-row">
                                <h2 class="notification-card-title">{{ $notification->title }}</h2>
                                @if (! $notification->is_read)
                                    <span class="notification-new">Baru</span>
                                @endif
                            </div>
                            <p class="notification-message">{{ $notification->message }}</p>
                            <time class="notification-time" datetime="{{ $notificationTime->toIso8601String() }}">
                                <iconify-icon icon="lucide:clock" width="17" height="17" aria-hidden="true"></iconify-icon>
                                <span>{{ $notificationTime->diffForHumans() }} ({{ $notificationTime->format('d M Y, H:i') }} WIB)</span>
                            </time>
                        </div>
                    </div>

                    <div class="notification-actions">
                        @if (! $notification->is_read)
                            <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="notification-action-read" type="submit">
                                    <iconify-icon icon="lucide:check" width="17" height="17" aria-hidden="true"></iconify-icon>
                                    <span>Tandai Dibaca</span>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="notification-action-delete" type="submit" title="Hapus notifikasi" aria-label="Hapus notifikasi">
                                <iconify-icon icon="lucide:trash-2" width="19" height="19" aria-hidden="true"></iconify-icon>
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="notification-pagination">{{ $notifications->links() }}</div>
    @else
        <section class="notification-empty">
            <div class="notification-empty-icon">
                <iconify-icon icon="lucide:bell-check" width="30" height="30" aria-hidden="true"></iconify-icon>
            </div>
            <h2>{{ $currentFilter === 'unread' ? 'Tidak Ada Notifikasi Belum Dibaca' : 'Belum Ada Notifikasi Masuk' }}</h2>
            <p>
                @if ($currentFilter === 'unread')
                    Semua pemberitahuan sudah dibaca. Anda dapat melihat kembali riwayat notifikasi melalui tab Semua.
                @else
                    Pemberitahuan pengajuan baru dari mahasiswa akan muncul di halaman ini.
                @endif
            </p>
        </section>
    @endif
</div>
@endsection
