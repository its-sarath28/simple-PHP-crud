
<?php require("config/config.php") ?>

<?php

session_start();

if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    $sql = "DELETE FROM users WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION["success_msg"] = "User deleted successfully";
    header("location: index.php");
}
