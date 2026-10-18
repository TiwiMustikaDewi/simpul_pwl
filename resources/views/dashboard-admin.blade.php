<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SIMPUL</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6fb; color: #24324a; }
        header { padding: 22px 7%; background: #173b67; color: white; display: flex; justify-content: space-between; align-items: center; gap: 15px; }
        main { padding: 35px 7%; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 20px; margin-top: 28px; }
        .card { background: white; padding: 24px; border-radius: 14px; box-shadow: 0 4px 18px #172b4d0d; }
        button { padding: 10px 16px; border: 0; border-radius: 8px; cursor: pointer; }
        .logout { background: white; color: #173b67; }
    </style>
</head>
<body>
    <header>
        <div><strong>SIMPUL</strong><div>Admin Jurusan</div></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout" type="submit">Logout</button>
        </form>
    </header>

    <main>
        <h1>Dashboard Admin Jurusan</h1>
        <p>Halo, {{ auth()->user()->name }}!</p>
        <p>Email: {{ auth()->user()->email }}</p>

        <div class="cards">
            <section class="card"><h3>Data Mahasiswa</h3><p>Kelola data mahasiswa peserta KP.</p></section>
            <section class="card"><h3>Verifikasi Pengajuan</h3><p>Periksa pengajuan dan dokumen KP.</p></section>
            <section class="card"><h3>Data Dosen</h3><p>Kelola data dosen pembimbing.</p></section>
            <section class="card"><h3>Dokumen KP</h3><p>Pantau kelengkapan dokumen KP.</p></section>
        </div>
    </main>
</body>
</html>
