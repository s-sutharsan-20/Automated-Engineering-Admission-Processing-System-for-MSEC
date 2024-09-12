<?php
if (isset($_POST["submit"])) {
    $register_no = filter_input(INPUT_POST, 'registerNumber', FILTER_SANITIZE_NUMBER_INT);
    $student_name = filter_input(INPUT_POST, 'studentName', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $phone_no = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $hse_mark = filter_input(INPUT_POST, 'hseMark', FILTER_SANITIZE_NUMBER_INT);
    $maths = filter_input(INPUT_POST, 'mathsMark', FILTER_SANITIZE_NUMBER_INT);
    $physics = filter_input(INPUT_POST, 'physicsMark', FILTER_SANITIZE_NUMBER_INT);
    $chemistry = filter_input(INPUT_POST, 'chemistryMark', FILTER_SANITIZE_NUMBER_INT);
    $cs1 = filter_input(INPUT_POST, 'choice1', FILTER_SANITIZE_STRING);
    $cs2 = filter_input(INPUT_POST, 'choice2', FILTER_SANITIZE_STRING);
    $cs3 = filter_input(INPUT_POST, 'choice3', FILTER_SANITIZE_STRING);

    if ($register_no !== false && $student_name && $hse_mark !== false && $phone_no !== false && $maths !== false && $physics !== false && $chemistry !== false && $cs1 && $cs2 && $cs3) {
        $cutoff = $maths + ($chemistry + $physics) / 2;

        $courses = [
            ['code' => 'BE01 - CIVIL', 'min_cutoff' => 140, 'seats' => 50],
            ['code' => 'BE02 - EEE', 'min_cutoff' => 150, 'seats' => 50],
            ['code' => 'BE03 - ECE', 'min_cutoff' => 165, 'seats' => 60],
            ['code' => 'BE04 - CSE', 'min_cutoff' => 170, 'seats' => 60],
            ['code' => 'BE05 - MECH', 'min_cutoff' => 130, 'seats' => 50],
            ['code' => 'BE06 - BME', 'min_cutoff' => 160, 'seats' => 50],
            ['code' => 'BT01 - IT', 'min_cutoff' => 175, 'seats' => 60],
            ['code' => 'BT02 - AI&DS', 'min_cutoff' => 185, 'seats' => 60],
            ['code' => 'BT03 - AI&R', 'min_cutoff' => 175, 'seats' => 50],
            ['code' => 'BT04 - BIOTECH', 'min_cutoff' => 165, 'seats' => 40],
        ];
        function allocateCourse($cs1, $cs2, $cs3, $cutoff, &$courses) {
            foreach ([$cs1, $cs2, $cs3] as $choice) {
                foreach ($courses as &$course) {
                    if ($choice === $course['code'] && $cutoff >= $course['min_cutoff'] && $course['seats'] > 0) {
                        $course['seats']--;
                        return $course['code'];
                    }
                }
            }
            return 'NIL'; 
        }

        $allotted_course = allocateCourse($cs1, $cs2, $cs3, $cutoff, $courses);

        $link = mysqli_connect("localhost", "root", "", "application");
        if ($link == false) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO student_details (register_no, student_name, gender, phone_no, email, hse_mark, maths_mark, physics_mark, chemistry_mark, choice_1, choice_2, choice_3, cutt_off, allotted_course) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "issdsiiiisssis", $register_no, $student_name, $gender, $phone_no, $email, $hse_mark, $maths, $physics, $chemistry, $cs1, $cs2, $cs3, $cutoff, $allotted_course);

        if (mysqli_stmt_execute($stmt)) {
            echo "Details Submitted Successfully";
            header("Location: submission.html");
        } else {
            echo "Something went wrong: " . mysqli_error($link);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($link);
    } else {
        echo "Please Provide all Information";
    }
}
?>
