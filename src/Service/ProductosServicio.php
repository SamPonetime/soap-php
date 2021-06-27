<?php

namespace SoapServer\Service;

use Exception;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;

class ProductosServicio
{

  /**
   * @var DbAdapter
   * @var AuthAdapter
   * 
   */
 
  public function __construct(DbAdapter $dbAdapter, AuthAdapter $auth)
  {
    $this->dbAdapter = $dbAdapter; 
    $this -> auth = $auth;
  }

   /**
    * Add productos

    * @param string $nameproduct
    * @param string $description
    * @param string $username
    * @param string $password
    * @return string
    */

   public function add(string $nameproduct, string $description, string $username, string $password)
   {
    
      if($this->authenticate($username, $password)) //verifica el acceso
      {
        return("Autenticación ha fallado");
      }

      else{
        $sqlInsert = "INSERT INTO products (nameproduct, description) "
        . "VALUES ('$nameproduct','$description')";

        $stmt = $this->dbAdapter->query($sqlInsert);
        $stmt->execute();

        return 'Producto agregado' . $nameproduct ;
    }
   }

   /**
     * update producto
     * @param int $id
     * @param string $nameproduct
     * @param string $description
     * @param string $username
     * @param string $password
     * @return string 
     */
    public function update(int $id, string $nameproduct, string $description, string $username, string $password){
        
      if(!$this->authenticate($username,$password))
      {
          return ("Autenticacion ha fallado");
      }
      else{
          $sqlUpdate = "UPDATE products 
              SET nameproduct = '$nameproduct', description = '$description' 
              WHERE id = '$id'";
          
          $stmt = $this->dbAdapter->query($sqlUpdate);
          $stmt->execute();

          return 'Actualizado';
      }
  }

  /**
   * delete producto
   * @param int $id
   * @param string $username
   * @param string $password
   * @return string 
   */
  public function delete(int $id, string $username, string $password){

      if(!$this->authenticate($username,$password))
      {
          return ("Autenticacion ha fallado");
      }
      else{
          $sqlDelete = "DELETE FROM products 
              WHERE id= '$id' ";

          $stmt = $this->dbAdapter->query($sqlDelete);
          $stmt->execute();

          return 'Eliminado';
      }
  }
    
    private function authenticate(string $username, string $password){

      $adapter = $this->auth;
      $adapter ->setIdentity($username);
      $adapter ->setCredential($password);

      try {
        $result = $adapter->authenticate();

        ob_start();
        var_dump($result->getMessages());
        $data = ob_get_clean();

        file_put_contents('/tmp/error.log', $data . "\n", FILE_APPEND);
        
        return $result->isValid();

    } catch (\Exception | \Error $e){
        file_put_contents('/tmp/error.log', $e->getMessage() . "\n", FILE_APPEND);
    }
  }

}

 