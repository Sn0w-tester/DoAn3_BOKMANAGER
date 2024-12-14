<?php
session_start();
include "../db_conn.php";
include "./func-validation.php";
include "./func-file-upload.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (
        isset($_POST['book_id']) &&
        isset($_POST['book_title']) &&
        isset($_POST['book_category']) &&
        isset($_POST['book_description']) &&
        isset($_POST['book_author']) &&
        isset($_POST['current_cover']) &&
        isset($_POST['current_file']) &&
        isset($_FILES['book_cover']) &&
        isset($_FILES['book_file'])
    ) {
        $id = $_POST['book_id'];
        $title = $_POST['book_title'];
        $category = $_POST['book_category'];
        $desc = $_POST['book_description'];
        $author = $_POST['book_author'];
        $current_cover = $_POST['current_cover'];
        $current_file = $_POST['current_file'];

        $text = "Book title";
        $location = "../edit_book.php";
        $ms = "id=$id&error";
        is_empty($title, $text, $location, $ms, "");

        $text = "Book category";
        $location = "../edit_book.php";
        $ms = "id=$id&error";
        is_empty($category, $text, $location, $ms, "");

        $text = "Book description";
        $location = "../edit_book.php";
        $ms = "id=$id&error";
        is_empty($desc, $text, $location, $ms, "");

        $text = "Book author";
        $location = "../edit_book.php";
        $ms = "id=$id&error";
        is_empty($author, $text, $location, $ms, "");

        if (!empty($_FILES['book_cover']['name'])) {
            if (!empty($_FILES['file']['name'])) {
                $allow_image_exs = array("jpg", "jpeg", "png");
                $path = "cover";
                $book_cover = upload_file($_FILES['book_cover'], $allow_image_exs, $path);

                $allow_file_exs = array("pdf", "docx", "doc", "pptx", "ppt");
                $path = "files";
                $file = upload_file($_FILES['book_file'], $allow_file_exs, $path);

                if ($book_cover['status'] == "error" || $file['status'] == "error") {
                    $em = $book_cover['data'];

                    header("Location: ../edit_book.php?error=$em&id=$id");
                    exit;
                } else {
                    $c_p_book_cover = "../uploads/cover/$current_cover";
                    $c_p_file = "../uploads/files/$current_file";

                    unlink($c_p_book_cover);
                    unlink($c_p_file);

                    $file_URL = $file["data"];
                    $book_cover_URL = $book_cover["data"];

                    $sql = "UPDATE books SET title=?, author_id=?, description=?, category_id=?, cover=?, file=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute([$title, $author, $desc, $category, $book_cover_URL, $file_URL, $id]);

                    if ($res) {
                        $sm = "Successfully updated!";
                        header("Location: ../edit_book.php?success=$sm&id=$id");
                        exit;
                    } else {
                        $em = "Unknown Error Occurred!";
                        header("Location: ../edit_book.php?error=$em&id=$id");
                        exit;
                    }
                }
            } else {
                $allow_image_exs = array("jpg", "jpeg", "png");
                $path = "cover";
                $book_cover = upload_file($_FILES['book_cover'], $allow_image_exs, $path);

                if ($book_cover['status'] == "error") {
                    $em = $book_cover['data'];

                    header("Location: ../edit_book.php?error=$em&id=$id");
                    exit;
                } else {
                    $c_p_book_cover = "../uploads/cover/$current_cover";

                    unlink($c_p_book_cover);

                    $book_cover_URL = $book_cover["data"];

                    $sql = "UPDATE books SET title=?, author_id=?, description=?, category_id=?, cover=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute([$title, $author, $desc, $category, $book_cover_URL, $id]);

                    if ($res) {
                        $sm = "Successfully updated!";
                        header("Location: ../edit_book.php?success=$sm&id=$id");
                        exit;
                    } else {
                        $em = "Unknown Error Occurred!";
                        header("Location: ../edit_book.php?error=$em&id=$id");
                        exit;
                    }
                }
            }
        } else if (!empty($_FILES['book_file']['name'])) {

            $allow_file_exs = array("pdf", "docx", "doc", "pptx", "ppt");
            $path = "files";
            $file = upload_file($_FILES['book_file'], $allow_file_exs, $path);

            if ($file['status'] == "error") {
                $em = $file['data'];

                header("Location: ../edit_book.php?error=$em&id=$id");
                exit;
            } else {
                $c_p_file = "../uploads/files/$current_file";

                unlink($c_p_file);

                $file_URL = $file["data"];

                $sql = "UPDATE books SET title=?, author_id=?, description=?, category_id=?, file=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$title, $author, $desc, $category, $file_URL, $id]);

                if ($res) {
                    $sm = "Successfully updated!";
                    header("Location: ../edit_book.php?success=$sm&id=$id");
                    exit;
                } else {
                    $em = "Unknown Error Occurred!";
                    header("Location: ../edit_book.php?error=$em&id=$id");
                    exit;
                }
            }
        } else {
            $sql = "UPDATE books SET title=?, author_id=?, description=?, category_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$title, $author, $desc, $category, $id]);

            if ($res) {
                $sm = "Successfully updated!";
                header("Location: ../edit_book.php?success=$sm&id=$id");
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                header("Location: ../edit_book.php?error=$em&id=$id");
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