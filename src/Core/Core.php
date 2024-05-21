<?php

namespace App\Core;

use App\Http\Request;
use App\Http\Response;

class Core {
    public static function dispatch(array $routes) {
        // Inicializa a URL com '/'
        $url = '/';

        // Se a URL está definida no GET, então devo concatenar na variável url ('/')
        isset($_GET['url']) && $url .= $_GET['url'];

        // Remove a barra final da URL (se não for a raiz)
        $url !== '/' && $url = rtrim($url, '/');

        // Prefixo para o path dos controllers
        $prefixController = 'App\\Controllers\\';

        // Variável inicial que verifica se a rota foi encontrada
        $routeFound = false;

        // Percorre todas as rotas definidas no arquivo routes/main.php
        foreach ($routes as $route) {
            // Regex para substituir o id
            $pattern = '#^'. preg_replace('/{id}/', '([\w-]+)', $route['path']) .'$#';

            // Verifica se a URL corresponde ao padrão da rota
            if (preg_match($pattern, $url, $matches)) {
                // Remove o primeiro elemento do array $matches (pois não é necessário)
                array_shift($matches);

                // Se tá aqui é porque a rota foi encontrada
                $routeFound = true;

                // Verifica se a rota que foi requisitada possui aquele método
                if ($route['method'] !== Request::method()) {
                    Response::json([
                        'error'     => true,
                        'success'   => false,
                        'message'   => 'Sorry, method not allowed.'
                    ], 405);
                    return;
                }

                // Divide a ação da rota em controlador e método (similar ao split do JS)
                [$controller, $action] = explode('@', $route['action']);

                // Constrói o nome completo da classe do Controller
                $controller = $prefixController . $controller;
                
                // Cria uma nova instância do controlador
                $extendController = new $controller();

                // Chama o método do controlador, passando os parâmetros necessários
                $extendController->$action(new Request, new Response, $matches);
            }
        }

        // Se nenhuma rota foi encontrada, utiliza o NotFoundController
        if (!$routeFound) {
            $controller = $prefixController . 'NotFoundController';
            $extendController = new $controller();
            $extendController->index(new Request, new Response);
        }
    }
}

?>