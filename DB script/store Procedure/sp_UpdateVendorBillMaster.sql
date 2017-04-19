DELIMITER $$
CREATE
    PROCEDURE `teasamrat`.`sp_UpdateVendorBillMaster`()
BEGIN
    DECLARE m_purchaseInvoiceId INTEGER DEFAULT 0;
    DECLARE m_purchaseInvoiceDate DATETIME;
    DECLARE m_purchaseBillAmount DECIMAL(10,2) DEFAULT 0;
    DECLARE m_vendorAccountId INTEGER ;
    DECLARE m_companyId INTEGER;
    DECLARE m_yearId INTEGER;
	#cursor finish variable declare
	DECLARE cursor_finish INTEGER DEFAULT 0;
	
	#cursor declaration 
	DECLARE CursorpurchaseBill CURSOR FOR
	SELECT Purchase_invoice_master.`id` AS invoiceId,Purchase_invoice_master.`purchase_invoice_date`,
		  Purchase_invoice_master.`total`,`account_master`.`id`,
		  Purchase_invoice_master.`year_id`,Purchase_invoice_master.`company_id`
	FROM 
		  Purchase_invoice_master
	INNER JOIN`vendor` ON `purchase_invoice_master`.`vendor_id` = vendor.`id`
	INNER JOIN`account_master` ON `vendor`.`account_master_id` = `account_master`.`id` ;
	#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
    
     OPEN CursorpurchaseBill ;
     get_bill: LOOP	
     
     FETCH CursorpurchaseBill INTO m_purchaseInvoiceId,m_purchaseInvoiceDate,m_purchaseBillAmount,m_vendorAccountId
     ,m_yearId,m_companyId;
     
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
     #insertion to bill master
     INSERT INTO `vendorbillmaster`
            (
             `billDate`,
             `billAmount`,
             `invoiceMasterId`,
             `purchaseType`,
             `vendorAccountId`,
             `companyId`,
             `yearId`)
	VALUES (
        m_purchaseInvoiceDate,
        m_purchaseBillAmount,
        m_purchaseInvoiceId,
        'T',
        m_vendorAccountId,
        m_companyId,
        m_yearId);
     
     END LOOP get_bill;
	CLOSE CursorpurchaseBill; 

END$$ #main End

DELIMITER ;

