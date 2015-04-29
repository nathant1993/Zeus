SELECT a.iteration_id, Iteration_Name,SUM( PBI_effort ) 
FROM  Backlog_Items a
Inner join Iteration b on b.Iteration_ID = a.Iteration_ID
GROUP BY iteration_id, Iteration_Name