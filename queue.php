<?php
class Queue
{
    private $items = [];

    public function enqueue($item)
    {
        $this->items[] = $item;
    }

    public function dequeue()   
    {
        return array_shift($this->items);
    }

    public function peek()
    {
        return $this->items[0] ?? null;
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

// Initialize or restore the queue from session
session_start();
if (!isset($_SESSION['queue'])) {
    $_SESSION['queue'] = new Queue();
} else {
    $_SESSION['queue'] = unserialize($_SESSION['queue']);
}
$queue = $_SESSION['queue'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['enqueue'])) {
        $queue->enqueue($_POST['item']);
    } elseif (isset($_POST['dequeue'])) {
        $queue->dequeue();
    }
}

// Save the queue state back to session
$_SESSION['queue'] = serialize($queue);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Example</title>
</head>
<body>
    <h1>Queue Implementation</h1>

    <h2>Add to Queue</h2>
    <form method="POST">
        <input type="text" name="item" placeholder="Enter item" required>
        <button type="submit" name="enqueue">Enqueue</button>
    </form>

    <h2>Queue Operations</h2>
    <form method="POST">
        <button type="submit" name="dequeue">Dequeue</button>
    </form>

    <h2>Current Queue</h2>
    <p>First item in queue (peek): <strong><?php echo $queue->peek() ?: 'None'; ?></strong></p>
    
    <h3>All items in the queue:</h3>
    <ul>
        <?php foreach ($queue->display() as $item): ?>
            <li><?php echo htmlspecialchars($item); ?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
