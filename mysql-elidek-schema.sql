SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS ELIDEK;
CREATE SCHEMA ELIDEK;
USE ELIDEK;

CREATE TABLE organisation (
    organisation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    org_name VARCHAR(100) NOT NULL,
    abbreviation VARCHAR(20) NOT NULL,
    org_type ENUM("University", "Research Centre", "Company"),
    city VARCHAR(50) NOT NULL,
    postal_code VARCHAR(20) DEFAULT NULL,
    street VARCHAR(45) NOT NULL,
    street_number INT NOT NULL,
    PRIMARY KEY (organisation_id),
    KEY category (organisation_id, org_type)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE research_centre (
    organisation_id INT UNSIGNED NOT NULL,
    org_type ENUM("Research Centre") NOT NULL,
    budget_from_ed_ministry REAL UNSIGNED DEFAULT NULL,
    budget_from_private REAL UNSIGNED DEFAULT NULL,
    PRIMARY KEY (organisation_id),
    KEY idx_fk_org (organisation_id),
    CONSTRAINT fk_organisation_RC FOREIGN KEY (organisation_id)
        REFERENCES organisation (organisation_id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE university (
    organisation_id INT UNSIGNED NOT NULL,
    org_type ENUM("University") NOT NULL,
    budget_from_ed_ministry REAL UNSIGNED DEFAULT NULL,
    PRIMARY KEY (organisation_id),
    KEY idx_fk_org (organisation_id),
    CONSTRAINT fk_organisation_U FOREIGN KEY (organisation_id)
        REFERENCES organisation (organisation_id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE company (
    organisation_id INT UNSIGNED NOT NULL,
    org_type ENUM("Company") NOT NULL,
    assets REAL UNSIGNED DEFAULT NULL,
    PRIMARY KEY (organisation_id),
    KEY idx_fk_org (organisation_id),
    CONSTRAINT fk_organisation_C FOREIGN KEY (organisation_id)
        REFERENCES organisation (organisation_id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE researcher (
    researcher_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    researcher_name VARCHAR(100) NOT NULL,
    sex ENUM('male', 'female') NOT NULL,
    birthdate DATE NOT NULL,
    age INT as (datediff(curdate(), birthdate) div 365),
	organisation_id INT UNSIGNED NOT NULL,
    org_starting_date DATE NOT NULL,
    PRIMARY KEY (researcher_id),
    KEY idx_fk_org (organisation_id),
    CONSTRAINT fk_organisation_id FOREIGN KEY (organisation_id)
        REFERENCES organisation (organisation_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE supervisor (
    supervisor_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    researcher_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (supervisor_id),
	KEY idx_fk_researcher_s (researcher_id),
    KEY idx_fk_project_s (project_id),
    CONSTRAINT fk_project_id3 FOREIGN KEY (project_id)
        REFERENCES project (project_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_researcher_id3 FOREIGN KEY (researcher_id)
        REFERENCES researcher (researcher_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE evaluator (
    evaluator_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    researcher_id INT UNSIGNED NOT NULL,
    grade ENUM('A', 'B', 'C', 'D', 'E', 'F') DEFAULT 'F',
    evaluation_date DATE,
    PRIMARY KEY (evaluator_id , project_id),
    KEY idx_fk_researcher (researcher_id),
    KEY idx_fk_project (project_id),
    CONSTRAINT fk_project_id4 FOREIGN KEY (project_id)
        REFERENCES project (project_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_researcher_id4 FOREIGN KEY (researcher_id)
        REFERENCES researcher (researcher_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

ALTER TABLE evaluator ADD CONSTRAINT passing_grade CHECK (grade <> 'F');

CREATE TABLE project (
    project_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    summary TEXT DEFAULT NULL,
    funding_amount REAL UNSIGNED NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    duration INT as (datediff(end_date, start_date) div 365),
    executive_id INT UNSIGNED NOT NULL,
    programm_id INT UNSIGNED NOT NULL,
    organisation_id INT UNSIGNED NOT NULL,
    supervisor_id INT UNSIGNED NOT NULL,
    evaluator_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (project_id),
    KEY idx_fk_executive_id (executive_id),
    KEY idx_fk_programm_id (programm_id),
    KEY idx_fk_organisation_id (organisation_id),
    KEY idx_fk_supervisor_id (supervisor_id),
    KEY idx_fk_evaluator_id (evaluator_id),
    /*
    CONSTRAINT fk_executive FOREIGN KEY (executive_id)
        REFERENCES executive (executive_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_programm FOREIGN KEY (programm_id)
        REFERENCES programm (programm_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_organisation FOREIGN KEY (organisation_id)
        REFERENCES organisation (organisation_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_supervisor FOREIGN KEY (supervisor_id)
        REFERENCES supervisor (supervisor_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_evaluator FOREIGN KEY (evaluator_id)
        REFERENCES evaluator (evaluator_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
      */  
    CONSTRAINT project_funding CHECK (funding_amount >= 100000 AND funding_amount <= 1000000)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

ALTER TABLE project ADD CONSTRAINT project_duration CHECK (duration <= 4 and duration >= 1);

CREATE TABLE researcher_in_project (
    researcher_id INT UNSIGNED NOT NULL,
	project_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (researcher_id , project_id),
    KEY idx_fk_researcher (researcher_id),
    KEY idx_fk_project (project_id),
    CONSTRAINT fk_researcher_id2 FOREIGN KEY (researcher_id)
        REFERENCES researcher (researcher_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_project_id2 FOREIGN KEY (project_id)
        REFERENCES project (project_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE phone (
    phone VARCHAR(10) NOT NULL,
    organisation_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (phone , organisation_id),
    KEY idx_fk_org_phone (organisation_id),
    CONSTRAINT fk_organisation_phone FOREIGN KEY (organisation_id)
        REFERENCES organisation (organisation_id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE executive (
    executive_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    executive_name VARCHAR(200) NOT NULL,
    PRIMARY KEY (executive_id)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE programm (
    programm_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    programm_name VARCHAR(100) NOT NULL,
    unit VARCHAR(200) NOT NULL,
    PRIMARY KEY (programm_id)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE scientific_field (
    field_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name_sci_field VARCHAR(100) NOT NULL,
    PRIMARY KEY (field_id)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE project_scientific_field (
    project_id INT UNSIGNED NOT NULL,
    field_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (project_id , field_id),
    KEY idx_fk_project_id (project_id),
    KEY idx_fk_sci (field_id),
    CONSTRAINT fk_project_id FOREIGN KEY (project_id)
        REFERENCES project (project_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_sci FOREIGN KEY (field_id)
        REFERENCES scientific_field (field_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE deliverable (
    title VARCHAR(50) NOT NULL,
    summary TEXT DEFAULT NULL,
    delivery_date DATE DEFAULT NULL,
    project_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (title , project_id),
    KEY idx_fk_project (project_id),
    CONSTRAINT fk_project FOREIGN KEY (project_id)
        REFERENCES project (project_id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

create index idx_project_id on project(project_id);
create index idx_researcher_id on researcher(researcher_id);
create index idx_organisation_id on organisation(organisation_id);
create index idx_executive_id on executive(executive_id);

###########################################################
# TRIGGERS
###########################################################

DELIMITER $

CREATE TRIGGER ins_type_company_in_organisation BEFORE INSERT ON company FOR EACH ROW BEGIN
	IF ((new.org_type) <> 
		(SELECT org_type FROM organisation as o WHERE o.organisation_id = new.organisation_id))  
	THEN
        SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot add company: Company cannot be different from organisation company';
      END IF; 
      END $
   
CREATE TRIGGER ins_type_university_in_organisation BEFORE INSERT ON university FOR EACH ROW BEGIN
	IF ((new.org_type) <> 
		(SELECT org_type FROM organisation as o WHERE o.organisation_id = new.organisation_id))  
	THEN
        SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot add university: University cannot be different from organisation university';
      END IF; 
      END $

CREATE TRIGGER ins_type_research_centre_in_organisation BEFORE INSERT ON research_centre FOR EACH ROW BEGIN
	IF ((new.org_type) <> 
		(SELECT org_type FROM organisation as o WHERE o.organisation_id = new.organisation_id))  
	THEN
        SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot add research center: Research center cannot be different from organisation research center';
      END IF; 
      END $

CREATE TRIGGER ins_evaluator_not_same_organisation BEFORE INSERT ON project FOR EACH ROW BEGIN
	IF ((SELECT organisation_id FROM researcher as r WHERE r.researcher_id = new.evaluator_id) = new.organisation_id)  
	THEN
        SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot add evaluator: Evaluator cannot evaluate the project of their organisation';
      END IF; 
      END $
      
CREATE TRIGGER upd_evaluator_not_same_organisation BEFORE UPDATE ON project FOR EACH ROW BEGIN
	IF ((SELECT organisation_id FROM researcher as r WHERE r.researcher_id = new.evaluator_id) = new.organisation_id)  
	THEN
        SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot update evaluator: Evaluator cannot evaluate the project of their organisation';
      END IF; 
      END $
      
CREATE TRIGGER ins_researcher_in_specific_project BEFORE INSERT ON researcher_in_project FOR EACH ROW BEGIN
	IF ((SELECT organisation_id FROM researcher AS r WHERE r.researcher_id = new.researcher_id) <> 
		(SELECT organisation_id FROM project AS p WHERE p.project_id = new.project_id))
	THEN
		SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot add researcher in project: Researcher cannot work in project of different organization';
	END IF; 
END $

CREATE TRIGGER upd_researcher_in_specific_project BEFORE UPDATE ON researcher_in_project FOR EACH ROW BEGIN
	IF ((SELECT organisation_id FROM researcher AS r WHERE r.researcher_id = new.researcher_id) <> 
		(SELECT organisation_id FROM project AS p WHERE p.project_id = new.project_id))
	THEN
		SIGNAL SQLSTATE '45000'   
        SET MESSAGE_TEXT = 'Cannot update researcher in project: Researcher cannot work in project of different organization';
	END IF; 
END $

DELIMITER ; 
   
###########################################################
# VIEWS
###########################################################

/*
# xvris kapoio kritirio
SELECT researcher_name, p.title FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
WHERE p.project_id = '824627027'
GROUP BY researcher_name;
*/
/*
#3.1
# kritirio to project starting date 
SELECT p.title, researcher_name, p.start_date FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
WHERE p.start_date = '2017-08-21'
ORDER BY p.title, r.researcher_name;


# kritirio to duration
SELECT p.title, researcher_name, p.duration FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
WHERE p.duration = 3
ORDER BY p.title, r.researcher_name;


# kritirio o executive
SELECT p.title, researcher_name, e.executive_name FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
INNER JOIN executive AS e ON e.executive_id = p.executive_id
WHERE p.executive_id = '476147609'
ORDER BY p.title, r.researcher_name;


#kritirio to project starting date kai to duration
SELECT p.title, researcher_name, p.start_date, p.duration FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
WHERE p.start_date = '2017-08-21' and p.duration = 1
ORDER BY p.title, r.researcher_name;


#kritirio to project starting date kai o executive
SELECT p.title, researcher_name, p.start_date, e.executive_name FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
INNER JOIN executive AS e ON e.executive_id = p.executive_id
WHERE p.start_date = '2017-08-21' and p.executive_id = '019769819'
ORDER BY p.title, r.researcher_name;

# kritirio to duration kai o executive
SELECT p.title, researcher_name, p.duration, e.executive_name FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
INNER JOIN executive AS e ON e.executive_id = p.executive_id
WHERE p.duration = 3 and p.executive_id = '476147609'
order BY p.title, r.researcher_name;
*/
/*
# kritirio to project starting date, to duration kai o executive
SELECT p.title, researcher_name, p.start_date, p.duration, e.executive_name FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
INNER JOIN executive AS e ON e.executive_id = p.executive_id
WHERE p.start_date = '2017-08-21' and p.duration = 1 and p.executive_id = '019769819'
ORDER BY p.title, r.researcher_name;
*/

/*
SELECT 
*
FROM organisation_by_researcher
ORDER BY researcher_name;


SELECT project.title, project.project_id, project.end_date, scientific_field.name_sci_field 
FROM project, scientific_field, project_scientific_field
WHERE scientific_field.name_sci_field='Computer Science' 
AND project.project_id = project_scientific_field.project_id 
AND scientific_field.field_id = project_scientific_field.field_id 
AND datediff(project.end_date, curdate()) > 0 
order by scientific_field.name_sci_field;
*/
##########################################################################################
 #QUERIES
##########################################################################################

# 3.2 
CREATE VIEW organisation_evaluator AS SELECT
p.title,
r.researcher_name,
e.grade,
e.evaluation_date
FROM project AS p
INNER JOIN evaluator AS e ON e.project_id = p.project_id
INNER JOIN researcher AS r ON r.researcher_id = e.researcher_id 
ORDER BY e.grade, e.evaluation_date;
#SELECT * FROM organisation_evaluator;

CREATE VIEW project_by_researcher 
AS
SELECT
r.researcher_name as researcher_name,  
p.title as project_title,
p.project_id as project_id
FROM project AS p
INNER JOIN researcher_in_project AS rp ON p.project_id = rp.project_id
INNER JOIN researcher AS r ON r.researcher_id = rp.researcher_id;

#3.4
CREATE VIEW projects_per_year AS
SELECT o.org_name, YEAR(p.start_date) AS year1, COUNT(*) AS num
FROM organisation AS o,project AS p
WHERE o.organisation_id = p.organisation_id
GROUP BY o.org_name , year1
ORDER BY num DESC;
/*
SELECT p1.org_name, p1.num, p1.year1, p2.org_name, p2.num, p2.year1 as year2 FROM projects_per_year p1, projects_per_year p2
WHERE p2.org_name=p1.org_name
AND p2.num = p1.num 
AND p2.year1 = (p1.year1 + 1)
GROUP BY p1.org_name 
HAVING p1.num>9;
*/

#3.5
CREATE VIEW pair_scientific_field AS
SELECT sf1.field_id AS field1, sf2.field_id as field2, sf1.name_sci_field as name1, sf2.name_sci_field as name2 from scientific_field sf1 
INNER JOIN scientific_field sf2 on sf1.field_id <> sf2.field_id and sf1.field_id < sf2.field_id
GROUP BY field1, field2;
/*
SELECT psf.field1, psf.name1, psf.field2, psf.name2, count(p2.project_id) as counter FROM pair_scientific_field psf
INNER JOIN project_scientific_field p1 on psf.field1 = p1.field_id
INNER JOIN project_scientific_field p2 on p2.project_id = p1.project_id and psf.field2 = p2.field_id
GROUP BY field1, field2
ORDER BY counter DESC
LIMIT 3;
*/

#3.6
/*
SELECT researcher.researcher_name, COUNT(researcher_in_project.project_id) AS number_of_participations, 
	datediff(curdate(), researcher.birthdate) div 365 as age
    FROM researcher 
    INNER JOIN researcher_in_project ON researcher_in_project.researcher_id = researcher.researcher_id 
    INNER JOIN project ON project.project_id = researcher_in_project.project_id 
    WHERE datediff(curdate(), researcher.birthdate) div 365 < 40 and datediff(project.end_date, curdate()) > 0 
    GROUP BY researcher.researcher_name 
    ORDER BY number_of_participations DESC;
*/
/*
#3.7
SELECT executive.executive_name, SUM(project.funding_amount) as total, organisation.org_name FROM executive
	INNER JOIN project ON project.executive_id = executive.executive_id
	INNER JOIN organisation ON organisation.organisation_id = project.organisation_id WHERE organisation.org_type = "Company"
    GROUP BY executive.executive_name 
	ORDER BY total DESC
    LIMIT 5;
*/
/*
#3.8
SELECT researcher.researcher_name, COUNT(researcher_in_project.project_id) AS number_of_projects
    FROM researcher 
    INNER JOIN researcher_in_project ON researcher_in_project.researcher_id = researcher.researcher_id 
    INNER JOIN project ON project.project_id = researcher_in_project.project_id
    WHERE NOT EXISTS (SELECT * FROM deliverable WHERE project_id = project.project_id)
    GROUP BY researcher.researcher_name HAVING number_of_projects>4
    ORDER BY number_of_projects DESC;
*/

/* Check
 SELECT researcher_id, p.project_id FROM supervisor
 INNER JOIN project as p ON p.project_id = supervisor.project_id
 where p.organisation_id = '206946265';

SELECT researcher_id, p.project_id FROM evaluator
 INNER JOIN project as p ON p.project_id = evaluator.project_id
 where p.organisation_id = '295754846'
 order by researcher_id;

SELECT project_id , duration FROM project;
*/

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
