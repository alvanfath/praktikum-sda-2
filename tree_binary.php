<?php
class TreeNode
{
    public $value;
    public $left;
    public $right;

    public function __construct($value)
    {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree
{
    private $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function insert($value)
    {
        $this->root = $this->insertRect($this->root, $value);
    }

    private function insertRect($node, $value)
    {
        if ($node == null) {
            return new TreeNode($value);
        }
        if ($value < $node->value) {
            $node->left = $this->insertRect($node->left, $value);
        } else {
            $node->right = $this->insertRect($node->right, $value);
        }
        return $node;
    }

    public function inorder()
    {
        return $this->inorderRec($this->root);
    }

    private function inorderRec($node)
    {
        $result = [];
        if ($node !== null) {
            $result = array_merge($result, $this->inorderRec($node->left));
            $result[] = $node->value;
            $result = array_merge($result, $this->inorderRec($node->right));
        }
        return $result;
    }
}

// Initialize or restore the binary tree from session
session_start();
if (!isset($_SESSION['binary_tree'])) {
    $_SESSION['binary_tree'] = new BinaryTree();
} else {
    $_SESSION['binary_tree'] = unserialize($_SESSION['binary_tree']);
}
$tree = $_SESSION['binary_tree'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $value = (int) $_POST['value'];
    if (!empty($value)) {
        $tree->insert($value);
    }
}

// Save the tree state back to session
$_SESSION['binary_tree'] = serialize($tree);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Tree</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="number"] {
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

        .tree-values {
            margin-top: 20px;
        }

        .tree-values ul {
            padding: 0;
            list-style: none;
        }

        .tree-values ul li {
            background-color: #f8f9fa;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Binary Tree</h1>

        <form method="POST">
            <input type="number" name="value" placeholder="Enter a number to insert" required>
            <button type="submit" name="insert">Tambahkan nomor</button>
        </form>

        <div class="tree-values">
            <h2>Traversal berurutan</h2>
            <ul>
                <?php
                $inorderValues = $tree->inorder();
                if (!empty($inorderValues)) {
                    foreach ($inorderValues as $value) {
                        echo "<li>{$value}</li>";
                    }
                } else {
                    echo "<li>Penyimpanan kosong.</li>";
                }
                ?>
            </ul>
        </div>
    </div>

</body>

</html>