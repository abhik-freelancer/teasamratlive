DELIMITER $$

CREATE
    /*[DEFINER = { user | CURRENT_USER }]*/
    PROCEDURE `teasamrat`.`sp_sundrydebtortrial`(
    IN fromdate DATETIME,todate DATETIME,companyid INT,accountingyearid INT)
    BEGIN #main begin
#variable declaration

   
   DECLARE  accountid INT;
   DECLARE  accountname VARCHAR(MAX);
   DECLARE  debitamount DECIMAL(10,2);
   DECLARE  creditamount DECIMAL(10,2);
   
   
   
   
    END$$ #main end

DELIMITER ;