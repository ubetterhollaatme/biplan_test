CREATE DATABASE `testcase`;

CREATE USER 'testcase'@'%' IDENTIFIED BY 'testcase';
GRANT ALL PRIVILEGES ON testcase.* TO 'testcase'@'%';
