<?php

require "Employeer.php";

    session_start(); 
    //csrf token*
    if (!isset($_SESSION['csrfToken'])) {
            //token 32 bytes
            $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
        } 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Employeer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <!-- style sheets -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> 
</head>
<body> 
    <?php  

        if (isset($_POST['addEmployee'])) { 
 
            if(isset($_POST['csrf-token']) && $_POST['csrf-token'] === $_SESSION['csrfToken'])
            {

                $newEmployee = new Employeer();
                
                $newEmployee->setName($_POST['name']);

                $newEmployee->setAge($_POST['age']);

                $newEmployee->setJob($_POST['job']);

                $newEmployee->setSalary($_POST['salary']);

                $newEmployee->setAdmissionDate($_POST['admissionDate']);
 
                $store = Employeer::storeEmployee($newEmployee);
   
                if($newEmployee)

                    echo '<script>added();</script>';
            }else{

                    echo '<script>alert("The request was canceled due to a security issue. Please try again later.");</script>';
            }
            
        }
     ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center text-uppercase text-muted">Add employee</h1>
                <form action="" method="POST" name="addEmployee" style="width: 80%; margin:auto;">
                    <input type="hidden" name="csrf-token" value="<?=$_SESSION['csrfToken']?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter name..." required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" name="age" id="age" aria-describedby="ageHelp" placeholder="Enter age..." required>
                    </div>
                    <div class="form-group">
                        <label for="job">Job</label>
                        <input type="text" class="form-control" name="job" id="job" aria-describedby="jobHelp" placeholder="Enter job..." required>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control" name="salary" id="salary" aria-describedby="salaryHelp" placeholder="Enter salary..." required>
                    </div>
                    <div class="form-group">
                        <label for="admissionDate">Admission date</label>
                        <input type="date" class="form-control" name="admissionDate" id="admissionDate" aria-describedby="admissionDateHelp" placeholder="Select date..." required>
                    </div> 
                    <div class="text-center">
                        <button class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success" name="addEmployee">Accept</button>
                    </div> 
                </form>
            </div>
        </div>
    </div> 
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  
    <script>
        const added = () =>{

            console.log('added');
        }
    </script>
</body>
</html>