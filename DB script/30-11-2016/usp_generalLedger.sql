DELIMITER $$

CREATE  PROCEDURE `usp_generalLedger`(companyId INT,yearId INT,accountId INT,fromDate DATE,todate DATE,fiscalstart DATE)
BEGIN
DECLARE m_voucherId INT;
DECLARE m_voucheramount DECIMAL(10,2);
DECLARE m_isDebit CHAR(1);
#-------------#
DECLARE v_totalsum DECIMAL(10,2);
#-------18-09-2016-------------#
DECLARE v_amount DECIMAL(12,2);
DECLARE v_accountname VARCHAR(100);
DECLARE v_voucherdate DATETIME;
DECLARE v_isdebit CHAR(1);
DECLARE v_counter INT;
DECLARE v_pagenumber INT;
DECLARE v_debitbalance DECIMAL(12,2);
DECLARE v_creditbalance DECIMAL(12,2);
DECLARE v_narration VARCHAR(1500);
DECLARE v_trantype VARCHAR(50);
DECLARE v_vouchernumber VARCHAR(50);
DECLARE v_voucherid INT;
DECLARE v_openingbalance DECIMAL(12,2);
DECLARE v_openingdebitbalance DECIMAL(12,2);
DECLARE v_openingcreditbalance DECIMAL(12,2);
DECLARE v_ismaster CHAR(1);
DECLARE v_vouchernumber_temp VARCHAR(50);
DECLARE v_vouchernumberforsorting VARCHAR(50);
DECLARE v_prev_vch_number_part VARCHAR(10);
DECLARE v_prev_vch_last_part VARCHAR(20);
DECLARE v_chequeNumber VARCHAR(50);
DECLARE v_chequeDate DATETIME;
DECLARE v_chequeText VARCHAR(50);
#--------------------#
DECLARE v_debitcount INT;
DECLARE v_creditcount INT;
DECLARE v_dummyvar INT;
DECLARE v_debitcnt INT;
DECLARE v_creditcnt INT;
DECLARE v_dummy_var INT;
#--------18-09-2016--------------#
DECLARE finished INTEGER DEFAULT 0;
#cursor finish variable#
DECLARE v_finish INTEGER DEFAULT 0;
DECLARE MYCURSOR CURSOR FOR
SELECT _voucherDate,_isdebit,_accountname,_narration,_amount,_trantype,_voucherNumber,_chequeNumber,_chequeDate
FROM TempTable1 ORDER BY _voucherDate;
#
#main cursor
# 
DECLARE  CURSOR_1 CURSOR FOR(
                              SELECT vm.id,vd.`voucher_amount`,vd.is_debit 
                              FROM voucher_master vm 
                              INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id` 
                              WHERE 
                              vd.`account_master_id` =accountId
                              AND vm.`company_id`=companyId  
                              AND vm.`year_id`=yearId
                              AND vm.`voucher_date` BETWEEN fromDate AND todate
                              ORDER BY  vm.`voucher_date`,vm.id
                              );
#temporary table for store transaction
DROP TEMPORARY TABLE IF EXISTS TempTable1;
CREATE TEMPORARY TABLE TempTable1
(
	_voucherDate DATETIME,
	_voucher_masterid INT,
	_payto INT,
	_isdebit CHAR(1),
  _detailid INT,
	_accountname VARCHAR(250),
	_accountid INT,
	_trantype VARCHAR(50),
	_narration VARCHAR(1500),
	_amount DECIMAL(12,2),
	_voucherNumber VARCHAR(100),
	_chequeNumber VARCHAR(50),
	_chequeDate DATETIME
);
#temporary table for store transaction end
BEGIN
DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finish=1;
OPEN CURSOR_1;
get_acc : LOOP
FETCH CURSOR_1 INTO m_voucherId,m_voucheramount,m_isDebit;
IF v_finish = 1 THEN
  LEAVE get_acc;
END IF;
              #select m_voucherId, m_voucheramount, m_isDebit;
              IF m_isDebit='Y' THEN #if transaction debit or credit
                
                      SELECT SUM(vd.voucher_amount) INTO v_totalsum 
                      FROM voucher_master vm 
                      INNER JOIN voucher_detail vd ON vm.id = vd.voucher_master_id
                      WHERE  vd.voucher_master_id = m_voucherId AND vd.is_debit='N' 
                      GROUP BY vd.voucher_master_id;
                
                
                        	IF (v_totalsum=m_voucheramount) THEN
                              #credit transaction insertion on temporay table#
                              INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                              SELECT DISTINCT   vm.`voucher_date`, vm.id,0,vd.`is_debit`,vd.`id`,am.`account_name`,am.`id`,
                                            CASE
                                              WHEN vm.`transaction_type` = 'PY' 
                                              THEN 'Payment' 
                                              WHEN vm.transaction_type = 'SL' 
                                              THEN 'Sales' 
                                              WHEN vm.transaction_type = 'PR' 
                                              THEN 'Purchase' 
                                              WHEN vm.transaction_type = 'RC' 
                                              THEN 'Receipt' 
                                              WHEN vm.transaction_type = 'CN' 
                                              THEN 'Contra' 
                                              WHEN vm.transaction_type = 'JV' 
                                              THEN 'Journal' 
                                              WHEN vm.transaction_type = 'GV' 
                                              THEN 'General' 
                                              WHEN vm.transaction_type = 'RP' 
                                              THEN 'Purchase' 
                                              WHEN vm.transaction_type = 'RS' 
                                              THEN 'Sales' 
                                              WHEN vm.transaction_type = 'VADV' 
                                              THEN 'Advance' 
                                              WHEN vm.transaction_type = 'CADV' 
                                              THEN 'Advance' 
                                            END AS trantype,
                                            IFNULL(vm.`narration`, '') AS narration,
                                            vd.`voucher_amount`,
                                            vm.`voucher_number`,
                                            vm.`cheque_number`,
                                            vm.`cheque_date` 
                                          FROM
                                            voucher_detail vd 
                                            INNER JOIN account_master am 
                                              ON vd.`account_master_id` = am.id 
                                            INNER JOIN voucher_master vm 
                                              ON vm.id = vd.`voucher_master_id` 
                                            INNER JOIN 
                                              (SELECT 
                                                vm.id 
                                              FROM
                                                voucher_master vm 
                                                INNER JOIN voucher_detail vd 
                                                  ON vm.id = vd.`voucher_master_id` 
                                              WHERE vd.account_master_id IN 
                                                (SELECT 
                                                  M.id 
                                                FROM
                                                  account_master M 
                                                  INNER JOIN account_master C 
                                                    ON M.id = C.id 
                                                    AND C.id = accountId) 
                                                AND vm.`voucher_date` BETWEEN fromDate AND todate
                                                AND vm.`company_id` = companyId 
                                                AND vm.`year_id` = yearId) B 
                                              ON vm.id = B.id 
                                          WHERE vm.id = m_voucherId 
                                            AND vd.`is_debit` = 'N' ;
                          ELSEIF v_totalsum > m_voucheramount THEN
                           #insertion on temp table#
                           #to do
                           INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                           SELECT DISTINCT vm.`voucher_date`,vm.id,0,vd.`is_debit`,vd.`id`,am.`account_name`,am.`id`,
                    							CASE 
                    							   WHEN vm.`transaction_type`='PY' THEN 'Payment'
                    								 WHEN vm.transaction_type='SL' THEN 'Sales'
                    								 WHEN vm.transaction_type='PR' THEN 'Purchase'
                    								 WHEN vm.transaction_type='RC' THEN 'Receipt'
                    								 WHEN vm.transaction_type='CN' THEN 'Contra'
                    								 WHEN vm.transaction_type='JV' THEN 'Journal'
                    								 WHEN vm.transaction_type='GV' THEN 'General'
                    								 WHEN vm.transaction_type ='RP'THEN 'Purchase'
                    								 WHEN vm.transaction_type='RS' THEN 'Sales'
                    								 WHEN vm.transaction_type='VADV' THEN 'Advance'
                    								 WHEN vm.transaction_type='CADV' THEN 'Advance'
                    							END AS trantype
                    							 ,IFNULL(vm.`narration`,'')AS narration,m_voucheramount AS amount,vm.`voucher_number`
                    							 ,vm.`cheque_number`,vm.`cheque_date`
                    							FROM voucher_detail vd
                    							INNER JOIN account_master am
                    							ON vd.`account_master_id`=am.id
                    							INNER JOIN voucher_master vm
                    							ON vm.id=vd.`voucher_master_id` 
                    							INNER JOIN (
                    										SELECT vm.`id`
                    										FROM voucher_master vm
                    										INNER JOIN voucher_detail vd
                    										ON vm.id=vd.`voucher_master_id` 
                    										WHERE vd.`account_master_id` =accountId
                    										AND vm.`voucher_date` BETWEEN fromDate AND todate
                    										AND vm.`company_id`=companyId 
                    										AND vm.`year_id`=yearId
                    										) B
                    							ON vm.id= B.id
                    							WHERE vm.id=m_voucherId  
                    							AND vd.`is_debit`='N';
                          
                          END IF;
                
                
              ELSEIF m_isDebit='N' THEN #credit transaction of this account
                
                SELECT SUM(vd.`voucher_amount`) INTO v_totalsum 
                FROM voucher_master vm 
                INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id`
                WHERE  vd.`voucher_master_id`= m_voucherId AND vd.`is_debit`='Y' 
                GROUP BY vd.`voucher_master_id`;
                
                 IF(v_totalsum = m_voucheramount)	THEN
                  #to do
                  INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                  SELECT DISTINCT  vm.`voucher_date`, vm.id, 0,vd.`is_debit`, vd.`id`, am.account_name, am.id,
                  CASE
			      WHEN vm.`transaction_type` = 'PY' 
                              THEN 'Payment'
                              WHEN vm.transaction_type = 'SL' 
                              THEN 'Sales' 
                              WHEN vm.transaction_type = 'PR' 
                              THEN 'Purchase' 
                              WHEN vm.transaction_type = 'RC' 
                              THEN 'Receipt' 
                              WHEN vm.transaction_type = 'CN' 
                              THEN 'Contra' 
                              WHEN vm.transaction_type = 'JV' 
                              THEN 'Journal' 
                              WHEN vm.transaction_type = 'GV' 
                              THEN 'General' 
                              WHEN vm.transaction_type = 'RP' 
                              THEN 'Purchase' 
                              WHEN vm.transaction_type = 'RS' 
                              THEN 'Sales' 
                              WHEN vm.transaction_type = 'VADV' 
                              THEN 'Advance' 
                              WHEN vm.transaction_type = 'CADV' 
                              THEN 'Advance' 
                            END AS trantype,
                            IFNULL(vm.`narration`, '') AS narration, vd.`voucher_amount`, vm.`voucher_number`, vm.`cheque_number`,vm.`cheque_date` 
                            FROM voucher_detail vd INNER JOIN account_master am ON vd.`account_master_id` = am.id 
                            INNER JOIN voucher_master vm  ON vm.id = vd.`voucher_master_id` 
                            INNER JOIN 
                            (SELECT 
                              vm.`id` 
                              FROM
                              voucher_master vm 
                              INNER JOIN voucher_detail vd 
                              ON vm.id = vd.`voucher_master_id` 
                              WHERE vd.`account_master_id` =  accountId
                              AND vm.`voucher_date` BETWEEN fromDate AND todate 
                              AND vm.`company_id` = companyId 
                              AND vm.`year_id` = yearId) B 
                              ON vm.id = B.id WHERE vm.id =m_voucherId  
                              AND vd.`is_debit` = 'Y' ;
                 ELSEIF (v_totalsum > m_voucheramount) THEN
                  #to do
                  #companyId int,yearId int,accountId int,fromDate date,todate date,fiscalstart date
                   INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
                    SELECT DISTINCT  vm.`voucher_date`, vm.id, 0,vd.`is_debit`,vd.id,am.account_name,am.id,
                    CASE
				  WHEN vm.`transaction_type` = 'PY' 
                                  THEN 'Payment'
                                  WHEN vm.transaction_type = 'SL' 
                                  THEN 'Sales' 
                                  WHEN vm.transaction_type = 'PR' 
                                  THEN 'Purchase' 
                                  WHEN vm.transaction_type = 'RC' 
                                  THEN 'Receipt' 
                                  WHEN vm.transaction_type = 'CN' 
                                  THEN 'Contra' 
                                  WHEN vm.transaction_type = 'JV' 
                                  THEN 'Journal' 
                                  WHEN vm.transaction_type = 'GV' 
                                  THEN 'General' 
                                  WHEN vm.transaction_type = 'RP' 
                                  THEN 'Purchase' 
                                  WHEN vm.transaction_type = 'RS' 
                                  THEN 'Sales' 
                                  WHEN vm.transaction_type = 'VADV' 
                                  THEN 'Advance' 
                                  WHEN vm.transaction_type = 'CADV' 
                                  THEN 'Advance' 
                      END AS trantype,
                      IFNULL(vm.`narration`, '') AS narration, m_voucheramount,vm.`voucher_number`,vm.`cheque_number`,vm.`cheque_date` 
                      FROM
                      voucher_detail vd 
                      INNER JOIN account_master am 
                      ON vd.`account_master_id` = am.id 
                      INNER JOIN voucher_master vm 
                      ON vm.id = vd.`voucher_master_id` 
                      INNER JOIN 
                        (SELECT 
                          vm.id 
                        FROM
                          voucher_master vm 
                          INNER JOIN voucher_detail vd 
                          ON vm.id = vd.`voucher_master_id` 
                          WHERE vd.`account_master_id` = accountId
                          AND vm.`voucher_date` BETWEEN fromDate AND todate
                          AND vm.`company_id` = companyId  
                          AND vm.`year_id` =yearId ) B 
                        ON vm.id = B.id 
                    WHERE vm.id = m_voucherId 
                      AND vd.is_debit = 'Y' ;
               
                 END IF;
                
              
              END IF;#if transaction debit or credit end
              
END LOOP get_acc;
CLOSE CURSOR_1;
END;
#select * from TempTable1;
DROP TEMPORARY TABLE IF EXISTS FinalTable;
CREATE TEMPORARY TABLE FinalTable
(
	_accountName VARCHAR(250),
	_debitamount DECIMAL(12,2),
	_creditamount DECIMAL(12,2),
	_voucherdate DATETIME,
	_acctag VARCHAR(3),
	_trantype VARCHAR(50),
	_grandtotaldebit DECIMAL(12,2),
	_grandtotalcredit DECIMAL(12,2),
	_narration VARCHAR(1500),
	_vouchernumber VARCHAR(50),
	_pagenumber INT,
	_voucherdatecopy DATETIME,
	_vouchernumberforsorting VARCHAR(50)
);
#----------------------
SET v_counter=0;
SET v_pagenumber=1;
SET v_debitbalance=0;
SET v_creditbalance =0;
SET v_openingbalance=0;
SET v_openingdebitbalance=0;
SET v_openingcreditbalance=0;
SET v_openingbalance=(
SELECT SUM(IFNULL(`opening_balance`,0)) 
FROM `account_opening_master`
WHERE `account_master_id` IN (
					 SELECT M.`id` 
					FROM account_master M 
					INNER JOIN `account_opening_master` C
					ON M.id= C.`account_master_id`
					AND C.`account_master_id`=accountId
					)
AND `account_opening_master`.`financialyear_id`=yearId
AND `account_opening_master`.`company_id`=companyId);
IF fromDate > fiscalstart THEN
SELECT SUM(IFNULL(vd.`voucher_amount`,0)) INTO v_openingdebitbalance
	FROM voucher_detail vd
	INNER JOIN voucher_master vm
	ON vm.id=vd.`voucher_master_id` 
	WHERE vd.`account_master_id` =accountId AND (vm.`voucher_date`>=fiscalstart AND vm.`voucher_date` < fromDate)
	AND vm.`company_id` = companyId AND vm.`year_id` = yearId AND vd.`is_debit` ='Y'
	GROUP BY vd.`account_master_id` ORDER BY vd.`account_master_id`;
	
SELECT SUM(IFNULL(vd.`voucher_amount`,0)) INTO v_openingcreditbalance
	FROM voucher_detail vd
	INNER JOIN voucher_master vm
	ON vm.id=vd.`voucher_master_id` 
	WHERE vd.`account_master_id` =accountId AND (vm.`voucher_date`>=fiscalstart AND vm.`voucher_date` < fromDate)
	AND vm.`company_id` = companyId AND vm.`year_id` = yearId AND vd.`is_debit` ='N'
	GROUP BY vd.`account_master_id` ORDER BY vd.`account_master_id`;
END IF;
#opening balance
SET v_openingbalance = v_openingbalance + v_openingdebitbalance - v_openingcreditbalance; 
#opening insertion on final table
IF(v_openingbalance > 0)
  THEN
 
  INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber) 
  VALUES (DATE_ADD(fromDate,INTERVAL -1 DAY) ,'Cr.','Opening Balance',v_openingbalance,0,v_openingbalance,0,1);
  SET v_creditbalance = v_creditbalance + v_openingbalance;
  
