<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Nilai</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 5px; }
        h3 { text-align: center; font-size: 14px; margin-top: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #0D6EFD; color: white; }
        .nilai { text-align: center; }
        .rata { font-weight: bold; text-align: center; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <h1>LAPORAN NILAI SISWA</h1>
    <h3>Media Pembelajaran Informatika - SMKN 1 Sintuk Toboh Gadang</h3>

    <table>
        <tr><td><strong>Nama:</strong></td><td>{{ $siswa->user->name }}</td></tr>
        <tr><td><strong>NIS:</strong></td><td>{{ $siswa->nis }}</td></tr>
        <tr><td><strong>Kelas:</strong></td><td>{{ $siswa->kelas->nama_kelas }}</td></tr>
    </table>

    <h4>Nilai Tugas</h4>
    <table>
        <thead><tr><th>No</th><th>Tugas</th><th>Nilai</th></tr></thead>
        <tbody>
            @forelse($nilaiTugas as $i => $n)
                <tr><td>{{ $i + 1 }}</td><td>{{ $n->tugas->judul }}</td><td class="nilai">{{ $n->nilai }}</td></tr>
            @empty
                <tr><td colspan="3" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
            <tr><td colspan="2" class="rata">Rata-rata Tugas</td><td class="nilai">{{ $rataTugas ? number_format($rataTugas, 1) : '-' }}</td></tr>
        </tbody>
    </table>

    <h4>Nilai Kuis</h4>
    <table>
        <thead><tr><th>No</th><th>Kuis</th><th>Nilai</th></tr></thead>
        <tbody>
            @forelse($nilaiKuis as $i => $n)
                <tr><td>{{ $i + 1 }}</td><td>{{ $n->kuis->judul }}</td><td class="nilai">{{ $n->nilai }}</td></tr>
            @empty
                <tr><td colspan="3" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
            <tr><td colspan="2" class="rata">Rata-rata Kuis</td><td class="nilai">{{ $rataKuis ? number_format($rataKuis, 1) : '-' }}</td></tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i') }}<br>
        &copy; Media Pembelajaran Informatika - SMK Negeri 1 Sintuk Toboh Gadang
    </div>
</body>
</html>
