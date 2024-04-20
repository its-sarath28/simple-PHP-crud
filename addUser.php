<?php require("include/header.php") ?>

<?php require("config/config.php") ?>

<?php
$name_err = $email_err = $address_err = "";
$name = $email = $address = "";
$err_flag = false;

if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);

    if (empty($name)) {
        $name_err = "Name is required";
        $err_flag = true;
    }

    if (empty($email)) {
        $email_err = "Email is required";
        $err_flag = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email address";
        $err_flag = true;
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $email_err = "Email already exists";
            $err_flag = true;
        }
    }

    if (empty($address)) {
        $address_err = "Address is required";
        $err_flag = true;
    }


    if (!$err_flag) {
        $sql = "INSERT INTO users (name, email, address) VALUES (?, ?, ?)";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss",  $name,  $email, $address);
            $stmt->execute();

            $_SESSION["success_msg"] = "User added successfully";

            header("location: index.php");
        } catch (Exception $e) {
            $err_msg = $e->getMessage();
        }
    }
}
?>

<div class="container">
    <div class="row vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="col-md-6">

            <h1 class="text-center mb-4">Add User</h1>

            <?php if (!empty($err_msg)) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $err_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <form method="POST" action="addUser.php">
                <a href="index.php" class="btn btn-primary text-start">Back</a>

                <div class="my-4">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="<?= $name ?>">
                    <small class="text-danger"><?php if ($err_flag) echo $name_err ?></small>
                </div>

                <div class="my-4">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?= $email ?>">
                    <small class="text-danger"><?php if ($err_flag) echo $email_err ?></small>
                </div>

                <div class="my-4">
                    <textarea name="address" id="address" rows="6" class="form-control" placeholder="Address"><?= $address ?></textarea>
                    <small class="text-danger"><?php if ($err_flag) echo $address_err ?></small>
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <button type="reset" class="btn btn-secondary">Clear</button>
                    <button name="submit" type="submit" class="btn btn-primary">Add user</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require("include/footer.php") ?>