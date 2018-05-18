-- 20-10-2017
ALTER TABLE `user` ADD `status` TINYINT NOT NULL AFTER `company_name`;

--25-10-2017 Md. Jobayer Islam
ALTER TABLE `user` CHANGE `type` `type` TINYINT(4) NOT NULL COMMENT '1=admin, 2=backend_user, 3=employer,4=external_maintainer, 5=tenant, 6=owner';
ALTER TABLE `apartment_service_charges` CHANGE `council_taz` `council_tax` FLOAT NOT NULL;

--26-10-2017 Md. Jobayer Islam
ALTER TABLE `apartment_detail`
  DROP `common_area_qty`,
  DROP `private_area_qty`;
  
ALTER TABLE `rooms` ADD `qty` INT NOT NULL AFTER `room_type`;

CREATE TABLE `common_area` (
  `id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `common_area`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `common_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
CREATE TABLE `private_area` (
  `id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `private_area`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `private_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- 26-10-2017 Md. Asif Rahman
CREATE TABLE `general_cost` (
	`gc_id` INT(10) NOT NULL,
	`apartment_id` INT(10) NOT NULL COMMENT 'id of the apartment',
	`cost_type` TINYINT NOT NULL COMMENT 'type of the cost ',
	`amount` FLOAT(10,2) NOT NULL COMMENT 'amount of the cost',
	`expire_date` DATETIME NOT NULL COMMENT 'expiration date of the payment',
	`payment_status` TINYINT NOT NULL COMMENT '0=due;1=paid',
	`payment_date` DATETIME NOT NULL COMMENT 'date of the payment done',
	PRIMARY KEY (`gc_id`)
)
COMMENT='this table is to save general cost data'
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


--26-10-2017 : Ashraful Islam Tushar
ALTER TABLE `tenant_request` ADD `assigned_to` INT NOT NULL AFTER `apartment_id` ,
ADD `cost` FLOAT NOT NULL AFTER `assigned_to` ,
ADD `charge_4_client` FLOAT NOT NULL AFTER `cost`;

DROP TABLE `request_assigned`;

ALTER TABLE `tenant_request` CHANGE `tanant_id` `user_id` INT(11) NOT NULL;

ALTER TABLE `tenant_request` DROP `request_date`;

ALTER TABLE `apartment_booked_list` CHANGE `tenant_id` `user_id` INT(11) NOT NULL COMMENT 'tenant type user ID';

CREATE TABLE `request_feedback` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `request_feedback`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `request_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- 27-10-2017
ALTER TABLE `request_feedback` ADD `seen` TINYINT NOT NULL AFTER `message`;
ALTER TABLE `request_feedback` CHANGE `seen` `seen` TINYINT(4) NOT NULL DEFAULT '0';

-- 30-10-2017 Md. Jobayer Islam
ALTER TABLE `rooms` CHANGE `room_type` `room_type` TINYINT(11) NOT NULL COMMENT '1=single,2=double';

ALTER TABLE `private_area` CHANGE `type` `type` VARCHAR(255) NOT NULL;

ALTER TABLE `apartment_service_charges` ADD `update_date` DATETIME NOT NULL AFTER `create_date`;

ALTER TABLE `common_area` CHANGE `id` `id` BIGINT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `private_area` CHANGE `id` `id` BIGINT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `apartment_detail` CHANGE `nr` `nr` VARCHAR(255) NOT NULL;

--10-11-2017
ALTER TABLE  `apartment_detail` ADD  `latitude` VARCHAR( 50 ) NULL AFTER  `address`
ALTER TABLE  `apartment_detail` ADD  `langitude` VARCHAR( 50 ) NULL AFTER  `latitude`
ALTER TABLE  `apartment_detail` CHANGE  `langitude`  `longitude` VARCHAR( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL


--13-11-2017
CREATE TABLE IF NOT EXISTS `uploaded_sales_files` (
  `uploaded_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `file_name` text NOT NULL,
  `original_file_name` text NOT NULL,
  PRIMARY KEY (`uploaded_file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;