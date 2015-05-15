SELECT b.iteration_id, iteration_name, SUM( PBI_effort ) as 'effort', starting_effort, CalcEffRemaining(b.iteration_id) as 'effort_done_to_date', (starting_effort - CalcEffRemaining(b.iteration_id)) as 'remaining_effort'
	FROM  backlog_items a
	right outer join iteration b on b.iteration_ID = a.iteration_ID
    where b.iteration_start_date <= sysdate()
    and a.state_id = 4
	GROUP BY iteration_id, iteration_name, CalcEffRemaining(a.iteration_id), (starting_effort - CalcEffRemaining(a.iteration_id))
    