<!DOCTYPE html>
<html>
   <head>
      <title>Form</title>
      <!-- Link Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
   </head>
   <body>
      <?php
      $servername = "localhost";
      $port = 3307;
      $username = "root";
      $password = "";
      $dbname = "pointofsale_mendoza";
      $table = "ref_menu";

      // Create a connection
      $conn = new mysqli($servername, $username, $password, $dbname, $port);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Retrieve values from POST form
          $menuName = $_POST["menuName"];
          $menuDescription = $_POST["menuDescription"];

          // Prepare and bind the statement
          $stmt = $conn->prepare(
              "INSERT INTO $table (menu_name, menu_description) VALUES (?, ?)"
          );
          $stmt->bind_param("ss", $menuName,  $menuDescription);

          // Execute the statement
          if ($stmt->execute() === true) {
              echo "New record created successfully!";
          } else {
              echo "Error: " . $stmt->error;
          }

          // Close statement
          $stmt->close();
      }

      // Close the connection
      $conn->close();
      ?>
         
      <div class="container mt-4">
         <h2>Form</h2>
         <form method="POST">
            <div class="form-group">
               <label for="name">Name:</label>
               <input type="text" class="form-control" id="name" name="menuName" placeholder="Enter your name">
            </div>
            <div class="form-group">
               <label for="description">Description:</label>
               <textarea class="form-control" id="description" name="menuDescription" placeholder="Enter description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
         </form>
      </div>
      <!-- Link Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
      <!-- You can write your custom scripts below this line -->
   </body>
</html>