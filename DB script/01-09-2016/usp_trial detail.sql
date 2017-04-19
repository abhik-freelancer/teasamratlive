DROP PROCEDURE IF EXISTS teasamrat.usp_trialDetail;
CREATE PROCEDURE teasamrat.`usp_trialDetail`(
    p_CompanyId int,
		p_YearId int,
		p_fromDate datetime,
		p_toDate datetime,
		p_fiscalstartdate datetime
)
BEGIN#main begin
#variable declaration
declare v_accountname varchar(255);
declare v_openingbalance decimal(12,2);
declare v_accountId integer;
declare v_balance decimal(12,2);
declare v_opbal decimal(12,2);
declare v_totdebit decimal(12,2);
declare v_totcredit decimal(12,2);
declare v_creditBalance decimal(12,2);
declare v_debitBalance decimal(12,2);
#variable declaration
DECLARE finished INTEGER DEFAULT 0;
DECLARE MYCURSOR CURSOR FOR
SELECT 
account_master.account_name,
IFNULL(account_opening_master.opening_balance,0) as opeing,
account_master.id
FROM account_master 
LEFT JOIN account_opening_master 
ON account_master.id=account_opening_master.account_master_id AND account_opening_master.financialyear_id= 6#p_yearId
WHERE 
account_master.company_id = 1 #p_CompanyId 
AND account_master.group_master_id NOT IN (1,2) ORDER BY account_master.account_name;

#Sundry drebtor cursor

declare SUNDRY_DEBTOR_CURSOR CURSOR FOR
SELECT 
account_master.account_name,
IFNULL(account_opening_master.opening_balance,0) as opeing,
account_master.id
FROM account_master 
LEFT JOIN account_opening_master 
ON account_master.id=account_opening_master.account_master_id AND account_opening_master.financialyear_id= 6#p_yearId
WHERE 
account_master.company_id = 1 #p_CompanyId 
AND account_master.group_master_id =1 ORDER BY account_master.account_name;

#Sundry creditor cursor

declare SUNDRY_CREDITOR_CURSOR CURSOR FOR
SELECT 
account_master.account_name,
IFNULL(account_opening_master.opening_balance,0) as opeing,
account_master.id
FROM account_master 
LEFT JOIN account_opening_master 
ON account_master.id=account_opening_master.account_master_id AND account_opening_master.financialyear_id= 6#p_yearId
WHERE 
account_master.company_id = 1 #p_CompanyId 
AND account_master.group_master_id =2 ORDER BY account_master.account_name;






	
DECLARE CONTINUE HANDLER 
FOR NOT FOUND SET finished = 1;
DROP TEMPORARY TABLE IF EXISTS finaltab;
CREATE TEMPORARY TABLE IF NOT EXISTS finaltab(
_totalOpening decimal(12,2),
_totalTransDebit decimal(12,2),
_totalTransCredit decimal(12,2),
_totalClosingDebit decimal(12,2),
_totalClosingCredit decimal(12,2),
_AccountName varchar(100)
);
  
  
  
OPEN MYCURSOR ;
get_account : LOOP
FETCH MYCURSOR INTO v_accountname,v_openingbalance,v_accountId;
SET v_opbal = v_openingbalance;
SET v_balance = v_openingbalance;
IF p_fromDate > p_fiscalstartdate THEN
    
 SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId
  );    
          set v_balance= v_balance + v_totdebit - v_totcredit;
					set v_totcredit=0;
					set v_totdebit=0;  
END IF;
# normal
SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN  p_fromDate AND p_toDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fromDate AND p_toDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId
  );    
set v_balance= v_balance + v_totdebit - v_totcredit;
  If v_balance < 0 THEN
		
			SET v_creditBalance = v_balance * -1;
			SET v_debitBalance =0; 
		
		ELSE
		
			SET v_debitBalance = v_balance;
			SET v_creditBalance =0;
			
		END IF;
# normal
INSERT INTO finaltab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(v_accountname,v_openingbalance,v_totdebit,v_totcredit,v_debitBalance,v_creditBalance);
		
			
		set v_totcredit=0;
		set v_totdebit=0;
		set v_debitBalance =0;
		set v_creditBalance =0;
IF finished=1 THEN
  LEAVE get_account;
END IF;

END LOOP get_account;  
CLOSE MYCURSOR;
#account id Sundry Debtors,Sundry Creditors  
#SUNDRY_DEBTOR_CURSOR

OPEN SUNDRY_DEBTOR_CURSOR;
  BEGIN
      DECLARE exit_flag INT DEFAULT 0;
      declare v_accountname varchar(255);
      declare v_openingbalance decimal(12,2);
      declare v_accountId integer;
      declare v_balance decimal(12,2);
      declare v_opbal decimal(12,2);
      declare v_totdebit decimal(12,2);
      declare v_totcredit decimal(12,2);
      declare v_creditBalance decimal(12,2);
      declare v_debitBalance decimal(12,2);
      DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET exit_flag = 1;
      
      
      #temp table
      DROP TEMPORARY TABLE IF EXISTS Debtortab;
CREATE TEMPORARY TABLE IF NOT EXISTS Debtortab(
_totalOpening decimal(12,2),
_totalTransDebit decimal(12,2),
_totalTransCredit decimal(12,2),
_totalClosingDebit decimal(12,2),
_totalClosingCredit decimal(12,2),
_AccountName varchar(100)
);
      
      
      
      

      SUNDRY_DEBTOR_CURSOR_LOOP: LOOP
        FETCH SUNDRY_DEBTOR_CURSOR INTO v_accountname,v_openingbalance,v_accountId;
        SET v_opbal = v_openingbalance;
        SET v_balance = v_openingbalance;
        
            IF exit_flag THEN LEAVE SUNDRY_DEBTOR_CURSOR_LOOP; 
            END IF;
           
           IF p_fromDate > p_fiscalstartdate THEN
    
 SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId
  );    
          set v_balance= v_balance + v_totdebit - v_totcredit;
					set v_totcredit=0;
					set v_totdebit=0;  
