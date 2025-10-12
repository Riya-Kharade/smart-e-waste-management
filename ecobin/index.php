<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecobin - E-Waste Management</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
    }

    /* Navbar */
    .navbar {
      background-color: #c30010;
    }
    .navbar-brand {
      color: #fff !important;
      font-weight: bold;
      font-size: 22px;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
      margin: 0 8px;
      font-weight: 500;
      transition: 0.3s;
    }
    .navbar-nav .nav-link:hover {
      color: #ffd6d9 !important;
    }

    /* Header */
    header {
      background: #c30010;
      color: #fff;
      padding: 80px 10px 40px;
      text-align: center;
      margin-top: 56px;
    }
    header h1 {
      font-size: 40px;
      margin-bottom: 10px;
    }
    header p {
      font-size: 18px;
      color: #ffcbd1;
    }

    /* Buttons */
    .btn-custom {
      background: #f01e2c;
      color: #fff;
      border-radius: 8px;
      padding: 12px 25px;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #d1001f;
    }

    /* About Section */
    .about {
      margin: 40px auto;
      padding: 30px;
      background: #fff0f0;
      border: 1px solid #f94449;
      border-radius: 12px;
      text-align: center;
    }

    .about h3 {
      color: #de0a26;
      margin-bottom: 15px;
    }

    /* Cards */
    .card {
      border: 1px solid #f94449;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
      background: #fff0f0;
    }
    .card i {
      font-size: 50px;
      margin-bottom: 15px;
      color: #f01e2c;
    }

    /* Footer */
    footer {
      background: #c30010;
      color: #fff;
      padding: 50px 20px 20px;
      margin-top: 40px;
    }
    footer h2 {
      font-size: 20px;
      margin-bottom: 15px;
      color: #ffd6d9;
      border-bottom: 2px solid #ff99a0;
      display: inline-block;
      padding-bottom: 5px;
    }
      footer h2:hover {
      font-size: 22px;
      margin-bottom: 15px;
      color: #ffd6d9;
      border-bottom: 3px solid #ff99a0;
      display: inline-block;
      padding-bottom: 5px;
      transition-duration:2s;
    }
    footer a {
      color: #fff;
      text-decoration: none;
      display: block;
      margin: 6px 0;
      transition: 0.3s;
      font-size: 15px;
    }
    footer a:hover {
      color: #ffcbd1;
      padding-left: 5px;
    }
    footer a i {
      margin-right: 8px;
      color: #ffd6d9;
    }
    footer .contact-info p {
      margin: 8px 0;
      font-size: 15px;
    }
    footer .contact-info i {
      margin-right: 8px;
      color: #ffd6d9;
    }
    footer .map iframe {
      width: 100%;
      height: 150px;
      border: 0;
      border-radius: 8px;
    }
    .footer-bottom {
      text-align: center;
      padding-top: 15px;
      border-top: 1px solid #ff99a0;
      margin-top: 20px;
      font-size: 14px;
    }
    /* Add vertical line separators */
    .footer-col {
      border-right: 1px solid #ff99a0;
      padding-right: 20px;
    }
    .footer-col:last-child {
      border-right: none;
    }

    .feature-card {
  border: 2px solid #de0a26;
  border-radius: 12px;
  background: #fff0f0;
  transition: 0.3s;
  height: 100%;
}
.feature-card:hover {
  transform: translateY(-5px);
  background: #ffd6d9;
}
.feature-card h5 {
  margin-top: 10px;
  margin-bottom: 10px;
  color: #c30010;
  font-weight: bold;
}
.feature-card p {
  font-size: 14px;
  color: #333;
}
.footer-bottom {
    text-align: center;
    padding: 15px 0;
    color: #fff;
    font-size: 14px;
}

.footer-bottom a.portfolio-link {
    color: #fff; /* Link color */
    text-decoration: none;
    transition: 0.3s;
}

