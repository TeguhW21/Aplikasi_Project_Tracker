<?php
require_once '../config/db.php';
class Project
{
    public $id;
    public $name;
    public $status;
    public $completion_progress;

    // Menambahkan project baru
    public static function addProject($name)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("INSERT INTO projects (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
    }

    // Mendapatkan semua project
    public static function getProjects()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->query("SELECT * FROM projects");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getProjectsJoinTask()
    {
        $db = new Database();
        $pdo = $db->getConnection();

        // Query untuk menggabungkan proyek dengan task
        $stmt = $pdo->query("SELECT 
                            projects.id, 
                            projects.name as project_name, 
                            projects.status as project_status, 
                            projects.completion_progress, 
                            tasks.id as task_id,
                            tasks.name as task_name, 
                            tasks.status as task_status,
                            tasks.project_id,
                            tasks.bobot
                          FROM projects 
                          LEFT JOIN tasks ON tasks.project_id = projects.id");

        // Ambil semua hasil sebagai array objek
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Mendapatkan project berdasarkan ID
    public static function getProjectsById($id)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Mengupdate project
    public static function updateProject($id, $name)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("UPDATE projects SET name = :name WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name]);
    }

    // Menghapus project
    public static function deleteProject($id)
    {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    // Menghitung completion progress dan status project berdasarkan task
    public static function updateCompletionAndStatus($project_id)
    {
        $db = new Database();
        $pdo = $db->getConnection();

        // Ambil task progress (total bobot dan bobot yang selesai)
        $taskProgress = Task::getTaskProgress($project_id);
        $totalBobot = $taskProgress->total_bobot;
        $completedBobot = $taskProgress->completed_bobot;

        // Menghitung completion progress
        $completionProgress = $totalBobot > 0 ? ($completedBobot / $totalBobot) * 100 : 0;

        // Menentukan status project berdasarkan status task
        $stmt = $pdo->prepare("SELECT DISTINCT status FROM tasks WHERE project_id = :project_id");
        $stmt->execute(['project_id' => $project_id]);
        $taskStatuses = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (in_array('in_progress', $taskStatuses)) {
            $projectStatus = 'in_progress';
        } elseif (in_array('draft', $taskStatuses)) {
            $projectStatus = 'draft';
        } else {
            $projectStatus = 'done';
        }

        // Update project dengan completion progress dan status
        $stmt = $pdo->prepare("UPDATE projects SET completion_progress = :completion_progress, status = :status WHERE id = :project_id");
        $stmt->execute(['completion_progress' => $completionProgress, 'status' => $projectStatus, 'project_id' => $project_id]);
    }
}
