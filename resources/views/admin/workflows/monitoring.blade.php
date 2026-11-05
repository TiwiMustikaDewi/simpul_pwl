<section class="panel workflow-panel">
    <div class="panel-title">
        <h2>Pelaksanaan KP mahasiswa</h2>
        <span class="small-badge">{{ $internships->count() }} KP</span>
    </div>
    <div class="workflow-table-wrap">
        <table class="workflow-table">
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Perusahaan</th>
                    <th>Periode</th>
                    <th>Pembimbing</th>
                    <th>Status</th>
                    <th>Logbook</th>
                    <th>Laporan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($internships as $internship)
                    <tr>
                        <td data-label="Mahasiswa">
                            {{ $internship->student_name }}
                            <small>{{ $internship->npm }} · {{ $internship->title }}</small>
                        </td>
                        <td data-label="Perusahaan">{{ $internship->company_name }}</td>
                        <td data-label="Periode">{{ $internship->start_date }} – {{ $internship->end_date }}</td>
                        <td data-label="Pembimbing">{{ $internship->supervisor_name ?? 'Belum ditetapkan' }}</td>
                        <td data-label="Status"><span class="status-pill {{ $internship->status }}">{{ str_replace('_', ' ', ucfirst($internship->status)) }}</span></td>
                        <td data-label="Logbook">{{ $internship->log_count }} aktivitas</td>
                        <td data-label="Laporan">{{ $internship->report_count }} laporan</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="table-empty">Belum ada data pelaksanaan KP.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
