<?php 
 require_once "Connection.php";
class Employeer
{	
	// employee vars
	private $name, $age, $job, $salary, $admissionDate, $id;
	// project vars
	private $id_project, $idEmployeeProject, $description, $value, $status, $deliveryDate;

 

	
	function __construct(){}

/*----------  store  ----------*/

	public static function storeEmployee($data)
	{	

		try {
			
			$salary = number_format($data->salary, 2, '.', '');

			$date = date('Y-m-d', strtotime($data->admissionDate));
				
			$stm = Connection::connect()->prepare(

				"INSERT INTO employees (name, age, job, salary, admission_date) 
				VALUES (:name, :age, :job, :salary, :admission_date)"

			);
			
			$stm->bindParam(":name", $data->name, PDO::PARAM_STR);
			$stm->bindParam(":age", $data->age, PDO::PARAM_INT);
			$stm->bindParam(":job", $data->job, PDO::PARAM_STR);
			$stm->bindParam(":salary", $salary, PDO::PARAM_STR);
			$stm->bindParam(":admission_date", $date, PDO::PARAM_STR);

			$result = $stm->execute();

			return $result;
			 

		} catch (PDOException $e) {

			echo "Error: " . $e->getMessage(); 

		}finally {
         
        	if ($stm !== null) {  $stm = null;  }
    	}
	}
/*----------  getters  ----------*/

