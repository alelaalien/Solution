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
    status INT, --0: pendente, 1: pronto, 2: entregado
    delivery_date DATE
);
