<?php
include "../validate/Message.php";
class database{
//chỉnh database ở đây dbname=
   private $dns ="mysql:host=localhost; dbname=kidzone; charset=utf8";
   //chỉnh username ở đây
   private $username="leemongyan";
   //chỉnh password ở đây
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
