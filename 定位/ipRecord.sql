create table ipRecord(ip varchar(15), canLocation char(1), longitude double, latitude double, accuracy int, locPosition varchar(255), ipPositon varchar(255), time datetime) CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP PROCEDURE IF EXISTS ipRecordInsert;
DELIMITER //
create PROCEDURE ipRecordInsert(newip varchar(15), newCanLocation char(1), longitude double, latitude double, accuracy int, locPosition varchar(255), ipPositon varchar(255))
BEGIN
declare lastTime datetime default "1970-01-01 00:00:00";
declare deltaTime int;
declare oldCanLocation char(1);
select time,canLocation into lastTime,oldCanLocation from ipRecord where ip=newip order by time desc limit 1;
select TIMESTAMPDIFF(MINUTE,lastTime,now()) into deltaTime;
if deltaTime>=15 || (newCanLocation='Y' && oldCanLocation='N') THEN
    insert into ipRecord values(newip,newCanLocation,longitude,latitude,accuracy,locPosition,ipPositon,now());
END IF;
END//
DELIMITER ;
