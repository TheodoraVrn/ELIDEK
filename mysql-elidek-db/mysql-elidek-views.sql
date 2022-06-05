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