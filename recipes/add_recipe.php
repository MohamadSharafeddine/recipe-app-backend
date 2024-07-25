<?php
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);


    if (isset($data['resturant_id'], $data['name'], $data['details'])) {
        $resturant_id = $data['resturant_id'];
        $name = $data['name'];
        $details = $data['details'];

        $stm = $conn->prepare("SELECT * FROM recipes WHERE name = ?");
        $stm->bind_param("s", $name);
        $stm->execute();
        $result = $stm->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["message" => "The item already exists with the name $name"]);
        } else {
            $stm = $conn->prepare("insert into recipes (resturant_id, name, details) values (?, ?, ?)");
            $stm->bind_param("iss", $resturant_id, $name, $details);

            try {
                $stm->execute();
                echo json_encode(["message" => "Recipe added successfully", "status" => "success"]);
            } catch (Exception $e) {
                echo json_encode(["message" => $e->getMessage(), "status" => "failure"]);
            }
        }
    } else {
        echo json_encode(["message" => "Invalid input"]);
    }
} else {
    echo json_encode(["message" => "Wrong request method"]);
}
?>
