<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecobin - Contact</title>
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
      margin-top: 40px;
      margin-bottom: 50px;
    }
    .page-title h2 {
      color: #de0a26;
      font-size: 36px;
      font-weight: bold;
    }
    .page-title p {
      color: #555;
      font-size: 18px;
    }

    /* Contact Section */
    .contact-info {
      background: #fde0e0;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      margin-bottom: 20px;
            margin-top: 130px;

    }
    .contact-info h5 {
      color: #c30010;
      margin-bottom: 20px;
      font-weight: bold;
    }
    .contact-info p {
      font-size: 16px;
      color: #333;
      margin-bottom: 15px;
    }
    .contact-info i {
      margin-right: 10px;
      color: #f01e2c;
    }

    .contact-form {
      background: #fff0f0;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .contact-form label {
      font-weight: bold;
      margin-top: 10px;
    }
    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #de0a26;
      border-radius: 8px;
    }
    .contact-form button {
      background: #f01e2c;
      color: #fff;
      border: none;
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }
    .contact-form button:hover {
      background: #d1001f;
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

    /* Hover effect for contact card */
.contact-card, .contact-form {
  transition: transform 0.3s, box-shadow 0.3s;
}

.contact-card:hover, .contact-form:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}
/* Hover effect for left contact card */
.contact-card {
  transition: transform 0.3s, box-shadow 0.3s;
}

.contact-card:hover {
  transform: translateY(-5px); /* Slight lift */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
  background-color: #fff0f0; /* Optional subtle color change */
}
/* Hover effect for contact info cards */
.contact-info {
  transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
  border-radius: 12px;
  padding: 20px;
  background-color: #fff0f0; /* Base background */
}

.contact-info:hover {
  transform: translateY(-5px); /* Slight lift */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Shadow for depth */
  background-color: #fde0e0; /* Slight highlight on hover */
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
    <h2>Contact Us</h2>
    <p>Have questions or feedback? Reach out to us!</p>
  </div>

  <!-- Contact Section -->
  <div class="container mb-5">
    <div class="row g-4">

      <!-- Left Contact Info -->
      <div class="col-md-5">
        <div class="contact-info">
          <h5>Contact Information</h5>
          <p><i class="fas fa-map-marker-alt"></i> 123 Eco Street, Mumbai, India</p>
          <p><i class="fas fa-phone"></i> +91 8275005788</p>
          <p><i class="fas fa-envelope"></i> support@ecobin.com</p>
          <p><i class="fas fa-globe"></i> www.ecobin.com</p>
        </div>
      </div>

      <!-- Right Contact Form -->
      <div class="col-md-7">
        <div class="contact-form">
          <form id="contactForm">
            <label for="name">Full Name</label>
            <input type="text" id="name" placeholder="Your Name" required>

            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Your Email" required>

            <label for="subject">Subject</label>
            <input type="text" id="subject" placeholder="Subject" required>

            <label for="message">Message</label>
            <textarea id="message" rows="5" placeholder="Your Message" required></textarea>

            <button type="submit">Send Message</button>
          </form>
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
