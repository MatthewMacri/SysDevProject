<?php
namespace Controllers;

require_once 'databasecontroller.php';

use Controllers\DatabaseController;

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

$db = DatabaseController::getInstance()->getConnection();

switch ($method) {
    case 'GET':
        $stmt = $db->prepare("SELECT * FROM project");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $db->prepare("INSERT INTO project (serialNumber, title, description, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['serialNumber'],
            $data['title'],
            $data['description'],
            $data['status']
        ]);
        echo json_encode(["message" => "Project created"]);
        break;

    // Add PUT and DELETE logic here
}