<?php
include 'partials/_dbconnect.php';
include 'partials/_header.php';

$noresults = true;
$query = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = mysqli_real_escape_string($conn, $query);

ob_start(); // Start output buffering
if (!empty($query)) {
    // Use LIKE for broader search results
    $sql = "SELECT * FROM threads WHERE thread_title LIKE '%$query%' OR thread_desc LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $noresults = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $title = htmlspecialchars($row['thread_title']);
            $desc = htmlspecialchars($row['thread_desc']);
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=" . $thread_id;
            echo "<div class='result'><h3><a href='$url' class='text-dark'>$title</a></h3><p>$desc</p></div>";
        }
    }
}

if ($noresults) {
    echo "<div class='jumbotron jumbotron-fluid'><div class='container'><p class='display-4'>No Results Found</p><p class='lead'><ul><li>Make sure that all words are spelled correctly</li><li>Try different keywords.</li><li>Try more general keywords.</li></ul></p></div></div>";
}

$searchResults = ob_get_clean(); // Store results and clear buffer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous" />
    <style>#maincontainer { min-height: 100vh; }</style>
    <title>wishnear - bring services near you</title>
</head>
<body>
    <div class="container my-3" id="maincontainer">
        <h1>Search results for <em><?php echo htmlspecialchars($_GET['search'] ?? ''); ?></em></h1>
        <?php echo $searchResults; ?>
    </div>
    <?php include 'partials/_footer.php'; ?>
</body>
</html>