	public function getName()
	{
		return $this->name ;
	}
	public function getAge()
	{
		return $this->age;
	}
	public function getJob()
	{
		return $this->job;
	}
	public function getSalary()
	{
		return $this->salary;
	}
	public function getAdmissionDate()
	{
		return $this->admissionDate;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getId_project()
	{
		return $this->id_project;
	}
		public function getIdEmployeeProject()
	{
		return $this->idEmployeeProject;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getValue()
	{
		return $this->value;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getDeliveryDate()
	{
		return $this->deliveryDate;
	}
	
/*----------  setters  ----------*/

// Considerei que não seria ideal definir os métodos setId para não interferir na gestão automática do banco de dados

	public function setName($name)
	{
		$this->name=$name;
	}

	public function setAge($age)
	{
		try {

            $intValue = filter_var($age, FILTER_VALIDATE_INT);

            if ($intValue === false || $intValue === null) {

                throw new InvalidArgumentException("Not valid number");
            }

           $this->age=$intValue;

        } catch (InvalidArgumentException $e) {
          
            echo "Error: " . $e->getMessage();
        }
		
	}

	public function setJob($job)
	{
		$this->job=$job;
	}

	public function setSalary($salary)
	{
		try {

			$salary = str_replace(',', '.', $salary);

            $validDecimal = number_format($salary, 2, '.', '');

            if (!is_numeric($validDecimal)) {
         
                throw new InvalidArgumentException("A valid decimal number with up to two decimal places is expected");
            }

            $this->salary=$validDecimal;

        } catch (InvalidArgumentException $e) {
   
            echo "Error: " . $e->getMessage();
        }
  
	}

	public function setAdmissionDate($admissionDate)
	{
		try {

            $validDate = new DateTime($admissionDate);
 
            $errors = DateTime::getLastErrors();

            if ($errors['error_count'] > 0 || $errors['warning_count'] > 0) {

                throw new InvalidArgumentException("Formatted 'YYYY-MM-DD' expected");
            }

            $this->admissionDate = $validDate->format('Y-m-d');  

        } catch (Exception $e) {
            
            echo "Error: " . $e->getMessage();
        } 
	}
	public function setIdEmployeeProject($idEmployeeProject)
	{
		// Considerando que, a partir da execução do método set, um valor de ID existente é recebido
		
		try {

            $validNumber = filter_var($idEmployeeProject, FILTER_VALIDATE_INT);

            if ($validNumber === false || $validNumber === null) {

                throw new InvalidArgumentException("Not valid employee ID");
            }

       		$this->idEmployeeProject=$validNumber;

        } catch (InvalidArgumentException $e) {
          
            echo "Error: " . $e->getMessage();
        }
 
	}

	public function setValue($value)
	{
		try {

			$value = str_replace(',', '.', $value);

            $validDecimal = number_format($value, 2, '.', '');

            if (!is_numeric($validDecimal)) {
         
                throw new InvalidArgumentException("A valid decimal number with up to two decimal places is expected");
            }

            $this->value=$validDecimal;

        } catch (InvalidArgumentException $e) {
   
            echo "Error: " . $e->getMessage();
        }
	}

	public function setDeliveryDate($deliveryDate)
	{
		try {

            $validDate = new DateTime($deliveryDate);
 
            $errors = DateTime::getLastErrors();

            if ($errors['error_count'] > 0 || $errors['warning_count'] > 0) {

                throw new InvalidArgumentException("Formatted 'YYYY-MM-DD' expected");
            }

            $this->deliveryDate = $validDate->format('Y-m-d');  

        } catch (Exception $e) {
            
            echo "Error: " . $e->getMessage();
        } 
	}

	public function setStatus($status)
	{ 
       	$this->status=$status;
 
	}

	public function setDescription($description)
	{
		$this->description=$description;
	}
 /*----------   other methods   ----------*/

	public function averageEmployeesAge()
	{
		try {

			$st = Connection::connect()->prepare("SELECT ROUND(AVG(age)) as average_employee_age FROM employees");

			$st->execute();

			$result = $st->fetch();

			if ($result !== false) {

				return $result['average_employee_age'];

			} else { 

				return null;
			}

		} catch (PDOException $e) {

			echo "Error: " . $e->getMessage(); 
		}finally {
         
        	if ($st !== null) {  $st = null;  }
    	}
	}

	public function employeeFunction()
	{
		try {
			$st = Connection::connect()->prepare("SELECT name as employee, job as function FROM employees");

			$st->execute();

			$result = $st->fetchAll();

			$st = null; 

			return $result; 

		} catch (PDOException $e) {

			echo "Error: " . $e->getMessage();

			return false;
		
		}finally {
         
        	if ($st !== null) {  $st = null;  }
    	}
	}

	public static function salaryIncreaseSimulator($percent)
	{	
		$value = $percent/100 + 1; 

		try {
			$st = Connection::connect()->prepare("SELECT name as employee, salary as current_salary, (salary * :value) increased_salary from employees");
			$st->bindParam(":value", $value, PDO::PARAM_STR);
			$st->execute();

			$result = $st->fetchAll();

			$st = null; 

			return $result; 

		} catch (PDOException $e) {

			echo "Error: " . $e->getMessage();
 
		}finally {
         
        	if ($st !== null) {  $st = null;  }
    	}
	}

	public function finishedProjects()
	{
		try{

			$statement = Connection::connect()->prepare("SELECT * FROM projects
						 where status = 'concluido' and YEAR(delivery_date) = YEAR(CURRENT_DATE) 
						 ORDER BY delivery_date DESC");

			if($statement->execute()){

				$result = $statement->fetchAll();

				$statement = null;

				return $result;

			}else{

				return 'error';
			} 
		}catch(Exception $e){
			
			echo "Error: " . $e->getMessage();

		}finally {
         
        	if ($statement !== null) {  $statement = null;  }
    	}
	}

	public static function nextProjectsToDeliver($from, $to)
	{
		try{

			$validDateFrom = new DateTime($from);
 
            $errorFrom = DateTime::getLastErrors();

            $validDateTo = new DateTime($to);

            $errorTo = DateTime::getLastErrors();

            if($errorFrom['error_count'] > 0 || $errorFrom['warning_count'] > 0){

            	throw new InvalidArgumentException("Formatted 'YYYY-MM-DD' expected for the first date");
            }

            if($errorTo['error_count'] > 0 || $errorTo['warning_count'] > 0){

            	throw new InvalidArgumentException("Formatted 'YYYY-MM-DD' expected for the second date");
            }

            $fromDate 	= $validDateFrom->format('Y-m-d');

            $toDate 	= $validDateTo->format('Y-m-d');

            $stm = Connection::connect()->prepare(
            	"SELECT e.name as employee, p.id_employee, p.id as id_project,
				p.description, p.value, p.delivery_date, p.status
				FROM projects p 
				LEFT JOIN employees e on e.id = p.id_employee 
				where status = 'entregar' and
				delivery_date BETWEEN :fromDate AND  :toDate   
				ORDER BY id_employee,  delivery_date;");

            $stm->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);

            $stm->bindParam(':toDate', $toDate, PDO::PARAM_STR);

            $stm->execute();

            $result = $stm->fetchAll();

            $stm = null;

            return $result;

		}catch(Exception $e){

			echo "Error: " . $e->getMessage();
  
		}finally {
         
        	if ($stm !== null) {  $stm = null;  }
    	}
	}

}