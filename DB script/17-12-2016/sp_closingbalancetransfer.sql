DELIMITER $$
CREATE PROCEDURE `sp_closingbalancetransfer`(
		CompanyId INT,
		YearId INT,
		fromDate DATETIME,
		toDate DATETIME,
		fiscalstartdate DATETIME,
		toyearId INT
		
)
BEGIN
#variable declaration
  DECLARE totdebit DECIMAL(12,2);
  DECLARE totcredit DECIMAL(12,2);
  DECLARE AccountId INT;
  DECLARE AccountName VARCHAR(50);
  DECLARE OpeningBalance DECIMAL(12,2);
  DECLARE ClosingBalance DECIMAL(12,2);
  DECLARE amount DECIMAL(12,2);
  DECLARE isdebit BIT;
  DECLARE balance DECIMAL(12,2);
  DECLARE ismaster BIT;
  
  DECLARE totdebit_String VARCHAR(50);
  DECLARE totcredit_String VARCHAR(50);
  DECLARE balance_String DECIMAL(12,2);
  DECLARE opbal DECIMAL(12,2);
  -- closing balance variable 01-12-2016
    DECLARE debitBalance DECIMAL(12,2);
	DECLARE creditBalance DECIMAL(12,2);
  -- closing balance variable 01-12-2016
  DECLARE exit_loop BOOLEAN;
-- account id fetch with opening
DECLARE MYCURSOR CURSOR FOR
        SELECT AM.account_name, IFNULL(account_opening_master.opening_balance,0) AS opening,AM.id
        FROM account_master AM
        LEFT JOIN account_opening_master 
        ON  AM.id = account_opening_master.account_master_id AND account_opening_master.financialyear_id =YearId
        INNER JOIN group_master ON AM.`group_master_id` = group_master.`id`
        INNER JOIN   group_category  ON   group_master.`group_category_id` =  group_category.`id` 
	   INNER JOIN   group_name ON group_name.`id` = group_category.`group_name_id` 
        WHERE AM.company_id=CompanyId AND group_name.`id` =3
        ORDER BY AM.account_name;
        
-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
_AccountId INT(20),
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);

DELETE FROM `account_opening_master` WHERE `account_opening_master`.`company_id`=CompanyId 
AND `account_opening_master`.`financialyear_id`=toyearId ;
   
OPEN MYCURSOR;
account_master: LOOP
FETCH  MYCURSOR INTO AccountName,OpeningBalance,AccountId;
  SET balance :=OpeningBalance;
  SET opbal := OpeningBalance;
  
   IF fromDate > fiscalstartdate THEN
      SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount ),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
      
      SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
          SET balance := balance + totdebit - totcredit;
					SET totcredit:=0;
					SET totdebit:=0;
      
   
   END IF;
   
   SET totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
     SET totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);      
          
    SET balance:= balance + totdebit - totcredit;
    IF exit_loop THEN
         CLOSE MYCURSOR;
         LEAVE account_master;
     END IF;
	 
	 
    
			
  INSERT INTO `account_opening_master`
            (`account_master_id`,`opening_balance`,`company_id`,`financialyear_id`)
  VALUES (AccountId, balance,CompanyId,toyearId);   
	   
	   SET totcredit:=0;
	   SET totdebit:=0;
        SET balance:=0;
   
   
    
END LOOP account_master;

  
END$$

DELIMITER ;

#call `sp_closingbalancetransfer` (1,6,'2016-04-01','2017-03-31','2016-04-01',7);

