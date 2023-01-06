<?php
$insert = false;
$update = false;
$delete = false;
$conn = mysqli_connect("localhost", "root", "", "aviidb");
if (!$conn) {
    echo mysqli_connect_error();

}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `sno`=$sno";
    $result = mysqli_query($conn, $sql);
    $delete = true;
}

// echo $_POST['hidin'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['hidin'])) {
        $title = $_POST['titleEdit'];
        $desc = $_POST['descEdit'];
        $sno = $_POST['hidin'];
        $sql = "UPDATE `notes` SET `title`= '$title', `description`='$desc' where `sno`='$sno'";
        $result = mysqli_query($conn, $sql);

        $update = true;

    } else {
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        $sql1 = "INSERT INTO `notes` (`title`,`description`) VALUES
     ('$title','$desc')
    ";
        $result1 = mysqli_query($conn, $sql1);
        if ($result1) {
            $insert = true;
        } else {
            echo mysqli_error($conn);
        }
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="post">
                        <div class="mb-3 form-group">
                            <input type="hidden" name="hidin" id="hidin">
                            <label for="titleEdit" class="form-label">Title</label>
                            <input name="titleEdit" type="text" class="form-control" id="titleEdit"
                                aria-describedby="emailHelp" placeholder="Add title here">

                            <div class="mb-3 mt-3">
                                <label for="descEdit" class="form-label">Description</label>
                                <textarea name="descEdit" class="form-control" placeholder="Add Description here"
                                    id="descEdit" style="height: 100px"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Note</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"> <b><i>myNotes</i></b> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Note Added !!</strong> Your note has been added successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($update) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Note Updated !!</strong> Your note has been updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';

    }

    if ($delete) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Note Deleted !!</strong> Your note has been deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';

    }

    $insert = false;
    $update = false;
    $delete = false;
    ?>

    <div class="container mt-4 ">
        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input name="title" type="text" class="form-control" id="title" aria-describedby="emailHelp"
                    placeholder="Add title here">

                <div class="mb-3 mt-3">
                    <label for="exampleInputPassword1" class="form-label">Description</label>
                    <textarea name="desc" class="form-control" placeholder="Add Description here" id="desc"
                        style="height: 100px"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Add Note</button>
        </form>

    </div>

    <div class="container mt-4">
        <table class="table" id="myTable">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Time</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "select * from notes";
                $result = mysqli_query($conn, $sql);

                $num = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    // echo $row['sno'] . $row['title'] . $row['description']. $row['time']."<br>";
                    $id = $row['sno'];
                    echo " <tr>
                       <th scope='row'>" . ++$num . "</th>
                       <td>" . $row['title'] . "</td>
                       <td>" . $row['description'] . "</td>
                       <td>" . $row['time'] . "</td>
                       <td> <button type='button' id='" . $row['sno'] . "' class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal' >Edit</button>
                       <button type='button' id='d" . $row['sno'] . "' class='delete btn btn-sm btn-danger'>Delete</button>
                       </td>
                       </tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
    <hr>


    <script src="https://code.jquery.com/jquery-2.2.4.js"
        integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script>
        // $('#myModal').modal('toggle');
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

        var edit = document.getElementsByClassName('edit');
        Array.from(edit).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("event", e);
                console.log(e.target.id);

                var tr = e.target.parentNode.parentNode;

                var title = tr.getElementsByTagName('td')[0].innerText;
                var desc = tr.getElementsByTagName('td')[1].innerText;
                titleEdit.value = title;
                descEdit.value = desc;
                hidin.value = e.target.id;
            })
        });

        var deleted = document.getElementsByClassName('delete');
        Array.from(deleted).forEach((element) => {
            element.addEventListener("click", (e) => {
                var sno = e.target.id.substr(1,);
                console.log("event", e);

                if (confirm("Are you sure to delete this note")) {
                    window.location = `index.php?delete=${sno}`;
                }
            })
        });

    </script>
</body>

</html>