DELIMITER $$



CREATE  PROCEDURE `sp_sundrydebtorAndCreditortrial`(
		CompanyId INT,
		YearId INT,
		fromDate DATETIME,
		toDate DATETIME,
		fiscalstartdate DATETIME,
		groupid INT
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
        LEFT JOIN account_opening_master ON  AM.id = account_opening_master.account_master_id 
        AND account_opening_master.financialyear_id =YearId
        WHERE AM.company_id=CompanyId AND AM.group_master_id=groupid
        ORDER BY AM.account_name;
        
-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
_totalOpening DECIMAL(12,2),
_totalTransDebit DECIMAL(12,2),
_totalTransCredit DECIMAL(12,2),
_totalClosingDebit DECIMAL(12,2),
_totalClosingCredit DECIMAL(12,2),
_AccountName VARCHAR(100)
);
 
   
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
	 
	 
    IF balance < 0
	THEN
				SET creditBalance:= (balance) *(-1);
				SET debitBalance:=0 ;
	ELSE
			
				SET debitBalance:= balance;
				SET creditBalance:=0;
    END IF;
		INSERT INTO finaltab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(AccountName,OpeningBalance,totdebit,totcredit,debitBalance,creditBalance);
			
		SET totcredit:=0;
		SET totdebit:=0;
        SET balance:=0;
   
   
    
END LOOP account_master;
SELECT finaltab._AccountName AS Account,finaltab._totalOpening AS Opening,
		finaltab._totalTransDebit AS Debit,finaltab._totalTransCredit AS Credit,finaltab._totalClosingDebit AS closingDebit,
		finaltab._totalClosingCredit AS closingCredit
FROM finaltab
WHERE (finaltab._totalOpening <> 0 OR finaltab._totalTransDebit<>0 OR finaltab._totalTransCredit<>0 OR finaltab._totalClosingDebit <>0
OR finaltab._totalClosingCredit<>0);
  
END$$

DELIMITER ;