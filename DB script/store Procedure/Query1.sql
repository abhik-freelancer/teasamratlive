SELECT 
Purchase_invoice_master.`id`,
Purchase_invoice_master.`purchase_invoice_number`,
#Purchase_invoice_master.`vendor_id`,
Purchase_invoice_master.`purchase_invoice_date`,
Purchase_invoice_master.`total`,
Purchase_invoice_master.`company_id`,
Purchase_invoice_master.`year_id`,
`account_master`.`id`,account_master.`account_name`
FROM 
Purchase_invoice_master
INNER JOIN
`vendor` ON `purchase_invoice_master`.`vendor_id` = vendor.`id`
INNER JOIN
`account_master` ON `vendor`.`account_master_id` = `account_master`.`id` 

SELECT * FROM vendorBillMaster
