SELECT * FROM `voucher_master` WHERE `transaction_type`='PR' AND voucher_master.`id`=76;


SELECT * ,account_master.`account_name`
FROM `voucher_detail` 
INNER JOIN
`account_master` ON voucher_detail.`account_master_id` = account_master.`id`
WHERE voucher_detail.`voucher_master_id`=207


SELECT * FROM `purchase_invoice_master` WHERE purchase_invoice_master.`voucher_master_id`=76;
SELECT * FROM `account_master`;
SELECT * FROM `group_master`;

SELECT * FROM `vendor` WHERE `vendor`.`vendor_name` LIKE 'APC%' 
SELECT * FROM `account_master` WHERE 

`account_master`.`id`=204
SELECT vendor.* FROM `vendor` 
INNER JOIN account_master 
ON vendor.`account_master_id`=`account_master`.`id` AND `account_master`.`company_id`=2

SELECT * FROM `voucher_detail`
WHERE `voucher_detail`.`voucher_master_id` IN (SELECT `voucher_master`.`id` FROM `voucher_master` WHERE voucher_master.`narration`='Purchase-Auto');
COMMIT;

DELETE FROM `voucher_master` WHERE voucher_master.`narration`='Purchase-Auto'
 
 


UPDATE purchase_invoice_master 
SET purchase_invoice_master.`voucher_master_id` = 76
WHERE purchase_invoice_master.`id`=704


