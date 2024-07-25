<?php
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("select * from resturants where id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $restaurant = $result->fetch_assoc();
        echo json_encode($restaurant);
    } else {
        echo json_encode(["message" => "Restaurant not found", "status" => "failure"]);
    }
} else {
    echo json_encode(["message" => "Wrong method or missing ID", "status" => "failure"]);
}
