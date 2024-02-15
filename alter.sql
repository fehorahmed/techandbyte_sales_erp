Kamrul(15-02-2024)

ALTER TABLE `banks` ADD `amount` DOUBLE(50,2) NOT NULL DEFAULT '0.00' AFTER `branch`;
ALTER TABLE `transactions` CHANGE `receipt_no` `receipt_no` INT(11) NULL;
