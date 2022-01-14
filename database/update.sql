ALTER TABLE  blog_category_data add column source_id integer UNSIGNED;
ALTER TABLE  blog_category_data ADD CONSTRAINT source_id_index FOREIGN KEY (source_id) REFERENCES blog_category_data(id) ON DELETE CASCADE;



ALTER TABLE blogs_data ADD COLUMN source_id INTEGER(10) UNSIGNED NULL AFTER `lang_id`;
ALTER TABLE blogs_data ADD CONSTRAINT source_id FOREIGN KEY (source_id) REFERENCES blogs_data(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE city_data ADD COLUMN source_id INTEGER(10) UNSIGNED NULL AFTER `lang_id`;
ALTER TABLE city_data ADD FOREIGN KEY (`source_id`) REFERENCES `city_data`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

insert into permission_data (title,permission_id,lang_id) select name,id,1 from permissions

ALTER TABLE projcategory_data ADD COLUMN source_id INTEGER(10) UNSIGNED NULL AFTER `lang_id`;
ALTER TABLE `projcategory_data` ADD FOREIGN KEY (`source_id`) REFERENCES `projcategory_data`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_info`
  DROP `verified_at`,
  DROP `password`;

ALTER TABLE  users add column uuid text;
DROP TRIGGER IF EXISTS `uuid`;CREATE TRIGGER `uuid` BEFORE INSERT ON `users` FOR EACH ROW SET New.uuid=md5(uuid());
