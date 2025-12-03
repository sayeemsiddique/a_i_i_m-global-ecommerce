ALTER TABLE `payments` ADD `shipping_cost` DECIMAL(11,2) NULL AFTER `amount`;
discount
discount_type
ALTER TABLE `order_return_details` ADD `discount` DECIMAL(11,2) NULL AFTER `unit`, ADD `discount_type` INT NULL AFTER `discount`;
ALTER TABLE `order_return_details` ADD `order_detail_id` INT NULL AFTER `order_id`;
ALTER TABLE `orders` ADD `currency` TEXT NULL AFTER `remark`;


ALTER TABLE `order_return_details` ADD `stock_status` TINYINT NULL COMMENT '1=add to stock,0=no' AFTER `varient_id`;

ALTER TABLE `settings` ADD `currency` TINYTEXT NULL AFTER `copyright`;


ALTER TABLE `orders` CHANGE `tds_amount` `voucher_type` TINYTEXT NULL DEFAULT NULL;
ALTER TABLE `orders` CHANGE `tds` `voucher_value` DECIMAL(18,2) NULL DEFAULT NULL COMMENT '%';
ALTER TABLE `orders` CHANGE `coupon_discount` `voucher_discount` DECIMAL(18,2) NULL DEFAULT NULL;
ALTER TABLE `orders` CHANGE `coupon_code_id` `voucher_id` INT(11) NULL DEFAULT NULL COMMENT 'voucher_id';
ALTER TABLE `orders` CHANGE `vds` `voucher_code` TINYTEXT NULL DEFAULT NULL COMMENT '%';
ALTER TABLE `orders` CHANGE `voucher_code` `voucher_code` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `order_returns` CHANGE `tds_amount` `voucher_type` TINYTEXT NULL DEFAULT NULL;
ALTER TABLE `order_returns` CHANGE `tds` `voucher_value` DECIMAL(18,2) NULL DEFAULT NULL COMMENT '%';
ALTER TABLE `order_returns` ADD `voucher_discount` DECIMAL(18,2) NULL AFTER `voucher_type`;
ALTER TABLE `order_returns` ADD `voucher_id` INT NULL AFTER `voucher_discount`;
ALTER TABLE `order_returns` CHANGE `vds` `voucher_code` TINYTEXT NULL DEFAULT NULL COMMENT '%';
ALTER TABLE `order_returns` CHANGE `voucher_code` `voucher_code` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `orders` CHANGE `vds_amount` `store_id` INT NULL DEFAULT NULL COMMENT 'vds total amount';
ALTER TABLE `order_returns` CHANGE `vds_amount` `store_id` INT NULL DEFAULT NULL COMMENT '';

ALTER TABLE `vouchers` ADD `person_max_use` TINYINT NOT NULL DEFAULT '0' AFTER `used_count`;

ALTER TABLE `campaigns` ADD `featured` TINYINT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `campaign_products` ADD `varient_id` INT NULL DEFAULT '0' AFTER `product_id`;
ALTER TABLE `campaigns` ADD `discount` DECIMAL(18,2) NULL AFTER `slug`, ADD `discount_type` TINYINT NULL AFTER `discount`;
