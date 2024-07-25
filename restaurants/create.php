<?php
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input["name"];
    $location = $input["location"];
    $cuisine_type = $input["cuisine_type"];

    if ($name != "" && $location != "" && $cuisine_type != "") {
        $stmt = $conn->prepare("SELECT * FROM resturants WHERE name=?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("insert into resturants (name, location, cuisine_type) values (?, ?, ?)");
            $stmt->bind_param("sss", $name, $location, $cuisine_type);
            try {
                $stmt->execute();
                $id = $stmt->insert_id;
                echo json_encode(["message" => "Restaurant created successfully", "status" => "success", "id" => $id]);
            } catch (Exception $e) {
                echo json_encode(["error" => "Restaurant could not be created", "status" => "failure"]);
            }
        } else {
            echo json_encode(["message" => "Restaurant already exists", "status" => "failure"]);
        }
    } else {
        echo json_encode(["message" => "Cannot leave empty data", "status" => "failure"]);
    }
} else {
    echo json_encode(["message" => "Wrong method.", "status" => "failure"]);
}