SELECT pbi_id, pbi_title, pbi_description, pbi_effort, c.description as 'priority', d.state_name, b.iteration_name, e.project_name
            FROM  backlog_items a
            right outer join iteration b on b.iteration_ID = a.iteration_ID
            inner join priority c on c.priority_id = a.priority_id
            inner join states d on d.state_id = a.state_id
            inner join project e on e.project_id = a.project_id
            where b.iteration_start_date <= sysdate() 
            and b.iteration_end_date >= sysdate()