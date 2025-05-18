
CREATE DATABASE cyber_project;
USE cyber_project;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255),
    google_id VARCHAR(255) UNIQUE,
    otp INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_id VARCHAR(100),
    full_name VARCHAR(100),
    email VARCHAR(100),
    amount DECIMAL(10,2),
    status VARCHAR(50),
    payment_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

