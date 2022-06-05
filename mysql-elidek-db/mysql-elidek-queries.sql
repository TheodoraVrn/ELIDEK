##########################################################################################
 # QUERIES
##########################################################################################

# 3.1
# xwris kapoio kritirio
SELECT researcher_name, p.title FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
WHERE p.project_id = '824627027'
GROUP BY researcher_name;

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

# kritirio to project starting date, to duration kai o executive
SELECT p.title, researcher_name, p.start_date, p.duration, e.executive_name FROM researcher AS r
INNER JOIN researcher_in_project AS rp ON rp.researcher_id = r.researcher_id
INNER JOIN project AS p ON p.project_id = rp.project_id
INNER JOIN executive AS e ON e.executive_id = p.executive_id
WHERE p.start_date = '2017-08-21' and p.duration = 1 and p.executive_id = '019769819'
ORDER BY p.title, r.researcher_name;

# 3.3
# Active Projects concerning this field
SELECT project.title, project.project_id, project.end_date, scientific_field.name_sci_field 
    FROM project, scientific_field, project_scientific_field
    WHERE scientific_field.name_sci_field='$selected' 
    AND project.project_id = project_scientific_field.project_id 
    AND scientific_field.field_id = project_scientific_field.field_id 
    AND datediff(project.end_date, curdate()) > 0 
    order by scientific_field.name_sci_field;

# Researchers currently working on this field
SELECT DISTINCT researcher.researcher_name, project.project_id, project.end_date, scientific_field.name_sci_field 
    FROM researcher, project, scientific_field, project_scientific_field, researcher_in_project
    WHERE scientific_field.name_sci_field='$selected' 
    AND project.project_id = project_scientific_field.project_id 
    AND project.project_id = researcher_in_project.project_id
    AND researcher.researcher_id = researcher_in_project.researcher_id
    AND scientific_field.field_id = project_scientific_field.field_id 
    AND datediff(project.end_date, curdate()) > 0 
    order by scientific_field.name_sci_field;

# 3.4
CREATE VIEW projects_per_year AS
SELECT o.org_name, YEAR(p.start_date) AS year1, COUNT(*) AS num
FROM organisation AS o,project AS p
WHERE o.organisation_id = p.organisation_id
GROUP BY o.org_name , year1
ORDER BY num DESC;
SELECT p1.org_name, p1.num, p1.year1, p2.org_name, p2.num, p2.year1 as year2 FROM projects_per_year p1, projects_per_year p2
WHERE p2.org_name=p1.org_name
AND p2.num = p1.num 
AND p2.year1 = (p1.year1 + 1)
GROUP BY p1.org_name 
HAVING p1.num>9;

#3.5
CREATE VIEW pair_scientific_field AS
SELECT sf1.field_id AS field1, sf2.field_id as field2, sf1.name_sci_field as name1, sf2.name_sci_field as name2 from scientific_field sf1 
INNER JOIN scientific_field sf2 on sf1.field_id <> sf2.field_id and sf1.field_id < sf2.field_id
GROUP BY field1, field2;
SELECT psf.field1, psf.name1, psf.field2, psf.name2, count(p2.project_id) as counter FROM pair_scientific_field psf
INNER JOIN project_scientific_field p1 on psf.field1 = p1.field_id
INNER JOIN project_scientific_field p2 on p2.project_id = p1.project_id and psf.field2 = p2.field_id
GROUP BY field1, field2
ORDER BY counter DESC
LIMIT 3;

#3.6
SELECT researcher.researcher_name, COUNT(researcher_in_project.project_id) AS number_of_participations, 
	datediff(curdate(), researcher.birthdate) div 365 as age
    FROM researcher 
    INNER JOIN researcher_in_project ON researcher_in_project.researcher_id = researcher.researcher_id 
    INNER JOIN project ON project.project_id = researcher_in_project.project_id 
    WHERE datediff(curdate(), researcher.birthdate) div 365 < 40 and datediff(project.end_date, curdate()) > 0 
    GROUP BY researcher.researcher_name 
    ORDER BY number_of_participations DESC;
    
#3.7
SELECT executive.executive_name, SUM(project.funding_amount) as total, organisation.org_name FROM executive
	INNER JOIN project ON project.executive_id = executive.executive_id
	INNER JOIN organisation ON organisation.organisation_id = project.organisation_id WHERE organisation.org_type = "Company"
    GROUP BY executive.executive_name 
	ORDER BY total DESC
    LIMIT 5;
    
#3.8
SELECT researcher.researcher_name, COUNT(researcher_in_project.project_id) AS number_of_projects
    FROM researcher 
    INNER JOIN researcher_in_project ON researcher_in_project.researcher_id = researcher.researcher_id 
    INNER JOIN project ON project.project_id = researcher_in_project.project_id
    WHERE NOT EXISTS (SELECT * FROM deliverable WHERE project_id = project.project_id)
    GROUP BY researcher.researcher_name HAVING number_of_projects>4
    ORDER BY number_of_projects DESC;