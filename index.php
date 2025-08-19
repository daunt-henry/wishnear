<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{display:none !important;
        #ques{
            min-height: 433px;
        }
        
    </style>
    <title>wishnear - bring services near you</title>
    
</head>

<body>
    <?php include 'partials/_dbconnect.php' ?>
    <?php include 'partials/_header.php' ?>
   

    <!-- Slider starts here  -->
    <!--<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">-->
    <!--    <ol class="carousel-indicators">-->
    <!--        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>-->
    <!--        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>-->
    <!--        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
    <!--    </ol>-->
       

    <!-- Category container starts here  -->
    <div class="container my-4" id = "ques">
        <h2 class="text-center my-4">Find Services in Jamshedpur</h2>
        <div class="row my-4">
            <!-- Fetch all the categories and use a Loop to iterate throught categories -->
            <?php 
        $sql = "SELECT * FROM `categories`";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
        //   echo $row['category_id'];
        $id = $row['category_id'];
        $cat = $row['category_name'];
        $desc = $row['category_description'];
        echo '<div class="col-md-4 my-2">
            <div class="card" style="width: 18rem">
              <img src="img/jamshedpur.jpg?'. $cat .'auto=compress&cs=tinysrgb&w=400"
                  class="card-img-top" alt="..." />
              <div class="card-body">
                  <h5 class="card-title"><a href="threadlist.php?catid='. $id .'">'. $cat .'</a></h5>
                  <p class="card-text">
                     '. substr($desc,0,90).'...
                  </p>
                  <a href="threadlist.php?catid='. $id .'" class="btn btn-primary">View Threads</a>
              </div>
          </div>
      </div>';
        }
        ?>
             




        </div>
    </div>
    
    
    
    
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