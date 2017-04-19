SELECT voucher_detail.voucher_master_id, SUM(voucher_detail.voucher_amount) as CreditAmount,voucher_detail.is_debit
FROM 
voucher_detail 
INNER JOIN 
voucher_master 
On voucher_master.id = voucher_detail.voucher_master_id
Where voucher_master.voucher_date between '2016-04-01' and '2016-08-26'
AND voucher_detail.is_debit='Y'
group by voucher_detail.voucher_master_id
ORDER by voucher_detail.voucher_master_id