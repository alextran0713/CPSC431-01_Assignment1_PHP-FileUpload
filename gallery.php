<!DOCTYPE html>
<?php
  if(isset($_POST)) {
    $photo = $_POST['photoName'];
    $name = $_POST['name'];
    $place = $_POST["location"];
    // I got this line of code from stack Overflow
    // This line of code will convert the ttime from html input type"date" to store in php varible
    // https://stackoverflow.com/questions/30243775/get-date-from-input-form-within-php
    $new_date = date('m/d/Y', strtotime($_POST['dateTaken']));
    $fileName = $_FILES["uploadFile"]["name"];
    $document_root = $_SERVER['DOCUMENT_ROOT'];
    $outputstring = $new_date."\t".$photo."\t"
                    .$name."\t".$place."\t".$fileName."\n";
    $saveTo = fopen("$document_root/CPSC431-01_Assignment1_PHP-FileUpload/uploads/data.txt", "ab");
    move_uploaded_file($_FILES["uploadFile"]["tmp_name"],"uploads/".$_FILES["uploadFile"]["name"]);


  $photo = $_POST['photoName'];
  $name = $_POST['name'];
  $place = $_POST["location"];
  // I got this line of code from stack Overflow
  // This line of code will convert the ttime from html input type"date" to store in php varible
  // https://stackoverflow.com/questions/30243775/get-date-from-input-form-within-php
  $new_date = date('Y-m-d', strtotime($_POST['dateTaken']));
  $fileName = $_FILES["uploadFile"]["name"];
  echo "$fileName";
  $document_root = $_SERVER['DOCUMENT_ROOT'];
  $outputstring = $new_date."\t".$photo."\t"
                  .$name."\t".$place."\t".$fileName."\n";
  echo "$outputstring";
  $saveTo = fopen("$document_root/CPSC431-01_Assignment1_PHP-FileUpload/uploads/data.txt", "ab");
  move_uploaded_file($_FILES["uploadFile"]["tmp_name"],"uploads/".$_FILES["uploadFile"]["name"]);

    if (!$saveTo) {
      echo "<p><strong> Your data didn't get saved property.</strong></p>";
      exit;
    }
    flock($saveTo, LOCK_EX);
    fwrite($saveTo, $outputstring, strlen($outputstring));
    flock($saveTo, LOCK_UN);
    fclose($saveTo);
  }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body>
    <div class="container" style="max-width:100%">
      <div class="jumbotron" style="margin-top:2vh;">
        <h1 class="display-5">View All Photos</h1>
        <hr class="my-4">
        <div class="row">
          <div class="col">
           <div class="input-group mb-3">
            <div class="input-group-prepend">
                 <label class="input-group-text" style="border:none" ><h4>Sort By:</h4></label>
            </div>
            <select class="btn btn-primary btn-lg" id="input" aria-pressed="true"  onchange="displaySort()">
                  <option selected style="width: 100vw" value="Default">Default</option>
                  <option value="Name">Name</option>
                  <option value="Date">Date</option>
            <select class="btn btn-primary btn-lg" id="inputGroupSelect01" aria-pressed="true" >
                  <option selected style="width: 60vw">Default</option>
                  <option value="Photoname">Name of photo</option>
                  <option value="Date">Date</option>
                  <option value="Photographer">Photographer</option>
            </select>
           </div>
          </div>
          <div class="col">
           <a href="index.html" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" >Upload Image</a>
          </div>
        </div>
          </div>
        </div>
            <a href="">Sort by</a>
          </div>
          <div class="col">
           <a href="index.html" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Upload Image</a>
          </div>
        </div>

        <hr class="my-4">
        <?php
        $post = file("$document_root/CPSC431-01_Assignment1_PHP-FileUpload/uploads/data.txt");
        $numberOfline = count($post);
        if ($numberOfline == 0) {
        echo "<p><strong>No data in the file<br />
              Please try again later.</strong></p>";
        }
      ?>
      <div class=""></div>
      <div class= "row" >
        <?php for ($i=0; $i<$numberOfline; $i++) { ?>
        <?php $line = explode("\t", $post[$i]);
        echo "<table>\n";
        echo "<tr>
                <th>Order Date</th>
                <th>Photo Name</th>
                <th>Name</th>
                <th>Location</th>
                <th>Image</th>
              <tr>";
        for ($i=0; $i<$numberOfline; $i++) {
        //split up each line
        $line = explode("\t", $post[$i]);

        // output each order
        echo "<tr>
              <td>".$line[0]."</td>
              <td style=\"text-align: right;\">".$line[1]."</td>
              <td style=\"text-align: right;\">".$line[2]."</td>
              <td style=\"text-align: right;\">".$line[3]."</td>
              <td style=\"text-align: right;\">".$line[4]."</td>
          </tr>";
      }
      echo "</table>"
      ?>
      <div class= "row" >
        <?php for ($i=0; $i<$numberOfline; $i++) { ?>
        <?php $line = explode("\t", $post[$i]);
          $date = $line[0];
          $photoName = $line[1];
          $nameUser = $line[2];
          $location = $line[3];
          $image  = $line[4];
          $data = array
          (
            "$i" => array (
              "Date" => "$date",
              "photoName" => "$photoName",
              "namUser" => "$nameUser",
              "location" => "$location",
              "image" => "$image",
            )
          );
          echo " Data: ". $data[$i]['Date'];
          ?>
          $image  = $line[4]; ?>
          <div class ="col-12 col-md-4 mb-5">
            <div class="card">
                <img src="uploads/<?php echo $image ?>" alt="" class="img-fluid w-100 mb-3">
                <div class="card-body">
                <h5 class="card-title">Photo name: <?php echo $photoName ?></h5>
                <p class="card-text">Date taken: <?php echo $date ?><p>
                <p class="card-text">Location: <?php echo $location ?><p>
                <p class="card-text">Photographer: <?php echo $nameUser ?><p>
                </div>
            </div>
          </div>
        <?php } ?>
      </div>
      </div>
    </div>
    <script>
      function displaySort(){
        var x = document.getElementById("input").value;
        document.getElementById("demo").innerHTML = "You selected: " + x;
      }
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
