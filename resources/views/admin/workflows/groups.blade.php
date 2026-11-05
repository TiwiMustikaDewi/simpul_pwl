<div class="workflow-grid">
    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Bentuk kelompok KP</h2>
        </div>

        <form action="{{ route('admin.groups.store') }}" method="POST" class="workflow-form">
            @csrf
            <label class="form-field">
                <span>Nama kelompok</span>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}" required maxlength="255">
            </label>
            <label class="form-field">
                <span>Ketua kelompok</span>
                <select class="form-control" name="leader_id" required>
                    <option value="">Pilih mahasiswa</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected(old('leader_id') == $student->id)>
                            {{ $student->name }} · {{ $student->npm }}
                        </option>
                    @endforeach
                </select>
            </label>
            <fieldset class="member-picker">
                <legend>Anggota kelompok</legend>
                @forelse ($students as $student)
                    <label>
                        <input type="checkbox" name="member_ids[]" value="{{ $student->id }}" @checked(in_array($student->id, old('member_ids', [])))>
                        <span>{{ $student->name }} <small>{{ $student->npm }}</small></span>
                    </label>
                @empty
                    <p class="empty-state">Belum ada mahasiswa terdaftar.</p>
                @endforelse
            </fieldset>
            <button type="submit" class="btn btn-primary">Buat kelompok</button>
        </form>
    </section>

    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Tetapkan dosen pembimbing</h2>
        </div>
        @forelse ($assignableInternships as $internship)
            <form action="{{ route('admin.groups.assign-supervisor', $internship->id) }}" method="POST" class="assignment-row">
                @csrf
                <div class="row-body">
                    <strong>
                        {{ $internship->group_name ? 'Kelompok ' . $internship->group_name : $internship->student_name . ' · ' . $internship->npm }}
                    </strong>
                    <small>{{ $internship->title }} · {{ $internship->status === 'in_progress' ? 'Sedang berjalan' : 'Disetujui' }}</small>
                </div>
                <select class="form-control" name="supervisor_id" required aria-label="Pilih dosen pembimbing">
                    <option value="">Pilih dosen</option>
                    @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }} · {{ $supervisor->nip }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline btn-sm">Tetapkan</button>
            </form>
        @empty
            <div class="empty-state">Belum ada KP disetujui yang dapat ditetapkan pembimbingnya.</div>
        @endforelse
    </section>
</div>

<section class="panel workflow-panel section-gap">
    <div class="panel-title">
        <h2>Kelompok terdaftar</h2>
        <span class="small-badge">{{ $groups->count() }} kelompok</span>
    </div>
    @forelse ($groups as $group)
        <details class="workflow-card">
            <summary>
                <span>
                    <strong>{{ $group->name }}</strong>
                    <small>Ketua: {{ $group->leader_name }} · Pembimbing: {{ $group->supervisor_name ?? 'Belum ditetapkan' }}</small>
                </span>
                <span class="text-link">Lihat anggota</span>
            </summary>
            <ul class="member-list">
                @forelse ($membersByGroup->get($group->id, collect()) as $member)
                    <li>{{ $member->name }} <small>{{ $member->npm }}</small></li>
                @empty
                    <li>Anggota belum ditambahkan.</li>
                @endforelse
            </ul>
        </details>
    @empty
        <div class="empty-state">Belum ada kelompok KP.</div>
    @endforelse
</section>
