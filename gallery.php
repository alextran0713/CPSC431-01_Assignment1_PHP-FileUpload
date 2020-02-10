<!DOCTYPE html>
<?php
  $photo = $_POST['photoName'];
  $name = $_POST['name'];
  $place = $_POST["location"];
  // I got this line of code from stack Overflow
  // This line of code will convert the ttime from html input type"date" to store in php varible
  // https://stackoverflow.com/questions/30243775/get-date-from-input-form-within-php
  $new_date = date('Y-m-d', strtotime($_POST['dateTaken']));
  $fileName = $_POST('uploadFile');
  echo "$fileName";
  $document_root = $_SERVER['DOCUMENT_ROOT'];
  $outputstring = $new_date."\t".$photo."\t"
                  .$name."\t".$place."\n";
  echo "$outputstring";
  $saveTo = fopen("$document_root/CPCS452/uploads/data.txt", "ab");
  move_uploaded_file($_FILES["uploadFile"]["tmp_name"],"uploads/".$_FILES["uploadFile"]["name"]);

  echo "$saveTo";
  if (!$saveTo) {
    echo "<p><strong> Your data didn't get saved property.</strong></p>";
    exit;
  }
  flock($saveTo, LOCK_EX);
  fwrite($saveTo, $outputstring, strlen($outputstring));
  flock($saveTo, LOCK_UN);
  fclose($saveTo);
  echo "<p>Successfully writen data in a file</p>";
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        table, th, td {
          border-collapse: collapse;
          border: 1px solid black;
          padding: 6px;
        }

        th {
          background: #ccccff;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="jumbotron" style="margin:auto; height:auto; margin-top:2vh;">
        <h1 class="display-5">Add Photo to Gallery</h1>
        <hr class="my-4">
        <?php
        $post = file("$document_root/CPCS452/uploads/data.txt");
        $numberOfline = count($post);
        if ($numberOfline == 0) {
        echo "<p><strong>No data in the file<br />
              Please try again later.</strong></p>";
        }
        echo "<table>\n";
        echo "<tr>
                <th>Order Date</th>
                <th>Photo Name</th>
                <th>Name</th>
                <th>Location</th>
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
          </tr>";
      }
      echo "</table>";
      ?>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
