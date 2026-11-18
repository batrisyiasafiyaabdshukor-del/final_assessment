
<?php
include "auth.php";
include "db.php";

// Get the result ID
$id = (int) ($_GET['id'] ?? 0);

// Find student result
$sql = $conn->prepare("SELECT * FROM results WHERE result_id = ?");
$sql->bind_param("i", $id);
$sql->execute();

$row = $sql->get_result()->fetch_assoc();

include "header.php";

if (!$row) {
    die("Student result not found.");
}
?>

<h2>View Student Result</h2>

<p>
    <strong>Student Name:</strong>
    <?php echo htmlspecialchars($row['student_name']); ?>
</p>

<p>
    <strong>Matric Number:</strong>
    <?php echo htmlspecialchars($row['matric_no']); ?>
</p>

<p>
    <strong>Subject Name:</strong>
    <?php echo htmlspecialchars($row['subject_name']); ?>
</p>

<p>
    <strong>Subject Code:</strong>
    <?php echo htmlspecialchars($row['subject_code']); ?>
</p>

<p>
    <strong>Test 1 (20%):</strong>
    <?php echo $row['test1']; ?>
</p>

<p>
    <strong>Test 2 (30%):</strong>
    <?php echo $row['test2']; ?>
</p>

<p>
    <strong>Final Examination (50%):</strong>
    <?php echo $row['final_exam']; ?>
</p>

<p>
    <strong>Total Marks:</strong>
    <?php echo $row['total_marks']; ?>
</p>

<p>
    <strong>Final Grade:</strong>
    <?php echo htmlspecialchars($row['final_grade']); ?>
</p>

<a href="index.php">Back to Records</a>

<?php
include "footer.php";
?>
