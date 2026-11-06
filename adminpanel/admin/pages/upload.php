<?php
session_start();

if (!isset($_SESSION['admin']['adminnakalogin'])) {
    header("location: ../index.php"); // Adjusted path to index.php
    exit;
}

// Include the path to conn.php
include("../../../conn.php");

if (isset($_FILES['csv_file']) && isset($_POST['examId'])) {
    $examId = $_POST['examId'];
    $file = $_FILES['csv_file']['tmp_name'];

    if ($file) {
        $handle = fopen($file, "r");
        if ($handle !== FALSE) {
            // Skip the first line if it contains headers
            fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $question = $data[0];
                $choiceA = $data[1];
                $choiceB = $data[2];
                $choiceC = $data[3];
                $choiceD = $data[4];
                $correctAnswer = $data[5];

                try {
                    $stmt = $conn->prepare("INSERT INTO exam_question_tbl (exam_id, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$examId, $question, $choiceA, $choiceB, $choiceC, $choiceD, $correctAnswer]);
                } catch (PDOException $e) {
                    $_SESSION['message'] = "Error inserting data: " . $e->getMessage();
                    header("Location: manage_exam.php?id=$examId");
                    exit;
                }
            }

            fclose($handle);
            $_SESSION['message'] = "Questions uploaded successfully!";
        } else {
            $_SESSION['message'] = "Error opening the file!";
        }
    } else {
        $_SESSION['message'] = "File not found!";
    }
} else {
    $_SESSION['message'] = "No file uploaded or exam ID missing!";
}

header("Location: ../manage-exam.php?id=$examId");


exit;
?>