<?php 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
require_once "config/config.php";

?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-qdQEsAI45WFCO5QwXBelBe1rR9Nwiss4rGEqiszC+9olH1ScrLrMQr1KmDR964uZ" crossorigin="anonymous">

<link rel="stylesheet" href="./style.css">
<body>

<div class="container mt-3">
		<?php 
			if(isset($_SESSION['file_upload'])){
		?>
			<div class="alert alert-success">
				<?php echo $_SESSION['file_upload'];?>
			</div>

		<?php		
			unset($_SESSION['file_upload']);
			}
		?>
    </div>
<form id="regForm" action="src/controller.php" method="post">

  <h1>Survey:</h1>
  <!-- One "tab" for each step in the form: -->
  <div class="tab" >
    
  </div>
  <div class="tab">
    Name:
    <p><input placeholder="Enter name..." oninput="this.className = ''" name="fname"></p>
    <!-- <p><input placeholder="Last name..." oninput="this.className = ''" name="lname"></p> -->
  </div>
  <div class="tab">Contact Info:
    <p><input placeholder="E-mail..." oninput="this.className = ''" name="email"></p>
    <!-- <p><input placeholder="Phone..." oninput="this.className = ''" name="phone"></p> -->
  </div>
  <div class="tab">Select your Profession:
    <!-- <p><input placeholder="dd" oninput="this.className = ''" name="dd"></p>
    <p><input placeholder="mm" oninput="this.className = ''" name="nn"></p>
    <p><input placeholder="yyyy" oninput="this.className = ''" name="yyyy"></p> -->
    <p><input type="radio" value="Developer" name="profession"> Developer</p>
    <p><input type="radio" value="Designer" name="profession"> Designer</p>

  </div>
  <div class="tab">Programming Language:
    <p><textarea oninput="this.className = ''" name="lang"></textarea></p>
    
  </div>
  <div class="tab">Design Tools:
    <p><textarea oninput="this.className = ''" name="tool"></textarea></p>
    
  </div>
  <div class="tab">Year of Experience:
    <p><input oninput="this.className = ''" name="exp"></p>
    
  </div>
  <div class="tab">
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" name="save" id="nextBtn" value="Next" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- <script src="./app.js"></script> -->
<script>
  // alert('ok');
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  
  
  if (n == 0) {

    document.getElementById("prevBtn").style.display = "none";
    
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    
    document.getElementById("nextBtn").innerHTML = "Submit";
    
    var btn = document.getElementById('nextBtn');
    btn.removeAttribute('type');
    btn.setAttribute('type', 'submit');
  }
  else {
        
          if(n==0)
          {
            
            document.getElementById("nextBtn").innerHTML = "Let's Start";
            document.getElementById("nextBtn").style.marginRight = "370px";
          }
          else
          {
            document.getElementById("nextBtn").innerHTML = "Next";
            
          }
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)

}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

</script>
</body>
</html>
