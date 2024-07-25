<?php

require "../connection.php";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $stmt = $conn->prepare('select r.* , rs.name as resturant_name from recipes r
        join resturants rs on rs.id=resturant_id');
    $stmt->execute();
    $result = $stmt->get_result();
    $recipes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;  
        }
        echo json_encode(["recipes" => $recipes,"status"=>"success"]);
    } else {
        echo json_encode(["message" => "no records were found","status"=>"faliure"]);
    }
} else {
echo json_encode(["error" => "Wrong request method"]);
}