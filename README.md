# 💰 Budget Tracker

A simple and effective PHP-based personal expense tracker that allows users to manage their income and expenses securely.



## 🛠️ Features

- 🔐 Secure user login/logout system
- ➕ Add, view, and manage income
- ➕ Add, view, and manage expenses
- 📊 Generate reports for better budgeting
- 🧾 SQL schema included for quick setup
- 🎨 Minimal UI using PHP, JAVASCRIPT, and CSS


---

## 🛠️ Tech Stack

- **PHP**
- **HTML**
- **MYSQL**
- **CSS**
- **JavaScript**

---

## 📦 Setup & Run Locally

1. **Clone the repo**
   ```bash
   git clone https://github.com/philip-thomas-12/budget-tracker.git
   cd budget-tracker

2. **Import the database:**
   Open phpMyAdmin or any MySQL client
   Import PersonalExpenseTracker.sql

3.  Configure DB connection:
    Update config.php with your database credentials:
      $host = 'localhost';
      $user = 'root';
      $pass = '';
      $dbname = 'your_database_name'; 
4.  Run Locally

6.  Or Deploy Online:
    Use hosting platforms like Render, 000webhost, etc.

7.  📜 License

    This project is licensed under the MIT License.    
      
   


## 📁 Project Structure

/

├── index.php # Home/Login page

├── dashboard.php # Main dashboard

├── add_income.php # Add income entries

├── add_expense.php # Add expense entries

├── incomereport.php # View income reports

├── expensereport.php # View expense reports

├── manage_income.php # Edit/delete income

├── manage_expense.php # Edit/delete expenses

├── change_password.php # Change user password

├── logout.php # Logout function

├── config.php # DB configuration

├── PersonalExpenseTracker.sql # DB Schema

├── css/ # Styles

├── js/ #  JS scripts

├── uploads/ # File uploads

├── loginbackground.jpg # Login background

├── profile.php

├── register.php

├── session.php

├── sidebar.php

└── README.md
