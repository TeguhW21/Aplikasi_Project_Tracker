<?php
// Konfigurasi
class Database
{
    private $host = 'localhost';
    private $dbname = 'db_project_task';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct()
    {
        try {
            // Membuat koneksi ke database
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi ke database gagal: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function closeConnection()
    {
        $this->pdo = null;
    }
}
