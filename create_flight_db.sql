CREATE TABLE flights
(
	nr_lotu					int			NOT NULL	PRIMARY KEY	AUTO_INCREMENT,
	name					varchar(50) NOT NULL,
	surname					varchar(50) NOT NULL,
	producer				varchar(100) 		,
	registration			varchar(20) NOT NULL,
	dep_ariport				varchar(10) NOT NULL,
	dep_date				date		NOT NULL,
	dep_time				time		NOT NULL,
	arr_ariport				varchar(10) NOT NULL,
	arr_date				date		NOT NULL,
	arr_time				time		NOT NULL,
	users_name				varchar(50)	NOT NULL,
	FOREIGN KEY (users_name) REFERENCES users(username)
);