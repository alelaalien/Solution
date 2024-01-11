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

			if($stm->execute())
			{

				return true;
			}else{

				return false;
			} 

			$stm = null;

		} catch (PDOException $e) {

			echo "Error: " . $e->getMessage();

			return false;
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
		try {

            $validNumber = filter_var($status, FILTER_VALIDATE_INT);

            if ($validNumber === false || $validNumber === null ) {

                throw new InvalidArgumentException("Not valid status number. The allowed values ​​are: 0 (pending)/ 1 (finished)/ 2 (delivered)");
            }

       		$this->status=$validNumber;

        } catch (InvalidArgumentException $e) {
          
            echo "Error: " . $e->getMessage();
        }
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

			return false;
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
		}
	}

	public function salaryIncreaseSimulator($percent)
	{	
		$value = $percent/100;
		try {
			$st = Connection::connect()->prepare("SELECT name as employee, salary as current_salary, (salary * 1.1) increased_salary from employees");

			$st->execute();

			$result = $st->fetchAll();

			$st = null; 

			return $result; 

		} catch (PDOException $e) {

			echo "Error: " . $e->getMessage();

			return false;
		}
	}


}