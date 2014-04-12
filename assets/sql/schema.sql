CREATE TABLE `user` (
   `id` int(11) not null auto_increment,
   `name` varchar(255) not null,
   `email` varchar(255) not null,
   `facebook_id` varchar(255) not null,
   `cell_number` varchar(255),
   `rating` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`),
   UNIQUE KEY (`facebook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `ride` (
   `id` int(11) not null auto_increment,
   `driver_id` int(11) not null,
   `origin` varchar(255) not null,
   `destination` varchar(255) not null,
   `capacity` int(11) not null default 1,
   `price` int(11) not null default 10,
   `start` datetime not null,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `user_ride` (
   `id` int(11) not null auto_increment,
   `user_id` int(11) not null,
   `ride_id` int(11) not null,
   `passenger_rating` varchar(255),
   `driver_rating` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

