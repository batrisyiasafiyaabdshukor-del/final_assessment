
<?php
include "auth.php";
include "db.php";

// Search student by name or matric number
$search = $_GET['search'] ?? "";

if ($search != "") {
    $sql = $conn->prepare("SELECT * FROM results
        WHERE student_name LIKE ? OR matric_no LIKE ?");

    $search_value = "%" . $search . "%";

    $sql->bind_param("ss", $search_value, $search_value);
} else {
    $sql = $conn->prepare("SELECT * FROM results");
}

$sql->execute();
$result = $sql->get_result();

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Assessment - Student Grading System</title>
</head>

<body>

    <h2>Student Records</h2>

    <a href="add.php">+ Add Results</a>
    <br><br>

    <!-- Search Form -->
    <form method="get" action="index.php">
        <input type="text" name="search"
            placeholder="Search by name or matric number"
            value="<?php echo htmlspecialchars($search); ?>">

        <button type="submit">Search</button>

        <a href="index.php">Show All</a>
    </form>

    <br>

    <table border="1">
        <tr>
            <th>No.</th>
            <th>Student Name</th>
            <th>Matric No.</th>
            <th>Subject</th>
            <th>Test 1 (20%)</th>
            <th>Test 2 (30%)</th>
            <th>Final (50%)</th>
            <th>Total</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>

        <?php
        $no = 1;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['matric_no']) . "</td>";
            echo "<td>" . htmlspecialchars($row['subject_name']) .
                " (" . htmlspecialchars($row['subject_code']) . ")</td>";

            echo "<td>" . $row['test1'] . "</td>";
            echo "<td>" . $row['test2'] . "</td>";
            echo "<td>" . $row['final_exam'] . "</td>";
            echo "<td>" . $row['total_marks'] . "</td>";
            echo "<td>" . htmlspecialchars($row['final_grade']) . "</td>";

            echo "<td>";

            // View button
            echo "<a href='view.php?id=" . (int)$row['result_id'] . "'>View</a> | ";

            // Edit button
            echo "<a href='edit.php?id=" . (int)$row['result_id'] . "'>Edit</a> | ";

            // Delete button
            echo "<form method='post' action='delete.php'
                style='display:inline;'
                onsubmit='return confirm(\"Delete this record?\")'>";

            echo "<input type='hidden' name='delete'
                value='" . (int)$row['result_id'] . "'>";

            echo "<input type='submit' value='Delete'>";
            echo "</form>";

            echo "</td>";
            echo "</tr>";
        }
        ?>

    </table>

    <br>

</body>
</html>

<?php
include "footer.php";
?>