END IF;
# normal
SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN  p_fromDate AND p_toDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fromDate AND p_toDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId
  );    
set v_balance= v_balance + v_totdebit - v_totcredit;
  If v_balance < 0 THEN
		
			SET v_creditBalance = v_balance * -1;
			SET v_debitBalance =0; 
		
		ELSE
		
			SET v_debitBalance = v_balance;
			SET v_creditBalance =0;
			
		END IF;
# normal
INSERT INTO Debtortab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(v_accountname,v_openingbalance,v_totdebit,v_totcredit,v_debitBalance,v_creditBalance);
		
			
		set v_totcredit=0;
		set v_totdebit=0;
		set v_debitBalance =0;
		set v_creditBalance =0;
           
      
      
      END LOOP;
  END;
  CLOSE SUNDRY_DEBTOR_CURSOR;


INSERT INTO finaltab(_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
select  'Sundry Debtor',SUM(_totalOpening) as opening,SUM(_totalTransDebit)as trnsDr,SUM(_totalTransCredit) as transCr,
SUM(_totalClosingDebit)as closeDr,SUM(_totalClosingCredit)as CloseCr
from Debtortab;

#SUNDRY_CREDITOR_CURSOR;




OPEN SUNDRY_CREDITOR_CURSOR;
  BEGIN
      DECLARE exit_flag INT DEFAULT 0;
      declare v_accountname varchar(255);
      declare v_openingbalance decimal(12,2);
      declare v_accountId integer;
      declare v_balance decimal(12,2);
      declare v_opbal decimal(12,2);
      declare v_totdebit decimal(12,2);
      declare v_totcredit decimal(12,2);
      declare v_creditBalance decimal(12,2);
      declare v_debitBalance decimal(12,2);
      DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET exit_flag = 1;
      
      
      #temp table
      DROP TEMPORARY TABLE IF EXISTS Creditortab;
CREATE TEMPORARY TABLE IF NOT EXISTS Creditortab(
_totalOpening decimal(12,2),
_totalTransDebit decimal(12,2),
_totalTransCredit decimal(12,2),
_totalClosingDebit decimal(12,2),
_totalClosingCredit decimal(12,2),
_AccountName varchar(100)
);
      
      
      
      

      SUNDRY_CREDITOR_CURSOR_LOOP: LOOP
        FETCH SUNDRY_CREDITOR_CURSOR INTO v_accountname,v_openingbalance,v_accountId;
        SET v_opbal = v_openingbalance;
        SET v_balance = v_openingbalance;
        
            IF exit_flag THEN LEAVE SUNDRY_CREDITOR_CURSOR_LOOP; 
            END IF;
           
           IF p_fromDate > p_fiscalstartdate THEN
    
 SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fiscalstartdate AND p_fromDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId
  );    
          set v_balance= v_balance + v_totdebit - v_totcredit;
					set v_totcredit=0;
					set v_totdebit=0;  
END IF;
# normal
SET v_totdebit:=(
    SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN  p_fromDate AND p_toDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='Y'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id =v_accountId);
      
  SET v_totcredit :=(
  SELECT IFNULL(SUM(voucher_detail.voucher_amount),0) as totalDebit
      FROM voucher_detail 
      INNER JOIN voucher_master ON voucher_master.id = voucher_detail.voucher_master_id
      WHERE voucher_master.voucher_date BETWEEN p_fromDate AND p_toDate
      AND voucher_master.company_id =1 AND voucher_master.year_id=6 AND voucher_detail.is_debit ='N'
      GROUP BY voucher_detail.account_master_id
      HAVING voucher_detail.account_master_id = v_accountId
  );    
set v_balance= v_balance + v_totdebit - v_totcredit;
  If v_balance < 0 THEN
		
			SET v_creditBalance = v_balance * -1;
			SET v_debitBalance =0; 
		
		ELSE
		
			SET v_debitBalance = v_balance;
			SET v_creditBalance =0;
			
		END IF;
# normal
INSERT INTO Creditortab (_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
		VALUES(v_accountname,v_openingbalance,v_totdebit,v_totcredit,v_debitBalance,v_creditBalance);
		
			
		set v_totcredit=0;
		set v_totdebit=0;
		set v_debitBalance =0;
		set v_creditBalance =0;
           
      
      
      END LOOP;
  END;
  CLOSE SUNDRY_CREDITOR_CURSOR;


INSERT INTO finaltab(_AccountName,_totalOpening ,_totalTransDebit,_totalTransCredit ,_totalClosingDebit,_totalClosingCredit)
select  'Sundry Creditor',SUM(_totalOpening) as opening,SUM(_totalTransDebit)as trnsDr,SUM(_totalTransCredit) as transCr,
SUM(_totalClosingDebit)as closeDr,SUM(_totalClosingCredit)as CloseCr
from Creditortab;


#SELECT * FROM finaltab;


SELECT finaltab._AccountName as Account,finaltab._totalOpening as Opening,
		finaltab._totalTransDebit as Debit,finaltab._totalTransCredit as Credit,finaltab._totalClosingDebit as closingDebit,
		finaltab._totalClosingCredit as closingCredit
FROM finaltab
WHERE (finaltab._totalOpening <> 0 OR finaltab._totalTransDebit<>0 OR finaltab._totalTransCredit<>0 OR finaltab._totalClosingDebit <>0
OR finaltab._totalClosingCredit<>0);

END;
