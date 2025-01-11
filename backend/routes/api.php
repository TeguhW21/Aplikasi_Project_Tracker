<?php
require_once '../controllers/ProjectController.php';
require_once '../controllers/TaskController.php';

// Inisialisasi Controller
$projectController = new ProjectController();
$taskController = new TaskController();

// Fungsi untuk mengirimkan response JSON
function sendJsonResponse($message, $statusCode = 200)
{
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($message);
    exit; // Menghentikan eksekusi setelah mengirim response
}

// Add Project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add_project') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Pastikan data project yang diterima valid
    if (isset($data['name'])) {
        $projectController->addProject($data['name']);
        sendJsonResponse(['message' => 'Project added successfully']);
    } else {
        sendJsonResponse(['error' => 'Project name is required'], 400);
    }
}

// Get Projects
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_projects') {
    $projects = $projectController->getProjects();
    sendJsonResponse($projects);
}
// Get Projects join Task
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_projects_task') {
    $projects = $projectController->getProjectsJoinTask();
    sendJsonResponse($projects);
}

// Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add_task') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validasi data task
    if (isset($data['name'], $data['status'], $data['project_id'], $data['bobot'])) {
        $taskController->addTask($data['name'], $data['status'], $data['project_id'], $data['bobot']);
        sendJsonResponse(['message' => 'Task added successfully']);
    } else {
        sendJsonResponse(['error' => 'Missing required task data'], 400);
    }
}

// Get Tasks by Project
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_tasks') {
    if (isset($_GET['project_id'])) {
        $project_id = $_GET['project_id'];
        $tasks = $taskController->getTasksByProject($project_id);
        sendJsonResponse($tasks);
    } else {
        sendJsonResponse(['error' => 'Project ID is required'], 400);
    }
}

// Endpoint untuk mendapatkan task berdasarkan ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_task') {
    $taskId = $_GET['id'];
    $taskController = new TaskController();
    $task = $taskController->getTaskById($taskId);
    if ($task) {
        echo json_encode($task);
    } else {
        echo json_encode(['error' => 'Task not found']);
    }
}

// Endpoint untuk mendapatkan task berdasarkan ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_project') {
    $projectsId = $_GET['id'];
    $projectsController = new ProjectController();
    $projects = $projectsController->getProjectsById($projectsId);
    if ($projects) {
        echo json_encode($projects);
    } else {
        echo json_encode(['error' => 'Task not found']);
    }
}


// Update Project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update_project') {
    $projectId = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);

    // Validasi data yang dikirimkan
    if (isset($data['name'])) {
        $projectController = new ProjectController();
        $projectController->updateProject($projectId, $data['name']);
        echo json_encode(['message' => 'Project updated successfully']);
    } else {
        echo json_encode(['error' => 'Missing required fields']);
    }
}

// Delete Project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete_project') {
    if (isset($_GET['_method']) && $_GET['_method'] === 'DELETE') {
        $projectId = $_GET['id'] ?? null;

        if ($projectId) {
            $projectController->deleteProject($projectId);
            sendJsonResponse(['message' => 'Project deleted successfully']);
        } else {
            sendJsonResponse(['error' => 'Project ID is required'], 400);
        }
    }
}

// Update Task
// Endpoint untuk mengupdate task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update_task') {
    $taskId = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);

    // Validasi data yang dikirimkan
    if (isset($data['name'], $data['status'], $data['project_id'], $data['bobot'])) {
        $taskController = new TaskController();
        $taskController->updateTask($taskId, $data['name'], $data['status'], $data['project_id'], $data['bobot']);
        echo json_encode(['message' => 'Task updated successfully']);
    } else {
        echo json_encode(['error' => 'Missing required fields']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete_task') {
    if (isset($_GET['_method']) && $_GET['_method'] === 'DELETE') {
        $taskId = $_GET['id'] ?? null;

        if ($taskId) {
            $taskController->deleteTask($taskId);
            sendJsonResponse(['message' => 'Task deleted successfully']);
        } else {
            sendJsonResponse(['error' => 'Task ID is required'], 400);
        }
    }
}

// Update Project Completion and Status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update_project_status') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Pastikan data project ada untuk update
    if (isset($data['project_id'])) {
        $projectController->updateCompletionAndStatus($data['project_id']);
        sendJsonResponse(['message' => 'Project completion and status updated']);
    } else {
        sendJsonResponse(['error' => 'Project ID is required'], 400);
    }
}
