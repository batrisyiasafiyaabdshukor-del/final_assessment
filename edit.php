
<?php
include "auth.php";
include "db.php";

// Get student result ID from URL
$id = (int) ($_GET['id'] ?? 0);

// Find selected student result
$sql = $conn->prepare("SELECT * FROM results WHERE result_id = ?");
$sql->bind_param("i", $id);
$sql->execute();

$row = $sql->get_result()->fetch_assoc();

// Check whether the result exists
if (!$row) {
    die("Student result not found.");
}

// Display existing student information
$student_name = $row['student_name'];
$matric_no = $row['matric_no'];
$subject_name = $row['subject_name'];
$subject_code = $row['subject_code'];
$test1 = $row['test1'];
$test2 = $row['test2'];
$final_exam = $row['final_exam'];

$error = "";

// When Submit button is clicked
if (isset($_POST['submit'])) {

    $student_name = trim($_POST['student_name'] ?? "");
    $matric_no = trim($_POST['matric_no'] ?? "");
    $subject_name = trim($_POST['subject_name'] ?? "");
    $subject_code = trim($_POST['subject_code'] ?? "");

    $test1 = $_POST['test1'] ?? "";
    $test2 = $_POST['test2'] ?? "";
    $final_exam = $_POST['final'] ?? "";

    // Check empty fields
    if (
        $student_name == "" ||
        $matric_no == "" ||
        $subject_name == "" ||
        $subject_code == "" ||
        $test1 === "" ||
        $test2 === "" ||
        $final_exam === ""
    ) {
        $error = "Please fill in all fields.";
    }

    // Check numeric marks
    else if (
        !is_numeric($test1) ||
        !is_numeric($test2) ||
        !is_numeric($final_exam)
    ) {
        $error = "Please enter valid numbers for marks.";
    }

    // Check allowed marks
    else if (
        $test1 < 0 || $test1 > 20 ||
        $test2 < 0 || $test2 > 30 ||
        $final_exam < 0 || $final_exam > 50
    ) {
        $error = "Invalid marks. Test 1: 0-20, Test 2: 0-30, Final: 0-50.";
    }

    else {

        // Convert marks to numbers
        $test1 = (float) $test1;
        $test2 = (float) $test2;
        $final_exam = (float) $final_exam;

        // Calculate total marks
        $total_marks = $test1 + $test2 + $final_exam;

        // Determine grade
        if ($total_marks >= 80)
            $final_grade = 'A';
        else if ($total_marks >= 65)
            $final_grade = 'B';
        else if ($total_marks >= 50)
            $final_grade = 'C';
        else if ($total_marks >= 40)
            $final_grade = 'D';
        else
            $final_grade = 'E';

        // Update student result
        $sql = $conn->prepare("UPDATE results SET
            student_name = ?,
            matric_no = ?,
            subject_name = ?,
            subject_code = ?,
            test1 = ?,
            test2 = ?,
            final_exam = ?,
            total_marks = ?,
            final_grade = ?
            WHERE result_id = ?
        ");

        $sql->bind_param(
            "ssssddddsi",
            $student_name,
            $matric_no,
            $subject_name,
            $subject_code,
            $test1,
            $test2,
            $final_exam,
            $total_marks,
            $final_grade,
            $id
        );

        if ($sql->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Failed to update student result.";
        }
    }
}

include "header.php";
?>

<h2>Edit Result</h2>

<?php
if ($error != "") {
    echo "<p style='color:red;'>" .
        htmlspecialchars($error) .
        "</p>";
}

include "form.php";
include "footer.php";
?>
