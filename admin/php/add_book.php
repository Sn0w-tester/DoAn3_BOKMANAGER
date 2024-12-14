<?php
session_start();
include "../db_conn.php";
include "./func-validation.php";
include "./func-file-upload.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (
        isset($_POST['book_title']) &&
        isset($_POST['book_category']) &&
        isset($_POST['book_description']) &&
        isset($_POST['book_author']) &&
        isset($_FILES['book_cover']) &&
        isset($_FILES['book_file'])
    ) {

        $title = $_POST['book_title'];
        $category = $_POST['book_category'];
        $desc = $_POST['book_description'];
        $author = $_POST['book_author'];

        $user_input = 'title=' . $title . '&category_id=' . $category . '&desc=' . $desc . "&author_id=" . $author ;

        $text = "Book title";
        $location = "../add_book.php";
        $ms = "error";
        is_empty($title, $text, $location, $ms, $user_input);

        $text = "Book category";
        $location = "../add_book.php";
        $ms = "error";
        is_empty($category, $text, $location, $ms, $user_input);

        $text = "Book description";
        $location = "../add_book.php";
        $ms = "error";
        is_empty($desc, $text, $location, $ms, $user_input);

        $text = "Book author";
        $location = "../add_book.php";
        $ms = "error";
        is_empty($author, $text, $location, $ms, $user_input);

        $allow_image_exs = array("jpg", "jpeg", "png");
        $path = "cover";
        $book_cover = upload_file($_FILES['book_cover'], $allow_image_exs, $path);

        if ($book_cover['status'] == "error") {
            $em = $book_cover['data'];

            header("Location: ../add_book.php?error=$em&$user_input");
            exit;
        } else {
            $allow_file_exs = array("pdf", "docx", "doc", "pptx", "ppt");
            $path = "files";
            $file = upload_file($_FILES['book_file'], $allow_file_exs, $path);

            if ($file['status'] == "error") {
                $em = $file['data'];

                header("Location: ../add_book.php?error=$em&$user_input");
                exit;
            } else {
                $file_URL = $file["data"];
                $book_cover_URL = $book_cover["data"];

                $sql = "INSERT INTO books (title, author_id, description, category_id, cover, file) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$title, $author, $desc, $category, $book_cover_URL, $file_URL]);


                if ($res) {
                    $sm = "The book successfully created!";
                    header("Location: ../add_book.php?success=$sm");
                    exit;
                } else {
                    $em = "Unknown Error Occurred!";
                    header("Location: ../add_book.php?error=$em");
                    exit;
                }
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