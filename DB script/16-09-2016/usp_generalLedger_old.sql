/****** Object:  StoredProcedure [dbo].[usp_GeneralLedgerReport]    Script Date: 09/15/2016 18:07:41 ******/
/* SET ANSI_NULLS ON */
 
/* SET QUOTED_IDENTIFIER ON */
 
DELIMITER //

CREATE PROCEDURE usp_GeneralLedgerReport

(

 p_fromdate DATE,
 p_todate DATE,
 p_pagesize INT,
 p_companyid INT,
 p_yearid INT,
 p_accountid INT,
 p_fiscalstartdate DATE

)


BEGIN



DECLARE v_amount DECIMAL(12,2);
DECLARE v_accountname VARCHAR(100);
DECLARE v_voucherdate DATETIME(3);
DECLARE v_isdebit TINYINT;
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
DECLARE v_ismaster TINYINT;
DECLARE v_vouchernumber_temp VARCHAR(50);
DECLARE v_vouchernumberforsorting VARCHAR(50);
DECLARE v_prev_vch_number_part VARCHAR(10);
DECLARE v_prev_vch_last_part VARCHAR(20);
DECLARE v_chequeNumber VARCHAR(50);
DECLARE v_chequeDate DATETIME(3);
DECLARE v_chequeText VARCHAR(50);
DECLARE exit_loop BOOLEAN;
DECLARE v_totalsum DECIMAL(12,2);
DECLARE TCURSOR CURSOR FOR
		SELECT _vchId,_vchNumber,_amount,_isdebit
			FROM  MyTab ;
			DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop = TRUE;

-- select @ismaster=isMaster from CompanyMaster where CompanyId = @CompanyId and YearId= @YearId 



DROP TEMPORARY TABLE IF EXISTS MyTab;
CREATE TEMPORARY TABLE MyTab
(
	_vchId INT,
	_vchNumber VARCHAR(50),
	_amount DECIMAL(12,2),
	_isdebit VARCHAR(1)
);




