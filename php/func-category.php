<?php

function get_all_categories($conn){
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0){
        $categories = $stmt->fetchAll();
    } else{
        $categories = 0;
    }

    return $categories;
}