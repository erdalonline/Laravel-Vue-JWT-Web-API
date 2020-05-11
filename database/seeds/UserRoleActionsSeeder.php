<?php

use Illuminate\Database\Seeder;

class UserRoleActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routes=[];
        foreach (Route::getRoutes ()->getIterator () as $route) {
            if (in_array ("permission",$route->action['middleware']) && in_array ("auth.jwt",$route->action['middleware'])) {
                $controller = explode ('@',$route->action['controller']);
                $controller = $controller[0];
                if(!isset($routes[$controller])){
                    $routes[$controller] = array();
                }
                $tmpRoute = array(
                    'url' => $route->uri,
                    'action' => $route->action['controller'],
                    'prefix' => $route->action['prefix'],
                );
                array_push ( $routes[$controller],$tmpRoute);
            }
        }
        foreach ($routes as $route => $value){
            $controllerGroupId = DB::table('user_role_term_actions')->insertGetId([
                'action' => $route,
            ]);
            if($controllerGroupId){
                foreach ($value as $item){
                    DB::table('user_role_term_actions')->insert([
                        'action' => $item['action'],
                        'url' => $item['url'],
                        'prefix' => ($item['prefix']) ? $item['prefix'] : null,
                        'top_id' => $controllerGroupId
                    ]);
                }
            }
        }
    }
}
