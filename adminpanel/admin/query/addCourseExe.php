<?php

include("../../../conn.php");

if ($conn === null) {
die(json_encode(array("res" => "failed", "message" => "Database connection failed")));
}

extract($_POST);

if (!isset($course_name) || empty($course_name)) {
die(json_encode(array("res" => "failed", "message" => "Course name is required")));
}

$course_name = strtoupper($course_name);

try {
// Start transaction
$conn->beginTransaction();

// Debugging: Log the course name being processed
error_log("Processing course: $course_name");

// Check if course already exists
$selCourse = $conn->prepare("SELECT * FROM course_tbl WHERE UPPER(cou_name) = :course_name");
$selCourse->bindParam(':course_name', $course_name);
$selCourse->execute();

if ($selCourse->rowCount() > 0) {
// Debugging: Log if course already exists
error_log("Course already exists: $course_name");

// If course exists, rollback transaction and set response
$conn->rollBack();
$res = array("res" => "exist", "course_name" => $course_name);
} else {
// Insert new course
$insCourse = $conn->prepare("INSERT INTO course_tbl (cou_name) VALUES (:course_name)");
$insCourse->bindParam(':course_name', $course_name);

if ($insCourse->execute()) {
// Debugging: Log successful insert
error_log("Course added successfully: $course_name");

// Commit transaction if insert is successful
$conn->commit();
$res = array("res" => "success", "course_name" => $course_name);
} else {
// Debugging: Log failed insert
error_log("Failed to add course: $course_name");

// Rollback transaction if insert fails
$conn->rollBack();
$res = array("res" => "failed", "course_name" => $course_name);
}
}
} catch (Exception $e) {
// Debugging: Log exception
error_log("Exception: " . $e->getMessage());

// Rollback transaction in case of an exception
$conn->rollBack();
$res = array("res" => "failed", "message" => $e->getMessage());
}

echo json_encode($res);


// include("../../../conn.php");

// extract($_POST);

// $course_name = strtoupper($course_name);
// $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_name='$course_name' ");

// if($selCourse->rowCount() > 0)
// {
// $res = array("res" => "exist", "course_name" => $course_name);
// }
// else
// {

// $insCourse = $conn->query("INSERT INTO course_tbl(cou_name) VALUES('$course_name') ");
// if($insCourse)
// {
// $res = array("res" => "success", "course_name" => $course_name);
// }
// else
// {
// $res = array("res" => "failed", "course_name" => $course_name);
// }


// }




// echo json_encode($res);
?>