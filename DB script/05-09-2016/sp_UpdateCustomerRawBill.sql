DELIMITER $$
CREATE PROCEDURE `sp_UpdateCustomerRawBill`()
BEGIN
    DECLARE m_taxInvoiceId INTEGER DEFAULT 0;
    DECLARE m_taxInvoiceDate DATETIME;
    DECLARE m_TaxBillAmount DECIMAL(10,2) DEFAULT 0;
    DECLARE m_customerAccountId INTEGER ;
    DECLARE m_companyId INTEGER;
    DECLARE m_yearId INTEGER;
	#cursor finish variable declare
	DECLARE cursor_finish INTEGER DEFAULT 0;
	
	#cursor declaration 
	DECLARE CursorSaleBill CURSOR FOR
	SELECT 
rawteasale_master.id AS InvoiceId,
rawteasale_master.sale_date AS salebilldate,
rawteasale_master.grandtotal,
account_master.id,
rawteasale_master.year_id,
rawteasale_master.company_id
FROM rawteasale_master
INNER JOIN customer ON rawteasale_master.customer_id = customer.id
INNER JOIN account_master ON account_master.id = customer.account_master_id;
  
	#declare cursor handler
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET cursor_finish = 1;
    
     OPEN CursorSaleBill ;
     get_bill: LOOP	
     
     FETCH CursorSaleBill INTO m_taxInvoiceId,m_taxInvoiceDate,m_TaxBillAmount,m_customerAccountId
     ,m_yearId,m_companyId;
     
     IF cursor_finish=1 THEN
      LEAVE get_bill;
     END IF;
     #insertion to bill master
     INSERT INTO customerbillmaster(
   billdate
  ,billamount
  ,invoicemasterid
  ,saletype
  ,customeraccountid
  ,companyid
  ,yearid
) VALUES (
   m_taxInvoiceDate 
  ,m_TaxBillAmount
  ,m_taxInvoiceId
  ,'R'  
  ,m_customerAccountId
  ,m_companyId
  ,m_yearId
);
     
     END LOOP get_bill;
	CLOSE CursorSaleBill; 
END$$

DELIMITER ;