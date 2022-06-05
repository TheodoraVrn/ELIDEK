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

CREATE TABLE phone (
    phone VARCHAR(10) NOT NULL,
    organisation_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (phone , organisation_id),
    KEY idx_fk_org_phone (organisation_id),
    CONSTRAINT fk_organisation_phone FOREIGN KEY (organisation_id)
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
    CONSTRAINT fk_researcher_id4 FOREIGN KEY (researcher_id)
        REFERENCES researcher (researcher_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

ALTER TABLE evaluator ADD CONSTRAINT passing_grade CHECK (grade <> 'F');

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
    CONSTRAINT project_funding CHECK (funding_amount >= 100000 AND funding_amount <= 1000000)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

ALTER TABLE project ADD CONSTRAINT project_duration CHECK (duration <= 4 and duration >= 1);

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
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=INNODB DEFAULT CHARSET=UTF8;

##########################################################################################
 # TRIGGERS
##########################################################################################

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

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;