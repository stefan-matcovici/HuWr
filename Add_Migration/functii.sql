CREATE OR REPLACE FUNCTION experienced_crew(p_id_flight flights.FlightID%type)
RETURN number AS
   v_count_total number := 0;
   v_count_exp number := 0;
   v_years number := 0;
   v_procent number:=0;
BEGIN
    FOR v_std_linie IN (select * from Crew where CrewMemberID in(select CrewMemberID from Assignment where FlightID=p_id_flight)) LOOP
      v_count_total:=v_count_total+1;
      select floor(months_between(sysdate, to_date(to_char(v_std_linie.EmploymentDate,'YYYY-MM-DD'),'YYYY-MM-DD'))/12) into v_years from dual;
      if(v_years>=2) then
        v_count_exp:=v_count_exp+1;
      end if;
    END LOOP;
    IF (v_count_total = 0) THEN
      RETURN 0;
    END IF;
    v_procent:=v_count_exp/v_count_total;
    if(v_procent>=0.75) then
      return 1;
    else return 0;
    end if;
END;

SELECT * FROM flights where experienced_crew(FLIGHTID) = 1;