.footer-bottom a.portfolio-link:hover {
    color: #ffe6e6; /* Hover color */
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

  <!-- Header -->
  <header>
    <h1>♻️ E-waste Management - Ecobin</h1>
    <p>Smart way to manage your e-waste</p>
  </header>

  <!-- Role Based Access -->
  <div class="container text-center mt-5">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card p-4">
          <i class="fas fa-user-shield"></i>
          <h5>Admin Login</h5>
          <a href="admin_login.php" class="btn btn-custom mt-2">Login</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4">
          <i class="fas fa-user"></i>
          <h5>Customer Login</h5>
          <a href="login.php" class="btn btn-custom mt-2">Login</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4">
          <i class="fas fa-truck"></i>
          <h5>Kabadiwala Login</h5>
          <a href="login.php" class="btn btn-custom mt-2">Login</a>
        </div>
      </div>
    </div>
  </div>

  <!-- About Project -->
  <div id="about" class="container about mt-5">
    <h3>About Project</h3>
    <p>
      Ecobin helps customers dispose gadgets safely, kabadiwalas collect e-waste efficiently, 
      and admins monitor the entire system for proper tracking and eco-friendly disposal.
    </p>
  </div>


    <!-- How Project Work  -->
  <div id="about" class="container about mt-5">
    <h3>How Project Works</h3>
    <p>
         Ecobin is designed to make e-waste management simple and eco-friendly.
          Customers can register and schedule their e-waste pickups easily.
           Kabadiwalas collect the e-waste efficiently and ensure it is recycled or disposed of safely. 
           The admin monitors the entire process, approves registrations, tracks collected waste, 
           and generates reports to ensure a smooth and sustainable system. This workflow ensures 
           proper e-waste disposal while keeping the environment safe and reducing harmful landfill waste.

    </p>
  </div>

<!-- Features Section -->
<div id="features" class="container mt-5">
  <h3 class="text-center mb-4" style="color:#de0a26;">Key Features of Ecobin</h3>
  <p class="text-center mb-5" style="color:#333;">
    Ecobin makes e-waste management simple, safe, and eco-friendly. Here’s what it offers to customers, kabadiwalas, and admins:
  </p>

  <div class="row g-4">
    <!-- Feature 1 -->
    <div class="col-md-3">
      <div class="feature-card p-4 text-center">
        <i class="fas fa-calendar-check fa-3x mb-3" style="color:#f01e2c;"></i>
        <h5>Easy Pickup Scheduling</h5>
        <p>Customers can quickly schedule e-waste pickups at their convenience.</p>
      </div>
    </div>

    <!-- Feature 2 -->
    <div class="col-md-3">
      <div class="feature-card p-4 text-center">
        <i class="fas fa-recycle fa-3x mb-3" style="color:#f01e2c;"></i>
        <h5>Safe Recycling & Disposal</h5>
        <p>Kabadiwalas collect and recycle e-waste safely, reducing environmental harm.</p>
      </div>
    </div>

    <!-- Feature 3 -->
    <div class="col-md-3">
      <div class="feature-card p-4 text-center">
        <i class="fas fa-chart-line fa-3x mb-3" style="color:#f01e2c;"></i>
        <h5>Real-Time Tracking</h5>
        <p>Admins can monitor pickups, collections, and user activity in real time.</p>
      </div>
    </div>

    <!-- Feature 4 -->
    <div class="col-md-3">
      <div class="feature-card p-4 text-center">
        <i class="fas fa-leaf fa-3x mb-3" style="color:#f01e2c;"></i>
        <h5>Eco-Friendly Impact</h5>
        <p>Contributes to a greener environment by reducing e-waste pollution.</p>
      </div>
    </div>
  </div>
</div>


  <!-- Footer -->
  <footer id="contact">
    <div class="container">
      <div class="row">
        <!-- Company Info -->
        <div class="col-md-4 mb-4 footer-col">
          <h2>Ecobin</h2>
          <p>Smart way to manage your e-waste efficiently and safely.</p>
          <div class="contact-info">
             <h2>Contact Us</h2>
            <p><i class="fas fa-user"></i> Riya Kharade</p>
            <p><i class="fas fa-phone"></i> 8275005788</p>
          </div>
        </div>
        <!-- Important Links -->
        <div class="col-md-4 mb-4 footer-col">
          <h2>Important Links</h2>
          <a href="index.php"><i class="fas fa-home"></i> Home</a>
          <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
          <a href="register.php"><i class="fas fa-user-plus"></i> Signup</a>
          <a href="#about"><i class="fas fa-info-circle"></i> About</a>
          <a href="#contact"><i class="fas fa-envelope"></i> Contact</a>
        </div>
        <!-- Contact & Map -->
        <div class="col-md-4 mb-4">
          <h2>ReachOut</h2>
          
          <div class="map">
            <iframe   src="https://www.google.com/maps?q=Vidyalankar+Institute+of+Technology,+Wadala,+Mumbai&output=embed"
 allowfullscreen></iframe>
          </div>
        </div>
      </div>
     <div class="footer-bottom">
    <p>
        © 2025 Ecobin | Developed by Team Ecobin | 
        <a href="https://riyakharade-portfolio.netlify.app/" target="_blank" class="portfolio-link">My Portfolio</a>
    </p>
</div>

    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
