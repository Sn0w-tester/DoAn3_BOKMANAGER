<?php
session_start();
include "../db_conn.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['category_name']) && isset($_POST['category_id'])) {
        $id = $_POST['category_id'];
        $name = $_POST['category_name'];

        if (empty($name)) {
            $em = "the Category name is required!";
            header("Location: ../edit_category.php?error=$em&id=$id");
            exit;
        } else {
            $sql = "UPDATE categories SET name=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name, $id]);


            if ($res) {
                $sm = "Successfully updated!";
                header("Location: ../edit_category.php?success=$sm&id=$id");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../edit_category.php?error=$em&id=$id");
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