<div class="workflow-grid">
    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Tambah perusahaan</h2>
        </div>

        <form action="{{ route('admin.companies.store') }}" method="POST" class="workflow-form">
            @csrf
            <div class="form-grid">
                <label class="form-field">
                    <span>Nama perusahaan / instansi</span>
                    <input class="form-control" type="text" name="name" value="{{ old('name') }}" required maxlength="255">
                </label>
                <label class="form-field">
                    <span>Kota</span>
                    <input class="form-control" type="text" name="city" value="{{ old('city') }}" required maxlength="255">
                </label>
                <label class="form-field form-field-wide">
                    <span>Alamat</span>
                    <textarea class="form-control" name="address" rows="3" required maxlength="5000">{{ old('address') }}</textarea>
                </label>
                <label class="form-field">
                    <span>Kontak person</span>
                    <input class="form-control" type="text" name="contact_person" value="{{ old('contact_person') }}" maxlength="255">
                </label>
                <label class="form-field">
                    <span>Nomor telepon</span>
                    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" maxlength="50">
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Tambah perusahaan</button>
        </form>
    </section>

    <section class="panel workflow-panel">
        <div class="panel-title">
            <h2>Daftar perusahaan</h2>
            <span class="small-badge">{{ $companies->count() }} perusahaan</span>
        </div>

        @forelse ($companies as $company)
            <details class="workflow-card">
                <summary>
                    <span>
                        <strong>{{ $company->name }}</strong>
                        <small>{{ $company->city }} · {{ $company->internship_count }} pengajuan KP</small>
                    </span>
                    <span class="text-link">Edit</span>
                </summary>
                <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" class="workflow-form">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <label class="form-field">
                            <span>Nama perusahaan / instansi</span>
                            <input class="form-control" type="text" name="name" value="{{ $company->name }}" required maxlength="255">
                        </label>
                        <label class="form-field">
                            <span>Kota</span>
                            <input class="form-control" type="text" name="city" value="{{ $company->city }}" required maxlength="255">
                        </label>
                        <label class="form-field form-field-wide">
                            <span>Alamat</span>
                            <textarea class="form-control" name="address" rows="3" required maxlength="5000">{{ $company->address }}</textarea>
                        </label>
                        <label class="form-field">
                            <span>Kontak person</span>
                            <input class="form-control" type="text" name="contact_person" value="{{ $company->contact_person }}" maxlength="255">
                        </label>
                        <label class="form-field">
                            <span>Nomor telepon</span>
                            <input class="form-control" type="text" name="phone" value="{{ $company->phone }}" maxlength="50">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-outline">Simpan perubahan</button>
                </form>
            </details>
        @empty
            <div class="empty-state">Belum ada perusahaan yang terdaftar.</div>
        @endforelse
    </section>
</div>
