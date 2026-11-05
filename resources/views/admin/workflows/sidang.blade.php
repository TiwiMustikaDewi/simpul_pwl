<section class="workflow-list">
    @forelse ($sidang as $item)
        <article class="panel workflow-panel">
            <div class="workflow-card-heading">
                <div>
                    <h2>{{ $item->student_name }} · {{ $item->npm }}</h2>
                    <p>{{ $item->title }}</p>
                </div>
                <span class="status-pill {{ $item->status }}">
                    {{ ['submitted' => 'Menunggu jadwal', 'scheduled' => 'Terjadwal', 'completed' => 'Selesai', 'rejected' => 'Ditolak'][$item->status] ?? $item->status }}
                </span>
            </div>
            @if ($item->sidang_date)
                <div class="workflow-meta">
                    <span>{{ \Carbon\Carbon::parse($item->sidang_date)->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                    <span>{{ $item->room ?? 'Ruang belum ditentukan' }}</span>
                </div>
            @endif
            @if ($item->notes)
                <div class="review-note"><strong>Catatan:</strong> {{ $item->notes }}</div>
            @endif

            @if ($item->status === 'submitted')
                <form action="{{ route('admin.sidang.schedule', $item->id) }}" method="POST" class="workflow-form form-grid">
                    @csrf
                    @method('PUT')
                    <label class="form-field">
                        <span>Tanggal dan waktu sidang</span>
                        <input class="form-control" type="datetime-local" name="sidang_date" value="{{ old('sidang_date') }}" required>
                    </label>
                    <label class="form-field">
                        <span>Ruang sidang</span>
                        <input class="form-control" type="text" name="room" value="{{ old('room') }}" required maxlength="255">
                    </label>
                    <div class="form-field-wide">
                        <button type="submit" class="btn btn-primary">Simpan jadwal</button>
                    </div>
                </form>
            @endif
        </article>
    @empty
        <div class="panel empty-state">
            <strong>Belum ada pengajuan sidang</strong>
            Pengajuan sidang KP akan muncul di sini untuk dijadwalkan.
        </div>
    @endforelse
</section>
