<?php
session_start();
include("db.php");

// --- Check if Kabadiwala is logged in ---
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'kabadiwala') {
    header("Location: login.php");
    exit();
}

$kabadiwala_id = $_SESSION['user_id'];
$message = "";

// --- Fetch Kabadiwala profile ---
$profile_sql = "SELECT id, name, email, phone FROM users WHERE id='$kabadiwala_id'";
$profile_result = mysqli_query($conn, $profile_sql);
if (!$profile_result || mysqli_num_rows($profile_result) == 0) {
    header("Location: login.php");
    exit();
}
$profile = mysqli_fetch_assoc($profile_result);

// --- Update Profile ---
if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $update_sql = "UPDATE users SET name='$name', email='$email' WHERE id='$kabadiwala_id'";
    if (mysqli_query($conn, $update_sql)) {
        $message = "✅ Profile updated successfully!";
        $profile['name'] = $name;
        $profile['email'] = $email;
    } else {
        $message = "❌ Failed to update profile!";
    }
}

// --- Update Pickup Status ---
if (isset($_POST['update_status'])) {
    $pickup_id = $_POST['pickup_id'];
    $status = $_POST['status'];
    $status_sql = "UPDATE pickup_schedule SET status='$status' WHERE id='$pickup_id' AND kabadiwala_id='$kabadiwala_id'";
    if (mysqli_query($conn, $status_sql)) {
        $message = "✅ Pickup status updated!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $message = "❌ Failed to update status!";
    }
}




$pickup_sql = "SELECT ps.*, u.name as customer_name, u.phone as customer_phone 
               FROM pickup_schedule ps
               JOIN users u ON ps.customer_id = u.id
               WHERE ps.kabadiwala_id='$kabadiwala_id' AND ps.status='Scheduled'
               ORDER BY ps.created_at DESC";
$pickup_result = mysqli_query($conn, $pickup_sql);


// --- Fetch Messages (only with assigned customers) ---
$messages_sql = "SELECT m.*, c.name AS customer_name
                 FROM messages m
                 JOIN pickup_schedule ps ON ps.customer_id = m.customer_id
                 LEFT JOIN users c ON m.customer_id = c.id
                 WHERE ps.kabadiwala_id='$kabadiwala_id'
                 ORDER BY m.sent_at ASC";
$messages_result = mysqli_query($conn, $messages_sql);

// --- Fetch assigned customers for dropdown ---
$customer_sql = "SELECT DISTINCT u.id, u.name 
                 FROM users u
                 JOIN pickup_schedule ps ON ps.customer_id = u.id
                 WHERE ps.kabadiwala_id='$kabadiwala_id'";
$customer_result = mysqli_query($conn, $customer_sql);

