<?php

namespace App;

use App\Http\Request\PopularCooksRequest;
use App\Http\Request\Request;
use App\Http\Response\Response;
use App\Http\Router\Router;

class App {

    public static function run(): void {
        $router = new Router();
        $container = new Container();

        $router->get('/migrate', function () use ($container) {
            $migration = new Migration($container->get('db'));
            $migration->run();
            return new Response('migrated');
        }, Request::class);

        $router->get('/seed', function () use ($container) {
            $seeder = new Seeder($container->get('db'));
            $seeder->run();
            return new Response('has seeded');
        }, Request::class);

        $router->post('/api/v1/order', function () use ($container) {
            $db = $container->get('db');
            return new Response(['orderId' => $db->create('orders', [])]);
        }, Request::class);

        $router->put('/api/v1/order/$orderId/add/$dishId', function (Request $request, int $orderId, int $dishId) use ($container) {
            $db = $container->get('db');
            $db->create('orders_dishes', [
                'order_id' => $orderId,
                'dish_id' => $dishId
            ]);

            return new Response('added');
        }, Request::class);

        $router->post('/api/v1/cooks/popular', function (PopularCooksRequest $request) use ($container) {
            $db = $container->get('db');
            $body = $request->getBody();
            $date1 = date('Y-m-d', $body['date1']);
            $date2 = date('Y-m-d', $body['date2']);

            $query = "
                select c.* from cooks c join orders_dishes od on od.dish_id IN (SELECT d.id FROM dishes d WHERE d.cook_id = c.id)
                join orders o on o.id = od.order_id and o.created_date <= '$date2' AND o.created_date >= '$date1' and status = 'success'
                GROUP BY c.id ORDER BY (COUNT(od.dish_id)) DESC;
            ";

            $res = $db->query($query)->fetchAll();

            return new Response($res);
        }, PopularCooksRequest::class);

        $router->run();
    }

}
