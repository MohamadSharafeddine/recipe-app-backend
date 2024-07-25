<?php

require '../connection.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $data = json_decode(file_get_contents('php://input'), true);
   

    $id=$data["id"];
    $details=$data['details'];
    $resturant_id =$data["resturant_id"];
    $name=$data["name"];



    if ($details !="" && $name !=""){   
    $stm=$conn->prepare("update recipes Set details = ?, name = ?, resturant_id=? WHERE id = ?");
    $stm->bind_param("ssii",$details,$name,$resturant_id,$id);
    try {
        $stm->execute();
        echo json_encode(["message"=>"the recipe is updated","status"=>"success"]);
    } catch (Exception $e) {
        echo json_encode(["message"=>"cant update the recipe","status"=>"failure"]);
    }
}else{
    echo json_encode(["message"=>"can't update with empty value"]);
}   
}
else{
    echo json_encode(["message"=>"wrong request method"]);
}