
CREATE DATABASE cyber_project;
USE cyber_project;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100),
  otp INT
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  description TEXT,
  price DECIMAL(10,2)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  course VARCHAR(100),
  price DECIMAL(10,2),
  purchase_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
