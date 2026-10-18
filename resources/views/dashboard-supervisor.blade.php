<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen | SIMPUL</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6fb; color: #24324a; }
        header { padding: 22px 7%; background: #315b48; color: white; display: flex; justify-content: space-between; align-items: center; gap: 15px; }
        main { padding: 35px 7%; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 20px; margin-top: 28px; }
        .card { background: white; padding: 24px; border-radius: 14px; box-shadow: 0 4px 18px #172b4d0d; }
        button { padding: 10px 16px; border: 0; border-radius: 8px; cursor: pointer; }
        .logout { background: white; color: #315b48; }
    </style>
</head>
<body>
    <header>
        <div><strong>SIMPUL</strong><div>Dosen Pembimbing</div></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout" type="submit">Logout</button>
        </form>
    </header>

    <main>
        <h1>Dashboard Dosen Pembimbing</h1>
        <p>Halo, {{ auth()->user()->name }}!</p>
        <p>Email: {{ auth()->user()->email }}</p>

        <div class="cards">
            <section class="card"><h3>Mahasiswa Bimbingan</h3><p>Pantau mahasiswa yang menjadi bimbingan.</p></section>
            <section class="card"><h3>Logbook KP</h3><p>Periksa aktivitas dan logbook mahasiswa.</p></section>
            <section class="card"><h3>Laporan KP</h3><p>Periksa laporan Kuliah Praktik.</p></section>
            <section class="card"><h3>Monitoring KP</h3><p>Pantau perkembangan pelaksanaan KP.</p></section>
        </div>
    </main>
</body>
</html>
