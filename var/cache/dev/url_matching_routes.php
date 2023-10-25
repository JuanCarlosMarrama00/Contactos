<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/contacto/insertar' => [[['_route' => 'insertar_contacto', '_controller' => 'App\\Controller\\ContactoController::insertar'], null, null, null, false, false, null]],
        '/contacto/nuevo' => [[['_route' => 'nuevo_contacto', '_controller' => 'App\\Controller\\ContactoController::nuevo'], null, null, null, false, false, null]],
        '/contacto/insertarSinProvincia' => [[['_route' => 'insertar_sin_provincia_contacto', '_controller' => 'App\\Controller\\ContactoController::insertarSinProvincia'], null, null, null, false, false, null]],
        '/' => [
            [['_route' => 'app_index', '_controller' => 'App\\Controller\\ContactoController::index'], null, null, null, false, false, null],
            [['_route' => 'Inicio', '_controller' => 'App\\Controller\\PageController::inicio'], null, null, null, false, false, null],
        ],
        '/page' => [[['_route' => 'app_page', '_controller' => 'App\\Controller\\PageController::index'], null, null, null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, null, null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/contacto/(?'
                    .'|editar/([^/]++)(*:197)'
                    .'|delete/([^/]++)(*:220)'
                    .'|([^/]++)(*:236)'
                    .'|buscar/([^/]++)(*:259)'
                    .'|update/([^/]++)/([^/]++)(*:291)'
                    .'|insertarConProvincia(*:319)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        197 => [[['_route' => 'editar_contacto', '_controller' => 'App\\Controller\\ContactoController::editar'], ['codigo'], null, null, false, true, null]],
        220 => [[['_route' => 'eliminar_contacto', '_controller' => 'App\\Controller\\ContactoController::delete'], ['id'], null, null, false, true, null]],
        236 => [[['_route' => 'app_contacto', '_controller' => 'App\\Controller\\ContactoController::ficha'], ['codigo'], null, null, false, true, null]],
        259 => [[['_route' => 'buscar_contacto', '_controller' => 'App\\Controller\\ContactoController::buscar'], ['texto'], null, null, false, true, null]],
        291 => [[['_route' => 'modificar_contacto', '_controller' => 'App\\Controller\\ContactoController::update'], ['id', 'nombre'], null, null, false, true, null]],
        319 => [
            [['_route' => 'insertar_con_provincia_contacto', '_controller' => 'App\\Controller\\ContactoController::insertarConProvincia'], [], null, null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
