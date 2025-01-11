<?php
require_once '../config/db.php';
class Task
{
    public $id;
    public $name;
    public $status;
    public $project_id;
    public $bobot;

    // Menambahkan task baru
    public static function addTask($name, $status, $project_id, $bobot)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("INSERT INTO tasks (name, status, project_id, bobot) VALUES (:name, :status, :project_id, :bobot)");
        $stmt->execute(['name' => $name, 'status' => $status, 'project_id' => $project_id, 'bobot' => $bobot]);
    }

    // Mendapatkan tasks berdasarkan project_id
    public static function getTasksByProject($project_id)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE project_id = :project_id");
        $stmt->execute(['project_id' => $project_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Mendapatkan task berdasarkan ID
    public static function getTaskById($id)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Mengupdate status task
    public static function updateTask($id, $name, $status, $project_id, $bobot)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("UPDATE tasks SET name = :name, status = :status, project_id = :project_id, bobot = :bobot WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'status' => $status, 'project_id' => $project_id, 'bobot' => $bobot]);
    }

    // Menghapus task
    public static function deleteTask($id)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    // Mendapatkan total bobot task dan bobot task yang sudah selesai
    public static function getTaskProgress($project_id)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("SELECT SUM(bobot) as total_bobot, SUM(CASE WHEN status = 'done' THEN bobot ELSE 0 END) as completed_bobot FROM tasks WHERE project_id = :project_id");
        $stmt->execute(['project_id' => $project_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
