<?php
session_start();

class Stack
{
    private $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function push($item)
    {
        $this->items[] = $item;
    }

    public function pop()
    {
        return array_pop($this->items);
    }

    public function peek()
    {
        return end($this->items);
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function display()
    {
        return $this->items;
    }
}

// Initialize the stack from session
if (!isset($_SESSION['stack'])) {
    $_SESSION['stack'] = [];
}

$stack = new Stack($_SESSION['stack']);

// Handle form actions (push, pop)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['push_value'])) {
        $stack->push($_POST['push_value']);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'pop') {
        $stack->pop();
    }

    // Save the updated stack back to session
    $_SESSION['stack'] = $stack->display();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stack Implementation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            text-align: center;
        }

        .stack {
            margin: 20px 0;
        }

        .stack-item {
            padding: 10px;
            background-color: #f2f2f2;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .empty-stack {
            color: red;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 80%;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }

        button.pop {
            background-color: #d9534f;
        }
    </style>
</head>

<body>
    <h1>Operasi Stack</h1>
    <div class="container">
        <!-- Form to push new value onto the stack -->
        <form method="POST">
            <input type="text" name="push_value" placeholder="Kirim value untuk menambah data" required>
            <button type="submit">Push</button>
        </form>

        <!-- Form to pop the top value -->
        <form method="POST">
            <input type="hidden" name="action" value="pop">
            <button type="submit" class="pop">Pop</button>
        </form>

        <!-- Display the stack -->
        <div class="stack">
            <h2>List Stack:</h2>
            <?php
            $stackItems = $stack->display();
            if ($stack->isEmpty()) {
                echo '<p class="empty-stack">Stack kosong.</p>';
            } else {
                foreach (array_reverse($stackItems) as $item) {
                    echo "<div class='stack-item'>{$item}</div>";
                }
            }
            ?>
        </div>

        <!-- Display the top item of the stack -->
        <?php if (!$stack->isEmpty()): ?>
            <p><strong>Stack Terbaru:</strong> <?php echo $stack->peek(); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>