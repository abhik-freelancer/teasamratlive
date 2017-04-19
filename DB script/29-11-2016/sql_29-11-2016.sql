SELECT account_master.`account_name`,account_master.`id`,
SUM(voucher_detail.`voucher_amount`) AS debitamount
FROM account_master 
INNER JOIN
group_master ON account_master.`group_master_id` = group_master.`id` AND group_master.`id`=1
INNER JOIN
voucher_detail ON account_master.`id` = voucher_detail.`account_master_id` AND voucher_detail.`is_debit`='Y'
INNER JOIN
voucher_master ON voucher_master.`id` = voucher_detail.`voucher_master_id`
WHERE voucher_master.`voucher_date` BETWEEN '2016-04-01' AND '2016-11-29' AND voucher_master.`company_id`=1
GROUP BY 
account_master.`account_name`,account_master.`id`
 
SELECT account_master.`account_name`,account_master.`id`,
SUM(voucher_detail.`voucher_amount`) AS creditamount
FROM account_master 
INNER JOIN
group_master ON account_master.`group_master_id` = group_master.`id` AND group_master.`id`=1
INNER JOIN
voucher_detail ON account_master.`id` = voucher_detail.`account_master_id` AND voucher_detail.`is_debit`='N'
GROUP BY 
account_master.`account_name`,account_master.`id`