<?php
class HashTable
{
    private $table = [];
    public function put($key, $value)
    {
        $hash = $this->hash($key);
        $this->table[$hash] = $value;
    }
    public function get($key)
    {
        $hash = $this->hash($key);
        return $this->table[$hash] ?? null;
    }
    private function hash($key)
    {
        return crc32($key) % 100; // Sederhana, menggunakan CRC32
    }
}
// Penggunaan
$hashTable = new HashTable();
$hashTable->put("name", "Alice");
$hashTable->put("age", 25);
echo $hashTable->get("name") . "\n"; // Output: Alice
echo $hashTable->get("age") . "\n"; // Output: Alice
?>