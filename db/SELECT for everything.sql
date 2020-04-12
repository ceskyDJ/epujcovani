SELECT
	`users`.`user_id` AS `User's ID`,
    CONCAT(`users`.`first_name`, " ", `users`.`last_name`) AS `User's fullname`,
    `users`.`email` AS `User's email`,
    `users`.`phone` AS `User's phone`,
    `cars`.`car_id` AS `Car's ID`,
    `cars`.`name` AS `Car's name`,
    `cars`.`day_price` AS `Car's day price`,
    `cars`.`image_name` AS `Car's image`,
    `car_rents`.`from` AS `Rented from`,
    `car_rents`.`to` AS `Rented to`,
    CONCAT(
    	DATEDIFF(`car_rents`.`to`, `car_rents`.`from`) + 1,
    	IF(
    		(DATEDIFF(`car_rents`.`to`, `car_rents`.`from`) + 1) > 1,
    		IF((DATEDIFF(`car_rents`.`to`, `car_rents`.`from`) + 1) < 5, " dny", " dní"),
    		" den"
    	)
    ) AS `Rent length`
FROM `car_rents`
JOIN `users` USING(`user_id`)
JOIN `cars` USING(`car_id`)
