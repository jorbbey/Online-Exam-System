<?php
require '../../../conn.php';
require '../dompdf/vendor/autoload.php';

// use Dompdf\Dompdf;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['exmne_id'])){
    $exmne_id = $_GET['exmne_id'];

    if (!$conn) {
        die('Connection Failed: ' . mysqli_connect_error());
    }
    // fetch examinee details
    $selExmne = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id = '$exmne_id'")->fetch(PDO::FETCH_ASSOC);

    if (!$selExmne) {
        die("Error fetching examinee details: " . $conn->errorInfo());
    }
    // fetch exam details
    $selExName = $conn->query("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id=ea.exam_id WHERE ea.exmne_id='$exmne_id'")->fetch(PDO::FETCH_ASSOC);

    if (!$selExName) {
        die('Error fetching exam details: ' . $conn->errorInfo());
    }
    $exam_id = $selExName['ex_id'];
    $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer WHERE ea.axmne_id='$exmne_id' AND ea.exam_id='$exam_id' AND ea.exans_status='new'");

    if (!$selScore) {
        die('Error fetching score details: ' . $conn->errorInfo());
    }

    $score = $selScore->rowCount();
    $over = $selExName['ex_questlimit_display'];
    $percentage = round(($score / $over) * 100,2);

    // generate html content

    $htmlContent = "
        <h1>Results</h1>
        <p>Fullname: {$selExmne['exmne_fullname']}</p>
        <p>Exam Name: {$selExName['ex_title']}</p>
        <p>Percntage: $percentage%</p>
    ";

    echo $htmlContent;

    echo '<button onclick="printBtn()" id="btn">Print Result</button>
            
 <script>
 const button = document.getElementById(btn)

     const printBtn = () => {
         window.print();
        button.display="block" ? button.display="none" : button.display="block";
     }
 </script>
    ';
//     //initialize Dompdf
//     $dompdf = new Dompdf();
//     $dompdf->loadHtml($htmlContent);
//     $dompdf->setPaper('A4', 'portrait');
//     $dompdf->render();

//     $output = $dompdf->output();
//     if ($output === false) {
// $dompdfErrors = $dompdf->get_canvas()->get_cpdf()->messages;
// foreach($dompdfErrors as $error){
//     echo"<p>Error: $error</p>";
// };
//     } else{

//         $dompdf->stream('result.pdf', array("Attachment" => true));
//     }
}
