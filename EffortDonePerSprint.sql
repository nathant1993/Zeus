SELECT a.iteration_id, iteration_name,SUM( PBI_effort ) 
FROM  backlog_items a
Inner join iteration b on b.iteration_ID = a.iteration_ID
GROUP BY iteration_id, iteration_name
