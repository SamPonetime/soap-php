<?php

use isw\Service\ProductsService;
use Laminas\Soap\AutoDiscover;
use SoapServer\Service\ProductosServicio;

include __DIR__ . '/../vendor/autoload.php';
$dbAdapter = include '../config/database.php';
$authAdapter = include '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (! isset($_GET['wsdl'])) {
        header('HTTP/1.1 400 Client Error');
        return;
    }

    $autodiscover = new AutoDiscover();
    $autodiscover
        ->setClass(ProductosServicio::class)
        ->setUri('http://192.168.1.69:8000/productos.php')
        ->setServiceName('ProductosServicio');
 
        // Emit the XML:
        header('Content-Type: application/wsdl+xml');
        echo $autodiscover->toXml();
        return;

}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 400 Client Error');
    return;
}

// pointing to the current file here
$soap = new Laminas\Soap\Server("http://192.168.1.69:8000/productos.php?wsdl");
$soap->setClass(new ProductosServicio($dbAdapter, $authAdapter));
$soap->handle();