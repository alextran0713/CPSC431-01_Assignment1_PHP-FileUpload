<!DOCTYPE html>
<?php
if(isset($_POST['submit'])){
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
<?php 
  
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
            <form method="POST" action="">
              <select class="btn btn-primary btn-lg" name="input" aria-pressed="true" onchange="form.submit()"> 
                    <option value="Default">Default</option>
                    <option value="ID">ID</option>
                    <option value="Name">Photographer</option>
                    <option value="Photo">PhotoName</option>
                    <option value="DateAs">Date</option>
              </select>
            </form>  
            <?php 
              $document_root = $_SERVER['DOCUMENT_ROOT'];
              $post = file("$document_root/CPSC431-01_Assignment1_PHP-FileUpload/uploads/data.txt");
              $numberOfline = count($post);
              if ($numberOfline == 0) {
                echo "<p><strong>No data in the file<br />
                      Please try again later.</strong></p>";
                }
                for ($i=0; $i<$numberOfline; $i++) { 
                  $line = explode("\t", $post[$i]); 
                  $date = $line[0];
                  $photoName = $line[1];
                  $nameUser = $line[2];
                  $location = $line[3];
                  $image  = $line[4]; 
                  $data[] = array
                  (
                    "Id" => "$i",
                    "date" => "$date",
                    "photoName" => "$photoName",
                    "nameUser" => "$nameUser",
                    "location" => "$location",
                    "image" => "$image",
                  ); 
              }
              if(isset($_POST['input'])){
                if($_POST['input'] == "Name"){
                  array_multisort(array_column($data, "nameUser"), SORT_STRING , $data);
                }
                elseif ($_POST['input'] == "Photo"){
                  array_multisort(array_column($data, "photoName"), SORT_STRING , $data);
                }
                elseif ($_POST['input'] == "DateAs"){
                  array_multisort(array_map('strtotime',array_column($data,'date')), 
                                  SORT_ASC, $data);
                }
                elseif ($_POST['input'] == "ID"){
                  array_multisort(array_column($data, "Id"), SORT_ASC , $data);
                }
              }
            ?>      
           </div>
          </div>
          <div class="col">
           <a href="index.html" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" >Upload Image</a>
          </div>  
        </div>
        <hr class="my-4">
        <div class="row">  
        <?php for($i = 0; $i < sizeof($data); $i++) {?>
          <div class ="col-12 col-md-4 mb-5">
              <div class="card">
                  <img src="uploads/<?php echo $data[$i]["image"]?>" alt="" class="img-fluid w-100 mb-3">
                  <div class="card-body">
                  <p class="card-text">Photo name: <?php echo $data[$i]["photoName"]  ?></p>
                  <p class="card-text">Date taken: <?php echo $data[$i]["date"] ?><p>
                  <p class="card-text">Location: <?php echo $data[$i]["location"] ?><p>
                  <p class="card-text">Photographer: <?php echo $data[$i]["nameUser"] ?><p>
                  </div>
              </div>
          </div>
        <?php } ?>
        </div>
     </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>