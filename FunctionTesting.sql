/*BEGIN
DECLARE 
thisIT int default 1;
latestIT int;

SET @latestIT = (select iteration_id from iteration order by iteration_id desc limit 1);


While (thisIT <= latestIT) DO
	(SELECT SUM( PBI_effort ) as 'effort1'FROM  backlog_items a
	Inner join iteration b on b.iteration_ID = a.iteration_ID
    where a.iteration_id = thisIT);
    SET @thisIT = thisIT+1;
END WHILE;
END*/

DELIMITER $
CREATE FUNCTION CalcEffRemaining( iLastIterationId INT )
RETURNS INT

BEGIN

   DECLARE 
	iThisIterationId, iEffortRemaining, iEffort INT default 0; 
	/*effRemaining INT default 0;*/

   SET iThisIterationId = 1;

	for each (select iteration_id 
				from iteration 
                where release_id = (
					select release_id
					from iteration
					where iteration_id=2)
				and iteration_id <=2)
			loop
            
            SELECT SUM( PBI_effort ) into iEffortRemaining FROM  backlog_items a
			Inner join iteration b on b.iteration_ID = a.iteration_ID
			where a.iteration_id = iThisIterationId;

            End loop;
    
    WHILE  iThisIterationId <= iLastIterationId DO
    
    SET iEffortRemaining = (SELECT SUM( PBI_effort ) as 'effort1' FROM  backlog_items a
	Inner join iteration b on b.iteration_ID = a.iteration_ID
    where a.iteration_id = iThisIterationId);
    
    SET iThisIterationId = iThisIterationId + 1;
   END WHILE ;

   RETURN iEffortRemaining;

END$
delimiter ; 

select iteration_id
from iteration
where release_id = (
	select release_id
	from iteration
	where iteration_id=2)
and iteration_id <=2


DELIMITER $
CREATE function CalcEffRemaining( iLastIterationId INT )
RETURNS INT

BEGIN

   DECLARE 
	 iEffortRemaining INT default 0; 
	/*effRemaining INT default 0;*/
     
            SELECT SUM( PBI_effort ) into iEffortRemaining FROM  backlog_items a
			Inner join iteration b on b.iteration_ID = a.iteration_ID
			where a.iteration_id <= iLastIterationId;

   RETURN iEffortRemaining;

END$
delimiter ; 

select CalcEffRemaining(3)
from dual;
 
select CalcEffRemaining(0) from dual

