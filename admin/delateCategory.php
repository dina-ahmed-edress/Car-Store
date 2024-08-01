<?php

include_once("includes/logged.php");
if(isset($_GET['id']))
{
 include_once("includes/conn.php");
 $id=$_GET['id'];


try{
            $sql = "SELECT * FROM `cars`";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            foreach ($stmt-> fetchAll() as $row){
            $cat_id=$row["cat_id"];
            if($id!=$cat_id){
            $sql = "DELETE FROM `categores` WHERE id =?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            
                }

           

//else{ echo" cant delete "; }
}echo "deleted";


                        }catch(PDOException $e){
            echo "can not delete " ;
        }
        

        

 
    
}


?>