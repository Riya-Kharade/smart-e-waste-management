<?php
session_start();
include("db.php");

// --- Check if user is logged in ---
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// --- Fetch user profile ---
$profile_sql = "SELECT id, name, email, phone FROM users WHERE id='$user_id'";
$profile_result = mysqli_query($conn, $profile_sql);

if(!$profile_result || mysqli_num_rows($profile_result) == 0){
    // User not found
    header("Location: login.php");
    exit();
}

$profile = mysqli_fetch_assoc($profile_result);

// --- Update Profile ---
if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $update_sql = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: customer_dashboard.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update profile!";
        header("Location: customer_dashboard.php");
        exit();
    }
}

// --- Add Pickup Request ---
if (isset($_POST['add_pickup'])) {
    $gadgets = trim($_POST['gadgets']);
    $weight = trim($_POST['weight']);
    $mobile = trim($_POST['mobile']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $pincode = trim($_POST['pincode']);
    $pickup_day = trim($_POST['pickup_day']);
    $pickup_time = trim($_POST['pickup_time']);

    $insert_sql = "INSERT INTO pickup_schedule 
        (customer_id, gadgets, weight_kg, mobile, address, city, pincode, pickup_day, pickup_time) 
        VALUES ('$user_id','$gadgets','$weight','$mobile','$address','$city','$pincode','$pickup_day','$pickup_time')";

    if (mysqli_query($conn, $insert_sql)) {
        $_SESSION['message'] = "Pickup request added successfully!";
        header("Location: customer_dashboard.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to add pickup request!";
        header("Location: customer_dashboard.php");
        exit();
    }
}

// --- Fetch Pickup Schedule ---
$schedule_sql = "SELECT ps.*, u.name as kabadiwala_name, u.phone as kabadiwala_phone 
                 FROM pickup_schedule ps 
                 LEFT JOIN users u ON ps.kabadiwala_id = u.id 
                 WHERE ps.customer_id='$user_id' 
                 ORDER BY ps.created_at DESC";
$schedule_result = mysqli_query($conn, $schedule_sql);

// --- Fetch Holiday Notices ---
$holiday_sql = "SELECT * FROM holiday_notices ORDER BY notice_date DESC";
$holiday_result = mysqli_query($conn, $holiday_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
/* ... your existing CSS ... */
</style>
<script>
function showSection(sectionId){
    document.querySelectorAll('.section').forEach(s=>s.style.display='none');
    const el = document.getElementById(sectionId);
    if(el) el.style.display='block';
}
</script>
<style>
body {font-family: 'Segoe UI', Arial, sans-serif; margin:0; background:#fdf2f2;}
.header {background:#c0392b; color:#fff; padding:15px 30px; display:flex; justify-content:space-between; align-items:center;}
.header h1 {margin:0; font-size:20px;}
.header .profile {text-align:right;}
.header .profile a {color:#fff;text-decoration:none;font-weight:bold;border:1px solid #fff;padding:5px 12px;border-radius:5px;transition:0.3s;}
.header .profile a:hover {background:#fff;color:#c30010;}
.container {display:grid; grid-template-columns:250px 1fr; min-height:calc(100vh - 60px);}
.sidebar {background:#fff; border-right:1px solid #ddd; padding:20px;}
.sidebar a {display:block; text-decoration:none; color:#333; padding:12px 15px; margin-bottom:10px; border-radius:8px;}
.sidebar a:hover {background:#c0392b; color:#fff;}
.content {padding:20px;}
.card {background:#fff; padding:20px; margin-bottom:20px; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.08);}
.card h2 {margin-top:0; font-size:18px; color:#c0392b;}
.btn {display:inline-block; background:#c0392b; color:#fff; padding:8px 15px; border-radius:6px; text-decoration:none; margin-top:8px;}
.btn:hover {background:#922b21;}
textarea, input[type=text], input[type=number], input[type=email] {width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; margin-bottom:10px;}
input[type=submit] {background:#c0392b; color:#fff; border:none; padding:8px 15px; border-radius:6px; cursor:pointer;}
input[type=submit]:hover {background:#922b21;}
.hidden {display:none;}
@media (max-width:1024px) {.container {grid-template-columns:200px 1fr;} .header h1 {font-size:18px;} .sidebar a {font-size:14px; padding:10px 12px;} .card h2 {font-size:16px;} }
@media (max-width:768px) {.container {grid-template-columns:1fr;} .sidebar {display:flex; flex-wrap:wrap; justify-content:space-around; border-right:none; border-bottom:1px solid #ddd;} .sidebar a {flex:1 1 45%; text-align:center; margin-bottom:8px;} .header {flex-direction:column; text-align:center; padding:10px;} }
@media (max-width:480px) {.header h1 {font-size:16px;} .sidebar a {flex:1 1 100%; padding:8px; font-size:13px;} .card {padding:15px;} input, textarea {padding:6px;} input[type=submit], .btn {padding:6px 10px; font-size:13px;} }
/* --- General Styles --- */
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    background: #fdf2f2;
    color: #333;
}
.header {
    background: #c0392b;
    color: #fff;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.header h1 {
    margin: 0;
    font-size: 22px;
}
.header .profile a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #fff;
    padding: 5px 12px;
    border-radius: 5px;
    transition: 0.3s;
}
.header .profile a:hover {
    background: #fff;
    color: #c30010;
}

/* --- Container and Sidebar --- */
.container {
    display: grid;
    grid-template-columns: 250px 1fr;
    min-height: calc(100vh - 60px);
}
.sidebar {
    background: #fff;
    border-right: 1px solid #ddd;
    padding: 20px;
    display: flex;
    flex-direction: column;
}
.sidebar a {
    display: block;
    text-decoration: none;
    color: #333;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
}
.sidebar a i {
    margin-right: 8px;
}
.sidebar a:hover {
    background: #c0392b;
    color: #fff;
}

/* --- Content Area --- */
.content {
    padding: 20px;
}
.card {
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-3px);
}
.card h2 {
    margin-top: 0;
    font-size: 20px;
    color: #c0392b;
}
.card p {
    font-size: 14px;
    line-height: 1.6;
}
.btn {
    display: inline-block;
    background: #c0392b;
    color: #fff;
    padding: 8px 15px;
    border-radius: 6px;
    text-decoration: none;
    margin-top: 8px;
    transition: 0.3s;
}
.btn:hover {
    background: #922b21;
}

/* --- Forms --- */
form input, form textarea, form select {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
    font-size: 14px;
}
form input[type=submit] {
    background: #c0392b;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}
form input[type=submit]:hover {
    background: #922b21;
}

/* --- Pickup Schedule List --- */
#schedule ul {
    list-style: none;
    padding: 0;
}
#schedule li {
    padding: 10px;
    margin-bottom: 10px;
    border-left: 4px solid #c0392b;
    background: #fff5f5;
    border-radius: 6px;
    font-size: 14px;
}

/* --- Holiday Notices --- */
#holiday ul {
    list-style: none;
    padding: 0;
}
#holiday li {
    padding: 10px;
    margin-bottom: 10px;
    border-left: 4px solid #c0392b;
    background: #fff5f5;
    border-radius: 6px;
    font-size: 14px;
}

/* --- Chat / Messages --- */
#messages #chat-box {
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background: #f9f9f9;
}
#messages #chat-box div {
    margin: 5px 0;
    max-width: 70%;
    padding: 10px;
    border-radius: 10px;
    font-size: 14px;
}
#messages #chat-box .you {
    background: #c0392b;
    color: #fff;
    margin-left: auto;
}
#messages #chat-box .kabadiwala {
    background: #eee;
    color: #000;
    margin-right: auto;
}
#messages textarea {
    height: 80px;
    resize: none;
}

/* --- Responsive --- */
@media (max-width:1024px) {
    .container {grid-template-columns: 200px 1fr;}
    .header h1 {font-size: 18px;}
    .sidebar a {font-size: 14px; padding: 10px 12px;}
    .card h2 {font-size: 18px;}
}
@media (max-width:768px) {
    .container {grid-template-columns: 1fr;}
    .sidebar {display:flex; flex-wrap:wrap; justify-content:space-around; border-right:none; border-bottom:1px solid #ddd;}
    .sidebar a {flex:1 1 45%; text-align:center; margin-bottom:8px;}
    .header {flex-direction:column; text-align:center; padding:10px;}
}
@media (max-width:480px) {
    .header h1 {font-size:16px;}
    .sidebar a {flex:1 1 100%; padding:8px; font-size:13px;}
    .card {padding:15px;}
    input, textarea {padding:6px;}
    input[type=submit], .btn {padding:6px 10px; font-size:13px;}
}

</style>

</head>
<body>

<div class="header">
<h1>Welcome, <?php echo htmlspecialchars($profile['name']); ?></h1>
<div class="profile">
    <a href="logout.php">Logout</a>
</div>
</div>

<div class="container">
<div class="sidebar" style="background:#ffe6e6;">
    <a href="javascript:void(0)" onclick="showSection('home')"><i class="fa fa-home"></i> Home</a>
    <a href="javascript:void(0)" onclick="showSection('profile')"><i class="fa fa-user"></i> Your Profile</a>
    <a href="javascript:void(0)" onclick="showSection('pickup')"><i class="fa fa-plus"></i> Add Pickup Request</a>
    <a href="javascript:void(0)" onclick="showSection('schedule')"><i class="fa fa-calendar"></i> View Schedule</a>
    <a href="javascript:void(0)" onclick="showSection('messages')"><i class="fa fa-envelope"></i> Send Message</a> <!-- NEW -->
    <a href="javascript:void(0)" onclick="showSection('holiday')"><i class="fa fa-bullhorn"></i> Holiday Notices</a>
    <a href="javascript:void(0)" onclick="showSection('resources')"><i class="fa fa-book"></i> Resources</a>
</div>


<div class="content">

<?php
if(!empty($_SESSION['message'])){
    echo "<div class='card' style='background:#d4edda;color:#155724;'>".$_SESSION['message']."</div>";
    unset($_SESSION['message']);
}
?>
<div id="home" class="section">

    <!-- Welcome Card -->
<div class="card" style="color:#c0392b; text-align:center; padding:30px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1);">
    <h2 style="font-size:32px; margin:0;">Welcome, <?php echo htmlspecialchars($profile['name']); ?>!</h2>
    <p style="margin-top:10px; font-size:18px; color:#555;">Use the menu to manage your pickups, profile, and messages.</p>
</div>


    <!-- Role & Stats Card -->
    <div class="card" style="margin-top:25px; padding:25px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1)">
        <h3 style="color:#c0392b; margin-bottom:15px;">Role: Customer</h3>
        <p style="font-size:16px; margin-bottom:20px;">As a customer, you can request pickups, view your schedule, check messages, and access resources.</p>

        <?php
        $total_pickup = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM pickup_schedule WHERE customer_id='$user_id'"))['total'];
        $pending_pickup = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM pickup_schedule WHERE customer_id='$user_id' AND status='Pending'"))['total'];
        $assigned_pickup = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM pickup_schedule WHERE customer_id='$user_id' AND status='Assigned'"))['total'];
        $completed_pickup = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM pickup_schedule WHERE customer_id='$user_id' AND status='Completed'"))['total'];
        ?>

        <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">
            <div style="flex:1; min-width:120px; background:#ff6f61; color:#fff; padding:20px; border-radius:12px; text-align:center; font-weight:bold; box-shadow:0 4px 10px rgba(0,0,0,0.2);">
                <i class="fa fa-calendar" style="font-size:20px;"></i>
                <p style="margin:5px 0; font-size:22px;"><?php echo $total_pickup; ?></p>
                <span>Total</span>
            </div>
            <div style="flex:1; min-width:120px; background:#ffa69e; color:#fff; padding:20px; border-radius:12px; text-align:center; font-weight:bold; box-shadow:0 4px 10px rgba(0,0,0,0.2);">
                <i class="fa fa-hourglass-start" style="font-size:20px;"></i>
                <p style="margin:5px 0; font-size:22px;"><?php echo $pending_pickup; ?></p>
                <span>Pending</span>
            </div>
            <div style="flex:1; min-width:120px; background:#ff3d00; color:#fff; padding:20px; border-radius:12px; text-align:center; font-weight:bold; box-shadow:0 4px 10px rgba(0,0,0,0.2);">
                <i class="fa fa-check-circle" style="font-size:20px;"></i>
                <p style="margin:5px 0; font-size:22px;"><?php echo $assigned_pickup; ?></p>
                <span>Assigned</span>
            </div>
            <div style="flex:1; min-width:120px; background:#ff8a65; color:#fff; padding:20px; border-radius:12px; text-align:center; font-weight:bold; box-shadow:0 4px 10px rgba(0,0,0,0.2);">
                <i class="fa fa-check" style="font-size:20px;"></i>
                <p style="margin:5px 0; font-size:22px;"><?php echo $completed_pickup; ?></p>
                <span>Completed</span>
            </div>
        </div>

        <!-- Buttons -->
        <div style="margin-top:25px; display:flex; gap:20px; flex-wrap:wrap;">
            <a href="javascript:void(0)" onclick="showSection('pickup')" class="btn" style="flex:1; min-width:180px; font-size:18px; padding:18px; background:#c0392b; color:#fff; border-radius:12px; text-align:center; transition:0.3s; box-shadow:0 4px 12px rgba(0,0,0,0.3);">Request Pickup</a>
            <a href="javascript:void(0)" onclick="showSection('schedule')" class="btn" style="flex:1; min-width:180px; font-size:18px; padding:18px; background:#e74c3c; color:#fff; border-radius:12px; text-align:center; transition:0.3s; box-shadow:0 4px 12px rgba(0,0,0,0.3);">View Schedule</a>
        </div>
    </div>

    <!-- Recent Pickup Requests Card -->
    <div class="card" style="margin-top:25px; padding:20px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); ">
        <h3 style="color:#c0392b; margin-bottom:15px;">Recent Pickup Requests</h3>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f8f9fa;">
                    <th style="padding:8px; border:1px solid #ddd;">Date</th>
                    <th style="padding:8px; border:1px solid #ddd;">Time</th>
                    <th style="padding:8px; border:1px solid #ddd;">Gadgets</th>
                    <th style="padding:8px; border:1px solid #ddd;">Weight (Kg)</th>
                    <th style="padding:8px; border:1px solid #ddd;">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $history_sql = "SELECT ps.*, u.name as kabadiwala_name 
                            FROM pickup_schedule ps 
                            LEFT JOIN users u ON ps.kabadiwala_id = u.id 
                            WHERE ps.customer_id='$user_id' 
                            ORDER BY ps.created_at DESC LIMIT 5";
            $history_result = mysqli_query($conn, $history_sql);
            if(mysqli_num_rows($history_result) == 0){
                echo '<tr><td colspan="5" style="padding:10px; text-align:center;">No pickups yet</td></tr>';
            } else {
                while($row = mysqli_fetch_assoc($history_result)):
                    $status = $row['status'];
                    $status_color = $status=='Pending'?'#fff3cd':($status=='Assigned'?'#d4edda':'#c8e6c9');
            ?>
                <tr style="background:<?php echo $status_color; ?>;">
                    <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($row['pickup_day']); ?></td>
                    <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($row['pickup_time']); ?></td>
                    <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($row['gadgets']); ?></td>
                    <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($row['weight_kg']); ?></td>
                    <td style="padding:8px; border:1px solid #ddd;"><?php echo $status; ?></td>
                </tr>
            <?php endwhile; } ?>
            </tbody>
        </table>
    </div>

</div>


<div id="profile" class="section card hidden" style="max-width:600px; margin:30px auto; padding:30px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff; text-align:center;">
    <h2 style="color:#c0392b; margin-bottom:25px; display:inline-flex; justify-content:center; gap:10px;">
        <i class="fa fa-user" style="font-size:28px;"></i> Your Profile
    </h2>
    <form method="POST" style="display:flex; flex-direction:column; gap:15px; text-align:left;">
        <label style="font-weight:bold; color:#555;">Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" required style="padding:12px; border-radius:8px; border:1px solid #ccc; font-size:16px;">

        <label style="font-weight:bold; color:#555;">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required style="padding:12px; border-radius:8px; border:1px solid #ccc; font-size:16px;">

        <label style="font-weight:bold; color:#555;">Phone (cannot change)</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>" disabled style="padding:12px; border-radius:8px; border:1px solid #ccc; font-size:16px; background:#f5f5f5;">

        <input type="submit" name="update_profile" value="Update Profile" style="padding:15px; border:none; border-radius:10px; background:#c0392b; color:#fff; font-size:18px; font-weight:bold; cursor:pointer; transition:0.3s;">
    </form>
</div>


<div id="pickup" class="section hidden" style="max-width:750px; margin:30px auto;">
    <!-- Pickup Card -->
    <div class="card" style="padding:30px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff;">
        <h2 style="color:#c0392b; margin-bottom:25px; display:flex; align-items:center; gap:10px;">
            <i class="fa fa-truck" style="font-size:28px;"></i> Add Pickup Request
        </h2>

        <form method="POST" style="display:flex; flex-direction:column; gap:20px;">

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Gadgets</label>
                <input type="text" name="gadgets" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Weight (Kg)</label>
                <input type="number" step="0.1" name="weight" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Mobile</label>
                <input type="text" name="mobile" value="<?php echo htmlspecialchars($profile['phone']); ?>" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Address</label>
                <input type="text" name="address" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">City</label>
                <input type="text" name="city" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Pincode</label>
                <input type="text" name="pincode" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Pickup Day</label>
                <input type="date" name="pickup_day" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <div style="display:flex; align-items:center; gap:15px;">
                <label style="width:150px; font-weight:bold; color:#555;">Pickup Time</label>
                <input type="time" name="pickup_time" required style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
            </div>

            <input type="submit" name="add_pickup" value="Add Pickup" style="padding:15px; border:none; border-radius:10px; background:#c0392b; color:#fff; font-size:18px; font-weight:bold; cursor:pointer; transition:0.3s; margin-top:10px;">

        </form>
    </div>
</div>

<div id="schedule" class="section card hidden" style="max-width:700px; margin:30px auto; padding:25px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff;">
    <h2 style="text-align:center; color:#c0392b; margin-bottom:25px; display:inline-flex; align-items:center; gap:10px;">
        <i class="fa fa-calendar-alt" style="font-size:28px;"></i> Your Pickup Schedule
    </h2>
    <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:15px;">
        <?php while($row = mysqli_fetch_assoc($schedule_result)): ?>
        <li style="padding:15px; border-radius:10px; background:#f8f8f8; display:flex; align-items:center; gap:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            <i class="fa fa-truck" style="color:#c0392b;"></i>
            <span>
                <strong><?php echo htmlspecialchars($row['pickup_day']); ?> <?php echo htmlspecialchars($row['pickup_time']); ?></strong><br>
                <?php if(!empty($row['kabadiwala_name'])): ?>
                    Kabadiwala: <?php echo htmlspecialchars($row['kabadiwala_name']); ?> (<?php echo htmlspecialchars($row['kabadiwala_phone']); ?>)
                <?php else: ?>
                    Not assigned yet
                <?php endif; ?>
            </span>
        </li>
        <?php endwhile; ?>
    </ul>
</div>

<div id="messages" class="section card hidden" style="max-width:550px; margin:20px auto; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background:#fff;">
    <h2 style="text-align:center; color:#c0392b; margin-bottom:20px; display:inline-flex; align-items:center; gap:8px; font-size:22px;">
        <i class="fa fa-comments" style="font-size:24px;"></i> Send Message
    </h2>

    <!-- Chat Box -->
    <div id="chat-box" style="max-height:300px; overflow-y:auto; padding:10px; border:1px solid #ccc; border-radius:8px; background:#f9f9f9; margin-bottom:15px;">
        <?php
        $messages_sql = "SELECT m.*, 
                            c.name AS customer_name, 
                            k.name AS kabadiwala_name
                         FROM messages m
                         LEFT JOIN users c ON m.customer_id = c.id
                         LEFT JOIN users k ON m.kabadiwala_id = k.id
                         WHERE m.customer_id='$user_id'
                         ORDER BY m.sent_at ASC";
        $messages_result = mysqli_query($conn, $messages_sql);

        if(mysqli_num_rows($messages_result) == 0){
            echo '<p style="text-align:center; color:#555; font-size:14px;">No messages yet</p>';
        }

        while($row = mysqli_fetch_assoc($messages_result)):
            $is_you = ($row['sender_type'] == 'customer'); 
            $sender_name = $is_you ? "You" : "Kabadiwala (" . htmlspecialchars($row['kabadiwala_name']) . ")";
        ?>
            <div style="margin:5px 0; max-width:65%; padding:8px 12px; border-radius:10px; font-size:14px;
                        <?php echo $is_you ? 'background:#c0392b;color:#fff;margin-left:auto;' : 'background:#eee;margin-right:auto;color:#000;'; ?>;
                        box-shadow:0 1px 4px rgba(0,0,0,0.1);">
                <strong><?php echo $sender_name; ?>:</strong> <?php echo htmlspecialchars($row['message']); ?>
                <div style="font-size:10px; text-align:right; margin-top:3px;"><?php echo date('d M H:i', strtotime($row['sent_at'])); ?></div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Send Message Form -->
    <h3 style="color:#c0392b; margin-bottom:12px; display:inline-flex; align-items:center; gap:6px; font-size:18px;">
        <i class="fa fa-paper-plane"></i> New Message
    </h3>
    <form id="sendForm" method="POST" action="send_message_customer.php" style="display:flex; flex-direction:column; gap:10px;">
        <textarea name="message" placeholder="Write message..." required style="padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px; resize:none; min-height:60px;"></textarea>

        <label style="font-weight:bold; color:#555; font-size:14px;">Select Kabadiwala:</label>
        <select name="kabadiwala_id" required style="padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
            <?php
            $kabadiwala_sql = "SELECT id, name FROM users WHERE role='kabadiwala'";
            $kabadiwala_result = mysqli_query($conn, $kabadiwala_sql);
            while($krow = mysqli_fetch_assoc($kabadiwala_result)):
            ?>
                <option value="<?php echo $krow['id']; ?>"><?php echo htmlspecialchars($krow['name']); ?></option>
            <?php endwhile; ?>
        </select>

        <input type="submit" name="send_message" value="Send" style="padding:12px; border:none; border-radius:8px; background:#c0392b; color:#fff; font-size:14px; font-weight:bold; cursor:pointer; transition:0.3s;">
    </form>
</div>


<!-- Resources Section -->
<div id="resources" class="section card hidden" style="max-width:700px; margin:30px auto; padding:25px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff;">
    <h2 style="text-align:center; color:#c0392b; margin-bottom:25px; display:inline-flex; align-items:center; gap:10px;">
        <i class="fa fa-book" style="font-size:28px;"></i> Resources
    </h2>
    <div style="display:flex; flex-direction:column; gap:15px;">
        <a href="docs/recycling_guide.pdf" class="btn" download style="padding:15px; border-radius:10px; background:#c0392b; color:#fff; font-size:16px; text-align:center; text-decoration:none; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:0.3s;">
            ♻ Recycling Guide
        </a>
        <a href="docs/price_list.pdf" class="btn" download style="padding:15px; border-radius:10px; background:#e74c3c; color:#fff; font-size:16px; text-align:center; text-decoration:none; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:0.3s;">
            📄 Price List
        </a>
    </div>
</div>

<!-- Holiday Notices Section -->
<div id="holiday" class="section card hidden" style="max-width:700px; margin:30px auto; padding:25px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff;">
    <h2 style="text-align:center; color:#c0392b; margin-bottom:25px; display:inline-flex; align-items:center; gap:10px;">
        <i class="fa fa-bell" style="font-size:28px;"></i> Holiday Notices
    </h2>
    <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
        <?php while($row = mysqli_fetch_assoc($holiday_result)): ?>
            <li style="padding:12px; border-radius:8px; background:#f8f8f8; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                <i class="fa fa-calendar-day" style="color:#c0392b; margin-right:8px;"></i>
                <?php echo date('d M Y', strtotime($row['notice_date'])); ?> - <?php echo htmlspecialchars($row['description']); ?>
            </li>
        <?php endwhile; ?>
        <?php if(mysqli_num_rows($holiday_result) == 0): ?>
            <li style="padding:12px; text-align:center; color:#555;">No holiday notices available</li>
        <?php endif; ?>
    </ul>
</div>


<script>
// Show Home by default
showSection('home');

// Auto-scroll chat to bottom
var chatBox = document.getElementById('chat-box');
if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;

</script>

</div>
</div>

</body>
</html>