ELSE
 
   SET v_openingbalance = v_openingbalance * -1;
   
   INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber) 
   VALUES ( DATE_ADD(fromDate,INTERVAL -1 DAY),'Dr.','Opening Balance',0,v_openingbalance,0,v_openingbalance,1);
   
    SET v_debitbalance= v_debitbalance + v_openingbalance;
	
 
 END IF; 
 #second cursor
 BEGIN
 DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
 OPEN MYCURSOR ;
 get_loop: LOOP
 
 FETCH  MYCURSOR INTO v_voucherdate,v_isdebit,v_accountname,v_narration,v_amount,v_trantype,v_vouchernumber,v_chequeNumber,v_chequeDate ;
 
 IF finished = 1 THEN 
	LEAVE get_loop;
 END IF;
 
 IF(IFNULL(v_chequeNumber,'') = '')
	THEN
		SET v_chequeText='';
	ELSE
		SET v_chequeText=CONCAT(' Cheque no. ' , v_chequeNumber , '. Cheque date ' , DATE_FORMAT (v_chequeDate, '%d/%m/%Y'));
	END IF;
  
 IF v_isdebit = 'Y' THEN
      IF NOT EXISTS(SELECT * FROM FinalTable WHERE _vouchernumber = v_vouchernumber)
			THEN
			INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
			VALUES (v_voucherdate,'Dr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,0,v_amount,0,v_amount,v_pagenumber,v_vouchernumber);
			SET v_creditbalance= v_creditbalance + v_amount;
		ELSE
				
				SELECT COUNT(vd.`is_debit`) INTO v_creditcount
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'N'; 
				SELECT COUNT(vd.is_Debit) INTO v_debitcount
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'Y'; 
				IF (v_debitcount > 1 AND v_creditcount > 1)
				THEN
					
					SET v_dummyvar = 1;
				ELSE
					INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
					VALUES (v_voucherdate,'Dr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,0,v_amount,0,v_amount,v_pagenumber,v_vouchernumber);
					SET v_creditbalance= v_creditbalance + v_amount;
				END IF;
			END IF;
		
      
      
 ELSE
 -- - NEW ADDITION -- REMOVE DUPLICATE VOUCHER NUMBER
		   IF NOT EXISTS(SELECT * FROM FinalTable WHERE _vouchernumber = v_vouchernumber)
			THEN
			INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) VALUES
			(v_voucherdate,'Cr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,v_amount,0,v_amount,0,v_pagenumber,v_vouchernumber);
			SET v_debitbalance= v_debitbalance + v_amount;
		   ELSE
				
				SELECT COUNT(vd.`is_debit`) INTO v_creditcnt
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  -- vm.VoucherNumber = @vouchernumber
				AND vd.is_Debit = 'N'; 
				SELECT COUNT(vd.`is_debit`) INTO v_debitcnt
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'Y'; 
				IF (v_creditcnt > 1 AND v_debitcnt > 1)
					THEN
						SET v_dummy_var = 1;
				ELSE
						INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
						VALUES (v_voucherdate,'Cr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,v_amount,0,v_amount,0,v_pagenumber,v_vouchernumber);
						SET v_debitbalance= v_debitbalance + v_amount;
					END IF;
			END IF;	
 
 END IF;
 
 END LOOP get_loop;
 CLOSE MYCURSOR;
 END;
SELECT * FROM FinalTable;
END$$

DELIMITER ;