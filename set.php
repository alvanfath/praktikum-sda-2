<?php
class Set
{
    private $elements = [];

    // Menambah elemen ke dalam set jika elemen tersebut belum ada
    public function add($element)
    {
        if (!in_array($element, $this->elements)) {
            $this->elements[] = $element;
        }
    }

    // Mengecek apakah elemen ada di dalam set
    public function contains($element)
    {
        return in_array($element, $this->elements);
    }

    // Menghapus elemen dari set
    public function remove($element)
    {
        $index = array_search($element, $this->elements);
        if ($index !== false) {
            unset($this->elements[$index]);
            $this->elements = array_values($this->elements); // Reindex array
        }
    }

    // Menampilkan elemen-elemen di dalam set
    public function display()
    {
        return $this->elements;
    }
}

// Inisialisasi atau restore Set dari session
session_start();
if (!isset($_SESSION['set'])) {
    $_SESSION['set'] = new Set();
} else {
    $_SESSION['set'] = unserialize($_SESSION['set']);
}
$set = $_SESSION['set'];

// Tangani aksi dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $element = $_POST['element'];
        $set->add($element);
    } elseif (isset($_POST['remove'])) {
        $element = $_POST['element'];
        $set->remove($element);
    }
}

// Simpan kembali ke session
$_SESSION['set'] = serialize($set);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Interaktif</title>
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

        .set-elements {
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
        <h1>Set Interaktif</h1>

        <!-- Form untuk menambah elemen -->
        <form method="POST">
            <input type="text" name="element" placeholder="Masukkan elemen" required>
            <button type="submit" name="add">Tambahkan Elemen</button>
            <button type="submit" name="remove">Hapus Elemen</button>
        </form>

        <!-- Tampilkan elemen-elemen dalam set -->
        <div class="set-elements">
            <h2>Elemen dalam Set</h2>
            <ul>
                <?php
                $elements = $set->display();
                if (!empty($elements)) {
                    foreach ($elements as $element) {
                        echo "<li>{$element}</li>";
                    }
                } else {
                    echo "<li>Set kosong.</li>";
                }
                ?>
            </ul>
        </div>
    </div>

</body>

</html>