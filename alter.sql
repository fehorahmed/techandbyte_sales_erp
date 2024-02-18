Kamrul(15-02-2024)

ALTER TABLE `banks` ADD `amount` DOUBLE(50,2) NOT NULL DEFAULT '0.00' AFTER `branch`;
ALTER TABLE `transactions` CHANGE `receipt_no` `receipt_no` INT(11) NULL;
ALTER TABLE `purchase_payments` ADD `supplier_id` BIGINT(20) NOT NULL AFTER `id`;
ALTER TABLE `inventory_orders` ADD `previous_paid` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `grand_total_amount`;
ALTER TABLE `inventory_logs` ADD `quantity` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `order_id`;
ALTER TABLE `sale_payments` ADD `customer_id` BIGINT(20) NOT NULL AFTER `id`;
