<?php
session_start();
include "../db_conn.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['category_name'])) {
        $name = $_POST['category_name'];

        if (empty($name)) {
            $em = "the Category name is required!";
            header("Location: ../add_category.php?error=$em");
            exit;
        } else {
            $sql = "INSERT INTO categories (name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name]);


            if ($res) {
                $sm = "Successfully created!";
                header("Location: ../add_category.php?success=$sm");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../add_category.php?error=$em");
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