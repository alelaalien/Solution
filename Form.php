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

        if (isset($_POST['name'])) { 
 
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

                    echo '<script>alert("Employee added");</script>';
            }else{

                    echo '<script>alert("The request was canceled due to a security issue. Please try again later.");</script>';
            }
            
        }
     ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center text-capitalize text-muted">Add employee</h1>
                <form action="" method="POST" name="addEmployee" style="width: 80%; margin:auto;"> 
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter name..." required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" maxlength="2" name="age" id="age" aria-describedby="ageHelp" placeholder="Enter age..." onkeypress="return valideKey(event, false, this);" required>
                    </div>
                    <div class="form-group">
                        <label for="job">Job</label>
                        <input type="text" class="form-control" name="job" id="job" aria-describedby="jobHelp" placeholder="Enter job..." required>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control"  maxlength="11"  name="salary" id="salary" aria-describedby="salaryHelp" placeholder="Enter salary..."  onkeypress="return valideKey(event, true, this);"  required>
                        <span class="text-danger small d-none" >*Up to 10 digits</span>
                    </div>
                    <div class="form-group">
                        <label for="admissionDate">Admission date</label>
                        <input type="date" class="form-control" name="admissionDate" id="admissionDate" aria-describedby="admissionDateHelp" placeholder="Select date..." required>
                    </div> 
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" onclick="clearForm();">Cancel</button>
                        <button type="submit" class="btn btn-success" name="csrf-token" value="<?=$_SESSION['csrfToken']?>">Accept</button> 
                    </div> 
                </form>
            </div>  
        </div>
        <div class="row  pt-3">
            <div class="col-12">
                <div data-toggle="collapse" data-target="#otherMethods" aria-expanded="false" aria-controls="otherMethods" style="cursor: pointer;">
                    <h5 class="text-muted text-center text-capitalize">Others methods</h5>
                </div>
                <div class="collapse" id="otherMethods">
                  <div class="card card-body">
                    <?php

                    /*=============================================================================================
                                                           EXERCISE 4                                          
                     =============================================================================================*/
                    //A (getters and setters)
                    // B 
                    $employeer = new Employeer();
                    $averageEmployeesAge = $employeer->averageEmployeesAge();
                    
                    // C
                    $percent10 = 10; $percent50 = 50;
                    $simulator10 = Employeer::salaryIncreaseSimulator($percent10);
                    $simulator50 = Employeer::salaryIncreaseSimulator($percent50); 
                    // D
                    $functionList = $employeer->employeeFunction();
                    // E
                    $finishedProjects = $employeer->finishedProjects();
                    // F
                    $from = '05-01-2024'; $to = '07-05-2024';
                    $nextProjects = Employeer::nextProjectsToDeliver($from, $to);
                     


                    ?> 
                    <div class="container-fluid" style="background: #f5deb321;">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="font-weight-semi-bold">Average age: <?= $averageEmployeesAge ? $averageEmployeesAge : 'NO DATA YET' ?></h6>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"><h6>Salary simulator</h6></div>
                            <div class="col-lg-6 col-md-12"> 
                                <p class="text-muted text-center"> Example 1: <?= $percent10 ?>%</p>

                                    <table class="table table-hover">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th>Employee</th>
                                                <th>Current salary</th>
                                                <th>Increased salary</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php 

                                                foreach ($simulator10 as $key => $value) { ?> 
                                                <tr>
                                                    <td class="text-center"><?=$value['employee']?></td>
                                                    <td class="text-center"><?=$value['current_salary']?></td>
                                                    <td class="text-center"><?=$value['increased_salary']?></td>
                                                </tr> 

                                            <?php }

                                            if(count($simulator10) == 0){ ?>

                                            <tr>
                                                <td colspan="12" class="text-center text-muted"> NO DATA YET</td>
                                            </tr> 

                                        <?php } ?>
                                        </tbody>
                                    </table> 
                            </div>
                            <div class="col-lg-6 col-md-12"> 
                                <p class="text-muted text-center"> Example 2: <?= $percent50 ?>%</p>

                                    <table class="table table-hover">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th>Employee</th>
                                                <th>Current salary</th>
                                                <th>Increased salary</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php 

                                                foreach ($simulator50 as $key => $value) { ?> 
                                                <tr>
                                                    <td class="text-center"><?=$value['employee']?></td>
                                                    <td class="text-center"><?=$value['current_salary']?></td>
                                                    <td class="text-center"><?=$value['increased_salary']?></td>
                                                </tr> 

                                            <?php }

                                            if(count($simulator50) == 0){ ?>

                                            <tr>
                                                <td colspan="12" class="text-center text-muted"> NO DATA YET</td>
                                            </tr> 

                                        <?php } ?> 
                                        </tbody>
                                    </table> 
                            </div>
                            <hr> 
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Functions list</h6>
                                <table class="table table-striped text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Function</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-striped">
                                        <?php 

                                            foreach ($functionList as $key => $value) { ?>
                                                    
                                            <tr>
                                                <td><?=$value['employee']?></td>
                                                <td><?=$value['function']?></td>
                                            </tr>

                                        <?php }

                                            if(count($functionList) == 0){ ?>

                                            <tr>
                                                <td colspan="12" class="text-center text-muted"> NO DATA YET</td>
                                            </tr> 

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Finished projects</h6>
                                <table class="table  table-striped text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Cod.</th>
                                            <th>Value</th>
                                            <th>Description</th>
                                            <th>Delivery date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-striped">
                                        <?php  
 

                                           foreach ($finishedProjects as $key => $value) { ?>

                                            <tr>
                                                <td><?=$value['id']?></td> 
                                                <td><?=$value['value']?></td> 
                                                <td><?=$value['description']?></td>   
                                                <td><?=$value['delivery_date']?></td> 
                                            </tr> 
                                        <?php }

                                            if(count($finishedProjects) == 0){ ?>

                                            <tr>
                                                <td colspan="12" class="text-center text-muted"> NO DATA YET</td>
                                            </tr> 

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Unfinished projects</h6>
                                <p class="text-muted">Example date: from '05-01-2024' to '07-05-2024' </p>
                                <table class="table table-striped text-center">
                                    <thead class="thead-dark">
                                        <tr> 
                                            <th>Employee</th>
                                            <th>Project ID</th>
                                            <th>Description</th>
                                            <th>Value</th>
                                            <th>Delivery date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-striped">
                                        <?php  

                                           foreach ($nextProjects as $key => $next) { ?>

                                            <tr>
                                                <td><?=$next['employee']?></td> 
                                                <td><?=$next['id_project']?></td> 
                                                <td><?=$next['description']?></td> 
                                                <td><?=$next['value']?></td>   
                                                <td><?=$next['delivery_date']?></td> 
                                            </tr> 
                                        <?php }

                                            if(count($nextProjects) == 0){ ?>

                                            <tr>
                                                <td colspan="12" class="text-center text-muted"> NO DATA YET</td>
                                            </tr> 

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                     
                  </div>
                </div>
            </div>
              
                        
        </div>
    </div> 
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  
    <script>

         function clearForm() {

                document.forms["addEmployee"].reset();
            }
  
            const valideKey = (evt, decimal, input) =>{ 
  
                var code = (evt.which) ? evt.which : evt.keyCode;  
         
                if(code==8) {  return true;    }

                else if(code >= 48 && code <= 57) { 

                    if($(input).attr('name') == 'age' && $(input).val().length < 2){

                        return true;

                    }else if($(input).attr('name') == 'salary'){

                        if($(input).val().length < 11){ 
                           

                            $('.text-danger').addClass('d-none');

                            return true;

                        }else{
 
                            $('.text-danger').removeClass('d-none');
                        }

                    }else {return false; }

                }else if(decimal && (code == 46 || code == 44) && $(input).val().length > 0){ 
                    

                    if ($(input).val().includes('.') || $(input).val().includes(',')) {  

                        return false;

                    }else{

                        return true;
                    } 
                }

                else{ 

                    return false; 
                }
            } 

    </script>
</body>
</html>