<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $appDir = './app';

    require_once $appDir . '/config.php';
    require_once $appDir . '/class/Failure.class.php';
    require_once $appDir . '/class/Exceptions.class.php';
    require_once $appDir . '/class/UrlMap.class.php';

    session_start();
    $method = $_SERVER['REQUEST_METHOD'];

    if(isset($_GET['api'])) {

        try {
            $urlMap = new UrlMap($_GET['api'], $config);
            $parameters = $urlMap->getMap();
            $parameters['method'] = $method;
            if($method === 'POST') {
                $handle = fopen('php://input','r');
                $jsonInput = fgets($handle);
                $decoded = json_decode($jsonInput,true);
                fclose($handle);
                
                $parameters['POST'] = $decoded;
            }
        } catch (UnknownApiException $e) {
            Failure::fail(404);
        } catch (IllegalArgumentException $e) {
            Failure::fail(412, $e->getMessage());
        } catch (Exception $e) {
            Failure::fail(404);
        }

        require_once $appDir . '/api' . '/' . $parameters['api'] . '.php';
    } else {
        require_once $appDir . '/template/home.template.php';
    }
?>