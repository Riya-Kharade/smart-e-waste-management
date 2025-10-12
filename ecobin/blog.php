<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecobin - Blog / News</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
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
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 10px;
      margin-top:20px;
    }
    .page-title p {
      color: #555;
      font-size: 18px;
    }

    /* News Cards */
    .news-card {
      border: 2px solid #de0a26;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      background: #fff0f0;
      padding: 20px;
      text-align: center;
    }
    .news-card:hover {
      transform: translateY(-5px);
    }
    .news-card i {
      font-size: 60px;
      color: #c30010;
      margin-bottom: 15px;
    }
    .news-card h5 {
      color: #c30010;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .news-card p {
      font-size: 16px;
      color: #333;
      line-height: 1.5;
      margin-bottom: 15px;
    }
    .news-card a {
      text-decoration: none;
      color: #f01e2c;
      font-weight: bold;
    }
    .news-card a:hover {
      text-decoration: underline;
    }

    /* Back Button */
    .btn-custom {
      background: #f01e2c;
      color: #fff;
      border-radius: 8px;
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
    .title-margin{
      margin-top:30px;
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
  <div class="container page-title title-margin">
    <h2>Ecobin Blog & News</h2>
    <p>Stay updated with the latest news and awareness campaigns on e-waste management.</p>
  </div>

  <!-- News Section -->
  <div class="container mb-5">
    <div class="row g-4">

      <!-- News Card 1 -->
      <div class="col-md-4">
        <div class="news-card">
          <i class="fas fa-landmark"></i>
          <h5>Government E-Waste Policy 2025</h5>
          <p>The government has updated the e-waste management rules for safer disposal and recycling practices.</p>
          <a href="#">Read More</a>
        </div>
      </div>

     

       <!-- News Card 6 -->
      <div class="col-md-4">
        <div class="news-card">
          <i class="fas fa-mobile-alt"></i>
          <h5>Benefits of Recycling Old Phones</h5>
          <p>Discover how recycling phones helps recover precious metals and reduces environmental pollution.</p>
          <a href="#">Read More</a>
        </div>
      </div>

      <!-- News Card 3 -->
      <div class="col-md-4">
        <div class="news-card">
          <i class="fas fa-industry"></i>
          <h5>New Recycling Centers Open</h5>
          <p>Several authorized e-waste recycling centers have opened to handle growing electronic waste efficiently.</p>
          <a href="#">Read More</a>
        </div>
      </div>

       <!-- News Card 2 -->
      <div class="col-md-4">
        <div class="news-card">
          <i class="fas fa-bullhorn"></i>
          <h5>Awareness Campaign in Mumbai</h5>
          <p>Ecobin partnered with local NGOs to raise awareness about responsible e-waste disposal.</p>
          <a href="#">Read More</a>
        </div>
      </div>
      <!-- News Card 4 -->
      <div class="col-md-4">
        <div class="news-card">
          <i class="fas fa-lightbulb"></i>
          <h5>Tips for Safe E-Waste Disposal</h5>
          <p>Learn simple steps to safely dispose of your old gadgets and reduce environmental hazards.</p>
          <a href="#">Read More</a>
        </div>
      </div>

      <!-- News Card 5 -->
      <div class="col-md-4">
        <div class="news-card">
          <i class="fas fa-laptop"></i>
          <h5>Recycling Electronics at Home</h5>
          <p>Guide to segregate and prepare electronic items for eco-friendly collection and recycling.</p>
          <a href="#">Read More</a>
        </div>
      </div>

     

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
