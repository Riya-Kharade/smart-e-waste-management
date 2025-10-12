<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecobin - FAQs</title>
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      padding-top: 80px; /* space for fixed navbar */
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
      margin-top: 30px; /* space from top header */
    }
    .page-title h2 {
      color: #de0a26;
      font-size: 38px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .page-title p {
      color: #555;
      font-size: 18px;
    }

    /* Accordion */
    .accordion-item {
      border: 2px solid #de0a26;
      border-radius: 12px;
      margin-bottom: 20px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .accordion-item:hover {
      transform: translateY(-3px);
    }
    .accordion-header {
      background: #fde0e0;
      padding: 20px 25px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 20px;
      font-weight: 600;
      color: #c30010;
      transition: background 0.3s;
    }
    .accordion-header:hover {
      background: #ffd6d6;
    }
    .accordion-body {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease;
      padding: 0 25px;
      background: #fff0f0;
    }
    .accordion-body p {
      padding: 20px 0;
      margin: 0;
      font-size: 17px;
      color: #333;
      line-height: 1.6;
    }
    .accordion-header i {
      transition: transform 0.3s;
      font-size: 18px;
    }
    .accordion-header.active i {
      transform: rotate(180deg);
    }

    /* Button */
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
    <h2>Frequently Asked Questions (FAQs)</h2>
    <p>All you need to know about Ecobin and e-waste management.</p>
  </div>

  <!-- FAQ Section -->
  <div class="container mb-5" id="faq">
    <!-- Question 1 -->
    <div class="accordion-item">
      <div class="accordion-header">
        How do I schedule an e-waste pickup?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>Customers can register or login to their account and schedule pickups using the “Schedule Pickup” option. Select a date, type of e-waste, and confirm the request.</p>
      </div>
    </div>

    <!-- Question 2 -->
    <div class="accordion-item">
      <div class="accordion-header">
        What type of e-waste can I dispose of?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>We accept small electronics, mobile phones, laptops, printers, cables, and household appliances. Hazardous chemicals or large appliances may require special handling.</p>
      </div>
    </div>

    <!-- Question 3 -->
    <div class="accordion-item">
      <div class="accordion-header">
        How do kabadiwalas collect e-waste?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>Kabadiwalas receive requests from the system, visit the customer location, collect e-waste safely, and update the status in the dashboard.</p>
      </div>
    </div>

    <!-- Question 4 -->
    <div class="accordion-item">
      <div class="accordion-header">
        How can I track my pickup request?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>After scheduling, customers can view the status of each request in their dashboard in real-time, ensuring transparency.</p>
      </div>
    </div>

    <!-- Question 5 -->
    <div class="accordion-item">
      <div class="accordion-header">
        Is my personal information safe?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>Yes, Ecobin keeps all personal information secure. Data is stored safely and used only for service management and notifications.</p>
      </div>
    </div>

    <!-- Question 6 -->
    <div class="accordion-item">
      <div class="accordion-header">
        How is e-waste recycled or disposed?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>Kabadiwalas follow proper recycling protocols. Electronics are sent to authorized recycling centers to extract valuable materials and reduce environmental impact.</p>
      </div>
    </div>

    <!-- Question 7 -->
    <div class="accordion-item">
      <div class="accordion-header">
        Can I reschedule or cancel a pickup?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>Yes, pickups can be rescheduled or canceled anytime through your dashboard before the scheduled pickup date.</p>
      </div>
    </div>

    <!-- Question 8 -->
    <div class="accordion-item">
      <div class="accordion-header">
        How does Ecobin benefit the environment?
        <i class="fas fa-chevron-down"></i>
      </div>
      <div class="accordion-body">
        <p>By ensuring proper e-waste collection, recycling, and disposal, Ecobin reduces harmful landfill waste and promotes eco-friendly practices.</p>
      </div>
    </div>
  </div>

  <!-- Back to Home Button -->
  <div class="text-center mb-5">
    <a href="index.php" class="btn btn-custom btn-lg">
      <i class="fas fa-home"></i> Back to Home
    </a>
  </div>

  <!-- JavaScript for Accordion -->
  <script>
    const headers = document.querySelectorAll(".accordion-header");
    headers.forEach(header => {
      header.addEventListener("click", () => {
        header.classList.toggle("active");
        const body = header.nextElementSibling;
        if(body.style.maxHeight) {
          body.style.maxHeight = null;
        } else {
          body.style.maxHeight = body.scrollHeight + "px";
        }
      });
    });
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
