<?php
include '../includes/config.php';
include 'header.php';

// 1. Hitung Total Artikel
$resArtikel = mysqli_query($conn, "SELECT COUNT(*) as total FROM artikel");
$totalArtikel = mysqli_fetch_assoc($resArtikel)['total'];

// 2. Hitung Total Situs (Domain Unik)
$resSitus = mysqli_query($conn, "SELECT COUNT(*) as total FROM situs");
$totalSitus = mysqli_fetch_assoc($resSitus)['total'];

// 3. Hitung Total Ekstensi
$resExt = mysqli_query($conn, "SELECT COUNT(*) as total FROM ekstensi");
$totalExt = mysqli_fetch_assoc($resExt)['total'];

// 4. Statistik Persebaran Ekstensi (Query Agregasi)
$sqlStat = "SELECT e.nama_ext, COUNT(s.id_situs) as jumlah_situs 
            FROM ekstensi e 
            LEFT JOIN situs s ON e.id_ext = s.id_ext 
            GROUP BY e.id_ext";
$resStat = mysqli_query($conn, $sqlStat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - CariCari V2</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; }
        .grid { display: grid; grid-template-columns: repeat(3, 1-fr); gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .card h3 { margin: 0; color: #666; font-size: 14px; text-transform: uppercase; }
        .card .number { font-size: 32px; font-weight: bold; color: #2563eb; margin: 10px 0; }
        
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #2563eb; color: white; }
        tr:hover { background: #f9fafb; }
        
        .btn { display: inline-block; padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .btn:hover { background: #1d4ed8; }
    </style>
</head>
<body>

<div class="container">
    <h1>📊 Dashboard Admin CariCari <small>V2</small></h1>
    
    <a href="tambah_artikel.php" class="btn">+ Tambah Artikel Baru</a>

    <div class="grid" style="display: flex; gap: 20px;">
        <div class="card" style="flex: 1;">
            <h3>Total Artikel</h3>
            <div class="number"><?= number_format($totalArtikel) ?></div>
            <p>Halaman terindeks</p>
        </div>
        <div class="card" style="flex: 1;">
            <h3>Total Situs</h3>
            <div class="number"><?= number_format($totalSitus) ?></div>
            <p>Domain unik</p>
        </div>
        <div class="card" style="flex: 1;">
            <h3>Ekstensi</h3>
            <div class="number"><?= number_format($totalExt) ?></div>
            <p>Jenis TLD (.id, .com, dll)</p>
        </div>
    </div>

    <h3>📈 Persebaran Domain per Ekstensi</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Ekstensi</th>
                <th>Jumlah Situs Terdaftar</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($resStat)): 
                $persen = ($totalSitus > 0) ? ($row['jumlah_situs'] / $totalSitus) * 100 : 0;
            ?>
            <tr>
                <td><b><?= $row['nama_ext'] ?></b></td>
                <td><?= $row['jumlah_situs'] ?> Situs</td>
                <td>
                    <div style="background: #e5e7eb; width: 100px; height: 10px; border-radius: 5px; display: inline-block;">
                        <div style="background: #2563eb; width: <?= $persen ?>%; height: 10px; border-radius: 5px;"></div>
                    </div>
                    <span style="font-size: 12px;"><?= round($persen, 1) ?>%</span>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
