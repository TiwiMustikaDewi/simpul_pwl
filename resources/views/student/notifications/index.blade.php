@extends('layouts.student')

@section('title', 'Pusat Notifikasi')

@section('content')
<div style="max-width: 960px; margin: 0 auto;">

    <!-- HEADER SECTION -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <a href="{{ route('mahasiswa.dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px; font-size: 12.5px; color: #64748b; text-decoration: none;">
                    <iconify-icon icon="lucide:arrow-left" width="14" height="14"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <span style="font-size: 12px; color: #cbd5e1;">/</span>
                <span style="font-size: 12.5px; color: #2563eb; font-weight: 500;">Pusat Notifikasi</span>
            </div>
            <h2 style="font-size: 22px; font-weight: 700; color: var(--text-main); line-height: 1.3; margin: 0;">
                Pusat Notifikasi & Pemberitahuan
            </h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">
                Pantau seluruh pengumuman dan riwayat perkembangan administrasi Kuliah Praktik kamu.
            </p>
        </div>

        @if ($unreadCount > 0)
            <form action="{{ route('mahasiswa.notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="btn-outline-custom" style="padding: 8px 16px; font-size: 12.5px; border-radius: 20px;">
                    <iconify-icon icon="lucide:check-check" width="16" height="16" style="color: #2563eb;"></iconify-icon>
                    <span>Tandai Semua Sudah Dibaca</span>
                </button>
            </form>
        @endif
    </div>

    <!-- FILTER TABS -->
    <div style="display: flex; gap: 8px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
        <a href="{{ route('mahasiswa.notifications.index', ['filter' => 'all']) }}" 
           style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: 20px; font-size: 12.5px; text-decoration: none; font-weight: {{ $currentFilter === 'all' ? '600' : '500' }}; background: {{ $currentFilter === 'all' ? '#2563eb' : '#f1f5f9' }}; color: {{ $currentFilter === 'all' ? '#ffffff' : '#475569' }}; transition: all .2s;">
            <span>Semua</span>
            <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; background: {{ $currentFilter === 'all' ? 'rgba(255,255,255,0.25)' : '#e2e8f0' }}; color: inherit;">
                {{ $totalCount }}
            </span>
        </a>

        <a href="{{ route('mahasiswa.notifications.index', ['filter' => 'unread']) }}" 
           style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: 20px; font-size: 12.5px; text-decoration: none; font-weight: {{ $currentFilter === 'unread' ? '600' : '500' }}; background: {{ $currentFilter === 'unread' ? '#2563eb' : '#f1f5f9' }}; color: {{ $currentFilter === 'unread' ? '#ffffff' : '#475569' }}; transition: all .2s;">
            <span>Belum Dibaca</span>
            @if ($unreadCount > 0)
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; background: {{ $currentFilter === 'unread' ? '#ef4444' : '#ef4444' }}; color: #ffffff;">
                    {{ $unreadCount }}
                </span>
            @else
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; background: #e2e8f0; color: #64748b;">
                    0
                </span>
            @endif
        </a>
    </div>

    <!-- NOTIFICATION LIST -->
    @if ($notifications->isNotEmpty())
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
            @foreach ($notifications as $notif)
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; padding: 18px 22px; background: {{ $notif->is_read ? '#ffffff' : '#f8fbff' }}; border: 1px solid {{ $notif->is_read ? 'var(--border-color)' : '#bfdbfe' }}; border-left: 4px solid {{ $notif->is_read ? '#cbd5e1' : '#2563eb' }}; border-radius: 14px; box-shadow: 0 1px 3px rgba(15,23,42,0.02); transition: all .2s;">
                    
                    <div style="display: flex; align-items: flex-start; gap: 14px; flex: 1; min-width: 0;">
                        <!-- ICON -->
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: {{ $notif->is_read ? '#f1f5f9' : '#dbeafe' }}; color: {{ $notif->is_read ? '#64748b' : '#2563eb' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                            <iconify-icon icon="{{ $notif->is_read ? 'lucide:bell' : 'lucide:bell-ring' }}" width="18" height="18"></iconify-icon>
                        </div>

                        <!-- CONTENT -->
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 4px;">
                                <h4 style="font-size: 14px; font-weight: 600; color: var(--text-main); margin: 0; line-height: 1.4;">
                                    {{ $notif->title }}
                                </h4>
                                @if (!$notif->is_read)
                                    <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 10px; letter-spacing: 0.3px;">
                                        Baru
                                    </span>
                                @endif
                            </div>

                            <p style="font-size: 13px; color: #475569; line-height: 1.55; margin: 0 0 8px 0; word-break: break-word;">
                                {{ $notif->message }}
                            </p>

                            <div style="display: flex; align-items: center; gap: 12px; font-size: 11.5px; color: #94a3b8;">
                                <span style="display: inline-flex; align-items: center; gap: 4px;">
                                    <iconify-icon icon="lucide:clock" width="13" height="13"></iconify-icon>
                                    <span>{{ $notif->created_at->diffForHumans() }} ({{ $notif->created_at->format('d M Y, H:i') }} WIB)</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                        @if (!$notif->is_read)
                            <form action="{{ route('mahasiswa.notifications.read', $notif->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="Tandai sudah dibaca" style="background: none; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 10px; font-size: 11.5px; font-weight: 500; color: #334155; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: all .15s;">
                                    <iconify-icon icon="lucide:check" width="14" height="14" style="color: #2563eb;"></iconify-icon>
                                    <span>Tandai Dibaca</span>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('mahasiswa.notifications.destroy', $notif->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Hapus notifikasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus notifikasi" style="background: none; border: 1px solid transparent; border-radius: 8px; padding: 6px 8px; font-size: 12px; color: #94a3b8; cursor: pointer; display: inline-flex; align-items: center; transition: all .15s;" onmouseover="this.style.color='#ef4444'; this.style.borderColor='#fecaca'; this.style.background='#fef2f2';" onmouseout="this.style.color='#94a3b8'; this.style.borderColor='transparent'; this.style.background='none';">
                                <iconify-icon icon="lucide:trash-2" width="15" height="15"></iconify-icon>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <div>
            {{ $notifications->links() }}
        </div>
    @else
        <!-- EMPTY STATE -->
        <div class="panel" style="text-align: center; padding: 48px 24px; border-radius: 16px;">
            <div style="width: 56px; height: 56px; margin: 0 auto 16px; background: #eff6ff; border-radius: 50%; display: grid; place-items: center;">
                <iconify-icon icon="lucide:bell-check" width="28" height="28" style="color: #2563eb;"></iconify-icon>
            </div>
            <h3 style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">
                @if ($currentFilter === 'unread')
                    Tidak Ada Notifikasi Belum Dibaca
                @else
                    Belum Ada Notifikasi Masuk
                @endif
            </h3>
            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; max-width: 480px; margin: 0 auto 22px;">
                @if ($currentFilter === 'unread')
                    Semua pemberitahuan sudah Anda baca. Anda dapat melihat kembali riwayat di tab "Semua".
                @else
                    Pemberitahuan resmi mengenai kelulusan berkas kesiapan KP, penetapan dosen pembimbing, catatan revisi, dan pengumuman jadwal sidang akan muncul di halaman ini.
                @endif
            </p>
            <div style="display: flex; justify-content: center; gap: 10px;">
                @if ($currentFilter === 'unread')
                    <a href="{{ route('mahasiswa.notifications.index', ['filter' => 'all']) }}" class="btn-outline-custom">
                        Lihat Semua Riwayat
                    </a>
                @endif
                <a href="{{ route('mahasiswa.dashboard') }}" class="btn-brand">
                    <iconify-icon icon="lucide:arrow-left" width="16" height="16"></iconify-icon>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
