ALTER TABLE `payments` ADD `shipping_cost` DECIMAL(11,2) NULL AFTER `amount`;
discount
discount_type
ALTER TABLE `order_return_details` ADD `discount` DECIMAL(11,2) NULL AFTER `unit`, ADD `discount_type` INT NULL AFTER `discount`;
ALTER TABLE `order_return_details` ADD `order_detail_id` INT NULL AFTER `order_id`;
ALTER TABLE `orders` ADD `currency` TEXT NULL AFTER `remark`;


ALTER TABLE `order_return_details` ADD `stock_status` TINYINT NULL COMMENT '1=add to stock,0=no' AFTER `varient_id`;

ALTER TABLE `settings` ADD `currency` TINYTEXT NULL AFTER `copyright`;
