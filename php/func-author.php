<?php

function get_all_author($conn){
    $sql = "SELECT * FROM authors";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0){
        $authors = $stmt->fetchAll();
    } else{
        $authors = 0;
    }

    return $authors;
}