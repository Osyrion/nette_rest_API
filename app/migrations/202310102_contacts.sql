CREATE TABLE `persons` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `name` varchar(32) DEFAULT NULL,
                           `surname` varchar(32) NOT NULL,
                           `email` varchar(255) NOT NULL UNIQUE,
                           PRIMARY KEY (id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `phones` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `phone` varchar(32) NOT NULL,
                          `person_id` int(11) NOT NULL,
                          PRIMARY KEY (id),
                          FOREIGN KEY (person_id) REFERENCES persons(id)
) ENGINE=InnoDB CHARSET=utf8;