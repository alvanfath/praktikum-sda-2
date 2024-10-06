<?php
class Map {
    private $elements = [];

    // Menambahkan pasangan kunci dan nilai ke dalam map
    public function put($key, $value) {
        $this->elements[$key] = $value;
    }

    // Mengambil nilai berdasarkan kunci dari map
    public function get($key) {
        return $this->elements[$key] ?? null;
    }

    // Menghapus pasangan kunci dan nilai dari map
    public function remove($key) {
        unset($this->elements[$key]);
    }

    // Menampilkan semua pasangan kunci dan nilai di dalam map
    public function display() {
        return $this->elements;
    }
}

// Inisialisasi atau restore Map dari session
session_start();
if (!isset($_SESSION['map'])) {
    $_SESSION['map'] = new Map();
} else {
    $_SESSION['map'] = unserialize($_SESSION['map']);
}
$map = $_SESSION['map'];

// Tangani aksi dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['put'])) {
        $key = $_POST['key'];
        $value = $_POST['value'];
        $map->put($key, $value);
    } elseif (isset($_POST['get'])) {
        $key = $_POST['key'];
        $value = $map->get($key);
        echo "<script>alert('Nilai untuk kunci \"$key\": $value');</script>";
    } elseif (isset($_POST['remove'])) {
        $key = $_POST['key'];
        $map->remove($key);
    }
}

// Simpan kembali ke session
$_SESSION['map'] = serialize($map);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Interaktif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            width: calc(100% - 22px);
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .map-elements {
            margin-top: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 8px;
            background-color: #f8f9fa;
            margin-bottom: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Map Interaktif</h1>

    <!-- Form untuk menambah, mengambil, atau menghapus pasangan kunci-nilai -->
    <form method="POST">
        <input type="text" name="key" placeholder="Masukkan kunci" required>
        <input type="text" name="value" placeholder="Masukkan nilai (untuk Tambah)" >
        <button type="submit" name="put">Tambahkan</button>
        <button type="submit" name="get">Ambil Nilai</button>
        <button type="submit" name="remove">Hapus</button>
    </form>

    <!-- Tampilkan pasangan kunci-nilai dalam map -->
    <div class="map-elements">
        <h2>Pasangan Kunci-Nilai dalam Map</h2>
        <ul>
            <?php
            $elements = $map->display();
            if (!empty($elements)) {
                foreach ($elements as $key => $value) {
                    echo "<li><strong>$key:</strong> $value</li>";
                }
            } else {
                echo "<li>Map kosong.</li>";
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>
