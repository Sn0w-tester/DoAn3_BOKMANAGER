<?php
session_start();
include "../db_conn.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['author_name']) && isset($_POST['author_id'])) {
        $id = $_POST['author_id'];
        $name = $_POST['author_name'];

        if (empty($name)) {
            $em = "the Author name is required!";
            header("Location: ../edit_author.php?error=$em&id=$id");
            exit;
        } else {
            $sql = "UPDATE authors SET name=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name, $id]);


            if ($res) {
                $sm = "Successfully updated!";
                header("Location: ../edit_author.php?success=$sm&id=$id");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../edit_author.php?error=$em&id=$id");
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