CREATE PROCEDURE voucher_check (
IN companyId int(20),
IN yearId int(20)
)
BEGIN
declare mVoucherNumber varchar(255) DEFAULT NULL;
declare mVoucherType varchar(50) default Null;
declare mCreditAmount decimal(10,2) DEFAULT 0;
declare mDebitAmount decimal(10,2) DEFAULT 0;
declare mVoucherMasterId integer default 0;

declare cursor_finish integer default 0;

#cursor declaration 
declare cursorvoucher cursor for
select voucher_master.voucher_number,voucher_master.id,voucher_master.transaction_type
FROM voucher_master where voucher_master.company_id = companyId and voucher_master.year_id=yearId
ORDER BY voucher_master.id;

#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
  
  DROP TEMPORARY TABLE IF EXISTS debitCreditTable;
 
 #temptable creation
 CREATE TEMPORARY TABLE IF NOT EXISTS  debitCreditTable
(
	vouchermasterid INT,
	vouchernumber varchar(255),
  vouchertype varchar(50),
	creditamount decimal(10,2),
  debitamount decimal(10,2)
);
    
     OPEN cursorvoucher ;
     get_bill: LOOP	
     
     FETCH cursorvoucher INTO mVoucherNumber,mVoucherMasterId,mVoucherType;
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
 #credit amount
SET @m_creditAmount:=(SELECT 
                        ifnull(sum(voucher_detail.voucher_amount),0) as CreditAmount
                    FROM voucher_master
                    INNER JOIN
                    voucher_detail ON voucher_master.id = voucher_detail.voucher_master_id 
                    AND voucher_detail.is_debit='N'
                    GROUP BY voucher_master.id, voucher_master.voucher_number
                    HAVING  voucher_master.id = mVoucherMasterId);
#debit_amount
SET @m_debitAmount:=(SELECT 
                        ifnull(sum(voucher_detail.voucher_amount),0) as debitamount
                    FROM voucher_master
                    INNER JOIN
                    voucher_detail ON voucher_master.id = voucher_detail.voucher_master_id 
                    AND voucher_detail.is_debit='Y'
                    GROUP BY voucher_master.id, voucher_master.voucher_number
                    HAVING  voucher_master.id = mVoucherMasterId);
SET @diff = @m_debitAmount -  @m_creditAmount;
IF @diff<>0 THEN
insert into debitCreditTable
(
	vouchermasterid ,
	vouchernumber ,
  vouchertype ,
	creditamount,
  debitamount 
)values(mVoucherMasterId,mVoucherNumber,mVoucherType,@m_creditAmount,@m_debitAmount);
END IF;  
  
  END LOOP get_bill;
	CLOSE cursorvoucher; 
SELECT * from debitCreditTable order by vouchertype;
	
END;
#call voucher_check(1, 6);