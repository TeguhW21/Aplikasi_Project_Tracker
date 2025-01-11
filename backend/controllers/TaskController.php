<?php
require_once '../models/Task.php';

class TaskController
{
    // Menambahkan task baru
    public function addTask($name, $status, $project_id, $bobot)
    {
        Task::addTask($name, $status, $project_id, $bobot);
    }

    // Mendapatkan tasks berdasarkan project
    public function getTasksByProject($project_id)
    {
        return Task::getTasksByProject($project_id);
    }

    // Mengupdate task
    public function updateTask($id, $name, $status, $project_id, $bobot)
    {
        Task::updateTask($id, $name, $status, $project_id, $bobot);
    }

    // Menghapus task
    public function deleteTask($id)
    {
        Task::deleteTask($id);
    }

    public function getTaskById($id)
    {
        return Task::getTaskById($id);
    }
}
