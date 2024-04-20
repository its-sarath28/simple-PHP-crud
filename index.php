<?php require("include/header.php") ?>

<?php require("config/config.php") ?>

<?php
$sql = "SELECT * FROM users";

$stmt = $conn->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();

?>

<div class="container">
    <h1 class="text-center mt-5">PHP - CRUD</h1>

    <div class="text-end my-4">
        <a href="addUser.php" class="btn btn-primary">Add user</a>
    </div>

    <?php if (isset($_SESSION["success_msg"])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION["success_msg"];
            unset($_SESSION["success_msg"]);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <div class="table-responsive" style="height: 30rem; overflow-y: auto">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    foreach ($result as $row) { ?>
                        <tr class="align-middle">
                            <th scope="row"><?php echo $row["id"] ?></th>
                            <td><?php echo $row["name"] ?></td>
                            <td><?php echo $row["email"] ?></td>
                            <td><?php echo $row["address"] ?></td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="updateUser.php?id=<?= $row["id"]; ?>" class="btn btn-primary">Edit</a>
                                    <a onclick="return confirm('Are you sure that you want to delete the user (<?= $row['name']; ?>) ?')" href="deleteUser.php?id=<?= $row["id"]; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="5">
                            <p class="text-center mb-0">
                                No Users found
                            </p>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</div>

<?php require("include/footer.php") ?>