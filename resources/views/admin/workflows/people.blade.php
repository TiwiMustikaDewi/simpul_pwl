<section class="panel workflow-panel">
    <div class="panel-title">
        <h2>Pengguna terdaftar</h2>
        <span class="small-badge">{{ $people->count() }} pengguna</span>
    </div>

    <div class="workflow-table-wrap">
        <table class="workflow-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Peran</th>
                    <th>NPM / NIP</th>
                    <th>Program Studi / Departemen</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($people as $person)
                    <tr>
                        <td data-label="Nama">{{ $person->name }}</td>
                        <td data-label="Peran">{{ $person->role === 'student' ? 'Mahasiswa' : 'Dosen Pembimbing' }}</td>
                        <td data-label="NPM / NIP">{{ $person->npm ?? $person->nip ?? '—' }}</td>
                        <td data-label="Program Studi / Departemen">{{ $person->major ?? $person->department ?? '—' }}</td>
                        <td data-label="Email">{{ $person->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table-empty">Belum ada data mahasiswa atau dosen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
