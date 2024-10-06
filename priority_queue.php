<?php
class PriorityQueue {
    private $items = [];

    public function enqueue($item, $priority) {
        $this->items[] = ["item" => $item, "priority" => $priority];
        usort($this->items, function($a, $b) {
            return $b['priority'] - $a['priority'];
        });
    }

    public function dequeue() {
        return array_shift($this->items)['item'];
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function getItems() {
        return $this->items;
    }
}

// Inisialisasi atau restore priority queue dari session
session_start();
if (!isset($_SESSION['priorityQueue'])) {
    $_SESSION['priorityQueue'] = new PriorityQueue();
} else {
    $_SESSION['priorityQueue'] = unserialize($_SESSION['priorityQueue']);
}
$priorityQueue = $_SESSION['priorityQueue'];

// Tangani aksi dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['enqueue'])) {
        $item = $_POST['item'];
        $priority = $_POST['priority'];
        $priorityQueue->enqueue($item, $priority);
    } elseif (isset($_POST['dequeue'])) {
        $priorityQueue->dequeue();
    }
}

// Simpan kembali ke session
$_SESSION['priorityQueue'] = serialize($priorityQueue);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Priority Queue Interaktif</title>
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
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: calc(100% - 22px);
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .queue-items {
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
    <h1>Priority Queue Interaktif</h1>

    <!-- Form untuk menambah item dengan prioritas -->
    <form method="POST">
        <input type="text" name="item" placeholder="Masukkan item" required>
        <input type="number" name="priority" placeholder="Masukkan prioritas" required>
        <button type="submit" name="enqueue">Tambahkan dengan Prioritas</button>
    </form>

    <!-- Form untuk menghapus item dengan prioritas tertinggi -->
    <form method="POST">
        <button type="submit" name="dequeue">Hapus Item Prioritas Tertinggi</button>
    </form>

    <!-- Tampilkan item-item queue dengan prioritas -->
    <div class="queue-items">
        <h2>Item dalam Priority Queue</h2>
        <ul>
            <?php
            $items = $priorityQueue->getItems();
            if (!empty($items)) {
                foreach ($items as $entry) {
                    echo "<li>{$entry['item']} (Prioritas: {$entry['priority']})</li>";
                }
            } else {
                echo "<li>Queue kosong.</li>";
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>
