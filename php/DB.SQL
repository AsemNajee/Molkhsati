DROP DATABASE IF EXISTS the_database_name;
CREATE DATABASE IF NOT EXISTS the_database_name;

USE the_database_name;

CREATE TABLE IF NOT EXISTS photos(
    id INT(8) AUTO_INCREMENT PRIMARY KEY ,
	link VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS teachers(
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(127),
    info VARCHAR(512),
    gender ENUM('male', 'famale') DEFAULT 'male'
);
CREATE TABLE IF NOT EXISTS subjects(
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(127),
    info VARCHAR(512), 
    photo_id INT(8),
    teacher_id INT(8),
    FOREIGN KEY (teacher_id) REFERENCES teachers(id),
    FOREIGN KEY (photo_id) REFERENCES photos(id)
);
CREATE TABLE IF NOT EXISTS authers(
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(127),
    info VARCHAR(512),
    gender ENUM('male', 'famale') DEFAULT 'male'
);
CREATE TABLE IF NOT EXISTS sections(
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(127),
    info VARCHAR(512)
);
CREATE TABLE IF NOT EXISTS summaries(
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(127),
    info VARCHAR(512),
    link VARCHAR(255),
    published_at DATE DEFAULT CURRENT_TIMESTAMP,
    photo_id INT(8),
    subject_id INT(8),
    auther_id INT(8),
    section_id INT(8),
    FOREIGN KEY (photo_id) REFERENCES photos(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (auther_id) REFERENCES authers(id),
    FOREIGN KEY (section_id) REFERENCES sections(id)
);

CREATE TABLE IF NOT EXISTS links(
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
    subject_id INT(8), 
	name VARCHAR(127),
    info VARCHAR(512),
    link VARCHAR(255),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);






-- for my summaries in database course
-- CREATE TABLE student(
-- 	st_name VARCHAR(30),
--     st_id INT(5) PRIMARY KEY,
--     age INT(3) CHECK( age > 18 )
-- );
-- CREATE TABLE course(
-- 	c_name VARCHAR(30),
--     c_id INT(3) PRIMARY KEY,
--     hours INT(1)
-- );
-- CREATE TABLE student_marks(
-- 	st_id INT(5) REFERENCES student(st_id),
--     c_id INT(3) REFERENCES course(c_id),
--     marks INT(3),
--     PRIMARY KEY (st_id, c_id)
-- );