<?php
$host = "localhost";
$user = "root";
$password = "Mush3kah6eeng9so";
$database = "mydatabase2";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("There was a problem connecting to the");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <title>iNotes- Note taking made easy</title>
</head>

<body>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>

    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/CRUD/index.php?update=true" method="POST">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Title
                            </label>
                            <input type="text" class="form-control" id="titleEdit" aria-describedby="emailHelp" name="titleEdit">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <div class="form-floating">
                                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" style="height: 100px" placeholder="type here.."></textarea>
                                <label for="description">Type here...</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNote</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    // Delete data
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $deleteSQL = "DELETE FROM `note` WHERE `id`='$id';";
        $result = mysqli_query($conn, $deleteSQL);

        if($result){
            echo
                '<div class="alert alert-success" role="alert">
                    Note deleted successfully
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }else{
            echo
                '<div class="alert alert-danger" role="alert">
                    There was some problem deleting the note
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    // Insert & Update data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_GET['update'] == 'true') {
            $sno = $_POST['snoEdit'];
            $title = $_POST['titleEdit'];
            $description = $_POST['descriptionEdit'];

            $updateSQL = "UPDATE `note` SET `title`='$title', `description`='$description' WHERE `id`='$sno';";
            $result = mysqli_query($conn, $updateSQL);

            if($result){
                echo
                    '<div class="alert alert-success" role="alert">
                        Note updated successfully
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }else{
                echo
                    '<div class="alert alert-danger" role="alert">
                        There was some problem updating the note
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        } else {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $insertNoteSQL = "INSERT INTO `note` (`title`,`description`) VALUES ('$title', '$description');";

            if (strlen($title) != 0 && strlen($description) != 0) {
                $result = mysqli_query($conn, $insertNoteSQL);

                if ($result) {
                    echo
                    '<div class="alert alert-success" role="alert">
                        Note inserted successfully
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                } else {
                    echo
                    '<div class="alert alert-danger" role="alert">
                        There was some problem inserting the note
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            }
        }
    }
    ?>

    <div class="container" style="width: 50%; margin: auto; margin-top: 6vh;">
        <!-- Form -->
        <h2>Add a note</h2>
        <form action="/CRUD/index.php?update=false" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">
                    Title
                </label>
                <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <div class="form-floating">
                    <textarea class="form-control" id="description" name="description" style="height: 100px" placeholder="type here.."></textarea>
                    <label for="description">Type here...</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Insert Note</button>
        </form>
    </div>

    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getAllSQL = "SELECT * FROM `note`";
                $result = mysqli_query($conn, $getAllSQL);
                $numrows = mysqli_num_rows($result);

                if ($numrows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        echo "
                            <tr>
                                <th scope=\"row\">$id</th>
                                <td>$title</td>
                                <td>$description</td>
                                <td><button type='button' class='edit btn btn-primary'>
                                Edit
                              </button></td>
                                <td><button type='button' class='delete btn btn-primary'>
                                Delete
                              </button></td>
                            </tr>
                            ";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit -->
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                no = tr.getElementsByTagName("th")[0].innerText;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;

                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = no;

                $('#editModal').modal('toggle');

                console.log(no, title, description);
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                no = tr.getElementsByTagName("th")[0].innerText;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;

                console.log(no, title, description);

                if(confirm("Do you really want to delete?")){
                    console.log("Yes");

                    window.location = `/crud/index.php?delete=${no}`;
                }else{
                    console.log("No");
                }
            })
        })
    </script>
</body>

</html>
