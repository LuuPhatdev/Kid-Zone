<?php
include "../validate/Message.php";
class database{
//DB Modify here
   private $dns ="mysql:host=localhost; dbname=kidzone; charset=utf8";

//You can changes username and password here to start source:
   private $username="leemongyan";
   private $password="09051997";

   private $pdo;
   private $stmt;

   public function __construct()
   {
      try{
         $this->pdo=new PDO($this->dns, $this->username, $this->password);
      }catch (Exception $e){
         Message::ShowMessage($e->getMessage());
      }
   }

   public function CloseConn()
   {
      $this->pdo=null;
   }

   public function EditData($query)
   {
      try{
         $this->stmt = $this->pdo->prepare($query);
         $this->stmt->execute();
         return $this->stmt;
      }catch (Exception $e){
         Message::ShowMessage($e->getMessage());
      }
   }

   public function EditDataParam($query, $param)
   {
      try{
         $this->stmt = $this->pdo->prepare($query);
         $this->stmt->execute($param);
         return $this->stmt;
      }catch (Exception $e){
         Message::ShowMessage($e->getMessage());
      }
   }
}
?>
