# command line instruction
php artisan migrate:refresh

# Remove null contraints
ALTER TABLE human_migrations MODIFY departure_country VARCHAR(255);
ALTER TABLE human_migrations MODIFY departure_city VARCHAR(255);
ALTER TABLE human_migrations MODIFY arrival_country VARCHAR(255);
ALTER TABLE human_migrations MODIFY arrival_city VARCHAR(255);
ALTER TABLE human_migrations MODIFY departure_longitude DOUBLE;
ALTER TABLE human_migrations MODIFY departure_latitude DOUBLE;
ALTER TABLE human_migrations MODIFY arrival_latitude DOUBLE;
ALTER TABLE human_migrations MODIFY arrival_longitude DOUBLE;
ALTER TABLE human_migrations MODIFY adults INTEGER;
ALTER TABLE human_migrations MODIFY children INTEGER;
ALTER TABLE human_migrations MODIFY reason LONGTEXT;
ALTER TABLE human_migrations MODIFY user_id INTEGER UNSIGNED;

ALTER TABLE human_migrations
  CHANGE created_at
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

#command line instruction
php artisan db:seed



# Creating helping table cities
create table cities
(
  ID int(8) unsigned not null auto_increment
    primary key,
  country char(2) not null,
  region char(3) not null,
  url varchar(50) not null,
  name varchar(50) not null,
  latitude double not null,
  longitude double not null,
  constraint country
  unique (country, name, region)
)
;
# Populating cities
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ZA', '11', '', 'Cape Town', -33.9167, 18.4167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ZA', '06', '', 'Pretoria', -25.7069, 28.2294);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ZA', '02', '', 'Durban', -29.85, 31.0167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ZA', '06', '', 'Johannesburg', -26.2, 28.0833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DZ', '01', '', 'Alger', 36.7631, 3.0506);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DZ', '01', '', 'Algiers', 36.7631, 3.0506);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TN', '26', '', 'Tunis', 36.8028, 10.1797);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('MA', '07', '', 'Casablanca', 33.5931, -7.6164);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('MA', '19', '', 'Marrakech', 31.6333, -8);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('EG', '11', '', 'Cairo', 30.05, 31.25);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('EG', '06', '', 'Alexandria', 31.1981, 29.9192);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('KE', '05', '', 'Nairobi', -1.2833, 36.8167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('SN', '01', '', 'Dakar', 14.6708, -17.4381);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('LS', '14', '', 'Roma', -29.45, 27.7333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ZA', '09', '', 'Messina', -22.35, 30.05);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TZ', '23', '', 'Dar Es Salaam', -6.8, 39.2833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('EG', '01', '', 'Damas', 30.8053, 31.3261);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'CA', '', 'San Francisco', 37.7312, -122.3826);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'NY', '', 'New York', 40.7528, -73.9725);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'CA', '', 'San Jose', 37.3239, -121.9144);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'IL', '', 'Chicago', 41.9288, -87.6315);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'TX', '', 'Austin', 30.2058, -97.8002);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'IN', '', 'Indianapolis', 39.793, -86.2853);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'NJ', '', 'Princeton', 40.3756, -74.6597);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'CA', '', 'San Diego', 32.9014, -117.2079);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'CT', '', 'Bristol', 41.6816, -72.9405);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'FL', '', 'Miami', 25.9388, -80.2144);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'TX', '', 'Dallas', 32.7673, -96.7776);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'DC', '', 'Washington', 38.8749, -77.0325);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'CA', '', 'Los Angeles', 34.053, -118.2642);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'UT', '', 'Salt Lake City', 40.7242, -111.8787);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'TX', '', 'El Paso', 31.7958, -106.3762);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'MO', '', 'Kansas City', 39.0362, -94.595);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'CA', '', 'Malibu', 34.0697, -118.8177);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'HI', '', 'Honolulu', 21.2967, -157.8498);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'MS', '', 'Oxford', 34.3402, -89.4833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'WA', '', 'Seattle', 47.6026, -122.3284);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'NV', '', 'Las Vegas', 36.11, -115.2118);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'AL', '', 'Houston', 34.1849, -87.3023);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'NH', '', 'Berlin', 44.4338, -71.2707);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'WA', '', 'Vancouver', 45.6023, -122.5167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'PA', '', 'Bristol', 40.1172, -74.8495);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'AR', '', 'El Dorado', 33.1929, -92.6434);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('SE', '26', '', 'Stockholm', 59.3333, 18.05);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ES', '29', '', 'Madrid', 40.4, -3.6833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'D2', '', 'Derby', 52.9333, -1.5);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('AU', '07', '', 'Queensferry', -38.4167, 145.5);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'B7', '', 'Bristol', 51.45, -2.5833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'Z1', '', 'Swansea', 51.6333, -3.9667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '40', '', 'Tokyo', 35.685, 139.7514);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '01', '', 'Karlsruhe', 49.0047, 8.3858);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CH', '20', '', 'Lugano', 46, 8.9667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Cologne', 50.9333, 6.95);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'A8', '', 'Paris', 48.8667, 2.3333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('IT', '07', '', 'Rome', 41.9, 12.4833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'AZ', '', 'Florence', 32.8881, -111.202);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BR', '21', '', 'Rio De Janeiro', -22.9, -43.2333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('ES', '56', '', 'Barcelona', 41.3833, 2.1833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '32', '', 'Osaka', 34.6667, 135.5);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '19', '', 'Yokohama', 35.45, 139.65);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('HU', '05', '', 'Budapest', 47.5, 19.0833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('AE', '03', '', 'Dubai', 25.2522, 55.28);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BR', '23', '', 'Porto Alegre', -30.0333, -51.2);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '34', '', 'Kawagoe', 35.9086, 139.4853);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('KR', '10', '', 'Pusan', 35.1028, 129.0403);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '38', '', 'Nonthaburi', 13.8333, 100.4833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'D4', '', 'Wear', 50.7, -3.4833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '02', '', 'Arnstorf', 48.5667, 12.8167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '13', '', 'Kobe', 34.6833, 135.1667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '19', '', 'Hadano', 35.3711, 139.2236);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BR', '27', '', 'Suzano', -23.5333, -46.3333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'A7', '', 'Aubergenville', 48.9667, 1.85);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BR', '18', '', 'Londrina', -23.3, -51.15);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BR', '08', '', 'Serra', -20.1167, -40.3);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RO', '23', '', 'Iasi', 47.1667, 27.6);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Dortmund', 51.5167, 7.45);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RO', '32', '', 'Satu Mare', 47.8, 22.8833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Bochum', 51.4833, 7.2167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'X2', '', 'Victoria', 51.75, -3.2);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('US', 'WY', '', 'Hanna', 42.0325, -106.6627);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('AU', '07', '', 'Seaford', -38.1, 145.1333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'C7', '', 'Coventry', 52.4167, -1.55);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('HR', '21', '', 'Zagreb', 45.8, 16);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RO', '33', '', 'Sibiu', 45.8, 24.15);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RO', '13', '', 'Cluj', 46.7667, 23.6);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '59', '', 'Kiev', 42.9047, 133.7022);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RO', '38', '', 'Bucharest', 44.4333, 26.1);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '66', '', 'Sankt Petersburg', 59.8944, 30.2642);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('VN', '44', '', 'Hanoi', 21.0333, 105.85);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'B8', '', 'Marseille', 43.3, 5.4);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '13', '', 'Dresden', 51.05, 13.75);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'A5', '', 'Bastia', 42.7028, 9.45);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'B5', '', 'Nantes', 47.2167, -1.55);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '70', '', 'Svobody', 44.0256, 43.0503);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('NL', '06', '', 'Eindhoven', 51.45, 5.4667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BG', '62', '', 'Tarnovo', 43.0858, 25.6556);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Nottuln', 51.9333, 7.35);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'A9', '', 'Blackpool', 53.8167, -3.05);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('SE', '06', '', 'Kungsbacka', 57.4833, 12.0667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('NL', '10', '', 'Middelburg', 51.5, 3.6167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '35', '', 'Kudymkar', 59.0131, 54.6556);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '02', '', 'Nivelles', 50.6, 4.3333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '03', '', 'Lodelinsart', 50.4333, 4.4333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '03', '', 'Roux', 50.4333, 4.3833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '11', '', 'Brussel', 50.8333, 4.3333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '02', '', 'Zellik', 50.8833, 4.2667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '05', '', 'Hasselt', 50.9333, 5.3333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '03', '', 'Seneffe', 50.5167, 4.25);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '07', '', 'Moustier', 50.4667, 4.6833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '06', '', 'Athus', 49.5667, 5.8333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '02', '', 'Anderlecht', 50.8333, 4.3);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FI', '13', '', 'Joutseno', 61.1, 28.5);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CZ', '86', '', 'Svitavy', 49.75, 16.4667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CZ', '88', '', 'Votice', 49.65, 14.65);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '04', '', 'Barnaul', 53.3558, 83.7522);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '53', '', 'Leningrad', 54.1247, 79.2403);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '71', '', 'Yekaterinburg', 56.85, 60.6);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Lippstadt', 51.6667, 8.35);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('SE', '15', '', 'Lindesberg', 59.5833, 15.25);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'B4', '', 'Croix', 50.6667, 3.15);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FI', '15', '', 'Teuva', 62.4833, 21.7333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FI', '15', '', 'Viitasaari', 63.0667, 25.8667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '01', '', 'Staufen Im Breisgau', 47.8833, 7.7333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('BE', '02', '', 'Stock', 50.85, 5);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('SE', '10', '', 'Falun', 60.6, 15.6333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '89', '', 'Birobijan', 48.8, 132.95);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FR', 'A8', '', 'Noisy', 48.3333, 2.9333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FI', '13', '', 'Veikkola', 60.3667, 24.3);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('IT', '18', '', 'Querce', 43.0667, 12.75);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '84', '', 'Karpov', 49.6833, 46.1833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Linnich', 50.9833, 6.2667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CZ', '85', '', '', 49.6833, 18.3333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '21', '', 'Nogina', 56.65, 41.05);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '72', '', 'Michurinsk', 52.8967, 40.4994);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '72', '', 'Tambov', 52.7317, 41.4339);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '76', '', 'Tula', 54.2044, 37.6111);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('FI', '06', '', 'Kainuu', 66.2167, 23.8);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('NL', '11', '', 'Leiderdorp', 52.15, 4.5333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('IT', '05', '', 'Sala Baganza', 44.7167, 10.2333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Geseke', 51.65, 8.5167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '06', '', 'Arkhangelsk', 64.5667, 40.5333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '15', '', 'Weimar', 50.9833, 11.3167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '34', '', 'Syktyvkar', 61.6667, 50.8122);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '49', '', 'Murmansk', 68.9667, 33.0833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '43', '', 'Lipetsk', 52.6186, 39.5689);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '30', '', 'Auri', 52.0167, 140.3833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Wall', 51.3833, 6.3833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('DE', '07', '', 'Holl', 50.9, 7.2833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('RU', '52', '', 'Vyatka', 58.4667, 35.6667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', 'Z2', '', 'Pontypool', 51.7011, -3.0444);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('PL', '25', '', 'Cieszyn', 49.7667, 18.6);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('PL', '46', '', 'Rabka', 49.6167, 19.95);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('JP', '11', '', 'Hiroshima', 34.4, 132.45);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '03', '', 'Bhan', 19.4667, 99.7167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '27', '', 'Nakhon Ratchasima', 14.9667, 102.1167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '22', '', 'Khon Kaen', 16.4333, 102.8333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '02', '', 'Wenzhou', 28.0192, 120.6544);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '02', '', 'Huzhou', 30.8661, 120.0964);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '04', '', 'Zhoushan', 32.9667, 119.5139);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '02', '', 'Shaoxing', 30.0017, 120.5811);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '08', '', 'Mishan', 45.5431, 131.8822);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '19', '', 'Daqing', 41.7239, 123.2017);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '31', '', 'Danzhou', 19.5147, 109.5703);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '24', '', 'Changzhi', 36.0458, 113.0442);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '01', '', 'Wuhu', 31.1667, 118.55);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('CN', '03', '', 'Ganzhou', 25.85, 114.9333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '70', '', 'Yala', 6.5428, 101.2836);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '76', '', 'Udornthani', 17.4075, 102.7931);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '51', '', 'Supanburi', 14.4667, 100.1167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '13', '', 'Pichit', 16.4333, 100.3667);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '03', '', 'Chiengrai', 19.9, 99.8333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '05', '', 'Lampoon', 18.5811, 99.0092);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '06', '', 'Lampang', 18.2983, 99.5072);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '07', '', 'Prae', 18.15, 100.1333);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '28', '', 'Buriram', 15, 103.1167);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '29', '', 'Surin', 14.8833, 103.4833);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('TH', '72', '', 'Yasothon', 15.7953, 104.1494);
INSERT INTO cities (country, region, url, name, latitude, longitude) VALUES ('GB', '17', '', 'London', 51.5, -0.1167);
# Procedure to seed human_migrations
DROP PROCEDURE IF EXISTS seed;
DELIMITER //
CREATE PROCEDURE seed()
  BEGIN
    DECLARE v_country VARCHAR(255);
    DECLARE v_city VARCHAR(255);
    DECLARE v_latitude DOUBLE;
    DECLARE v_longitude DOUBLE;
    declare v_counter int unsigned default 0;

    while v_counter < 1000 do
      SELECT country,name,latitude,longitude INTO v_country,v_city,v_latitude,v_longitude FROM cities ORDER BY RAND() LIMIT 1;
      UPDATE human_migrations SET departure_country = v_country,
        departure_city = v_city,
        departure_latitude = v_latitude,
        departure_longitude = v_longitude WHERE id=v_counter;
      set v_counter=v_counter+1;
    end while;
    commit;
  END //
DELIMITER ;
# Go for it
CALL seed();
# replace departure_country,city,latitude,longitude with arrival_*, recompile the function and go for it once more :)
