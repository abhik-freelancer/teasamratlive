create PROCEDURE sp_finishProductStockCal(IN companyId int,IN yearId int)
BEGIN
declare mProductPacketId int default 0;
declare mProduct varchar(255);

declare finishedProductkgs decimal(12,2);
declare finishedProductOpening decimal(12,2);
declare finishProductPurchase decimal(12,2);
declare finishProductSale decimal(12,2);

declare finishProductStockIn decimal(12,2);
declare finishProductStockOut decimal(12,2);
declare finishProductBalance decimal(12,2);

DECLARE finished INTEGER DEFAULT 0;
DECLARE cursor_productpacketId CURSOR FOR 
	SELECT product_packet.id ,CONCAT(product.product,'',packet.packet) AS product FROM 
	product 
	INNER JOIN product_packet ON product.id = product_packet.productid
	INNER JOIN packet ON product_packet.packetid = packet.id;

DECLARE CONTINUE HANDLER 	FOR NOT FOUND SET finished = 1;
#Stock in temp table
DROP TEMPORARY TABLE IF EXISTS tempfinishStockIn;
CREATE TEMPORARY TABLE IF NOT EXISTS  tempfinishStockIn
(
	productpacketid INT,
	productpacket VARCHAR(256),
	stockIn  NUMERIC(12,2),
	stockOut NUMERIC(12,2),
	balance  NUMERIC(12,2)
);

OPEN cursor_productpacketId;
productpacketloop: LOOP
	FETCH cursor_productpacketId INTO mProductPacketId,mProduct;
		IF finished=1 THEN
			LEAVE productpacketloop;
		END IF;
    
    -- opening
    SET finishedProductOpening=(
    SELECT IFNULL(finished_product_op_stock.opening_balance,0) 
		FROM finished_product_op_stock WHERE finished_product_op_stock.company_id =companyId 
		AND finished_product_op_stock.year_id = yearId 
    AND finished_product_op_stock.finished_product_id =mProductPacketId );
    -- finish product
    SET finishedProductkgs=(
    SELECT   
				SUM(IFNULL(finished_product_dtl.net_in_packet,0)) 
		FROM finished_product_dtl
		INNER JOIN
		finished_product ON finished_product.id = finished_product_dtl.finishProductId
		WHERE finished_product.company_id = companyId AND finished_product.year_id=yearId
		GROUP BY	 
		finished_product_dtl.product_packet
		HAVING finished_product_dtl.product_packet = mProductPacketId);
    
    -- purchase finish product
    SET finishProductPurchase=(
    SELECT
			SUM(IFNULL(purchase_finishproductdetail.quantity,0)) 
			FROM purchase_finishproductdetail
			INNER JOIN
			purchase_finishproductmaster ON purchase_finishproductmaster.id = purchase_finishproductdetail.purchase_finishmasterId
			WHERE purchase_finishproductmaster.companyid = companyId AND purchase_finishproductmaster.yearid =yearId
			GROUP BY purchase_finishproductdetail.productpacketid
			HAVING purchase_finishproductdetail.productpacketid = mProductPacketId);
      
      -- SET finishProductStockIn = (finishedProductOpening + finishedProductkgs + finishProductPurchase );
      SET finishProductStockIn =  finishProductPurchase ;
    
    SET finishProductSale=(
    SELECT
			SUM(IFNULL(sale_bill_details.quantity,0)) 
		FROM sale_bill_details
		INNER JOIN
		sale_bill_master ON sale_bill_master.id = sale_bill_details.salebillmasterid
		WHERE sale_bill_master.companyid = companyId AND sale_bill_master.yearid =yearId
		GROUP BY sale_bill_details.productpacketid
		HAVING sale_bill_details.productpacketid =mProductPacketId);  
    
    SET finishProductStockOut = finishProductSale;
    
    SET finishProductBalance = finishProductStockIn - finishProductStockOut;
    
      
     INSERT INTO tempfinishStockIn( productpacketid ,productpacket ,stockIn,stockOut,balance)
	VALUES (mProductPacketId,mProduct,finishProductStockIn,finishProductStockOut,finishProductBalance); 
   -- SELECT mProductPacketId , mProduct,finishedProductOpening, finishedProductkgs,finishProductPurchase;
      
    
END LOOP productpacketloop;
CLOSE cursor_productpacketId;

select * from tempfinishStockIn;

END
