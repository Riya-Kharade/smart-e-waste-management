<?php
session_start();
include("db.php");

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch counts from DB
$customer_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_customers FROM users WHERE role='customer'"))['total_customers'];
$kabadiwala_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_kabadiwalas FROM users WHERE role='kabadiwala'"))['total_kabadiwalas'];
$total_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users"))['total_users'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
body {margin:0;font-family:'Segoe UI',Arial,sans-serif;background:#f4f4f4;}
header {background:#c30010;color:#fff;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 3px 6px rgba(0,0,0,0.2);}
header h1 {margin:0;font-size:22px;}
header a {color:#fff;text-decoration:none;font-weight:bold;border:1px solid #fff;padding:5px 12px;border-radius:5px;transition:0.3s;}
header a:hover {background:#fff;color:#c30010;}

.container {display:flex;min-height:calc(100vh - 60px);}
.sidebar {width:250px;background:#fff;border-right:1px solid #f5c2c2ff;padding:20px;}
.sidebar a {display:block;color:#333;padding:12px 15px;margin-bottom:10px;border-radius:8px;text-decoration:none;transition:0.3s;}
.sidebar a:hover {background:#c30010;color:#fff;}

.main-content {flex:1;padding:20px;overflow-x:auto;}
.tab {display:none;}
.active-tab {display:block;}

.cards {display:flex;gap:20px;flex-wrap:wrap;}
.card {background:#fff0f0;border:2px solid #de0a26;border-radius:12px;padding:20px;flex:1;min-width:200px;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.1);transition:0.3s;}
.card i {font-size:50px;color:#f01e2c;margin-bottom:10px;}
.card:hover {transform:translateY(-5px);background:#fff5f5;}

table {width:100%;border-collapse:collapse;background:#fff;box-shadow:0 3px 6px rgba(0,0,0,0.1);border-radius:10px;overflow:hidden;margin-bottom:20px;}
table th, table td {padding:12px 10px;border-bottom:1px solid #ddd;text-align:left;}
table th {background:#f01e2c;color:#fff;}
table tr:hover {background:#ffe6e6;}
.btn {padding:6px 12px;background:#c30010;color:#fff;border-radius:6px;text-decoration:none;transition:0.3s;cursor:pointer;}
.btn:hover {background:#922b21;}

.progress-bar {width:100%;background:#ffe6e6;border-radius:8px;height:12px;margin:10px 0;overflow:hidden;}
.progress-bar .fill {height:100%;background:#f01e2c;border-radius:8px;}

.resource-list {list-style:none;padding:0;}
.resource-list li {margin-bottom:12px;}
.resource-list li a {color:#c30010;text-decoration:none;font-weight:bold;padding:5px 10px;border-radius:5px;transition:0.3s;}
.resource-list li a:hover {background:#f01e2c;color:#fff;}

/* Responsive */
@media screen and (max-width:900px){
    .container {flex-direction:column;}
    .sidebar {width:100%;}
    .cards {flex-direction:column;}
}
/* Centered search container */
.search-container {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center;     /* Center vertically if needed */
    max-width: 400px;
    margin: 20px auto;       /* Auto margin centers the container */
}

/* Search input field */
.search-container input[type="text"] {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 25px 0 0 25px;
    font-size: 16px;
    outline: none;
    transition: 0.3s all ease;
}

/* Focus effect */
.search-container input[type="text"]:focus {
    border-color: #c30010;
    box-shadow: 0 0 8px rgba(195, 0, 16, 0.3);
}

/* Search button */
.search-container button {
    padding: 10px 20px;
    background-color: #c30010;
    color: #fff;
    border: none;
    border-radius: 0 25px 25px 0;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s all ease;
}

/* Hover effect */
.search-container button:hover {
    background-color: #f01e2c;
    transform: scale(1.05);
}
/* ---------------- H2 Headings ---------------- */
.main-content h2 {
    font-size: 26px;                  /* Bigger text */
    font-weight: 700;                 /* Bold */
    color: #c30010;                   /* Main dashboard red */
    padding-bottom: 10px;             /* Space for underline */
    margin-bottom: 25px;              /* Space before content */
    text-transform: uppercase;        /* Optional uppercase */
    letter-spacing: 1px;              /* Slight spacing between letters */
    border-bottom: 4px solid;         /* Underline */
    border-image: linear-gradient(to right, #c30010, #f01e2c) 1; /* Gradient underline */
    text-shadow: 1px 1px 3px rgba(0,0,0,0.1); /* Subtle shadow */
    display: flex;
    align-items: center;
}

/* ---------------- Icons for each tab ---------------- */
.main-content h2 .icon {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    margin-right: 12px;
    font-size: 24px;
    color: #f01e2c;
}

/* Individual icons per section */
.customers-icon::before { content: "\f0c0"; }      /* Users icon */
.kabadiwalas-icon::before { content: "\f0d1"; }    /* Truck icon */
.pickup-icon::before { content: "\f2b5"; }         /* Hand-holding box */
.schedule-icon::before { content: "\f073"; }       /* Calendar icon */
.history-icon::before { content: "\f1da"; }        /* History/Clock icon */
.holiday-icon::before { content: "\f073"; }        /* Calendar icon */
.resources-icon::before { content: "\f02d"; }      /* File icon */

/* Sidebar container */
.sidebar {
    width: 250px;
    background: #fff;          /* white sidebar */
    color: #333;
    padding: 20px 0;
    border-right: 1px solid #ddd;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 12px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

/* Logo on top */
.sidebar .logo {
    text-align: center;
    margin-bottom: 25px;
    color: #c30010;
}
.sidebar .logo h3 {
    margin: 8px 0 0;
    font-size: 20px;
    font-weight: 700;
}

/* Sidebar links */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #333;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Sidebar icons */
.sidebar a i {
    font-size: 18px;
    width: 22px; /* aligns icons */
}

/* Hover & Active effects */
.sidebar a:hover,
.sidebar a.active {
    background: #c30010;      /* red highlight */
    color: #fff;
    transform: translateX(4px);
}

/* Optional: divider between links */
.sidebar a:not(:last-child) {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

/* Responsive sidebar for small screens */
@media (max-width: 900px) {
    .sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
    }
    .sidebar a {
        flex: 1;
        justify-content: center;
        border-left: none;
        border-bottom: 3px solid transparent;
    }
    .sidebar a:hover,
    .sidebar a.active {
        border-bottom: 3px solid #c30010;
        transform: none;
    }
}
/* Add smooth transition to link content */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #333;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden; /* to hide sliding overflow */
}

/* Icon slide effect */
.sidebar a i {
    font-size: 18px;
    width: 22px;
    transition: transform 0.3s ease;
}

/* Slide icon slightly on hover */
.sidebar a:hover i {
    transform: translateX(5px); /* slide 5px to right */
}

/* Add a subtle sliding underline effect */
.sidebar a::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0%;
    height: 3px;
    background: #fff;
    border-radius: 2px;
    transition: width 0.3s ease;
}

/* Grow underline on hover */
.sidebar a:hover::after {
    width: 100%;
}
.sidebar a:hover,
.sidebar a.active {
    background: #c30010;  /* red highlight */
    color: #fff;
    transform: translateX(0); /* keep main block static */
    transition: all 0.4s ease; /* smoother */
}
.cards {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

/* Card styles */
.card {
    flex: 1 1 320px;       /* larger minimum width */
    min-width: 320px;
    max-width: 380px;      /* larger max width */
    background: linear-gradient(145deg, #fff0f0, #ffe6e6);
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    padding: 30px;          /* increased padding */
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
}

.card h3 {
    margin: 15px 0;
    font-size: 1.5rem;       /* larger font */
    color: #c30010;
}

.card p {
    font-size: 1.2rem;       /* larger text */
    margin: 8px 0;
}

/* Icon circle */
.icon-circle {
    width: 70px;             /* larger circle */
    height: 70px;
    margin: 0 auto 15px auto;
    background: #c30010;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.icon-circle i {
    color: #fff;
    font-size: 28px;         /* larger icon */
}

/* Circular chart */
.circle-chart {
    width: 120px;            /* bigger chart */
    height: 120px;
    margin: 15px auto;
}

.circular-chart {
    display: block;
    max-width: 100%;
    max-height: 100%;
}

.circle-bg {
    fill: none;
    stroke: #eee;
    stroke-width: 4.5;
}

.circle {
    fill: none;
    stroke: #f01e2c;
    stroke-width: 4.5;
    stroke-linecap: round;
    transition: stroke-dasharray 0.6s ease;
}

.percentage {
    fill: #c30010;
    font-size: 0.65em;
    text-anchor: middle;
}

/* Pie chart card */
.card canvas {
    max-width: 100%;
    height: 220px;           /* increased size */
    margin: 0 auto;
}


</style>
</head>
<body>

<header>
    <h1>Welcome, Admin</h1>
    <a href="logout.php">Logout</a>
</header>

<div class="container">
    <div class="sidebar">
    <div class="logo">
        <i class="fas fa-recycle" style="font-size:32px;"></i>
        <h3>E-Waste Admin</h3>
    </div>
    <a href="#" data-tab="dashboard" class="active"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a href="#" data-tab="customers"><i class="fas fa-users"></i> Customers</a>
    <a href="#" data-tab="kabadiwalas"><i class="fas fa-truck"></i> Kabadiwalas</a>
    <a href="#" data-tab="pickup_requests"><i class="fas fa-box"></i> Pickup Requests</a>
    <a href="#" data-tab="schedules"><i class="fas fa-calendar-alt"></i> Schedules</a>
    <a href="#" data-tab="pickup_history"><i class="fas fa-history"></i> Pickup History</a>
    <a href="#" data-tab="holiday_notices"><i class="fas fa-bell"></i> Holiday Notices</a>
    <a href="#" data-tab="resources"><i class="fas fa-folder-open"></i> Resources</a>
</div>


    <div class="main-content">

       <!-- Dashboard -->
<div id="dashboard" class="tab active-tab">
    <h2><span class="icon dashboard-icon"></span>Dashboard Overview</h2>
    <div class="cards">
        
        <!-- Customers Card -->
        <div class="card">
            <div class="icon-circle"><i class="fas fa-users"></i></div>
            <h3>Customers</h3>
            
            <!-- Circular chart -->
            <div class="circle-chart">
                <svg viewBox="0 0 36 36" class="circular-chart red">
                    <path class="circle-bg"
                          d="M18 2.0845
                             a 15.9155 15.9155 0 0 1 0 31.831
                             a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <path class="circle"
                          stroke-dasharray="<?php echo $total_count ? round(($customer_count/$total_count)*100) : 0; ?>, 100"
                          d="M18 2.0845
                             a 15.9155 15.9155 0 0 1 0 31.831
                             a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <text x="18" y="20" class="percentage"><?php echo $total_count ? round(($customer_count/$total_count)*100) : 0; ?>%</text>
                </svg>
            </div>
            
            <p><strong><?php echo $customer_count; ?></strong> Users</p>
        </div>

        <!-- Kabadiwalas Card -->
        <div class="card">
            <div class="icon-circle"><i class="fas fa-truck"></i></div>
            <h3>Kabadiwalas</h3>
            
            <!-- Circular chart -->
            <div class="circle-chart">
                <svg viewBox="0 0 36 36" class="circular-chart red">
                    <path class="circle-bg"
                          d="M18 2.0845
                             a 15.9155 15.9155 0 0 1 0 31.831
                             a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <path class="circle"
                          stroke-dasharray="<?php echo $total_count ? round(($kabadiwala_count/$total_count)*100) : 0; ?>, 100"
                          d="M18 2.0845
                             a 15.9155 15.9155 0 0 1 0 31.831
                             a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <text x="18" y="20" class="percentage"><?php echo $total_count ? round(($kabadiwala_count/$total_count)*100) : 0; ?>%</text>
                </svg>
            </div>
            
            <p><strong><?php echo $kabadiwala_count; ?></strong> Users</p>
        </div>

        <!-- Pie Chart Card -->
        <div class="card">
            <i class="fas fa-chart-pie"></i>
            <canvas id="userChart" width="200" height="200"></canvas>
        </div>

    </div>

    
</div>

<!-- Customers -->
<div id="customers" class="tab">
<h2><span class="icon customers-icon"></span>Customers List</h2>
<div class="search-container">
    <input type="text" id="searchCustomers" placeholder="Search Customers...">
    <button onclick="searchTable('customersTable','searchCustomers')">Search</button>
</div>
<table id="customersTable">
    <tr><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
    <?php
    $cust = mysqli_query($conn, "SELECT * FROM users WHERE role='customer'");
    while($row = mysqli_fetch_assoc($cust)){
        echo "<tr data-id='{$row['id']}'>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>
                <button class='btn edit' data-id='{$row['id']}'>Edit</button>
                <button class='btn delete' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>";
    }
    ?>
</table>
</div>



<!-- Kabadiwalas -->
<div id="kabadiwalas" class="tab">
<h2><span class="icon kabadiwalas-icon"></span>Kabadiwalas List</h2>
<div class="search-container">
    <input type="text" id="searchKabadiwalas" placeholder="Search Kabadiwalas...">
    <button onclick="searchTable('kabadiwalasTable','searchKabadiwalas')">Search</button>
</div>
<table id="kabadiwalasTable">
    <tr><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
    <?php
    $kab = mysqli_query($conn, "SELECT * FROM users WHERE role='kabadiwala'");
    while($row = mysqli_fetch_assoc($kab)){
        echo "<tr data-id='{$row['id']}'>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>
                <button class='btn edit' data-id='{$row['id']}'>Edit</button>
                <button class='btn delete' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>";
    }
    ?>
</table>
</div>


        <!-- Pickup Requests -->
        <div id="pickup_requests" class="tab">
<h2><span class="icon pickup-icon"></span>Pickup Requests</h2>
            <table id="requestsTable">
                <tr>
                    <th>Customer</th><th>Gadgets</th><th>Weight</th><th>Mobile</th>
                    <th>Address</th><th>City</th><th>Pincode</th><th>Kabadiwala</th>
                    <th>Status</th><th>Action</th>
                </tr>
                <?php
                $requests = mysqli_query($conn, "
                    SELECT ps.*, u.name AS customer_name, k.id AS kabadiwala_id, k.name AS kabadiwala_name
                    FROM pickup_schedule ps
                    LEFT JOIN users u ON ps.customer_id = u.id
                    LEFT JOIN users k ON ps.kabadiwala_id = k.id
                    WHERE ps.status='Pending' OR ps.status='Not Acceptable'
                    ORDER BY ps.created_at DESC
                ");
                while($row = mysqli_fetch_assoc($requests)){
                    echo "<tr data-id='{$row['id']}'>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['gadgets']}</td>
                        <td>{$row['weight_kg']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['pincode']}</td>
                        <td>
                            <select class='kabadiwalaSelect'>";
                                $kabadiwalas = mysqli_query($conn, "SELECT id,name FROM users WHERE role='kabadiwala'");
                                while($k = mysqli_fetch_assoc($kabadiwalas)){
                                    $sel = ($k['id'] == ($row['kabadiwala_id'] ?? 0)) ? 'selected' : '';
                                    echo "<option value='{$k['id']}' $sel>{$k['name']}</option>";
                                }
                    echo "</select>
                        </td>
                        <td>
                            <select class='statusSelect'>
                                <option value='Pending' ".($row['status']=='Pending'?'selected':'').">Pending</option>
                                <option value='Scheduled' ".($row['status']=='Scheduled'?'selected':'').">Scheduled</option>
                                <option value='Not Acceptable' ".($row['status']=='Not Acceptable'?'selected':'').">Not Acceptable</option>
                            </select>
                        </td>
                        <td><button class='btn updateRequest'>Update</button></td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Schedules -->
        <div id="schedules" class="tab">
<h2><span class="icon schedule-icon"></span>Schedules</h2>
            <table id="schedulesTable">
                <tr>
                    <th>Customer</th><th>Kabadiwala</th><th>Gadgets</th><th>Weight</th>
                    <th>Pickup Day</th><th>Pickup Time</th><th>Status</th><th>Action</th>
                </tr>
                <?php
                $schedules = mysqli_query($conn, "
                    SELECT ps.*, c.name AS customer_name, k.name AS kabadiwala_name
                    FROM pickup_schedule ps
                    LEFT JOIN users c ON ps.customer_id = c.id
                    LEFT JOIN users k ON ps.kabadiwala_id = k.id
                    WHERE ps.status='Scheduled'
                    ORDER BY ps.pickup_day, ps.pickup_time
                ");
                while($row = mysqli_fetch_assoc($schedules)){
                    echo "<tr data-id='{$row['id']}'>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['kabadiwala_name']}</td>
                        <td>{$row['gadgets']}</td>
                        <td>{$row['weight_kg']}</td>
                        <td>{$row['pickup_day']}</td>
                        <td>{$row['pickup_time']}</td>
                        <td>
                            <select class='statusSelect'>
                                <option value='Scheduled' ".($row['status']=='Scheduled'?'selected':'').">Scheduled</option>
                                <option value='Completed' ".($row['status']=='Completed'?'selected':'').">Completed</option>
                            </select>
                        </td>
                        <td><button class='btn updateSchedule'>Update</button></td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Pickup History -->
        <div id="pickup_history" class="tab">
<h2><span class="icon history-icon"></span>Pickup History</h2>
            <table id="historyTable">
                <tr>
                    <th>ID</th><th>Customer</th><th>Kabadiwala</th><th>Gadgets</th>
                    <th>Weight (Kg)</th><th>Mobile</th><th>Address</th><th>City</th>
                    <th>Pincode</th><th>Pickup Day</th><th>Pickup Time</th><th>Status</th><th>Created At</th>
                </tr>
                <?php
                $history = mysqli_query($conn, "
                    SELECT ps.*, c.name AS customer_name, k.name AS kabadiwala_name
                    FROM pickup_schedule ps
                    LEFT JOIN users c ON ps.customer_id = c.id
                    LEFT JOIN users k ON ps.kabadiwala_id = k.id
                    WHERE ps.status='Completed' OR ps.status='Not Acceptable'
                    ORDER BY ps.created_at DESC
                ");
                while($row = mysqli_fetch_assoc($history)){
                    $created_at = isset($row['created_at']) && $row['created_at'] != '' ? date("d M Y H:i", strtotime($row['created_at'])) : "-";
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['kabadiwala_name']}</td>
                        <td>{$row['gadgets']}</td>
                        <td>{$row['weight_kg']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['pincode']}</td>
                        <td>{$row['pickup_day']}</td>
                        <td>{$row['pickup_time']}</td>
                        <td>{$row['status']}</td>
                        <td>$created_at</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Holiday Notices -->
        <div id="holiday_notices" class="tab">
<h2><span class="icon holiday-icon"></span>Holiday Notices</h2>
            <form id="addHolidayForm" style="margin-bottom:20px;">
                <input type="date" name="notice_date" required>
                <input type="text" name="description" placeholder="Description" required>
                <button type="submit" class="btn">Add Holiday</button>
            </form>
            <table id="holidayTable">
                <tr><th>Date</th><th>Description</th><th>Action</th></tr>
                <?php
                $holidays = mysqli_query($conn, "SELECT * FROM holiday_notices ORDER BY notice_date DESC");
                while($row = mysqli_fetch_assoc($holidays)){
                    $notice_date = isset($row['notice_date']) && $row['notice_date'] != '' ? date("d M Y", strtotime($row['notice_date'])) : "-";
                    echo "<tr data-id='{$row['id']}'>
                        <td>$notice_date</td>
                        <td class='desc'>{$row['description']}</td>
                        <td><button class='btn deleteHoliday'>Delete</button></td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Resources -->
        <div id="resources" class="tab">
<h2><span class="icon resources-icon"></span>Resources</h2>
            <ul class="resource-list">
                <li><a href="docs/price_list.pdf" target="_blank">Price List</a></li>
                <li><a href="docs/recycling_guide.pdf" target="_blank">Recycling Guide</a></li>
            </ul>
        </div>

    </div>
</div>

<script>
// ---------------- Tab switching ----------------
document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function(e){
        e.preventDefault();
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active-tab'));
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active-tab');
    });
});

// ---------------- Pie chart ----------------
const ctx = document.getElementById('userChart').getContext('2d');
new Chart(ctx, {
    type:'pie',
    data:{
        labels:['Customers','Kabadiwalas'],
        datasets:[{
            data:[<?php echo $customer_count; ?>,<?php echo $kabadiwala_count; ?>],
            backgroundColor:['#f01e2c','#c30010'],
            borderColor:['#fff','#fff'],
            borderWidth:2
        }]
    },
    options:{responsive:true,plugins:{legend:{position:'bottom'}}}
});

// ---------------- Update Pickup Requests ----------------
document.querySelectorAll('.updateRequest').forEach(btn => {
    btn.addEventListener('click', function(){
        const tr = this.closest('tr');
        const id = tr.dataset.id;
        const status = tr.querySelector('.statusSelect').value;
        const kabadiwala_id = tr.querySelector('.kabadiwalaSelect').value;

        fetch('update_pickup_request.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`id=${id}&status=${status}&kabadiwala_id=${kabadiwala_id}`
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            location.reload(); // refresh table
        });
    });
});

// ---------------- Update Schedule ----------------
document.querySelectorAll('.updateSchedule').forEach(btn=>{
    btn.addEventListener('click', function(){
        const tr = this.closest('tr');
        const id = tr.dataset.id;
        const status = tr.querySelector('.statusSelect').value;

        fetch('update_schedule.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`id=${id}&status=${status}`
        })
        .then(res=>res.text())
        .then(data=>{
            alert(data);
            location.reload();
        });
    });
});

// ---------------- Delete Holiday ----------------
document.querySelectorAll('.deleteHoliday').forEach(btn=>{
    btn.addEventListener('click', function(){
        const tr = this.closest('tr');
        const id = tr.dataset.id;

        if(confirm("Are you sure to delete this holiday?")){
            fetch('delete_holiday.php',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:`id=${id}`
            })
            .then(res=>res.text())
            .then(data=>{
                alert(data);
                tr.remove();
            });
        }
    });
});

// ---------------- Add Holiday ----------------
document.getElementById('addHolidayForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_holiday.php',{
        method:'POST',
        body:formData
    })
    .then(res=>res.text())
    .then(data=>{
        alert(data);
        location.reload();
    });
});

// ---------------- Searchbar ----------------

function searchTable(tableId, inputId) {
    let input = document.getElementById(inputId);
    let filter = input.value.toLowerCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) { // skip header row
        let tdArray = tr[i].getElementsByTagName("td");
        let show = false;

        for (let j = 0; j < tdArray.length - 1; j++) { // skip Actions column
            if (tdArray[j].innerText.toLowerCase().indexOf(filter) > -1) {
                show = true;
                break;
            }
        }

        tr[i].style.display = show ? "" : "none";
    }
}

// ---------------- Customers Edit ----------------
document.querySelectorAll('#customers .edit').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        // Open the edit page (update_customer.php)
        window.location.href = 'update_customer.php?id=' + id;
    });
});

// ---------------- Customers Delete ----------------
document.querySelectorAll('#customers .delete').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        if(confirm("Are you sure you want to delete this customer?")){
            fetch('delete_customer.php',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:'id='+id
            })
            .then(res => res.text())
            .then(data=>{
                alert(data);
                location.reload(); // Refresh table
            });
        }
    });
});

// ---------------- Kabadiwalas Edit ----------------
document.querySelectorAll('#kabadiwalas .edit').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        // Open the edit page (update_kabadiwala.php)
        window.location.href = 'update_kabadiwala.php?id=' + id;
    });
});

// ---------------- Kabadiwalas Delete ----------------
document.querySelectorAll('#kabadiwalas .delete').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        if(confirm("Are you sure you want to delete this Kabadiwala?")){
            fetch('delete_kabadiwala.php',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:'id='+id
            })
            .then(res => res.text())
            .then(data=>{
                alert(data);   // <-- Show server response
                if(data.includes("successfully")){
                    location.reload(); // Only reload if successful
                }
            });
        }
    });
});

document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        // remove active from all links
        document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
        this.classList.add('active'); // set current as active

        // show corresponding tab
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active-tab'));
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active-tab');
    });
});


</script>

</body>
</html>
