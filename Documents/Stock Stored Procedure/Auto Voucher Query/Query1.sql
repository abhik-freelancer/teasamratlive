#Vendor
SET @Vendor:=(
SELECT (IFNULL(`purchase_invoice_master`.`total`,0)) AS totalCreditAmountForVendor
FROM 
`purchase_invoice_master`
INNER JOIN
`vendor` ON `purchase_invoice_master`.`vendor_id` =`vendor`.`id`
INNER JOIN`account_master` ON `vendor`.`account_master_id` = `account_master`.`id` 
AND `account_master`.`company_id`=1
WHERE purchase_invoice_master.id=704);
SELECT @Vendor;

#Purchase AC/C
SELECT 
`purchase_invoice_master`.`id`,
( IFNULL(`purchase_invoice_master`.`tea_value`,0)
+IFNULL(`purchase_invoice_master`.`brokerage`,0)
+IFNULL(`purchase_invoice_master`.`service_tax`,0)
+IFNULL(`purchase_invoice_master`.`stamp`,0)
+IFNULL(`purchase_invoice_master`.`other_charges`,0)
+IFNULL(`purchase_invoice_master`.`round_off`,0)
+IFNULL(`purchase_invoice_master`.`total_cst`,0)
) AS totalCreditAmountForVendor,'Y' AS IS_DEBIT,
'Purchase A/c' AS Account
FROM 
`purchase_invoice_master`
WHERE purchase_invoice_master.id=704
#VAT INPUT
SELECT 
`purchase_invoice_master`.`id`,
( IFNULL(`purchase_invoice_master`.`total_vat`,0)
) AS totalCreditAmountForVendor,'Y' AS IS_DEBIT,
'VAT' AS Account
FROM 
`purchase_invoice_master`
WHERE purchase_invoice_master.id=704













