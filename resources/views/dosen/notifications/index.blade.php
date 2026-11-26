@extends('layouts.dosen')

@section('title', 'Pusat Notifikasi')

@push('styles')
<style>
    .dosen-notification-page { max-width: 960px; margin: 0 auto; }
    .dosen-notification-heading { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
    .dosen-notification-heading h1 { margin: 0; color: #0f172a; font-size: 23px; font-weight: 700; }
    .dosen-notification-heading p { margin: 5px 0 0; color: #64748b; font-size: 13px; }
    .dosen-notification-filters { display: flex; gap: 8px; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
    .dosen-notification-filter { display: inline-flex; gap: 7px; align-items: center; padding: 7px 14px; border-radius: 20px; background: #f1f5f9; color: #475569; font-size: 12px; text-decoration: none; }
    .dosen-notification-filter.is-active { background: #2563eb; color: #fff; }
    .dosen-notification-list { display: grid; gap: 10px; }
    .dosen-notification-card { display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; padding: 16px 18px; border: 1px solid #bfdbfe; border-left: 4px solid #2563eb; border-radius: 13px; background: #f8fbff; }
    .dosen-notification-card.is-read { border-color: #e2e8f0; border-left-color: #cbd5e1; background: #fff; }
    .dosen-notification-content { min-width: 0; }
    .dosen-notification-content h2 { margin: 0 0 4px; color: #0f172a; font-size: 14px; font-weight: 600; }
    .dosen-notification-content p { margin: 0 0 7px; color: #475569; font-size: 12px; line-height: 1.55; }
    .dosen-notification-time { color: #94a3b8; font-size: 11px; }
    .dosen-notification-actions { display: flex; flex: 0 0 auto; align-items: center; gap: 7px; }
    .dosen-notification-actions button { padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; color: #334155; font: inherit; font-size: 11px; cursor: pointer; }
    .dosen-notification-empty { padding: 30px 18px; border: 1px solid #e2e8f0; border-radius: 13px; background: #fff; color: #64748b; text-align: center; }
    @media (max-width: 640px) {
        .dosen-notification-heading { flex-direction: column; }
        .dosen-notification-card { flex-direction: column; }
        .dosen-notification-actions { align-self: flex-end; }
    }
</style>
@endpush

@section('content')
<div class="dosen-notification-page">
    <div class="dosen-notification-heading">
        <div>
            <h1>Pusat Notifikasi</h1>
            <p>Pengumuman dan penugasan bimbingan KP untuk Anda.</p>
        </div>
        @if ($unreadCount > 0)
            <form action="{{ route('dosen.notifications.read-all') }}" method="POST">
                @csrf
                <button class="btn btn-outline btn-sm" type="submit">Tandai semua dibaca</button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="panel" role="status" style="margin-bottom: 14px; color: #166534;">{{ session('success') }}</div>
    @endif

    <nav class="dosen-notification-filters" aria-label="Filter notifikasi">
        <a class="dosen-notification-filter {{ $currentFilter === 'all' ? 'is-active' : '' }}" href="{{ route('dosen.notifications.index', ['filter' => 'all']) }}">
            Semua <span>{{ $totalCount }}</span>
        </a>
        <a class="dosen-notification-filter {{ $currentFilter === 'unread' ? 'is-active' : '' }}" href="{{ route('dosen.notifications.index', ['filter' => 'unread']) }}">
            Belum dibaca <span>{{ $unreadCount }}</span>
        </a>
    </nav>

    @if ($notifications->isNotEmpty())
        <div class="dosen-notification-list">
            @foreach ($notifications as $notification)
                @php($notificationTime = $notification->created_at->copy()->timezone('Asia/Jakarta'))
                <article class="dosen-notification-card {{ $notification->is_read ? 'is-read' : '' }}">
                    <div class="dosen-notification-content">
                        <h2>{{ $notification->title }}</h2>
                        <p>{{ $notification->message }}</p>
                        <time class="dosen-notification-time" datetime="{{ $notificationTime->toIso8601String() }}">
                            {{ $notificationTime->format('d M Y, H:i') }} WIB
                        </time>
                    </div>
                    <div class="dosen-notification-actions">
                        @if (! $notification->is_read)
                            <form action="{{ route('dosen.notifications.read', $notification) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Tandai dibaca</button>
                            </form>
                        @endif
                        <form action="{{ route('dosen.notifications.destroy', $notification) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" aria-label="Hapus notifikasi">Hapus</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
        <div style="margin-top: 16px;">{{ $notifications->links() }}</div>
    @else
        <div class="dosen-notification-empty">Belum ada notifikasi untuk Anda.</div>
    @endif
</div>
@endsection
