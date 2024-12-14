<?php
session_start();
include "../db_conn.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        if (empty($id)) {
            $em = "Error Occurred!";
            header("Location: ../dashboard.php?error=$em");
            exit;
        } else {
            $sql = "DELETE FROM authors WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$id]);


            if ($res) {

                $sm = "Successfully removed!";
                header("Location: ../dashboard.php?success=$sm");
                exit;
            } else {
                $em = "Error Occurred!";
                header("Location: ../dashboard.php?error=$em");
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