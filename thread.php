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
      $id = $_GET['threadid'];
      $sql = "SELECT * FROM `threads` WHERE thread_id= $id " ;
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($result)){
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thred_user_id = $row['thread_user_id'];

        // Query the users table to find out the name of the OP
        $sql2 =  "SELECT user_email FROM `users` WHERE sno=$thred_user_id";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
      }

   ?>
   <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
      //Insert into comment db
      $comment = $_POST['comment'];
      $comment = str_replace("<", "&lt;", $comment );
      $comment = str_replace(">", "&gt;", $comment );
      $sno = $_POST['sno'];
      $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', CURRENT_TIMESTAMP)" ;
      $result = mysqli_query($conn, $sql);
      $showAlert = true;
      if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your review has been added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      }
    }

      ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?> </h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            
                <p>Posted by <em><?php echo $posted_by; ?></em></p>
            
        </div>
    </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<div class="container">
    <h1 class="py-2">Give a Review</h1>
    <form action="' . $_SERVER ['REQUEST_URI'] . '" method="post">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your review</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            <input type="hidden" name="sno" value = "'.$_SESSION['sno'].'">
        </div>
        <button type="submit" class="btn btn-success">Post Review</button>
    </form>
</div>';
    }
    else{
      echo '<div class = "container">
      <h1 class="py-2">Give a Review at</h1>
          <p class= "lead">You are not logged in. Please login to give reviews.</p>';
    //   <p class= "lead">You are not logged in. Please login to give reviews.</p>';
    //   <p class= "lead">daunthenry462@gmail.com or WhatsApp - +91-8709568123.</p>';
    }
    ?>

    <div class="container" id="ques">
        <h1 class="py-2">Reviews</h1>
        <?php 
      $id = $_GET['threadid'];
      $sql = "SELECT * FROM `comments` WHERE thread_id=$id " ;
      $result = mysqli_query($conn, $sql);
      $noResult = true;
      while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['comment_id']; 
        $content = $row['comment_content'];
        $comment_time =  $row['comment_time'];
        $comment_by = $row['comment_by'];

        $sql2 =  "SELECT user_email FROM `users` WHERE sno=$comment_by";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
        echo ' <div class="media my-3">
        <img src="img/user_default.png" width = 54px class="mr-3" alt="...">
        <div class="media-body">
        <p class = "font-weight-bold my-0">'.$row2['user_email'].' at ' . $comment_time . '</p>
         '. $content .'
        </div>
      </div>';

        
      }

       if($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No reviews yet</p>
          <p class="lead">Be the first person to give a review </p>
        </div>
      </div>';
      }
    ?>

        <?php include 'partials/_footer.php';?>

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