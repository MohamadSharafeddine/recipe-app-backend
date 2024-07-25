<?php
require "../connection.php";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $stmt = $conn->prepare('select * from resturants');
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurants = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $restaurants[] = $row;
        }
        echo json_encode(["restaurants" => $restaurants,"status"=>"success"]);
    } else {
        echo json_encode(["message" => "no records were found","status"=>"faliure"]);
    }
} else {
echo json_encode(["error" => "Wrong request method"]);
}
