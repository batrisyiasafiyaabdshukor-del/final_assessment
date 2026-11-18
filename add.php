

<?php
include "auth.php";
include "db.php";

$student_name = "";
$matric_no = "";
$subject_name = "";
$subject_code = "";
$test1 = "";
$test2 = "";
$final_exam = "";
$error = "";

if (isset($_POST['submit'])) {

    $student_name = trim($_POST['student_name'] ?? "");
    $matric_no = trim($_POST['matric_no'] ?? "");
    $subject_name = trim($_POST['subject_name'] ?? "");
    $subject_code = trim($_POST['subject_code'] ?? "");

    $test1 = $_POST['test1'] ?? "";
    $test2 = $_POST['test2'] ?? "";
    $final_exam = $_POST['final'] ?? "";

    // Check that all fields are filled in
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

    // Check that marks are valid numbers
    else if (
        !is_numeric($test1) ||
        !is_numeric($test2) ||
        !is_numeric($final_exam)
    ) {
        $error = "Please enter valid numbers for marks.";
    }

    // Check that marks are within the allowed ranges
    else if (
        $test1 < 0 || $test1 > 20 ||
        $test2 < 0 || $test2 > 30 ||
        $final_exam < 0 || $final_exam > 50
    ) {
        $error = "Invalid marks. Test 1: 0-20, Test 2: 0-30, Final: 0-50.";
    }

    else {

        $test1 = (float) $test1;
        $test2 = (float) $test2;
        $final_exam = (float) $final_exam;

        // Calculate total marks
        $total_marks = $test1 + $test2 + $final_exam;

        // Determine final grade
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

        // Insert student result into database
        $sql = $conn->prepare("INSERT INTO results
            (student_name, matric_no, subject_name, subject_code,
            test1, test2, final_exam, total_marks, final_grade)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $sql->bind_param(
            "ssssdddds",
            $student_name,
            $matric_no,
            $subject_name,
            $subject_code,
            $test1,
            $test2,
            $final_exam,
            $total_marks,
            $final_grade
        );

        if ($sql->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Failed to save student result.";
        }
    }
}

include "header.php";
?>

<h2>Add Results</h2>

<?php
if ($error != "") {
    echo "<p style='color:red;'>" .
        htmlspecialchars($error) .
        "</p>";
}

include "form.php";
include "footer.php";
?>
