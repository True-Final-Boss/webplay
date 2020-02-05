<?php
$websiteURL = 'https://evanjoneswebplay.herokuapp.com/';
$authors = array('Evan_Jones');
$nav_items = array('About Us', 'Contact Us', 'OMDB Search');
$urls = array('Webpages/AboutUs.php', 'Webpages/contactUs.php', 'Webpages/omdb.php');


function noCache(){
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}



function head(){
  $head = '<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS -->
    <link href="../CSS/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Required PHP Functions -->

    <title>Team Alpha</title>
  </head>';
  echo $head;
}

function nav_bar()
{
  global $nav_items, $urls;

  $navbar = '<nav class="navbar navbar-expand-lg navbar-dark">
    <!-- Image and text -->
    <nav class="navbar">
      <a class="navbar-brand" href="https://team-alpha-web-site.herokuapp.com">
        <img src="../Images/mystic.png" width="40" height="30" class="d-inline-block align-top" alt="">
        Alpha Alpacas
      </a>
    </nav>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">';
  echo $navbar;
  for ($x = 0; $x < sizeof($nav_items) ; $x++) {
    $nav_bar_menu .= '<li class="nav-item"><a class="nav-link" href= /' . $urls[$x] . '>'. $nav_items[$x] .'</a></li>';
  }
  echo $nav_bar_menu;

  $closeNavBar = '</ul>
      </div>
    </nav>';
  echo $closeNavBar;
}

function footer()
{
  echo '<div class="card text-center"><div class="card-footer"><small class="text-muted">The website https://team-alpha-web-site.herokuapp.com is by Team Alpha</small></div></div>';
}

function getMovies($search){

  $url = 'http://omdbapi.com/?apikey=ddbdfa64&s=%27'.urlencode($search);
  echo "<p style=\"color:#0E0816\">".$url."</p>";
  $handle = curl_init();
  curl_setopt($handle, CURLOPT_URL, $url);
  curl_setopt_array($handle,
  array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true
  )
  );
  $output = curl_exec($handle);
  $response = json_decode($output, true);
  curl_close($handle);
  $NumberOfElements = count($response['Search']);
  $imageURL = $response['Search'][$x]['Poster'];
  echo '<div class ="movie-wrapper">';
  for ($x = 0; $x < $NumberOfElements ; $x++) {
     echo '<div class="box'.$x.'">';
     echo $response["Search"][$x]["Title"].'<br>';
     echo '<img src=" '.$response['Search'][$x]['Poster'].' " alt="No-Image-Available"><br>';
    echo '<!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong'.$x.'">
      View Plot
    </button>';
    echo'<!-- Modal -->
    <div class="modal fade" id="exampleModalLong'.$x.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle'.$x.'" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle'.$x.'">'.$response["Search"][$x]["Title"].'</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">';
            echo '<b>';
            echo details($response["Search"][$x]["imdbID"]);
            echo '</b></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>';
    echo '</div>';
  }
  echo '</div>';
}


function details($movieID){
    $url = 'http://omdbapi.com/?apikey=ddbdfa64&i='. $movieID;
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt_array($handle,
    array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true
    )
    );
    $output = curl_exec($handle);
    $response = json_decode($output, true);
    curl_close($handle);
    echo $response["Plot"];
}
?>
