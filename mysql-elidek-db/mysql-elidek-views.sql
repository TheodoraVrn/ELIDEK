##########################################################################################
 # VIEWS
##########################################################################################

# 3.2
CREATE VIEW project_by_researcher 
AS
SELECT
r.researcher_name as researcher_name,  
p.title as project_title,
p.project_id as project_id
FROM project AS p
INNER JOIN researcher_in_project AS rp ON p.project_id = rp.project_id
INNER JOIN researcher AS r ON r.researcher_id = rp.researcher_id;

CREATE VIEW organisation_evaluator AS SELECT
p.title,
r.researcher_name,
e.grade,
e.evaluation_date
FROM project AS p
INNER JOIN evaluator AS e ON e.project_id = p.project_id
INNER JOIN researcher AS r ON r.researcher_id = e.researcher_id 
ORDER BY e.grade, e.evaluation_date;

# 3.4
CREATE VIEW projects_per_year AS
SELECT o.org_name, YEAR(p.start_date) AS year1, COUNT(*) AS num
FROM organisation AS o,project AS p
WHERE o.organisation_id = p.organisation_id
GROUP BY o.org_name , year1
ORDER BY num DESC;

#3.5
CREATE VIEW pair_scientific_field AS
SELECT sf1.field_id AS field1, sf2.field_id as field2, sf1.name_sci_field as name1, sf2.name_sci_field as name2 from scientific_field sf1 
INNER JOIN scientific_field sf2 on sf1.field_id <> sf2.field_id and sf1.field_id < sf2.field_id
GROUP BY field1, field2;