INSERT INTO MyTab (_vchId,_vchNumber,_amount,_isdebit) 
SELECT vm.id,vm.`voucher_number`,vd.`voucher_amount`,vd.is_debit 
FROM voucher_master vm 
INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id` 
INNER JOIN account_master am ON vd.`account_master_id`=am.id
WHERE 
vd.`account_master_id` =30
AND vm.`company_id`=1  
AND vm.`year_id`=6
AND vm.`voucher_date` BETWEEN '2016-04-01' AND '2016-09-15'
ORDER BY  vm.`voucher_date`,vm.id;







-- ------


SET v_totalsum=0;



-- set exit_loop flag to true if there are no more rows

DROP TEMPORARY TABLE IF EXISTS TempTable1;
CREATE TEMPORARY TABLE TempTable1
(
	_srl INT AUTO_INCREMENT  NOT NULL,
	_voucherDate DATETIME(3),
	_voucher_masterid INT,
	_payto INT,
	_isdebit TINYINT,
  _detailid INT,
	_accountname VARCHAR(250),
	_accountid INT,
	_trantype VARCHAR(50),
	_narration VARCHAR(1500),
	_amount DECIMAL(12,2),
	_voucherNumber VARCHAR(50),
	_chequeNumber VARCHAR(50),
	_chequeDate DATETIME(3)

);
#cursor open
OPEN TCURSOR;
voucher_loop : LOOP
FETCH  TCURSOR INTO v_voucherid,v_vouchernumber,v_amount,v_isdebit;

	IF v_isdebit ='Y' THEN
			SELECT SUM(vd.`voucher_amount`) INTO v_totalsum 
			FROM voucher_master vm 
			INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id`
			AND vm.`id`= v_voucherid
			AND vd.`is_debit`='N' ;
			
			IF (v_totalsum=v_amount) THEN
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
							 ,IFNULL(vm.`narration`,''),vd.`voucher_amount`,vm.`voucher_number`
							 ,vm.`cheque_number`,vm.`cheque_date`
							FROM voucher_detail vd
							INNER JOIN account_master am
							ON vd.`account_master_id`=am.id
							INNER JOIN voucher_master vm
							ON vm.id=vd.`voucher_master_id` 
							INNER JOIN (
										SELECT vm.id
										FROM voucher_master vm
										INNER JOIN voucher_detail vd
										ON vm.id=vd.`voucher_master_id` 
										WHERE vd.AccountId IN (SELECT M.id 
																	FROM account_master M INNER JOIN account_master C
																	ON M.id= C.id
																	AND C.id=p_accountid
																)AND vm.`voucher_date` BETWEEN p_fromdate AND p_todate
										AND vm.`company_id`=p_companyid  
										AND vm.`year_id`=p_yearid
										) B
							ON vm.id= B.id
							WHERE vm.id=v_voucherid 
							AND vd.`is_debit`='N' ;
			
			ELSEIF(v_totalsum > v_amount)

					THEN

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

							 ,IFNULL(vm.`narration`,'')AS narration,v_amount AS amount,vm.`voucher_number`

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

										WHERE vd.`account_master_id` =30

										AND vm.`voucher_date` BETWEEN '2016-04-01' AND '2016-09-17'

										AND vm.`company_id`=1 

										AND vm.`year_id`=6

										) B

							ON vm.id= B.id

							WHERE vm.id=1125  

							AND vd.`is_debit`='N';

					END IF;
			END IF;
	
		ELSEIF (v_isdebit='N')THEN
			SELECT  SUM(vd.`voucher_amount`) INTO v_totalsum 
						FROM  voucher_master vm 
						INNER JOIN
						voucher_detail vd ON vm.id = vd.`voucher_master_id` 
						AND vm.id=v_voucherid  
						AND isDebit='Y';
						IF(v_totalsum = v_amount)
							THEN
							INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 
									SELECT DISTINCT vm.`voucher_date`,
									vm.id,0,
									vd.`is_debit`,
									vd.`id`,
									am.account_name,
									am.id,
									CASE 
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
									 ,IFNULL(vm.`narration`,''),vd.`voucher_amount`,vm.`voucher_number`
									 ,vm.`cheque_number`,vm.`cheque_date`
									FROM  voucher_detail vd
									INNER JOIN account_master am
									ON vd.`account_master_id`=am.id
									INNER JOIN voucher_master vm
									ON vm.id=vd.`voucher_master_id` 
									INNER JOIN (

												SELECT vm.`id`

												FROM voucher_master vm

												INNER JOIN voucher_detail vd

												ON vm.id=vd.`voucher_master_id` 

												WHERE vd.`account_master_id` =p_accountid
												AND vm.VoucherDate BETWEEN p_fromdate AND p_todate

												AND vm.`company_id`=p_companyid  

												AND vm.`year_id`=p_yearid

												) B

									ON vm.id= B.id

									WHERE vm.id=v_voucherid  

									AND vd.`is_debit`='Y'; 
							ELSEIF(v_totalsum > v_amount)

								THEN

									INSERT INTO TempTable1 (_voucherDate,_voucher_masterid,_payto,_isdebit,_detailid,_accountname,_accountid,_trantype,_narration,_amount,_voucherNumber,_chequeNumber,_chequeDate) 

									
									SELECT DISTINCT vm.`voucher_date`,
									vm.id,0,
									vd.`is_debit`,
									vd.id,am.account_name,am.id,

									CASE 

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

									 ,IFNULL(vm.`narration`,''),v_amount,vm.`voucher_number`

									 ,vm.`cheque_number`,vm.`cheque_date`

									FROM voucher_detail vd

									INNER JOIN account_master am

									ON vd.`account_master_id`=am.id

									INNER JOIN voucher_master vm

									ON vm.id=vd.`voucher_master_id` 

									INNER JOIN (

												SELECT vm.id

												FROM voucher_master vm

												INNER JOIN voucher_detail vd

												ON vm.id=vd.`voucher_master_id` 

												WHERE vd.`account_master_id` =p_accountid

																

												AND vm.`voucher_date` BETWEEN p_fromdate AND p_todate

												AND vm.`company_id`=p_companyid  

												AND vm.`year_id`=p_yearid

												) B

									ON vm.id= B.id

									WHERE vm.id=v_voucherid   

									AND vd.isDebit='Y'; 

								END IF;	
									

		END IF;
