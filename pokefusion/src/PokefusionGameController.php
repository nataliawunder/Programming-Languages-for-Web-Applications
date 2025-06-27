<?php

class PokefusionGameController
{
  // https://cs4640.cs.virginia.edu/xax8gw/pokefusion/
  // Contributions: 
  // Natalia: Home, Login, Register, User Profile, Gallery (HTML, CSS, JS, PHP)
  // Azka: Home, Login, Register, Play implementation (HTML, CSS, JS, PHP)


  private $db;
  private $input;
  private $errorMessage = "";

  /**
   * Constructor
   */
  public function __construct($input)
  {
    // Start the session!
    session_start();

    $this->db = new Database();

    $this->input = $input;

    $this->loadData();
  }

  /**
   * Run the server
   * 
   * Given the input (usually $_GET), then it will determine
   * which command to execute based on the given "command"
   * parameter.  Default is the welcome page.
   */
  public function run()
  {
    // Get the command
    $command = "home";
    if (isset($this->input["command"]) && (
      $this->input["command"] == "register" || $this->input["command"] == "login" || $this->input["command"] == "rules" || isset($_SESSION["username"])))
      $command = $this->input["command"];

    switch ($command) {
      case "register":
        $this->register();
        break;
      case "login":
        $this->login();
        break;
      case "userProfile":
        $this->userProfile();
        break;
      case "gallery":
        $this->gallery();
        break;
      case "submitRating":
        $this->submitRating();
        break;
      case "saveDrawing":
        $this->saveDrawing();
        break;
      case "userInfoAPI":
        $this->userInfoAPI();
        break;
      // case "rules":
      //   $this->showRules();
      //   break;
      // case "rulesLoggedIn":
      //   $this->showRulesLoggedIn();
      //   break;
      case "play":
        $this->play();
        break;
      case "homeLoggedIn":
        $this->showHomeLoggedIn();
        break;
      case "logout":
        $this->logout(); // notice no break 
      case "home":
      default:
        $this->showHome();
        break;
    }
  }

  public function loadData()
  {
    // to - do to make faster
    // $wordListPath = '/opt/src/anagrams/data/words7.txt';
    // $wordBankPath = '/opt/src/anagrams/data/word_bank.json';

    // $wordListPath = '/students/xax8gw/students/xax8gw/private/anagramsDB/data/words7.txt';
    // $wordBankPath = '/students/xax8gw/students/xax8gw/private/anagramsDB/data/word_bank.json';

    // https://www.php.net/manual/en/function.file.php
    // $this->targetWords = file($wordListPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // $this->validWords = json_decode(file_get_contents($wordBankPath), true);
  }

  public function userInfoAPI() {
    $userInfo = [
      "user_id" => $_SESSION["user_id"],
      "username" => $_SESSION["username"],
      "email" => $_SESSION["email"]
    ];
    header('Content-Type: application/json');
    echo json_encode($userInfo, JSON_PRETTY_PRINT);
  }
  
  public function showHome()
  {
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/home.php");
    //include("/opt/src/pokefusion/templates/home.php");
  }

  public function showHomeLoggedIn()
  {
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/homeLoggedIn.php");
    //include("/opt/src/pokefusion/templates/homeLoggedIn.php");
  }

