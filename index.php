<?php include 'filesLogic.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="main.css">
    <title>Upload files</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Select File</h3>
          <input type="file" name="myfile"> <br>
          <input type="date" name="expiryDate"> <br>
          <button type="submit" name="save">upload</button>
        </form>
      </div>
    </div>
  </body>
</html>

