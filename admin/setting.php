<?php
include '../includes/config.php';

$pesan = "";

if (isset($_POST['update_setting'])) {
    $nama    = mysqli_real_escape_string($conn, $_POST['nama_website']);
    $slogan  = mysqli_real_escape_string($conn, $_POST['slogan']);
    $footer  = mysqli_real_escape_string($conn, $_POST['footer_text']);
    $url_base = mysqli_real_escape_string($conn, $_POST['url_base']);
    $email   = mysqli_real_escape_string($conn, $_POST['email_kontak']);
    
    $update_fields = "nama_website = '$nama', slogan = '$slogan', footer_text = '$footer', url_base = '$url_base', email_kontak = '$email'";

    $target_dir = "../assets/img/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    // LOGIKA UPLOAD LOGO
    if ($_FILES['logo']['name'] != "") {
        $logo_name = "logo_" . time() . "_" . $_FILES["logo"]["name"];
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_dir . $logo_name)) {
            $update_fields .= ", logo_path = '$logo_name'";
        }
    }

    // LOGIKA UPLOAD FAVICON
    if ($_FILES['favicon']['name'] != "") {
        $fav_name = "fav_" . time() . "_" . $_FILES["favicon"]["name"];
        if (move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_dir . $fav_name)) {
            $update_fields .= ", favicon_path = '$fav_name'";
        }
    }

    $sql = "UPDATE setting SET $update_fields WHERE id_setting = 1";

    if (mysqli_query($conn, $sql)) {
        header("Location: setting.php?pesan=sukses");
        exit;
    } else {
        $pesan = "<div class='alert error'>Gagal: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Lengkap - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; }
        .container-box { max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; }
        input[type="text"], input[type="url"], input[type="email"], input[type="file"] {
            width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box;
        }
        .btn-save { background: #2563eb; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; }
        .preview-img { max-width: 80px; display: block; margin-bottom: 10px; border: 1px solid #ddd; padding: 5px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; background: #dcfce7; color: #166534; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-box">
    <h2>⚙️ Pengaturan Website</h2>
    <?php if(isset($_GET['pesan'])) echo "<div class='alert'>✅ Perubahan berhasil disimpan!</div>"; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Website & Slogan</label>
            <input type="text" name="nama_website" value="<?= $set['nama_website'] ?>" placeholder="Nama Web" style="margin-bottom:10px;">
            <input type="text" name="slogan" value="<?= $set['slogan'] ?>" placeholder="Slogan">
        </div>

        <div class="form-group">
            <label>Email Kontak</label>
            <input type="email" name="email_kontak" value="<?= $set['email_kontak'] ?>" placeholder="admin@domain.com">
        </div>

        <div class="form-group">
            <label>URL Dasar Website</label>
            <input type="url" name="url_base" value="<?= $set['url_base'] ?>">
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label>Logo Utama</label>
                <?php if($set['logo_path']): ?>
                    <img src="../assets/img/<?= $set['logo_path'] ?>" class="preview-img">
                <?php endif; ?>
                <input type="file" name="logo">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Favicon (Ikon Tab)</label>
                <?php if($set['favicon_path']): ?>
                    <img src="../assets/img/<?= $set['favicon_path'] ?>" style="width: 32px; height:32px; margin-bottom:10px;">
                <?php endif; ?>
                <input type="file" name="favicon">
            </div>
        </div>

        <div class="form-group">
            <label>Teks Footer</label>
            <input type="text" name="footer_text" value="<?= $set['footer_text'] ?>">
        </div>

        <button type="submit" name="update_setting" class="btn-save">💾 Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
