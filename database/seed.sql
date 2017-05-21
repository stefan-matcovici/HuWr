SELECT * FROM human_migrations;
SELECT * FROM cities;
DESCRIBE human_migrations;

ALTER TABLE human_migrations MODIFY departure_country VARCHAR(255);
ALTER TABLE human_migrations MODIFY departure_city VARCHAR(255);
ALTER TABLE human_migrations MODIFY arrival_country VARCHAR(255);
ALTER TABLE human_migrations MODIFY arrival_city VARCHAR(255);
ALTER TABLE human_migrations MODIFY departure_longitude VARCHAR(255);
ALTER TABLE human_migrations MODIFY departure_latitude VARCHAR(255);
ALTER TABLE human_migrations MODIFY arrival_latitude VARCHAR(255);
ALTER TABLE human_migrations MODIFY arrival_longitude VARCHAR(255);

ALTER TABLE human_migrations MODIFY arrival_longitude INTEGER;
ALTER TABLE human_migrations MODIFY adults INTEGER;
ALTER TABLE human_migrations MODIFY children INTEGER;
ALTER TABLE human_migrations MODIFY reason LONGTEXT;
ALTER TABLE human_migrations MODIFY user_id INTEGER UNSIGNED;

DROP PROCEDURE IF EXISTS seed;
DELIMITER //
CREATE PROCEDURE seed()
  BEGIN
    DECLARE v_country VARCHAR(255);
    DECLARE v_city VARCHAR(255);
    DECLARE v_latitude INTEGER;
    DECLARE v_longitude INTEGER;
    declare v_counter int unsigned default 0;

    while v_counter < 1000 do
      SELECT country,name,latitude,longitude INTO v_country,v_city,v_latitude,v_longitude FROM cities ORDER BY RAND() LIMIT 1;
      UPDATE human_migrations SET arrival_country = v_country,
                                  arrival_city = v_city,
                                  arrival_latitude = v_latitude,
                                  arrival_longitude = v_longitude WHERE id=v_counter;
      set v_counter=v_counter+1;
    end while;
    commit;
  END //
DELIMITER ;

CALL seed();