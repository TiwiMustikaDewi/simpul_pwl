<section class="workflow-list">
    @forelse ($experiences as $experience)
        <article class="panel workflow-panel">
            <div class="workflow-card-heading">
                <div>
                    <h2>{{ $experience->position }} · {{ $experience->company_name }}</h2>
                    <p>{{ $experience->student_name }} · {{ $experience->npm }}</p>
                </div>
                <span class="status-pill {{ $experience->is_validated ? 'approved' : 'pending' }}">
                    {{ $experience->is_validated ? 'Tervalidasi' : 'Menunggu validasi' }}
                </span>
            </div>

            <dl class="experience-details">
                <div><dt>Proses seleksi</dt><dd>{{ $experience->selection_process }}</dd></div>
                <div><dt>Keterampilan</dt><dd>{{ $experience->skills_used }}</dd></div>
                <div><dt>Pengalaman</dt><dd>{{ $experience->experience_review }}</dd></div>
            </dl>

            @unless ($experience->is_validated)
                <form action="{{ route('admin.experiences.validate', $experience->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Validasi pengalaman</button>
                </form>
            @endunless
        </article>
    @empty
        <div class="panel empty-state">
            <strong>Belum ada pengalaman KP</strong>
            Pengalaman yang dikirim mahasiswa akan tampil di sini untuk diperiksa.
        </div>
    @endforelse
</section>
