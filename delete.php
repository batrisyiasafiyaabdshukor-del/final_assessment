
<?php
include "auth.php";
include "db.php";

if (isset($_POST['delete'])) {
    $id = (int) $_POST['delete'];

    $sql = $conn->prepare("DELETE FROM results WHERE result_id = ?");
    $sql->bind_param("i", $id);

    if ($sql->execute()) {
        header("Location: index.php");
        exit();
    }
}
?>
