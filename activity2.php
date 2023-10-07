<!DOCTYPE html>
<html>

<body>

    
    <form action="activity2.php" action="GET">
        <input type="textbox" name="number"/>
        <input type="submit" value="submit"/>
    </form>
    <?php 

    if(isset($_GET["number"])) { 

        $number = $_GET["number"];
        $dilimeter = 0;
        $current = 1;

    
        $dilimeter = $number;

        for ($i = 0; $i < $dilimeter; $i++) {
            echo $current . " ";
            $current = $current * 2;
        }
    }
    

        

      


    ?>
     
</body>
  
</html>