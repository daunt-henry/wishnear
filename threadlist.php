<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <style>
      img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{display:none !important;
    #ques {
        min-height: 433px;
    }
    </style>
    <title>wishnear - bring services near you</title>
</head>

<body>
  <?php include 'partials/_dbconnect.php' ?>
    <?php include 'partials/_header.php' ?>
    <?php 
      $id = $_GET['catid'];
      $sql = "SELECT * FROM `categories` WHERE category_id= $id " ;
      $result = mysqli_query($conn, $sql);
     
      while($row = mysqli_fetch_assoc($result)){
       
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
      }
    ?>

    <?php 
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
      //Insert into thread db
      $th_title = $_POST['title'];
      $th_desc = $_POST['desc'];

      $th_title = str_replace("<", "&lt;", $th_title );
      $th_title = str_replace(">", "&gt;", $th_title );

      $th_desc = str_replace("<", "&lt;", $th_desc );
      $th_desc = str_replace(">", "&gt;", $th_desc );

      $sno = $_POST['sno'];
      $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', CURRENT_TIMESTAMP)" ;
      $result = mysqli_query($conn, $sql);
      $showAlert = true;
      if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your post has been added please wait for the community to respond.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      }
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Services available in <?php echo $catname; ?> </h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
        </div>
    </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<div class="container">
        <h1 class="py-2">Become a service-person from your home or anywhere</h1>
        <form action="'. $_SERVER ["REQUEST_URI"] .'" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Enter Name and Profession</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Name - Profession">
        <small id="emailHelp" class="form-text text-muted"></small>
    </div>
    <input type="hidden" name="sno" value = "'.$_SESSION['sno'].'">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Give Your Details</label>
        <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="Address, phone.no:"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else{
      echo '<div class = "container">
      <h1 class="py-2">Become a service-person from your home or anywhere</h1>
      <p class= "lead">You are not logged in. Please login to become a service-person.</p>';
    //<p class= "lead">You are not logged in. Please login to become a service-person.</p>';
    //<p class= "lead">Mail Your details at daunthenry462@gmail.com or WhatsApp - +91-8709568123</p>';
    }
    ?>
    <div class="container" id="ques">
        <h1 class="py-2">Browse Services</h1>
        <?php 
      $id = $_GET['catid'];
      $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id " ;
      $result = mysqli_query($conn, $sql);
      $noResult = true;
      while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['thread_id']; 
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_time = $row['timestamp'];
        $thread_user_id = $row['thread_user_id'];
        $sql2 =  "SELECT user_email FROM `users` WHERE sno=$thread_user_id";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
        
      echo '  <div class="media my-3">
          <img src="img/user_default.png" width = 54px class="mr-3" alt="...">
          <div class="media-body">'.'
            <h5 class="mt-0"><a class = "text-dark" href="thread.php?threadid=' . $id . '">'. $title .'</a></h5>
           '. $desc .'
          </div>'.'<p class = "font-weight-bold my-0">posted by: ' . $row2['user_email'] . ' at ' . $thread_time . '</p>'.

        '</div>';
      }

       // echo var_dump($noResult);
       if($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Services Found</p>
          <p class="lead">Be the first person to post a service</p>
        </div>
      </div>';
      }
    ?>

        <?php include 'partials/_footer.php' ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
</body>

</html>