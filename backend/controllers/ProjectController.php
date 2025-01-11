<?php
require_once '../models/Project.php';

class ProjectController
{
    // Menambahkan project baru
    public function addProject($name)
    {
        Project::addProject($name);
    }

    // Mendapatkan semua project
    public function getProjects()
    {
        return Project::getProjects();
    }

    public function getProjectsJoinTask()
    {
        return Project::getProjectsJoinTask();
    }

    // Mengupdate project
    public function updateProject($id, $name)
    {
        Project::updateProject($id, $name);
    }

    // Menghapus project
    public function deleteProject($id)
    {
        Project::deleteProject($id);
    }

    // Mengupdate completion dan status project
    public function updateCompletionAndStatus($project_id)
    {
        Project::updateCompletionAndStatus($project_id);
    }

    public function getProjectsById($id)
    {
        return Project::getProjectsById($id);
    }
}
