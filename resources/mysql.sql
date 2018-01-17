CREATE TABLE IF NOT EXISTS `osm_node` (
  `id` bigint(64) NOT NULL,
  `version` bigint(64) NOT NULL DEFAULT 0,
  `lat` double DEFAULT NULL,
  `long` double DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `uid` bigint(64) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `timestamp` datetime DEFAULT NULL,
  `changeset` bigint(64) DEFAULT NULL,
  PRIMARY KEY (`id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_node_tag` (
  `node_id` bigint(64) NOT NULL,
  `k` varchar(255) NOT NULL,
  `v` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`node_id`,`k`),
  KEY `k` (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_relation` (
  `id` bigint(64) NOT NULL,
  `version` bigint(64) NOT NULL DEFAULT 0,
  `user` varchar(255) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `changeset` bigint(64) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_relation_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relation_id` bigint(64) NOT NULL,
  `type` enum('node','way','relation') DEFAULT 'node',
  `ref` bigint(64) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `sort` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relation_id` (`relation_id`),
  KEY `ref` (`ref`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_relation_tag` (
  `relation_id` bigint(64) NOT NULL,
  `k` varchar(255) NOT NULL,
  `v` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`relation_id`,`k`),
  KEY `k` (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_way` (
  `id` bigint(64) NOT NULL,
  `version` bigint(64) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `user` varchar(255) DEFAULT NULL,
  `uid` bigint(64) DEFAULT NULL,
  `changeset` bigint(64) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_way_node` (
  `way_id` bigint(64) NOT NULL,
  `node_id` bigint(64) NOT NULL,
  `sort` INT(11) NOT NULL,
  PRIMARY KEY (`way_id`,`node_id`),
  KEY `node_id` (`node_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `osm_way_tag` (
  `way_id` bigint(64) NOT NULL,
  `k` varchar(255) NOT NULL,
  `v` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`way_id`,`k`),
  KEY `k` (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
