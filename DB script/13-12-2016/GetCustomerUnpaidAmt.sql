DELIMITER $$

USE `teasamrat`$$

DROP PROCEDURE IF EXISTS `GetCustomerUnpaidAmt`$$

CREATE DEFINER=`samrat`@`localhost` PROCEDURE `GetCustomerUnpaidAmt`(
IN companyId INT(20),
IN customerBillMaster INT(20),
IN customerpaymentId INT(20),
OUT unpaidAmount DECIMAL(10,2)
)
BEGIN
 DECLARE _mbillAmount DECIMAL(10,2) DEFAULT 0;
 DECLARE _madjustedAmount DECIMAL(10,2) DEFAULT 0;
 DECLARE _mpaidAmount DECIMAL(10,2) DEFAULT 0;
SET _mbillAmount:=(SELECT IFNULL(customerbillmaster.`billamount`,0) AS bill
FROM `customerbillmaster` 
WHERE  customerbillmaster.`customerbillmasterid`=customerBillMaster AND customerbillmaster.`companyid`=companyId);
SET  _madjustedAmount:= (SELECT IFNULL(SUM(`customeradvanceadjstdtl`.`adjustedamount`),0) AS adjustmentAmount
FROM `customeradvanceadjstdtl`
GROUP BY 
`customeradvanceadjstdtl`.`customerbillmaster`
HAVING 
`customeradvanceadjstdtl`.`customerbillmaster`=customerBillMaster);
#check add edit mode
IF customerpaymentId <>0 THEN
	SET _mpaidAmount:= (SELECT IFNULL(SUM(`customerreceiptdetail`.`receiptamount`),0) AS paid FROM 
	`customerreceiptdetail`
	GROUP BY 
	`customerreceiptdetail`.`customerbillmasterid`
	,customerreceiptdetail.`customerrecptmstid`
	HAVING  
	customerreceiptdetail.`customerbillmasterid`=customerBillMaster 
	AND customerreceiptdetail.`customerrecptmstid`<>customerpaymentId);
ELSE
	SET _mpaidAmount:= (SELECT IFNULL(SUM(`customerreceiptdetail`.`receiptamount`),0) AS paid FROM 
	`customerreceiptdetail`
	GROUP BY 
	`customerreceiptdetail`.`customerbillmasterid`
	HAVING  
	customerreceiptdetail.`customerbillmasterid`=customerBillMaster 
	);
END IF;

 #select _mbillAmount;
 #SELECT _madjustedAmount;
 #SELECT _mpaidAmount;
IF(_madjustedAmount IS NULL)THEN
	SET _madjustedAmount:=0;
END IF;
IF(_mpaidAmount IS NULL)THEN
	SET _mpaidAmount:=0;
END IF;
 
 
 SET unpaidAmount := _mbillAmount - (_madjustedAmount + _mpaidAmount);
 #SET unpaidAmount :=50;
 #SELECT unpaidAmount;
 
 END$$

DELIMITER ;