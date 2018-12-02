<?php
    include 'database.php';
    $dbConn = getDatabaseConnection();

    function checkSearchIsNotEmpty(){
        if (isset($_POST["submitSearch"]) && empty(($_POST["searchByStats"]))){
            echo "Search can't be blank!";
        }
    }
    
    function searchFor() {
        
        echo $dbConn;
        global $dbConn; 
        
        // $sql = "SELECTx
        //     users_info.user,
        //     users_info.country, rtise,
        //     users_info.rate,
        //     users_info.state"; 
        
        
        $sql = "SELECT * 
                FROM `helpers` WHERE 1";
                
                
        // $sql = "SELECT * FROM `helpers`user_id WHERE 1";
        // $sql += "SELECT * FROM `helpers` child_care WHERE 1";
        // $sql += "SELECT * FROM `helpers` elder_care WHERE 1"; 
        // $sql += "SELECT * FROM `helpers` animal_care WHERE 1";
        // $sql += "SELECT * FROM `helpers` start_date WHERE 1";
        // $sql += "SELECT * FROM `helpers` end_date WHERE 1";
        // $sql += "SELECT * FROM `helpers` description WHERE 1";
        // $sql += "SELECT * FROM `helpers` price WHERE 1";
        
        // if(isset($_POST['submitSearch'])) {
        //       // query the databse for any records that match this search
        //       $sql .= " AND (searchByStats LIKE :searchByStats)";
        //      // $sql .= " AND (line1 LIKE '%{$_POST['search']}%' OR line2 LIKE '%{$_POST['search']}%')";
        // } 
        
        $statement = $dbConn -> prepare($sql); 
        // $statement->execute(array(':searchByStats'=>'%'.$_POST['searchByStats'].'%'));
        $statement -> execute(); 
        $records = $statement->fetchAll(PDO::FETCH_ASSOC); 
        //echo json_encode($records);
        
        return $records; 
    }
    
    function displayRecords($records) {
        // foreach ($records as $record) {
        //     echo $record["searchByStats"]."<br>";
        // }
        foreach($records as $record) 
     {
        echo "<strong>Name: </strong>". $record['user_id']."<br>";
        echo "<strong>Specializes in child care: </strong>". $record['child_care']."<br>";
        echo "<strong>Specializes in elder care: </strong>". $record['elder_care']."<br>";
        echo "<strong>Specializes in animal care: </strong>".$record['animal_care']."<br>";
        echo "<strong>Start date: </strong>".$record['start_date']."<br>";
        echo "<strong>End date: </strong>".$record['end_date']."<br>";
        echo "<strong>Description: </strong>".$record['description']."<br>";
        echo "<strong>Price: </strong>".$record['price']."<br>";
        
        
        echo "<br>";
        echo "<br>";
        echo "<br>";
     }
    }
?>