  public function register()
  {
    // check if form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (
        isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) &&
        !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])
      ) {

        // check that username looks right using regular expressions
        if (!preg_match("/^\w+$/", $_POST["username"])) {
          $message = "<p class='alert alert-danger'>Invalid username format. Please try again.</p>";
          $this->showRegister($message);
          return;
        }

        // check that email looks right using regular expressions
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          $message = "<p class='alert alert-danger'>Invalid email format. Please try again.</p>";
          $this->showRegister($message);
          return;
        }

        // check that password format is correct
        // this does not match the password text box bc requires 1 special character for more secure password
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[\S]{8,20}$/', $_POST["password"])) {
          $message = "<p class='alert alert-danger'>Invalid password format. Please try again.</p>";
          $this->showRegister($message);
          return;
        }

        // check if email and username is already registered
        $result = $this->db->query("SELECT * FROM pokefusion_users WHERE username = $1;", $_POST["username"]);
        $results = $this->db->query("SELECT * FROM pokefusion_users WHERE email = $1;", $_POST["email"]);
        
        if (empty($result) && empty($results)) {
          // create the user account
          $result = $this->db->query(
            "INSERT INTO pokefusion_users (username, email, password) VALUES ($1, $2, $3);",
            $_POST["username"],
            $_POST["email"],
            password_hash($_POST["password"], PASSWORD_DEFAULT)
          );

          // redirect to login screen
          header("Location: ?command=login");
          return;
        } else {
          // email or username already registered
          $message = "<p class='alert alert-danger'>Account already registered. Try again or log in.</p>";
          $this->showRegister($message);
          return;
        }
      } else {
        // form is submitted but required fields are missing
        $message = "<p class='alert alert-danger'>Username, email, or password missing.</p>";
        $this->showRegister($message);
        return;
      }
    }

    // if the page is accessed without form submission, no error message
    $this->showRegister();
  }

  public function showRegister($message = "")
  {
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/register.php");
    //include("/opt/src/pokefusion/templates/register.php");
  }

  public function login()
  {
    // source for cookie log in: https://www.youtube.com/watch?v=kmaUSZXfbxg
    // check if form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (
        isset($_POST["username"]) && isset($_POST["password"]) &&
        !empty($_POST["username"]) && !empty($_POST["password"])
      ) {

        $results = $this->db->query("SELECT * FROM pokefusion_users WHERE username = $1;", $_POST["username"]);

        if (empty($results)) {
          // user not found
          $message = "<p class='alert alert-danger'>User not found. Please try again or register an account.</p>";
          $this->showLogin($message, "");
          return;
        } else {
          // check if the password is correct
          $hashed_password = $results[0]["password"];
          $correct = password_verify($_POST["password"], $hashed_password);
          if ($correct) {
            // success!
            $_SESSION["user_id"] = $results[0]['id'];
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["email"] = $results[0]['email'];

            if (!empty($_POST["rememberMe"])) {
              setcookie("username", $_POST["username"], time() + (3600 * 24 * 7));
              setcookie("password", $_POST["password"], time() + (3600 * 24 * 7));
              setcookie("userlogin", $_POST["rememberMe"], time() + (3600 * 24 * 7));
            } else {
              // remove cookie if unchecked
              setcookie("username", $_POST["username"], 30);
              setcookie("password", $_POST["password"], 30);
            }

            // redirect to profile screen
            header("Location: ?command=userProfile");
            return;
          } else {
            // incorrect password
            $message = "<p class='alert alert-danger'>Incorrect password. Please try again.</p>";
            $this->showLogin($message, "");
            return;
          }
        }
      } else {
        // form submitted with missing fields
        $message = "<p class='alert alert-danger'>Username or password missing.</p>";
        $this->showLogin($message, "");
        return;
      }
    }

    $savedUsername = "";
    if (isset($_COOKIE["remembered_user"])) {
      $savedUsername = $_COOKIE["remembered_user"];
    }

    $this->showLogin("", $savedUsername);
  }


  public function showLogin($message = "", $savedUsername = "")
  {
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/login.php");
    //include("/opt/src/pokefusion/templates/login.php");
  }

  public function showRules()
  {
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/rules.php");
    //include("/opt/src/pokefusion/templates/rules.php");
  }

  public function showRulesLoggedIn()
  {
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/rulesLoggedIn.php");
    //include("/opt/src/pokefusion/templates/rulesLoggedIn.php");
  }

  public function userProfile() {
    $user_id = $_SESSION["user_id"];
    $username = $_SESSION["username"];
    $email = $_SESSION["email"];
    $drawings = [];
    $message = "";

    if (isset($_SESSION["successMessage"])) {
      $message = $_SESSION["successMessage"];
      unset($_SESSION["successMessage"]);
    }
    if (isset($_SESSION["errorMessage"])) {
      $message = $_SESSION["errorMessage"];
      unset($_SESSION["errorMessage"]);
    }

    // handle drawing deletion if POST request made
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["drawingToDelete"])) {
      $drawing_id = $_POST["drawingToDelete"];

      // delete drawing
      $delete = $this->db->query("DELETE FROM pokefusion_drawings WHERE id = $1 AND user_id = $2;", $drawing_id, $user_id);

      // returns an array 
      if (count($delete) === 0) {
        $_SESSION["successMessage"] = "<p class='alert alert-danger'>Drawing deleted successfully!</p>";
      } else {
          $_SESSION["errorMessage"] = "<p class='alert alert-danger'>Error deleting drawing.</p>";
      }

      // avoid form resubmission
      header("Location: ?command=userProfile");
      return;
    }

    if (isset($_GET['search']) && !empty($_GET['search'])) {
      //https://www.w3schools.com/postgresql/postgresql_like.php
      $searchTerm = '%' . $_GET['search'] . '%';
      $drawings = $this->db->query("SELECT * FROM pokefusion_drawings WHERE user_id = $1 AND title ILIKE $2;", $user_id, $searchTerm);
    } else {
      $drawings = $this->db->query("SELECT * FROM pokefusion_drawings WHERE user_id = $1;", $user_id);
    }

    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/userProfile.php");
    //include("/opt/src/pokefusion/templates/userProfile.php");
  }

  public function submitRating() {
    if (!isset($_POST["drawing_id"]) || !isset($_POST["rating"])) {
        $_SESSION["errorMessage"] = "Invalid rating submission.";
        header("Location: ?command=gallery");
        return;
    }

    $drawing_id = $_POST["drawing_id"];
    $rating = $_POST["rating"];
    $user_id = $_SESSION["user_id"];

    if ($rating < 1 || $rating > 5) {
        $_SESSION["errorMessage"] = "<p class='alert alert-danger'>Rating must be between 1 and 5.</p>";
        header("Location: ?command=gallery");
        return;
    }

    // insert or update rating in pokefusion_drawing_ratings
    $existingRatings = $this->db->query("SELECT * FROM pokefusion_drawing_ratings WHERE user_id = $1 AND drawing_id = $2;", $user_id, $drawing_id);

    if (count($existingRatings) > 0) {
        $this->db->query("UPDATE pokefusion_drawing_ratings SET rating = $1 WHERE user_id = $2 AND drawing_id = $3;", $rating, $user_id, $drawing_id);
    } else {
        $this->db->query("INSERT INTO pokefusion_drawing_ratings (user_id, drawing_id, rating) VALUES ($1, $2, $3);", $user_id, $drawing_id, $rating);
    }

    // calculate new average
    $avg_result = $this->db->query("SELECT AVG(rating) as avg_rating FROM pokefusion_drawing_ratings WHERE drawing_id = $1 AND rating BETWEEN 1 AND 5;", $drawing_id);
    $average = round($avg_result[0]["avg_rating"]);

    // update the drawing's average rating
    $this->db->query("UPDATE pokefusion_drawings SET rating = $1 WHERE id = $2;", $average, $drawing_id);

    $_SESSION["successMessage"] = "<p class='alert alert-success'>Thank you for rating!</p>";
    header("Location: ?command=gallery");
  } 


  public function gallery() {
    $drawings = [];
    $message = "";

    if (isset($_SESSION["successMessage"])) {
        $message = $_SESSION["successMessage"];
        unset($_SESSION["successMessage"]);
    }
    if (isset($_SESSION["errorMessage"])) {
        $message = $_SESSION["errorMessage"];
        unset($_SESSION["errorMessage"]);
    }

    // https://www.postgresql.org/docs/current/tutorial-join.html
    // join tables help
    $title = null;
    $username = null;
    $rating = null;

    if (isset($_GET['title']) && trim($_GET['title']) !== '') {
        $title = '%' . trim($_GET['title']) . '%';
    }

    if (isset($_GET['username']) && trim($_GET['username']) !== '') {
        $username = '%' . trim($_GET['username']) . '%';
    }

    if (isset($_GET['rating']) && is_numeric($_GET['rating'])) {
        $rating = (int)$_GET['rating'];
    }

    // will select all since 1=1 (true)
    $query = "select drawings.*, users.username
        from pokefusion_drawings drawings
        join pokefusion_users users on drawings.user_id = users.id
        where 1 = 1";

    $params = [];
    $paramIndex = 1;

    if ($title !== null) {
        $query .= " AND drawings.title ILIKE $" . $paramIndex;
        $params[] = $title;
        $paramIndex += 1;
    }

    if ($username !== null) {
        $query .= " AND users.username ILIKE $" . $paramIndex;
        $params[] = $username;
        $paramIndex += 1;
    }

    if ($rating !== null) {
        $query .= " AND drawings.rating >= $" . $paramIndex;
        $params[] = $rating;
        $paramIndex += 1;
    }

    $drawings = $this->db->query($query, ...$params);

    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/gallery.php");
    //include("/opt/src/pokefusion/templates/gallery.php");
  }


  public function play() {
    $user_id = $_SESSION["user_id"];
    $username = $_SESSION["username"];
    $email = $_SESSION["email"];
    $url = "https://pokeapi.co/api/v2/pokemon?limit=151"; //first 151 pokemon
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $allPokemon = [];
    foreach ($data['results'] as $pokemon) {
      $name = ucfirst($pokemon['name']); //capitalize first letter to make it look pritty
      $allPokemon[] = $name;
    }
    $pokemon1 = $allPokemon[array_rand($allPokemon)];
    $pokemon2 = $allPokemon[array_rand($allPokemon)];
    
    while ($pokemon1 === $pokemon2) {
      $pokemon2 = $allPokemon[array_rand($allPokemon)];
    }

    $pokemon1Data = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokemon1"), true);
    $pokemon2Data = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokemon2"), true);

    $imageSrc1 = $pokemon1Data['sprites']['other']['official-artwork']['front_default'];
    $imageSrc2 = $pokemon2Data['sprites']['other']['official-artwork']['front_default'];

    $user_id = $_SESSION["user_id"];
    $title = $pokemon1 . " + " . $pokemon2;
    $img_url = $imageSrc1;  //placeholder
    $rating = 0;

    // insert into database
    // $this->db->query(
    //   "INSERT INTO pokefusion_drawings (user_id, rating, img_url, title) VALUES ($1, $2, $3, $4);",
    //   $user_id,
    //   $rating,
    //   $img_url,
    //   $title
    // );
    include("/students/xax8gw/students/xax8gw/private/pokefusion/templates/play.php");
    //include("/opt/src/pokefusion/templates/play.php");
  }

  public function saveDrawing() {
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        return;
    }
    
    // get request body
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);
    
    if (!$data || !isset($data['imageData']) || !isset($data['title'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        return;
    }
    
    $user_id = $_SESSION["user_id"];
    $img_url = $data['imageData'];
    $title = $data['title'];
    $rating = 0;
    
    try {
        $this->db->query(
            "INSERT INTO pokefusion_drawings (user_id, rating, img_url, title) VALUES ($1, $2, $3, $4);",
            $user_id,
            $rating,
            $img_url,
            $title
        );
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
  }

  public function logout() {
    // Destroy the session
    session_destroy();

    // Start a new session.
    session_start();
  }
}