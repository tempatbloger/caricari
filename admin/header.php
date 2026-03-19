<?php
// Mendapatkan nama file saat ini untuk menandai menu yang aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    .admin-header {
        background: #1e293b;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .admin-logo {
        font-size: 20px;
        font-weight: bold;
        color: #38bdf8;
        text-decoration: none;
    }
    .admin-nav {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .admin-nav li a {
        display: block;
        padding: 20px 15px;
        color: #cbd5e1;
        text-decoration: none;
        transition: 0.3s;
        font-size: 14px;
    }
    .admin-nav li a:hover {
        background: #334155;
        color: white;
    }
    .admin-nav li a.active {
        background: #2563eb;
        color: white;
        border-bottom: 3px solid #38bdf8;
    }
    .btn-logout {
        background: #ef4444;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
        margin-left: 10px;
    }
</style>

<header class="admin-header">
    <a href="index.php" class="admin-logo">🚀 CariCari V2 <small style="font-size: 10px; color: #94a3b8;">ADMIN</small></a>
    
    <ul class="admin-nav">
        <li><a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">🏠 Dashboard</a></li>
        <li><a href="setting.php" class="<?= ($current_page == 'setting.php') ? 'active' : '' ?>">Pengaturan</a></li>
        <li><a href="list_artikel.php" class="<?= ($current_page == 'list_artikel.php') ? 'active' : '' ?>">📰 List Artikel</a></li>
        <li><a href="tambah_artikel.php" class="<?= ($current_page == 'tambah_artikel.php') ? 'active' : '' ?>">➕ Tambah Data</a></li>
        <li><a href="../index.php" target="_blank" style="color: #fbbf24;">🌐 Lihat Situs</a></li>
    </ul>
</header>
