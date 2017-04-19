DELIMITER $$

USE `teasamrat`$$

DROP PROCEDURE IF EXISTS `GetVendorUnpaidBill`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetVendorUnpaidBill`(
IN companyId INT(20),
IN vendorBillMaster INT(20),
OUT unpaidAmount DECIMAL(10,2)
)
BEGIN
 DECLARE _mbillAmount DECIMAL(10,2) DEFAULT 0;
 DECLARE _madjustedAmount DECIMAL(10,2) DEFAULT 0;
 DECLARE _mpaidAmount DECIMAL(10,2) DEFAULT 0;

SET _mbillAmount:=(SELECT IFNULL(vendorbillmaster.`billAmount`,0) AS bill
FROM `vendorbillmaster` 
WHERE  vendorbillmaster.`vendorBillMasterId`=vendorBillMaster AND vendorbillmaster.`companyId`=companyId);

SET  _madjustedAmount:= (SELECT IFNULL(SUM(`vendoradjustmentdetails`.`adjustedAmount`),0) AS adjustmentAmount
FROM `vendoradjustmentdetails`
GROUP BY 
`vendoradjustmentdetails`.`vendorBillMasterId`
HAVING 
`vendoradjustmentdetails`.`vendorBillMasterId`=vendorBillMaster);

SET _mpaidAmount:= (SELECT IFNULL(SUM(`vendorbillpaymentdetail`.`paidAmount`),0) AS paid FROM 
`vendorbillpaymentdetail`
GROUP BY 
`vendorbillpaymentdetail`.`vendorBillMaster`
HAVING 
`vendorbillpaymentdetail`.`vendorBillMaster`=vendorBillMaster);


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