IF exit_loop THEN
	CLOSE TCURSOR;
	LEAVE voucher_loop
END IF;

END LOOP voucher_loop;

DROP TEMPORARY TABLE IF EXISTS FinalTable;
CREATE TEMPORARY TABLE FinalTable

(

	_serialId INT AUTO_INCREMENT  NOT NULL,
	_accountName VARCHAR(250),
	_debitamount DECIMAL(12,2),
	_creditamount DECIMAL(12,2),
	_voucherdate DATETIME(3),
	_acctag VARCHAR(3),
	_trantype VARCHAR(50),
	_grandtotaldebit DECIMAL(12,2),
	_grandtotalcredit DECIMAL(12,2),
	_narration VARCHAR(1500),
	_vouchernumber VARCHAR(50),
	_pagenumber INT,
	_voucherdatecopy DATETIME(3),
	_vouchernumberforsorting VARCHAR(50)

)



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
					AND C.`account_master_id`=p_accountid
					)
AND `account_opening_master`.`financialyear_id`=p_yearid
AND `account_opening_master`.`company_id`=p_companyid);

IF(p_fromdate > p_fiscalstartdate )

THEN
	SELECT IFNULL(SUM(vd.`voucher_amount`),0) INTO v_openingdebitbalance
	FROM voucher_detail vd
	INNER JOIN voucher_master vm
	ON vm.id=vd.`voucher_master_id` 
	WHERE `account_master_id` IN
						(
							SELECT M.id 
								FROM account_master M INNER JOIN account_master C
							ON M.id= C.id
							AND C.id=p_accountid
						)

	AND vm.`voucher_date` >= p_fiscalstartdate AND vm.`voucher_date` < p_fromdate
	AND vm.`company_id`=p_companyid  
	AND vm.`year_id`=p_yearid
	AND vd.`is_debit` = 'Y';


	SELECT IFNULL(SUM(vd.`voucher_amount`),0) INTO v_openingcreditbalance
	FROM voucher_detail vd
	INNER JOIN voucher_master vm
	ON vm.id=vd.`voucher_master_id` 
	WHERE vd.`account_master_id` IN
						(
						 SELECT M.AccountId 
						FROM account_master M INNER JOIN account_master C
						ON M.id= C.id
						AND C.id=p_accountid
						)

	AND vm.`voucher_date` >= p_fiscalstartdate AND vm.`voucher_date`< p_fromdate
	AND vm.`company_id`=p_companyid  
	AND vm.`year_id`=p_yearid
	AND vd.`is_debit` = 'N';

END IF;
SET v_openingbalance = v_openingbalance + v_openingdebitbalance - v_openingcreditbalance; 
IF(v_openingbalance > 0)

  THEN
  INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber) 
  VALUES (DATE_ADD(p_fromdate,INTERVAL -1 DAY) ,'Cr.','Opening Balance',v_openingbalance,0,v_openingbalance,0,1);

  SET v_creditbalance = v_creditbalance + v_openingbalance;
  
 ELSE
 
   SET v_openingbalance = v_openingbalance * -1;

    INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber) 
    VALUES ( DATE_ADD(p_fromdate,INTERVAL -1 DAY),'Dr.','Opening Balance',0,v_openingbalance,0,v_openingbalance,1)
    SET v_debitbalance= v_debitbalance + v_openingbalance;
	
 
 END IF; 


DECLARE finished INTEGER DEFAULT 0;
DECLARE MYCURSOR CURSOR FOR
SELECT _voucherDate,_isdebit,_accountname,_narration,_amount,_trantype,_voucherNumber,_chequeNumber,_chequeDate
FROM TempTable1 ORDER BY _voucherDate;

DECLARE CONTINUE HANDLER 
FOR NOT FOUND SET finished = 1;

