<?php
class Deque {
    private $items = [];

    public function addFront($item) {
        array_unshift($this->items, $item);
    }

    public function addRear($item) {
        $this->items[] = $item;
    }

    public function removeFront() {
        return array_shift($this->items);
    }

    public function removeRear() {
        return array_pop($this->items);
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function getItems() {
        return $this->items;
    }
}

// Inisialisasi atau restore deque dari session
session_start();
if (!isset($_SESSION['deque'])) {
    $_SESSION['deque'] = new Deque();
} else {
    $_SESSION['deque'] = unserialize($_SESSION['deque']);
}
$deque = $_SESSION['deque'];

// Tangani aksi dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addFront'])) {
        $item = $_POST['item'];
        $deque->addFront($item);
    } elseif (isset($_POST['addRear'])) {
        $item = $_POST['item'];
        $deque->addRear($item);
    } elseif (isset($_POST['removeFront'])) {
        $deque->removeFront();
    } elseif (isset($_POST['removeRear'])) {
        $deque->removeRear();
    }
}

// Simpan deque kembali ke session
$_SESSION['deque'] = serialize($deque);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deque Interaktif</title>
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
        .deque-items {
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
    <h1>Deque Interaktif</h1>

    <!-- Form untuk menambah item di depan atau belakang -->
    <form method="POST">
        <input type="text" name="item" placeholder="Masukkan item" required>
        <button type="submit" name="addFront">Tambah di Depan</button>
        <button type="submit" name="addRear">Tambah di Belakang</button>
    </form>

    <!-- Form untuk menghapus item dari depan atau belakang -->
    <form method="POST">
        <button type="submit" name="removeFront">Hapus dari Depan</button>
        <button type="submit" name="removeRear">Hapus dari Belakang</button>
    </form>

    <!-- Tampilkan item-item deque -->
    <div class="deque-items">
        <h2>Item Deque Saat Ini</h2>
        <ul>
            <?php
            $items = $deque->getItems();
            if (!empty($items)) {
                foreach ($items as $item) {
                    echo "<li>$item</li>";
                }
            } else {
                echo "<li>Deque kosong.</li>";
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>
