<?php
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input["id"];
    $name = $input["name"];
    $location = $input["location"];
    $cuisine_type = $input["cuisine_type"];

    $stmt = $conn->prepare("select * from resturants where id =?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("update resturants set name=?, location=?, cuisine_type=? where id=?");
        $stmt->bind_param("sssi", $name, $location, $cuisine_type, $id);
        try {
            $stmt->execute();
            echo json_encode(["message" => "Restaurant updated successfully", "status" => "success"]);
        } catch (Exception $e) {
            echo json_encode(["error" => $stmt->error, "status" => "failure"]);
        }
    } else {
        echo json_encode(["message" => "Restaurant not found", "status" => "failure"]);
    }
} else {
    echo json_encode(["message" => "Wrong request method", "status" => "failure"]);
}