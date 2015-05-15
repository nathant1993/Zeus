drop function CalcEffRemaining

DELIMITER $
CREATE function CalcEffRemaining( iLastIterationId INT )
RETURNS INT

BEGIN

   DECLARE 
	 iEffortRemaining INT default 0; 
	/*effRemaining INT default 0;*/
     
            SELECT SUM( PBI_effort ) into iEffortRemaining FROM  backlog_items a
			Inner join iteration b on b.iteration_ID = a.iteration_ID
			where a.iteration_id <= iLastIterationId
            and a.state_id = 4;

   RETURN iEffortRemaining;

END$
delimiter ; 