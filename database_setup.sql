CREATE DATABASE employeer;
CREATE TABLE employees(
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    age INT,
    job VARCHAR(50),
    salary DECIMAL(10, 2),
    admission_date DATE
    );
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_employee INT,
    description VARCHAR(100),
    value DECIMAL(10, 2),
    status VARCHAR (20), --entregar, concluido
    delivery_date DATE
);
ALTER TABLE projects ADD FOREIGN KEY (id_employee) REFERENCES employees(id) ON DELETE RESTRICT ON UPDATE RESTRICT; 