OPEN MYCURSOR ;



get_loop: LOOP
 FETCH  MYCURSOR INTO v_voucherdate,v_isdebit,v_accountname,v_narration,v_amount,v_trantype,v_vouchernumber,v_chequeNumber,v_chequeDate ;
 
 
 IF v_finished = 1 THEN 
	LEAVE get_loop;
 END IF;
 -- build email list
 
 SET v_counter=v_counter+1;
 
 
 IF(IFNULL(v_chequeNumber,'') = '')

	THEN

		SET v_chequeText='';


	ELSE


		SET v_chequeText=CONCAT(' Cheque no. ' , v_chequeNumber , '. Cheque date ' , DATE_FORMAT (v_chequeDate, '%d/%m/%Y'));

	END IF;
	
	IF(v_isdebit = 'Y')

		THEN

		-- select * from @FinalTable

		-- - NEW ADDITION -- REMOVE DUPLICATE VOUCHER NUMBER
		IF NOT EXISTS(SELECT * FROM FinalTable WHERE _vouchernumber = v_vouchernumber)
			THEN
			INSERT INTO @FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
			VALUES (v_voucherdate,'Dr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,0,v_amount,0,v_amount,v_pagenumber,v_vouchernumber)

			SET v_creditbalance= v_creditbalance + v_amount;
		ELSE

				DECLARE v_debitcount INT;
				DECLARE v_creditcount INT;
				DECLARE v_dummyvar INT;

				SELECT COUNT(vd.`is_debit`) INTO v_creditcount
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'N'; 

				SELECT COUNT(vd.isDebit) INTO v_debitcount
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  
				AND vd.`is_debit` = 'Y'; 

				IF (v_debitcount > 1 AND v_creditcount > 1)
				THEN
					
					SET v_dummyvar = 1;


				ELSE
					INSERT INTO @FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) 
					VALUES (v_voucherdate,'Dr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,0,v_amount,0,v_amount,v_pagenumber,v_vouchernumber)

					SET v_creditbalance= v_creditbalance + v_amount;
				END IF;


			END IF;
		


	ELSE

		  -- - NEW ADDITION -- REMOVE DUPLICATE VOUCHER NUMBER
		   IF NOT EXISTS(SELECT * FROM FinalTable WHERE _vouchernumber = v_vouchernumber)
			THEN
			INSERT INTO FinalTable(_voucherdate,_acctag,_accountName,_narration,_trantype,_vouchernumber,_debitamount,_creditamount,_grandtotaldebit,_grandtotalcredit,_pagenumber,_vouchernumberforsorting) VALUES

			(v_voucherdate,'Cr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,v_amount,0,v_amount,0,v_pagenumber,v_vouchernumber)

			SET v_debitbalance= v_debitbalance + v_amount;
		   ELSE
				DECLARE v_debitcnt INT;
				DECLARE v_creditcnt INT;
				DECLARE v_dummy_var INT;

				SELECT COUNT(vd.`is_debit`) INTO v_creditcnt
				FROM voucher_master vm
				INNER JOIN voucher_detail vd
				ON vm.id = vd.`voucher_master_id` 
				WHERE vm.id=v_voucherid  -- vm.VoucherNumber = @vouchernumber
				AND vd.isDebit = 'N'; 

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
						VALUES (v_voucherdate,'Cr.',v_accountname,CONCAT(v_narration,v_chequeText),v_trantype,v_vouchernumber,v_amount,0,v_amount,0,v_pagenumber,v_vouchernumber)

						SET v_debitbalance= v_debitbalance + v_amount;
					END IF;

			END IF;	

		END IF;
 
 
 
 
 
 
END LOOP get_loop;
CLOSE MYCURSOR;

#----
SELECT * FROM FinalTable;



END;
//

DELIMITER ;




-- exec usp_GeneralLedgerReport '2016-04-01','2016-04-30',16,1,5,36226,'2016-04-01'
-- exec usp_GeneralLedgerReport '2016-04-01','2016-04-30',16,1,5,43235,'2016-04-01'