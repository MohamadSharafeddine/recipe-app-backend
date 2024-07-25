<?php
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input["id"];

    $stmt = $conn->prepare("SELECT * FROM resturants WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM resturants WHERE id=?");
        $stmt->bind_param("i", $id);
        try {
            $stmt->execute();
            echo json_encode(["message" => "Restaurant deleted successfully", "status" => "success"]);
        } catch (Exception $e) {
            echo json_encode(["error" => "Restaurant could not be deleted", "status" => "failure"]);
        }
    } else {
        echo json_encode(["message" => "Restaurant doesn't exist", "status" => "failure"]);
    }
} else {
    echo json_encode(["message" => "Wrong method", "status" => "failure"]);
}