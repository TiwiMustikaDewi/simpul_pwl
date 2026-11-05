<section class="workflow-list">
    @forelse ($applications as $application)
        <article class="panel workflow-panel">
            <div class="workflow-card-heading">
                <div>
                    <h2>{{ $application->title }}</h2>
                    <p>{{ $application->student_name }} · {{ $application->npm }} · {{ $application->company_name }}</p>
                </div>
                <span class="status-pill {{ $application->status }}">
                    {{ [
                        'pending' => 'Menunggu verifikasi',
                        'approved' => 'Disetujui',
                        'rejected' => 'Perlu perbaikan',
                        'in_progress' => 'Sedang berjalan',
                        'completed' => 'Selesai',
                    ][$application->status] ?? $application->status }}
                </span>
            </div>

            <div class="workflow-meta">
                <span>{{ $application->type === 'group' ? 'Kelompok' : 'Individu' }}</span>
                <span>{{ $application->start_date }} – {{ $application->end_date }}</span>
                <span>Pembimbing: {{ $application->supervisor_name ?? 'Belum ditetapkan' }}</span>
            </div>

            @if ($application->admin_note)
                <div class="review-note"><strong>Catatan admin:</strong> {{ $application->admin_note }}</div>
            @endif

            @if ($application->status === 'pending')
                <form action="{{ route('admin.applications.review', $application->id) }}" method="POST" class="workflow-form">
                    @csrf
                    <label class="form-field">
                        <span>Catatan pemeriksaan (wajib jika pengajuan ditolak)</span>
                        <textarea class="form-control" name="admin_note" rows="2" maxlength="5000">{{ old('admin_note') }}</textarea>
                    </label>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit" name="decision" value="approved">Setujui pengajuan</button>
                        <button class="btn btn-danger" type="submit" name="decision" value="rejected">Tolak dengan catatan</button>
                    </div>
                </form>
            @endif
        </article>
    @empty
        <div class="panel empty-state">
            <strong>Belum ada pengajuan KP</strong>
            Pengajuan mahasiswa akan muncul di sini untuk ditinjau.
        </div>
    @endforelse
</section>
