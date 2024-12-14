<?php
session_start();
include "../db_conn.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['author_name'])) {
        $name = $_POST['author_name'];

        if (empty($name)) {
            $em = "the author name is required!";
            header("Location: ../add_author.php?error=$em");
            exit;
        } else {
            $sql = "INSERT INTO authors (name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name]);


            if ($res) {
                $sm = "Successfully created!";
                header("Location: ../add_author.php?success=$sm");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../add_author.php?error=$em");
                exit;
            }
        }
    } else {
        header("Location: ../dashboard.php");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}