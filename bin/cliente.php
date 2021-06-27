<?php

use Laminas\Soap\Client;

include __DIR__ . '/../vendor/autoload.php';

$cliente = new Client('http://192.168.1.69:8000/productos.php?wsdl');

var_dump($cliente->getFunctions()); //añadido para validacion users

    $username = 'admin';
    $password = 'password';

    //primer producto
    $id = 1;
    $nameproduct = 'Pan';
    $description = 'Pan Integral de 530 g';


     // Agregar producto
     $result1 = $cliente->add($nameproduct, $description, $username, $password);
     echo "Agregado:  {$result1} \n";
 
     //Actualizar producto
     $nameproduct = 'Nuevo Producto';
 
     $result1 = $cliente->update($id, $nameproduct, $description, $username, $password);
     echo "Actualizado:  {$result1} \n";
 
     //Eliminar producto
     $result1 = $cliente->delete($id, $username, $password);
     echo "Eliminado:  {$result1} \n";
 
    
?>