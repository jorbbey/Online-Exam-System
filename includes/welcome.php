<?php
include("conn.php");
include("query/selectData.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Card Design</title>
    <style>
        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            margin: auto 50px;
            width: 90%;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 50px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .card-title {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }

        .card-description {
            margin-top: 10px;
            font-size: 0.9em;
            color: #777;
            line-height: 1.6;
            text-align: center;
        }

        .card-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .card-button:hover {
            background-color: #0056b3;
        }

        .card .exam-ctn {
            display: none;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }


        .exam-list {
            width: 100%;
        }

        .exam-list .exam {
            text-decoration: none;
            color: #777;
        }

        .exam-list:hover {
            transform: translateX(10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <main>

        <!-- Exam Card -->
        <div class="card">
            <img src="assets/images/user-img.jpg" alt="Card Image">
            <div class="card-content">
                <h1 class="card-title">Welcome</h1>
                <h5><?php echo ($selExmneeData['exmne_fullname']); ?></h5>
                <p class="card-description">
                    You Should be well prepared for this examination
                </p>
                <p>Best of luck</p>
                <button class="card-button" onclick="showExamBox()">Start Exam</button>

                <!-- pop-up -->

                <div class="exam-ctn" id="exam-ctn">
                    <h4>Avialable exams</h4>
                    <p> <?php
                        if ($selExam->rowCount() > 0) {
                            while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { ?>
                                <li class="exam-list">
                                    <a href="#" id="startQuiz" class="exam" data-id="<?php echo $selExamRow['ex_id']; ?>">
                                        <?php
                                        $lenthOfTxt = strlen($selExamRow['ex_title']);
                                        if ($lenthOfTxt >= 23) { ?>
                                            <?php echo substr($selExamRow['ex_title'], 0, 20); ?>.....
                                        <?php } else {
                                            echo $selExamRow['ex_title'];
                                        }
                                        ?>
                                    </a>
                                </li>
                            <?php }
                        } else { ?>
                            <a href="#">
                                <i class="metismenu-icon"></i>No Exam's @ the moment
                            </a>
                        <?php }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Feeback Container -->

        <div class="card">
            <img src="assets/images/feedback-img-2.jpg" alt="Card Image">
            <div class="card-content">
                <h1 class="card-title">Write a feedback</h1>
                <h5><?php echo ($selExmneeData['exmne_fullname']); ?></h5>
                <p class="card-description">
                    Share your experience with your tutors
                </p>
                <button class="card-button" data-toggle="modal" data-target="#feedbacksModal">Write a feedback</button>

            </div>
        </div>
    </main>


    <script>
        const examBox = document.getElementById('exam-ctn');

        const showExamBox = () => {
            examBox.style.display = 'block';
        }
    </script>
</body>

</html>