// --- Fetch Holiday Notices ---
$holiday_sql = "SELECT * FROM holiday_notices ORDER BY notice_date DESC";
$holiday_result = mysqli_query($conn, $holiday_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kabadiwala Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
body {font-family: 'Segoe UI', Arial, sans-serif; margin:0; background:#fdf2f2;}
.header {background:#c0392b; color:#fff; padding:15px 30px; display:flex; justify-content:space-between; align-items:center;}
.header h1 {margin:0; font-size:20px;}
.header .profile a {color:#fff;text-decoration:none;font-weight:bold;border:1px solid #fff;padding:5px 12px;border-radius:5px;transition:0.3s;}
.header .profile a:hover {background:#fff;color:#c0392b;}
.container {display:grid; grid-template-columns:250px 1fr; min-height:calc(100vh - 60px);}
.sidebar {background:#fff; border-right:1px solid #ddd; padding:20px;}
.sidebar a {display:block; text-decoration:none; color:#333; padding:12px 15px; margin-bottom:10px; border-radius:8px;}
.sidebar a:hover {background:#c0392b; color:#fff;}
.content {padding:20px;}
.card {background:#fff; padding:20px; margin-bottom:20px; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.08);}
.card h2 {margin-top:0; font-size:18px; color:#c0392b;}
.btn {display:inline-block; background:#c0392b; color:#fff; padding:8px 15px; border-radius:6px; text-decoration:none; margin-top:8px;}
.btn:hover {background:#922b21;}
textarea, input[type=text], input[type=email], select {width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; margin-bottom:10px;}
input[type=submit] {background:#c0392b; color:#fff; border:none; padding:8px 15px; border-radius:6px; cursor:pointer;}
input[type=submit]:hover {background:#922b21;}
li {margin-bottom:10px;}
.hidden {display:none;}
@media(max-width:768px){.container{grid-template-columns:1fr;} .sidebar{border-bottom:1px solid #ddd;}}
</style>
<script>
function showSection(sectionId){
    document.querySelectorAll('.section').forEach(s=>s.style.display='none');
    document.getElementById(sectionId).style.display='block';
}
function confirmUpdate(){
    return confirm("Are you sure you want to update this status?");
}
</script>
</head>
<body>

<div class="header">
<h1 style="font-size:32px; margin:0;">
          
            Welcome, <?php echo htmlspecialchars($profile['name']); ?>!
              <i class="fa fa-hand-paper" style="color:#fff; margin-right:10px;"></i>
        </h1>    <div class="profile">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
<div class="sidebar" style="background:#ffe6e6;">
    <a href="javascript:void(0)" onclick="showSection('home')"><i class="fa fa-home"></i> Home</a>
    <a href="javascript:void(0)" onclick="showSection('profile')"><i class="fa fa-user"></i> Profile</a>
    <a href="javascript:void(0)" onclick="showSection('pickups')"><i class="fa fa-truck"></i> Pickups</a>
    <a href="javascript:void(0)" onclick="showSection('messages')"><i class="fa fa-envelope"></i> Messages</a>
    <a href="javascript:void(0)" onclick="showSection('holiday')"><i class="fa fa-bullhorn"></i> Holidays</a>
    <a href="javascript:void(0)" onclick="showSection('resources')"><i class="fa fa-book"></i> Resources</a>
</div>

<div class="content">
<?php if($message) echo "<div class='card' style='background:#fdecea;color:#c0392b;'>$message</div>"; ?>
<div id="home" class="section">

    <!-- Welcome Card -->
    <div class="card" style="background:#fff; color:#333; text-align:center; padding:30px; border-radius:15px; 
        box-shadow:0 6px 15px rgba(0,0,0,0.1); transition:0.3s; cursor:pointer;"
        onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 25px rgba(0,0,0,0.15)';"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 15px rgba(0,0,0,0.1)';"
    >
        <h2 style="font-size:32px; margin:0;">
            <i class="fa fa-hand-paper" style="color:#c0392b; margin-right:10px;"></i>
            Welcome, <?php echo htmlspecialchars($profile['name']); ?>!
        </h2>
        <p style="margin-top:15px; font-size:18px; line-height:1.5;">
            Manage your profile, pickups, messages, and check holidays from the menu.
        </p>
    </div>

    <!-- Role & Pickup Card -->
    <div class="card" style="margin-top:25px; padding:25px; border-radius:15px; 
        box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff; transition:0.3s; cursor:pointer;"
        onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 25px rgba(0,0,0,0.15)';"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 15px rgba(0,0,0,0.1)';"
    >
        <h3 style="color:#c0392b; margin-bottom:15px;">
            <i class="fa fa-user-tie" style="color:#c0392b; margin-right:8px;"></i>
            Role: Kabadiwala
        </h3>
        <p style="font-size:16px; margin-bottom:20px; line-height:1.5;">
            As a Kabadiwala, you are responsible for picking up e-waste assigned to you, communicating with customers, and keeping track of your schedule.
        </p>

        <!-- Pickup Count -->
        <div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:10px;">
            <div style="flex:1; min-width:220px; background:#f9f9f9; color:#333; padding:20px; 
                border-radius:12px; text-align:center; font-weight:bold; box-shadow:0 4px 12px rgba(0,0,0,0.1); 
                transition:0.3s;"
                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)';"
            >
                <i class="fa fa-truck" style="font-size:28px; margin-bottom:10px; color:#c0392b;"></i>
                <p style="margin:5px 0; font-size:24px;"><?php echo mysqli_num_rows($pickup_result); ?></p>
                <span style="font-size:16px; color:#555;">Total Assigned Pickups</span>
            </div>
        </div>
    </div>

</div>


<div id="profile" class="section card hidden" style="max-width:600px; margin:30px auto; padding:30px; border-radius:15px; box-shadow:0 6px 15px rgba(0,0,0,0.1); background:#fff; font-family:Arial, sans-serif;">
   <h2 style="text-align:center; color:#c0392b; margin-bottom:25px; font-size:28px;">
    <i class="fa fa-user" style="color:#c0392b; margin-right:10px;"></i>
    Update Profile
</h2>

    <form method="POST" style="display:flex; flex-direction:column; gap:18px;">
        
        <div style="display:flex; flex-direction:column;">
            <label style="font-weight:bold; color:#555; margin-bottom:5px;">
                <i class="fa fa-id-badge" style="color:#c0392b; margin-right:10px;"></i>Name
            </label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" required 
                   style="padding:12px; border-radius:8px; border:1px solid #ccc; font-size:16px; transition:0.3s; outline:none;"
                   onfocus="this.style.borderColor='#c0392b';" onblur="this.style.borderColor='#ccc';">
        </div>

        <div style="display:flex; flex-direction:column;">
            <label style="font-weight:bold; color:#555; margin-bottom:5px;">
                <i class="fa fa-envelope" style="color:#c0392b; margin-right:10px;"></i>Email
            </label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required 
                   style="padding:12px; border-radius:8px; border:1px solid #ccc; font-size:16px; transition:0.3s; outline:none;"
                   onfocus="this.style.borderColor='#c0392b';" onblur="this.style.borderColor='#ccc';">
        </div>

        <div style="display:flex; flex-direction:column;">
            <label style="font-weight:bold; color:#555; margin-bottom:5px;">
                <i class="fa fa-phone" style="color:#c0392b; margin-right:10px;"></i>Phone (cannot change)
            </label>
            <input type="text" value="<?php echo htmlspecialchars($profile['phone']); ?>" disabled
                   style="padding:12px; border-radius:8px; border:1px solid #ccc; font-size:16px; background:#f5f5f5; color:#555;">
        </div>

        <input type="submit" name="update_profile" value="Update Profile" 
               style="padding:15px; border:none; border-radius:10px; background:#c0392b; color:#fff; font-size:18px; font-weight:bold; cursor:pointer; transition:0.3s;"
               onmouseover="this.style.background='#e74c3c';" onmouseout="this.style.background='#c0392b';">
    </form>
</div>


<div id="pickups" class="section card hidden" style="max-width:700px; margin:40px auto; padding:30px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1); background:#fff; font-family:Arial, sans-serif;">
    <h2 style="color:#c0392b; margin-bottom:30px; text-align:center; font-size:28px;">
        <i class="fa fa-tasks" style="margin-right:10px;"></i>
        Assigned Pickups
    </h2>

    <?php while($row = mysqli_fetch_assoc($pickup_result)): ?>
        <div style="padding:20px; margin-bottom:25px; border:1px solid #ddd; border-radius:15px; background:#f9f9f9; box-shadow:0 3px 10px rgba(0,0,0,0.05);">

            <!-- Customer -->
            <div style="display:flex; align-items:center; margin-bottom:12px; font-size:16px; font-weight:bold; color:#333;">
                <i class="fa fa-user" style="color:#c0392b; margin-right:10px;"></i>
                Customer: <?php echo htmlspecialchars($row['customer_name']); ?>
            </div>

            <!-- Gadget -->
            <div style="display:flex; align-items:center; margin-bottom:12px; font-size:15px; color:#555;">
                <i class="fa fa-laptop" style="color:#c0392b; margin-right:10px;"></i>
                Gadget: <?php echo htmlspecialchars($row['gadgets']); ?>
            </div>

            <!-- Weight -->
            <div style="display:flex; align-items:center; margin-bottom:12px; font-size:15px; color:#555;">
                <i class="fa fa-balance-scale" style="color:#c0392b; margin-right:10px;"></i>
                Weight: <?php echo htmlspecialchars($row['weight_kg']); ?> Kg
            </div>

            <!-- Address -->
            <div style="display:flex; align-items:center; margin-bottom:12px; font-size:15px; color:#555;">
                <i class="fa fa-map-marker" style="color:#c0392b; margin-right:10px;"></i>
                Address: <?php echo htmlspecialchars($row['address']); ?>, <?php echo htmlspecialchars($row['city']); ?> - <?php echo htmlspecialchars($row['pincode']); ?>
            </div>

            <!-- Date -->
            <div style="display:flex; align-items:center; margin-bottom:12px; font-size:15px; color:#444;">
                <i class="fa fa-calendar" style="color:#c0392b; margin-right:10px;"></i>
                Date: <?php echo htmlspecialchars($row['pickup_day']); ?>
            </div>

            <!-- Time -->
            <div style="display:flex; align-items:center; margin-bottom:12px; font-size:15px; color:#444;">
                <i class="fa fa-clock" style="color:#c0392b; margin-right:10px;"></i>
                Time: <?php echo htmlspecialchars($row['pickup_time']); ?>
            </div>

            <!-- Status & Update Button -->
            <form method="POST" style="margin-top:15px;" onsubmit="return confirm('Are you sure to update status?')">
                <input type="hidden" name="pickup_id" value="<?php echo $row['id']; ?>">
                <select name="status" style="padding:8px 12px; border-radius:6px; border:1px solid #ccc; font-size:14px; margin-bottom:10px;">
                    <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Completed" <?php if($row['status']=='Completed') echo 'selected'; ?>>Completed</option>
                </select>
                <br>
                <input type="submit" name="update_status" value="Update" style="padding:10px 15px; border:none; border-radius:6px; background:#c0392b; color:#fff; font-weight:bold; cursor:pointer; font-size:14px; transition:0.3s;width:100%;"
                       onmouseover="this.style.background='#e74c3c';" onmouseout="this.style.background='#c0392b';">
            </form>

        </div>
    <?php endwhile; ?>
</div>


<div id="messages" class="section card hidden" style="max-width:700px; margin:20px auto; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background:#fff;">
<h2 style="color:#c0392b; margin-bottom:25px; text-align:center; font-size:28px;">
        <i class="fa fa-comment" style="margin-right:10px;"></i>
        Customer Messages
    </h2>
    <!-- Chat Box -->
    <div id="chat-box" style="max-height:300px; overflow-y:auto; padding:10px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9;">
        <?php
        while($row = mysqli_fetch_assoc($messages_result)):
            $is_you = ($row['sender_type'] == 'kabadiwala');
            $sender_name = $is_you ? "You" : htmlspecialchars($row['customer_name']);
        ?>
            <div style="margin:4px 0; max-width:70%; padding:8px 10px; border-radius:10px; 
                        <?php echo $is_you ? 'background:#c0392b;color:#fff;margin-left:auto;' : 'background:#eee;color:#000;margin-right:auto;'; ?>;
                        box-shadow:0 1px 3px rgba(0,0,0,0.1); font-size:13px; line-height:1.3;">
                <strong><?php echo $sender_name; ?>:</strong> <?php echo htmlspecialchars($row['message']); ?>
                <div style="font-size:9px; text-align:right; margin-top:3px;"><?php echo date('d M Y H:i', strtotime($row['sent_at'])); ?></div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Send Message Form -->
    <h3 style="color:#c0392b; margin-top:20px; font-size:16px;">Send New Message</h3>
    <form method="POST" action="send_message_kabadiwala.php" style="display:flex; flex-direction:column; gap:10px;">
        <textarea name="message" placeholder="Write your message..." required 
                  style="padding:8px; border-radius:6px; border:1px solid #ccc; font-size:13px; resize:none; height:80px;"></textarea>
        <label style="font-weight:bold; color:#555; font-size:13px;">Select Customer:</label>
        <select name="customer_id" required 
                style="padding:8px; border-radius:6px; border:1px solid #ccc; font-size:13px;">
            <?php while($crow = mysqli_fetch_assoc($customer_result)): ?>
                <option value="<?php echo $crow['id']; ?>"><?php echo htmlspecialchars($crow['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <input type="submit" value="Send" 
               style="padding:10px; border:none; border-radius:8px; background:#c0392b; color:#fff; font-size:14px; font-weight:bold; cursor:pointer; transition:0.3s;"
               onmouseover="this.style.background='#e74c3c';" onmouseout="this.style.background='#c0392b';">
    </form>
</div>

<!-- Holiday Notices -->
<div id="holiday" class="section card hidden" style="max-width:700px; margin:20px auto; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background:#fff;">
 <h2 style="color:#c0392b; margin-bottom:25px; text-align:center; font-size:28px;">
        <i class="fa fa-calendar" style="margin-right:10px;"></i>
        Holiday Notices
    </h2>    <ul style="list-style:none; padding:0; margin:0; font-size:14px; color:#333;">
        <?php while($row = mysqli_fetch_assoc($holiday_result)): ?>
            <li style="padding:8px 10px; margin-bottom:8px; border-bottom:1px solid #eee;">
                <strong><?php echo date('d M Y', strtotime($row['notice_date'])); ?></strong> - <?php echo htmlspecialchars($row['description']); ?>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<!-- Resources -->
<div id="resources" class="section card hidden" style="max-width:700px; margin:20px auto; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background:#fff;">
<h2 style="color:#c0392b; margin-bottom:25px; text-align:center; font-size:28px;">
        <i class="fa fa-book" style="margin-right:10px;"></i>
        Resources
    </h2>    <a href="docs/recycling_guide.pdf" class="btn" download style="display:block; margin-bottom:10px; padding:10px 15px; border-radius:8px; background:#c0392b; color:#fff; text-decoration:none; font-weight:bold; transition:0.3s;"
       onmouseover="this.style.background='#e74c3c';" onmouseout="this.style.background='#c0392b';">
        ♻ Recycling Guide
    </a>
    <a href="docs/price_list.pdf" class="btn" download style="display:block; padding:10px 15px; border-radius:8px; background:#c0392b; color:#fff; text-decoration:none; font-weight:bold; transition:0.3s;"
       onmouseover="this.style.background='#e74c3c';" onmouseout="this.style.background='#c0392b';">
        📄 Price List
    </a>
</div>

</div>
</div>

<script>
showSection('home');
const chatBox = document.getElementById('chat-box');
if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>

</body>
</html>
