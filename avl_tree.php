<?php 

class AVLTreeNode { 
    public mixed $value; 
    public ?AVLTreeNode $left; 
    public ?AVLTreeNode $right; 
    public int $height; 

    public function __construct(mixed $value) { 
        $this->value = $value; 
        $this->left = null; 
        $this->right = null; 
        $this->height = 1; 
    } 
} 

class AVLTree { 
    private ?AVLTreeNode $root; 

    public function __construct() { 
        $this->root = null; 
    } 

    public function insert(mixed $value): void { 
        $this->root = $this->insertRec($this->root, $value); 
    } 

    private function insertRec(?AVLTreeNode $node, mixed $value): AVLTreeNode { 
        if ($node === null) { 
            return new AVLTreeNode($value); 
        } 

        if ($value < $node->value) { 
            $node->left = $this->insertRec($node->left, $value); 
        } else { 
            $node->right = $this->insertRec($node->right, $value); 
        } 

        // Update height
        $node->height = 1 + max($this->getHeight($node->left), $this->getHeight($node->right)); 

        // Balance the node
        return $this->balance($node); 
    } 

    private function balance(?AVLTreeNode $node): ?AVLTreeNode { 
        $balance = $this->getBalanceFactor($node); 

        // Left Left Case
        if ($balance > 1 && $this->getBalanceFactor($node->left) >= 0) { 
            return $this->rotateRight($node); 
        } 

        // Left Right Case
        if ($balance > 1 && $this->getBalanceFactor($node->left) < 0) { 
            $node->left = $this->rotateLeft($node->left); 
            return $this->rotateRight($node); 
        } 

        // Right Right Case
        if ($balance < -1 && $this->getBalanceFactor($node->right) <= 0) { 
            return $this->rotateLeft($node); 
        } 

        // Right Left Case
        if ($balance < -1 && $this->getBalanceFactor($node->right) > 0) { 
            $node->right = $this->rotateRight($node->right); 
            return $this->rotateLeft($node); 
        } 

        return $node; 
    } 

    private function rotateLeft(AVLTreeNode $node): AVLTreeNode { 
        $newRoot = $node->right; 
        $node->right = $newRoot->left; 
        $newRoot->left = $node; 

        // Update heights
        $node->height = 1 + max($this->getHeight($node->left), $this->getHeight($node->right)); 
        $newRoot->height = 1 + max($this->getHeight($newRoot->left), $this->getHeight($newRoot->right)); 

        return $newRoot; 
    } 

    private function rotateRight(AVLTreeNode $node): AVLTreeNode { 
        $newRoot = $node->left; 
        $node->left = $newRoot->right; 
        $newRoot->right = $node; 

        // Update heights
        $node->height = 1 + max($this->getHeight($node->left), $this->getHeight($node->right)); 
        $newRoot->height = 1 + max($this->getHeight($newRoot->left), $this->getHeight($newRoot->right)); 

        return $newRoot; 
    } 

    private function getHeight(?AVLTreeNode $node): int { 
        return $node ? $node->height : 0; 
    } 

    private function getBalanceFactor(?AVLTreeNode $node): int { 
        return $node ? $this->getHeight($node->left) - $this->getHeight($node->right) : 0; 
    } 

    public function inorder(): array { 
        return $this->inorderRec($this->root); 
    } 

    private function inorderRec(?AVLTreeNode $node): array { 
        $result = []; 
        if ($node !== null) { 
            $result = array_merge($result, $this->inorderRec($node->left)); 
            $result[] = $node->value; 
            $result = array_merge($result, $this->inorderRec($node->right)); 
        } 
        return $result; 
    } 
} 

// Penggunaan 
$avlTree = new AVLTree(); 
$avlTree->insert(10); 
$avlTree->insert(20); 
$avlTree->insert(30); // Menyebabkan rotasi 
print_r($avlTree->inorder()); // Output: Array ( [0] => 10 [1] => 20 [2] => 30 ) 

?>
