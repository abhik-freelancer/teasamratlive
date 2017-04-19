CREATE PROCEDURE usp_TrialBalance (
    CompanyId int,
		YearId int,
		fromDate datetime,
		toDate datetime,
		fiscalstartdate datetime
)
BEGIN
#variable declaration


  declare totdebit decimal(12,2);
  declare totcredit decimal(12,2);
  declare AccountId int;
  declare AccountName varchar(50);
  declare OpeningBalance decimal(12,2);
  declare ClosingBalance decimal(12,2);
  declare amount decimal(12,2);
  declare isdebit bit;
  declare balance decimal(12,2);
  declare ismaster bit;
  #declare refaccountId int;
  declare totdebit_String varchar(50);
  declare totcredit_String varchar(50);
  declare balance_String decimal(10,2);
  declare opbal decimal(10,2);
  declare exit_loop boolean;



-- account id fetch with opening
declare MYCURSOR CURSOR FOR
        select AM.account_name, IFNULL(account_opening_master.opening_balance,0) as opening,AM.id
        FROM account_master AM
        left join account_opening_master on 
        AM.id = account_opening_master.account_master_id 
        and account_opening_master.financialyear_id =6
        where AM.company_id=1
        order by AM.account_name;
        


-- set exit_loop flag to true if there are no more rows
DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;
   
DROP TEMPORARY TABLE IF EXISTS finaltab;

CREATE TEMPORARY TABLE IF NOT EXISTS finaltab
( 
 
_totalDebit decimal(10,2),
_totalCredit decimal(10,2),
_AccountName varchar(50)
);
 
   
OPEN MYCURSOR;
account_master: LOOP
FETCH  MYCURSOR INTO AccountName,OpeningBalance,AccountId;
  set balance =OpeningBalance;
  set opbal = OpeningBalance;
  
   IF fromDate > fiscalstartdate THEN
      set totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount ),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
      
      set totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date >= fiscalstartdate AND VM.voucher_date < fromDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
          set balance= balance + totdebit - totcredit;
					set totcredit=0;
					set totdebit=0;
      
   
   END IF;
   
   set totdebit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='Y' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);
          
     set totcredit:=  (SELECT  IFNULL(SUM(VD.voucher_amount),0) 
					FROM voucher_detail VD
					INNER JOIN voucher_master VM
					ON VD.voucher_master_id =VM.id
					AND VD.is_debit ='N' AND VD.account_master_id =AccountId
					AND VM.voucher_date  BETWEEN fromDate AND toDate
					AND VM.company_id =CompanyId
					AND VM.year_id =YearId);      
          
    set balance= balance + totdebit - totcredit;
    
    If balance < 0
			THEN
				SET balance = balance * -1;
				SET balance_String =balance;# CAST( balance as char)  ;
				if opbal<>0 or totdebit<>0 or totcredit<>0 THEN 
				INSERT INTO finaltab (_AccountName,_totalCredit,_totalDebit) VALUES (AccountName,balance_String,0);
        END IF;
		ELSE
			
				 SET balance_String = balance ; #CAST( balance as char); 
				 IF opbal<>0 or totdebit<>0 or totcredit<>0  THEN
				 INSERT INTO finaltab (_AccountName,_totalCredit,_totalDebit) VALUES (AccountName,0,balance_String);
         END IF;
			END IF;

		
			

		set totcredit=0;
		set totdebit=0;
   
   
   
    IF exit_loop THEN
         CLOSE MYCURSOR;
         LEAVE account_master;
     END IF;
END LOOP account_master;
SELECT * FROM finaltab;
  
END;#final end
