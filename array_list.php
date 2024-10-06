<?php
session_start(); // Start the session to store list data

class ArrayList
{
    private $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function add($item)
    {
        $this->items[] = $item;
    }

    public function get($index)
    {
        return $this->items[$index] ?? null;
    }

    public function size()
    {
        return count($this->items);
    }

    public function remove($index)
    {
        if (isset($this->items[$index])) {
            array_splice($this->items, $index, 1);
        }
    }

    public function display()
    {
        return $this->items;
    }
}

// Initialize or retrieve the list from session
if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
}

$list = new ArrayList($_SESSION['list']);

// Adding and removing items based on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['item'])) {
        $list->add($_POST['item']);
    }

    if (isset($_POST['remove_index'])) {
        $indexToRemove = (int) $_POST['remove_index'];
        $list->remove($indexToRemove);
    }

    // Save the updated list back to the session
    $_SESSION['list'] = $list->display();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemograman PHP</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>List Array</h1>

    <!-- Form to add a new item -->
    <form method="POST">
        <label for="item">Add Item:</label>
        <input type="text" id="item" name="item" required>
        <button type="submit">Add</button>
    </form>

    <!-- Display the list as a table -->
    <table>
        <tr>
            <th>Index</th>
            <th>Item</th>
            <th>Action</th>
        </tr>
        <?php
        $items = $list->display();
        foreach ($items as $index => $item) {
            echo "<tr>
                    <td>{$index}</td>
                    <td>{$item}</td>
                    <td>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='remove_index' value='{$index}'>
                            <button type='submit'>Remove</button>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>

</html>