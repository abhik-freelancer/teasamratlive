DROP PROCEDURE IF EXISTS teasamrat.usp_DebtorsDue;
CREATE PROCEDURE teasamrat.`usp_DebtorsDue`(
yearId INT,
companyId int,
fromdate date,
todate date)
BEGIN
Declare fiscalStartDate Date;
DECLARE accountId INT;
DECLARE accountDesc varchar(255);
DECLARE openingBal decimal(12,2);
DECLARE totalDebit decimal(12,2);
DECLARE totalCredit decimal(12,2);
DECLARE closingBal decimal(12,2);
DECLARE balanceTag varchar(10);
DECLARE PreviousBillAmt decimal(12,2);
DECLARE CompanyName varchar(255);
DECLARE Period varchar(255);
#cursor handler variable
DECLARE finished INTEGER DEFAULT 0;
#cursor declaration
DECLARE cursor_accountId cursor for 
        SELECT `account_master`.id,`account_master`.account_name
        FROM account_master
        WHERE `account_master`.group_master_id=1 ORDER BY `account_master`.account_name;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

drop temporary table if exists TempTable;
create temporary table TempTable
(
	id int auto_increment primary key NOT NULL,
	AccountId int,
	AccountDescription varchar(255),
	Opening decimal(12,2),
	DebitAmount decimal(12,2),
  CreditAmount decimal(12,2),
	Balance decimal(12,2),
	BalanceTag varchar(10)
);



#fiscal start date set
SET fiscalStartDate:=(
SELECT 
  financialyear.`start_date` 
FROM
  `financialyear` 
WHERE financialyear.id =  yearId);


OPEN cursor_accountId;
account_loop : LOOP
FETCH NEXT FROM cursor_accountId INTO accountId,accountDesc;
 IF finished = 1 THEN 
   LEAVE account_loop;
 END IF;
 
 
 
 
 #opening balance fetch of account
 set openingBal:=(
 SELECT IFNULL(`account_opening_master`.`opening_balance`,0)  FROM `account_opening_master` 
  WHERE `account_opening_master`.`account_master_id` = accountId
  AND `account_opening_master`.`company_id` = companyId AND account_opening_master.`financialyear_id`= yearId);
 
 #if fromdate not equals to start date.
 #select fromdate,fiscalStartDate;
 
 IF fromdate > fiscalStartDate 	THEN
	# debit
  SET totalDebit :=(
	SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'Y' 
	AND VM.`voucher_date` >= fiscalStartDate
	AND VM.voucher_date < fromdate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  # credit
  SET totalCredit:=(
  SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'N' 
	AND VM.`voucher_date` >= fiscalStartDate
	AND VM.voucher_date < fromdate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
		
  SET openingBal := ifnull(openingBal,0) + ifnull(totalDebit,0) - ifnull(totalCredit,0);
 
END IF;

 
 
 # debit
 SET totalDebit :=(
	SELECT  IFNULL(SUM(VD.`voucher_amount`),0)  FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'Y' 
	AND VM.`voucher_date` BETWEEN fromdate and todate
	AND VM.`company_id` = companyId
	AND VD.`account_master_id` = accountId);
  
  #credit
  SET totalCredit:=(
  SELECT  IFNULL(SUM(VD.`voucher_amount`),0) FROM 
	voucher_detail VD 
	INNER JOIN voucher_master VM ON VM.id = VD.voucher_master_id	WHERE VD.is_debit = 'N' 
	AND VM.`voucher_date` BETWEEN fromdate and todate
	AND VM.`company_id` =companyId
	AND VD.`account_master_id` =accountId);
  
  set closingBal := (openingBal + ifnull(totalDebit,0))-(ifnull(totalCredit,0));
  
 
 
 if(closingBal>0) then
  	  set balanceTag ='DR';
  else
	   set balanceTag ='CR';
  end if; 
 

if (openingBal<>0 or totalDebit <> 0 or totalCredit <> 0) THEN

insert into TempTable(AccountId,	AccountDescription,Opening ,DebitAmount , CreditAmount ,Balance ,BalanceTag)
	VALUES(accountId,accountDesc,openingBal,totalDebit,totalCredit,closingBal,balanceTag);

end if;

END LOOP account_loop;


CLOSE cursor_accountId;
  
SELECT * FROM TempTable where Balance<>0 order by AccountDescription  ;
  
  
END;
