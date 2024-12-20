<?php
session_start();
include "db_conn.php";
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    include "php/func-book.php";
    $books = get_all_book($conn);

    include "php/func-author.php";
    $authors = get_all_author($conn);

    include "php/func-category.php";
    $categories = get_all_categories($conn);

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - BOKMANAGER</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="dashboard.php">ADMIN</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="dashboard.php">Store</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add_book.php">Add Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add_category.php">Add category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add_author.php">Add author</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">logout</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username"
                    aria-describedby="basic-addon2">
                <span class="input-group-text" id="basic-addon2">@example.com</span>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>

            <?php if ($books == 0) { ?>
                <div class="alert alert-warning text-center p-5" role="alert">
                    There is no book in the database
                </div>
            <?php } else { ?>

                <!-- List of all books -->
                <h4 class="mt-5">All books</h4>
                <table class="table table-bordered shadow">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($books as $book) {
                            $i++;
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td>
                                    <img width="100" src="uploads/cover/<?= $book['cover'] ?>" alt=""><br>
                                    <a class="link-dark d-block text-center"
                                        href="uploads/files/<?= $book['file'] ?>"><?= $book['title'] ?></a>
                                </td>
                                <td>
                                    <?php if ($authors == 0) {
                                        echo "undefined";
                                    } else {
                                        foreach ($authors as $author) {
                                            if ($author['id'] == $book['author_id']) {
                                                echo $author['name'];
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?= $book['description'] ?></td>
                                <td>
                                    <?php if ($categories == 0) {
                                        echo "undefined";
                                    } else {
                                        foreach ($categories as $category) {
                                            if ($category['id'] == $book['category_id']) {
                                                echo $category['name'];
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="edit_book.php?id=<?= $book['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="php/delete_book.php?id=<?= $book['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <?php if ($categories == 0) { ?>
                <div class="alert alert-warning text-center p-5" role="alert">
                    There is no category in the database
                </div>
            <?php } else { ?>
                <!-- List of all category -->
                <h4 class="mt-5">All Categories</h4>
                <table class="table table-bordered shadow">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $j = 0;
                        foreach ($categories as $category) {
                            $j++
                                ?>
                            <tr>
                                <td><?= $j ?></td>
                                <td><?= $category['name'] ?></td>
                                <td>
                                    <a href="edit_category.php?id=<?= $category['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="php/delete_category.php?id=<?= $category['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <?php if ($authors == 0) { ?>
                <div class="alert alert-warning text-center p-5" role="alert">
                    There is no auther in the database
                </div>
            <?php } else { ?>
                <!-- List of all Authors -->
                <h4 class="mt-5">All Authors</h4>
                <table class="table table-bordered shadow">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Author Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 0;
                        foreach ($authors as $author) {
                            $k++
                                ?>
                            <tr>
                                <td><?= $k ?></td>
                                <td><?= $author['name'] ?></td>
                                <td>
                                    <a href="edit_author.php?id=<?= $author['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="php/delete_author.php?id=<?= $author['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </body>

    </html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>