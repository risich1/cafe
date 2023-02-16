<?php

namespace App;

use App\Source\DB;
use Faker\Factory;


class Seeder {

    protected DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function run(): void {
        $faker = Factory::create();

        $cooks = [];
        $dishes = [];

        for ($i = 0; $i < 10; $i++) {
            $cooks[] = ['cook_name' => $faker->name];

            for ($j = 0; $j < 10; $j++) {
                $dName = "Dish $i $j";
                $dishes[] = ['dish_title' => $dName, 'cook_id' => $i + 1];
            }
        }

        $this->db->createBatch('cooks', $cooks);
        $this->db->createBatch('dishes', $dishes);

        foreach ([1,2,3,4,5] as $order) {
            $this->db->create('orders', [
                'created_date' => '2022-07-1' . rand(1, 9),
                'status' => 'success'
            ]);
            $this->db->create('orders_dishes', [
                'order_id' => $order,
                'dish_id' => $order * 2
            ]);
        }
    }

}
