<?php
class Graph {
    private $adjacencyList = [];

    // Add a vertex to the graph
    public function addVertex($vertex) {
        if (!isset($this->adjacencyList[$vertex])) {
            $this->adjacencyList[$vertex] = [];
        }
    }

    // Add an edge between two vertices
    public function addEdge($vertex1, $vertex2) {
        $this->adjacencyList[$vertex1][] = $vertex2;
        $this->adjacencyList[$vertex2][] = $vertex1; // For undirected graph
    }

    // Get adjacency list
    public function getAdjacencyList() {
        return $this->adjacencyList;
    }
}

// Initialize or restore graph from session
session_start();
if (!isset($_SESSION['graph'])) {
    $_SESSION['graph'] = new Graph();
} else {
    $_SESSION['graph'] = unserialize($_SESSION['graph']);
}
$graph = $_SESSION['graph'];

// Handle form submissions to add vertices and edges
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['vertex'])) {
        $vertex = $_POST['vertex'];
        $graph->addVertex($vertex);
    }
    if (isset($_POST['vertex1']) && isset($_POST['vertex2'])) {
        $vertex1 = $_POST['vertex1'];
        $vertex2 = $_POST['vertex2'];
        $graph->addEdge($vertex1, $vertex2);
    }
}

// Save graph state back to session
$_SESSION['graph'] = serialize($graph);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph Adjacency List</title>
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
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .adjacency-list {
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
    <h1>Graph Adjacency List</h1>

    <!-- Form to add a vertex -->
    <form method="POST">
        <input type="text" name="vertex" placeholder="Enter a vertex" required>
        <button type="submit">Add Vertex</button>
    </form>

    <!-- Form to add an edge -->
    <form method="POST">
        <input type="text" name="vertex1" placeholder="Enter first vertex" required>
        <input type="text" name="vertex2" placeholder="Enter second vertex" required>
        <button type="submit">Add Edge</button>
    </form>

    <!-- Display Adjacency List -->
    <div class="adjacency-list">
        <h2>Adjacency List</h2>
        <ul>
            <?php
            $adjacencyList = $graph->getAdjacencyList();
            if (!empty($adjacencyList)) {
                foreach ($adjacencyList as $vertex => $edges) {
                    echo "<li>{$vertex} => " . implode(', ', $edges) . "</li>";
                }
            } else {
                echo "<li>The graph is empty.</li>";
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>
