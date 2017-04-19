ALTER TABLE `tea_samrat`.`purchase_invoice_master`   
  ADD COLUMN `other_charges` DECIMAL(10,2) NULL AFTER `stamp`;

--30.09.2015--
ALTER TABLE `tea_samrat`.`purchase_invoice_master`   
  ADD COLUMN `round_off` DECIMAL(10,2) NULL AFTER `other_charges`;






 
