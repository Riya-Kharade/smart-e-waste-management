<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecobin - Fun Zone</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      font-family: 'Arial', sans-serif;
      padding-top: 70px;
    }

    /* Navbar */
    .navbar {
      background-color: #c30010;
    }
    .navbar-brand, .navbar-nav .nav-link {
      color: #fff !important;
    }
    .navbar-nav .nav-link:hover {
      color: #ffd6d9 !important;
    }

    /* Page Title */
    .page-title {
      text-align: center;
      margin-bottom: 50px;
    }
    .page-title h2 {
      color: #de0a26;
      font-size: 40px;
      font-weight: bold;
      margin-bottom: 10px;
      margin-top:40px;
    }
    .page-title p {
      color: #555;
      font-size: 18px;
    }

    /* Game Blocks */
    .game-row {
      border-radius: 20px;
      padding: 25px;
      margin-bottom: 25px;
      background: #fff0f0;
      display: flex;
      align-items: center;
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
    }
    .game-row:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .game-icon i {
      font-size: 60px;
      color: #f01e2c;
      transition: transform 0.3s;
    }
    .game-row:hover .game-icon i {
      transform: rotate(20deg) scale(1.2);
    }
    .game-info h5 {
      color: #c30010;
      font-weight: bold;
      font-size: 22px;
      margin-bottom: 10px;
    }
    .game-info p {
      color: #333;
      font-size: 16px;
      line-height: 1.5;
    }

    .btn-custom {
      background: #f01e2c;
      color: #fff;
      border-radius: 12px;
      padding: 12px 25px;
      font-weight: bold;
      transition: 0.3s;
      text-decoration: none;
    }
    .btn-custom:hover {
      background: #d1001f;
      color: #fff;
      text-decoration: none;
    }

  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><i class="fas fa-recycle"></i> Ecobin</a>
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="game.php">Fun Zone</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Signup</a></li>
         <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Page Title -->
  <div class="container page-title">
    <h2>Fun Zone - Play & Learn!</h2>
    <p>Test your e-waste knowledge and have fun while learning how to recycle properly.</p>
  </div>

  <!-- Game Section -->
  <div class="container mb-5">

    <!-- Game 1 -->
    <div class="game-row">
      <div class="game-icon me-4">
        <i class="fas fa-question-circle"></i>
      </div>
      <div class="game-info flex-grow-1">
        <h5>E-Waste Quiz</h5>
        <p>Answer questions about recycling and proper e-waste disposal. Earn points for correct answers!</p>
      </div>
      <a href="quiz.php" class="btn btn-custom ms-3">Play Quiz</a>
    </div>

    <!-- Game 2 -->
    <div class="game-row">
      <div class="game-icon me-4">
        <i class="fas fa-recycle"></i>
      </div>
      <div class="game-info flex-grow-1">
        <h5>Sorting Game</h5>
        <p>Drag and drop items into the correct recycling bins. Score points for correct sorting!</p>
      </div>
      <a href="sorting.php" class="btn btn-custom ms-3">Play Sorting</a>
    </div>

    <!-- Game 3 -->
    <div class="game-row">
      <div class="game-icon me-4">
        <i class="fas fa-brain"></i>
      </div>
      <div class="game-info flex-grow-1">
        <h5>Memory Game</h5>
        <p>Match pairs of recyclable and non-recyclable items. Complete all matches to win!</p>
      </div>
      <a href="memory-game.php" class="btn btn-custom ms-3">Play Memory</a>
    </div>

    <!-- Game 4 -->
    <div class="game-row">
      <div class="game-icon me-4">
        <i class="fas fa-puzzle-piece"></i>
      </div>
      <div class="game-info flex-grow-1">
        <h5>Puzzle Game</h5>
        <p>Solve puzzles made from e-waste awareness images. Complete quickly for a high score!</p>
      </div>
      <a href="puzzle.php" class="btn btn-custom ms-3">Play Puzzle</a>
    </div>

  </div>

  <div class="text-center mb-5">
    <a href="index.php" class="btn btn-custom btn-lg">
      <i class="fas fa-home"></i> Back to Home
    </a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
