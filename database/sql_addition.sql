ALTER TABLE `payments` ADD `shipping_cost` DECIMAL(11,2) NULL AFTER `amount`;
discount
discount_type
ALTER TABLE `order_return_details` ADD `discount` DECIMAL(11,2) NULL AFTER `unit`, ADD `discount_type` INT NULL AFTER `discount`;
ALTER TABLE `order_return_details` ADD `order_detail_id` INT NULL AFTER `order_id`;
