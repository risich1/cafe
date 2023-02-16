<?php

namespace App;

use App\Source\DB;

class Migration {

    protected DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    function run(): void {
        $queries = [];

        $queries[] = "CREATE TABLE IF NOT EXISTS orders (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        status ENUM('creating','in_process','success') DEFAULT 'creating' NOT NULL,
        created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $queries[] = "CREATE TABLE IF NOT EXISTS cooks (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        cook_name VARCHAR(70)
        )";

        $queries[] = "CREATE TABLE IF NOT EXISTS dishes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dish_title VARCHAR(70),
        cook_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (cook_id) REFERENCES cooks(id)
        )";

        $queries[] = "CREATE TABLE IF NOT EXISTS orders_dishes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        order_id INT(6) UNSIGNED NOT NULL,
        dish_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (dish_id) REFERENCES dishes(id)
        )";

        foreach ($queries as $query) {
            $this->db->query($query);
        }
    }

}
