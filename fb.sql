CREATE TABLE IF NOT EXISTS `mr_form` (
`id` int(11) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `versi` varchar(10) NOT NULL,
  `json_form` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `mr_form`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`) USING BTREE;

ALTER TABLE `mr_form`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;



CREATE TABLE IF NOT EXISTS `mr_result` (
`id` int(11) NOT NULL,
  `id_form` int(11) NOT NULL,
  `status` char(2) NOT NULL DEFAULT '0',
  `json_result` longtext NOT NULL,
  `user_created` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_updated` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

ALTER TABLE `mr_result`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`) USING BTREE, ADD KEY `id_form` (`id_form`) USING BTREE;

ALTER TABLE `mr_result`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;