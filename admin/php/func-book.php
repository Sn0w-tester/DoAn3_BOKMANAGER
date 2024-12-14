<?php

function get_all_book($conn){
    $sql = "SELECT* FROM books ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0){
        $books = $stmt->fetchAll();
    } else{
        $books = 0;
    }

    return $books;
}

function get_book($conn, $id){
    $sql = "SELECT * FROM books WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([ $id ]);

    if ($stmt->rowCount() > 0){
        $book = $stmt->fetch();
    } else{
        $book = 0;
    }

    return $book;
}