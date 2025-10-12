# smart-e-waste-management
♻️ Smart E-Waste Management System to streamline e-waste pickups, user management, and awareness 🌱. 📝 Includes interactive features like Blog, Fun Zone games 🎮, and FAQ ❓. 💻 Built with HTML, CSS, JavaScript, PHP, and MySQL 🛠️.



### Overview
Ecobin is a comprehensive web application designed to streamline e-waste collection, awareness, and engagement. It offers a user-friendly interface for customers, kabadiwalas (waste collectors), and admins to manage e-waste pickups, view resources, play games, read blogs, and interact through messages.

### Features

#### Customer Module
- Signup/Login system
- Schedule e-waste pickups
- Track pickup status
- Access educational resources
- Blog section for e-waste awareness
- Fun zone: Quiz, Memory Game, Puzzle, Match the Pair
- FAQ section for quick help

#### Kabadiwala Module
- Dashboard with assigned pickups
- Update pickup status (Pending/Completed)
- View customer details and addresses
- Messaging system with assigned customers
- View holiday notices
- Access resources for efficient waste collection

#### Admin Module
- View all users (customers & kabadiwalas)
- Approve or reject registration requests
- Monitor and manage scheduled pickups
- Generate reports on completed and pending pickups

### Technologies Used
- **Frontend:** HTML5, CSS3, JavaScript, Font Awesome
- **Backend:** PHP
- **Database:** MySQL
- **Hosting:** XAMPP / Local Server

### Project Structure
```
Ecobin/
│
├─ index.php
├─ admin_dashboard.php
├─ kabadiwala_dashboard.php
├─ login.php
├─ signup.php
├─ send_message_kabadiwala.php
├─ db.php
├─ docs/
│   ├─ recycling_guide.pdf
│   └─ price_list.pdf
├─ css/
│   └─ style.css
├─ js/
│   └─ script.js
├─ images/
└─ README.md
```

### How to Run
1. Clone the repository: 
```bash
git clone https://github.com/riyakharade/ecobin.git
```
2. Import the database `ecobin.sql` in phpMyAdmin.
3. Configure `db.php` with your database credentials.
4. Start XAMPP (Apache & MySQL).
5. Open `index.php` in your browser.

### Demo
You can showcase the project with screenshots and/or a demo video highlighting:
- Customer signup and scheduling pickups
- Kabadiwala dashboard and status updates
- Admin dashboard management
- Fun zone games and blog section

### Credits
- Developed under **E-Waste subject** guidance by **Nilima Main Mam**.
- Portfolio: [Riya Kharade](https://riyakharade-portfolio.netlify.app/)

### License
This project is for educational purposes.
