CREATE DATABASE IF NOT EXISTS testdb;
USE testdb;
CREATE TABLE IF NOT EXISTS `users_data` (
`id` int(11) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_message` text NOT NULL
)AUTO_INCREMENT=1 ;

ALTER TABLE `users_data`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

