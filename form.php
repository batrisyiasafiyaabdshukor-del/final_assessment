


<form method="post">

    <label for="student_name">Student Name</label>
    <input type="text" id="student_name" name="student_name"
        value="<?php echo htmlspecialchars($student_name); ?>"
        required>
    <br><br>

    <label for="matric_no">Matric Number</label>
    <input type="text" id="matric_no" name="matric_no"
        value="<?php echo htmlspecialchars($matric_no); ?>"
        required>
    <br><br>

    <label for="subject_name">Subject Name</label>
    <input type="text" id="subject_name" name="subject_name"
        value="<?php echo htmlspecialchars($subject_name); ?>"
        required>
    <br><br>

    <label for="subject_code">Subject Code</label>
    <input type="text" id="subject_code" name="subject_code"
        value="<?php echo htmlspecialchars($subject_code); ?>"
        required>
    <br><br>

    <label for="test1">Test 1 (20%)</label>
    <input type="number" id="test1" name="test1"
        min="0" max="20" step="0.01"
        value="<?php echo htmlspecialchars((string)$test1); ?>"
        required>
    <br><br>

    <label for="test2">Test 2 (30%)</label>
    <input type="number" id="test2" name="test2"
        min="0" max="30" step="0.01"
        value="<?php echo htmlspecialchars((string)$test2); ?>"
        required>
    <br><br>

    <label for="final">Final Examination (50%)</label>
    <input type="number" id="final" name="final"
        min="0" max="50" step="0.01"
        value="<?php echo htmlspecialchars((string)$final_exam); ?>"
        required>
    <br><br>

    <input type="submit" name="submit" value="Submit">

</form>
