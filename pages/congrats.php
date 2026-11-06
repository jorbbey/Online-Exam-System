 <?php
    $examId = $_GET['id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$examId' ")->fetch(PDO::FETCH_ASSOC);

    ?>

 <div class="app-main__outer">
     <div class="app-main__inner">
         <div id="refreshData">

             <div class="col-md-12">
                 <div class="app-page-title">
                     <div class="page-title-wrapper">
                         <div class="page-title-heading">
                             <div>
                                 <?php echo $selExam['ex_title']; ?>
                                 <div class="page-title-subheading">
                                     <?php echo $selExam['ex_description']; ?>
                                 </div>

                             </div>
                         </div>
                     </div>
                 </div>

                 <!-- <div class="row col-md-12" style="display: flex; justify-content: center; align-items: center;">
                     <h1 class="text-primary">RESULT'S</h1>
                 </div> -->

                 <div class="row col-md-12 float-left" style="display: flex; justify-content: center; align-items: center;">
                     <div class="main-card mb-3 card" style="width: 100%;">
                         <h1>Congratulations</h1>
                         <p>You've successfully completed
                             <span>
                                     <?php echo $selExam['ex_description']; ?>
                                 
                                 ( <?php echo $selExam['ex_title']; ?> )
                             </span>
                             examination
                         </p>
                     </div>
                 </div>

                 <div class="col-md-12 float-left" style=" display: flex; align-items: center; flex-wrap: wrap;">
             </div>


         </div>
     </div>
 </div>