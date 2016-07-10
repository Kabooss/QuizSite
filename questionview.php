<?
// Code mostly unmodified, addition of ajax function *doesnt seem to work?*
?>

<!doctype html>
<html>
<head>
<?php $this->load->helper("url"); ?>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
	      rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Libre+Baskerville' rel='stylesheet' type='text/css'>
	<style>
		body {
			padding-top: 70px; /* needed to position navbar properly */
			font-family: 'Libre Baskerville', serif;
			} 
		.answerColor{
			color:blue;
		}
		.testClass{}
	</style>
	 <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
	<script>
	
	$(document).ready(function(){
		$(".testClass").click(function(){
			
			$.ajax({
				type:"POST",
				url:"<?php echo base_url() ?>index.php/quizzes/checkAnswer",
				data:{
					answer:$('.testClass :selected').val(),
					qid:$qindex
					},
				success: function(result)
				{
					
					if(result == "OK")
						{
						$(".answerColor").css('color', 'green');
						window.alert(result);
						}else{
							$(".answerColor").css("color", "red");
							window.alert(result);
						}
				}
				error: function(xhr, result, errorThrown){
					window.alert('failed');
				}
			});
		});
	});
	
	
	
	
	</script>
	
	
	
	
	
	
	<title>QuizMachine!</title>
</head>
<body>
	
	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
	  <div class="container">
		<div class="container-fluid">
		    <div class="navbar-header">
		      <p class="navbar-brand">
		        <a href="../../index.php/quizzes/">QuizMachine!</a>
		      </p>
		    </div>
		  </div>
	  </div>
	</nav>
	<div class="container">
		<div class='row'>
				<div class="col-md-8">
        			<h2>The <?php echo $quiz['name'] ?> quiz</h2>
				</div> <!-- col-md-8 -->
				<div class="col-md-8">
					You are this far through the quiz!
				<div class="progress">
					<?php
						if ($qindex > 0) {
						   $progress = ceil(($qindex / $quiz['quizsize']) * 100); // look up ceil() on php.net
						}
						else {
						   $progress = 0;
						}
					?>
					
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $progress ?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;width:<?php echo $progress ?>%" style="width:<?php echo $progress ?>%">
				    <?php echo $progress ?>%
				  </div>
				</div>
			</div>
				<div class="col-md-8">
					<h4>Question <?php echo ($qindex+1) ?></h4>
					<p>
						<?php
							// echo out question title
							// remember that the $question array contains both the question (as key 'q') and
							// the answers (as key 'a')
							echo $question['q']['question'];
						?>
					</p>
					<form class="form" method="POST" action="../../index.php/quizzes/next">
						<?php
							// loop over the answers and print out each as a radio button
							foreach ($question['a'] as $a) {
								// note that the value of the radio button is the answer id field, not the answer itself
						?>
								<div class="radio">
								  <label>
								    <input type="radio" class="testClass" name="answer" value="<?php echo $a['id'] ?>">
								     <p class="answerColor"><?php echo $a['answer'] ?></p>
								  </label>
								</div>
						<?php
							}
						?>
						<!-- now add hidden fields - see comments in controller for meanings of these fields -->
						<input type=hidden name="currq" value="<?php echo $question['q']['id'] ?>"> <!-- which q are we answering? -->
						<input type=hidden name="qindex" value="<?php echo $qindex ?>">             <!-- what pos in the qlist we are? -->
						<input type=hidden name="qlist" value="<?php echo implode(':',$qlist) ?>">  <!-- ids of all questions in quiz -->
						<input type=hidden name="alist" value="<?php echo $alist ?>">               <!-- ids of answers so far  -->
						<input type=hidden name="quiz" value="<?php echo $quiz['id']?>">
						<input type=submit value="Submit your answer!">
					</form>
				</div> <!-- col-md-8 -->
				
		</div> <!-- row -->
	</div> <!-- container -->
	
</body>

</html>


-------------------------------------------
//This is the function the ajax should be running.

public function checkAnswer(){
		
		$ansid = array($_POST['answer']);
		$qid = array($_POST['qid']);
		//get answer id, and quid id.
		$result = $this->quiz->score($qid, $aid);
		
		if($result === true){
			if($result >=1){
				echo "OK";
				
			}else{
				echo "$result";
			}
			}else{
				echo "failed";
		}
		
	}	
	 
