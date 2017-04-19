DELIMITER $$
CREATE PROCEDURE usp_generalLedger(companyId int,yearId int,accountId int,fromDate date,todate date,fiscalstart date)
BEGIN

DECLARE m_voucherId int;
DECLARE m_voucheramount decimal(10,2);
DECLARE m_isDebit char(1);
#-------------
DECLARE v_totalsum decimal(10,2);

#cursor finish variable#
DECLARE v_finish integer default 0;

#main cursor
DECLARE  CURSOR_1 CURSOR FOR(
                              SELECT vm.id,vd.`voucher_amount`,vd.is_debit 
                              FROM voucher_master vm 
                              INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id` 
                              WHERE 
                              vd.`account_master_id` =30
                              AND vm.`company_id`=1  
                              AND vm.`year_id`=6
                              AND vm.`voucher_date` BETWEEN '2016-04-01' AND '2016-09-15'
                              ORDER BY  vm.`voucher_date`,vm.id
                              );
DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finish=1;

#temporary table for store transaction
DROP TEMPORARY TABLE IF EXISTS TempTable1;
CREATE TEMPORARY TABLE TempTable1
(
	_srl INT AUTO_INCREMENT  NOT NULL,
	_voucherDate DATETIME,
	_voucher_masterid INT,
	_payto INT,
	_isdebit char(1),
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
                
                
              ELSEIF m_isDebit='N' THEN
                
                SELECT SUM(vd.`voucher_amount`) AS v_totalsum 
                FROM voucher_master vm 
                INNER JOIN voucher_detail vd ON vm.`id`=vd.`voucher_master_id`
                WHERE  vd.`voucher_master_id`= m_voucherId AND vd.`is_debit`='Y' 
                GROUP BY vd.`voucher_master_id`;
                
                 IF(v_totalsum = m_voucheramount)	THEN
                  #to do
                  select 1;
                 ELSEIF (v_totalsum > m_voucheramount) THEN
                #to do
                 select 2;
                 END IF;
                
              
              END IF;#if transaction debit or credit end
              

END LOOP get_acc;
CLOSE CURSOR_1;
END$$
 
DELIMITER ;

# call usp_generalLedger(companyId int,yearId int,accountId int,fromDate date,todate date,fiscalstart date);
# call usp_generalLedger(1,6,30,'2016-04-01','2016-09-15','2016-04-01');