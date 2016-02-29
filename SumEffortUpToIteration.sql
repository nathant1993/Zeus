SELECT SUM( PBI_effort ) as 'effort1'FROM  backlog_items a
	Inner join iteration b on b.iteration_ID = a.iteration_ID
    where a.iteration_id <=3
    
