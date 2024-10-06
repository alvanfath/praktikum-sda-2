<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Search Tree - Inorder Traversal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Inorder Traversal of Binary Search Tree</h1>

    <?php
    // Definisi kelas TreeNode yang merepresentasikan setiap node dalam BST
    class TreeNode {
        public $value; // Nilai dari node
        public $left;  // Referensi ke subtree kiri
        public $right; // Referensi ke subtree kanan

        // Constructor untuk menginisialisasi node baru
        public function __construct($value) {
            $this->value = $value;
            $this->left = null;
            $this->right = null;
        }
    }

    // Definisi kelas BST (Binary Search Tree)
    class BST {
        private $root; // Root dari tree

        // Constructor untuk menginisialisasi tree
        public function __construct() {
            $this->root = null;
        }

        // Fungsi untuk memasukkan nilai ke dalam tree
        public function insert($value) {
            $this->root = $this->insertRec($this->root, $value);
        }

        // Fungsi rekursif untuk memasukkan nilai
        private function insertRec($node, $value) {
            if ($node === null) {
                return new TreeNode($value); // Buat node baru jika belum ada
            }

            if ($value < $node->value) {
                $node->left = $this->insertRec($node->left, $value); // Masukkan ke subtree kiri
            } else {
                $node->right = $this->insertRec($node->right, $value); // Masukkan ke subtree kanan
            }

            return $node; // Kembalikan node setelah modifikasi
        }

        // Fungsi untuk menampilkan tree dalam urutan inorder (kiri-root-kanan)
        public function inorder() {
            return $this->inorderRec($this->root);
        }

        // Fungsi rekursif untuk inorder traversal
        private function inorderRec($node) {
            $result = [];
            if ($node !== null) {
                $result = array_merge($result, $this->inorderRec($node->left)); // Kunjungi subtree kiri
                $result[] = $node->value; // Kunjungi node root
                $result = array_merge($result, $this->inorderRec($node->right)); // Kunjungi subtree kanan
            }
            return $result; // Kembalikan array hasil traversal
        }
    }

    // Penggunaan BST
    $bst = new BST(); // Membuat instance dari BST
    $bst->insert(15); // Masukkan nilai 15
    $bst->insert(10); // Masukkan nilai 10
    $bst->insert(20); // Masukkan nilai 20

    // Ambil hasil inorder traversal
    $inorderResult = $bst->inorder();

    // Tampilkan hasil dalam bentuk tabel
    echo '<table>';
    echo '<tr><th>Node Value</th></tr>';
    foreach ($inorderResult as $value) {
        echo "<tr><td>{$value}</td></tr>";
    }
    echo '</table>';
    ?>

</body>
</html>
