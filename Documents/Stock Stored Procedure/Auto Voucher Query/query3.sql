SELECT * FROM `voucher_master` WHERE voucher_master.`transaction_type`='SL'
SELECT * ,account_master.`account_name`
FROM `voucher_detail` 
INNER JOIN
`account_master` ON voucher_detail.`account_master_id` = account_master.`id`
WHERE voucher_detail.`voucher_master_id` IN (82,83);
SELECT * FROM `sale_bill_master` WHERE `sale_bill_master`.`voucher_master_id`=82;

SELECT 
	`sale_bill_master`.`taxinvoiceno`,
	`sale_bill_master`.`taxinvoicedate`,
	`sale_bill_master`.`companyid`,
	`sale_bill_master`.`yearid`,`sale_bill_master`.`id` AS SaleMasterId,
	(IFNULL(`sale_bill_master`.`grandtotal`,0)) AS totalDebitAmountForCustomer,
	`customer`.`account_master_id` AS customerAccountId,
		(IFNULL(`sale_bill_master`.`totalamount`,0)
			-(IFNULL(`sale_bill_master`.`discountAmount`,0)
			+IFNULL(`sale_bill_master`.`deliverychgs`,0)
			+IFNULL(`sale_bill_master`.`roundoff`,0))
		) AS totalCreditSaleAC,
		(IFNULL(`sale_bill_master`.`taxamount`,0)
		) AS totalCreditVAToutput
	FROM `sale_bill_master` 
	INNER JOIN `customer` ON `sale_bill_master`.`customerId` = `customer`.`id`
	ORDER BY `sale_bill_master`.`taxinvoiceno`;