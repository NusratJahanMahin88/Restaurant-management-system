# Restaurant Management System (MVC, PHP + MySQL,HTML+ CSS , JavaScript)


A full-featured restaurant management system built with *HTML, PHP, JavaScript and MySQL, following a clean **MVC architecture** and **SoC**(Separation of Concerns).

The system supports three main user roles: **Staff, Admin, and Customers**.  
-  **Staff** can manage orders, place orders, cancel orders, update status of order, hide/show menu items and interact with a real-time kitchen dashboard.  
-  **Admins** can configure menu ,add new menu_item, add new admin,manage admin profile,manage staff ,customer,order, see order analytics and calculate revenue. 

-  **Customers** can create own profile, place orders,download receipts, receive email notifications, and track progress.  

This project was designed to simulate a real-world restaurant workflow with 
**secure backend logic**, 
**responsive UI**, and 
**role-based access control**.


##  Features

### Authentication & Security
- Secure login for **Customer**, **Staff** and **Admin**

- Passwords stored with `password_hash()` and verified with `password_verify()`
- CSRF tokens for form submissions
- `htmlspecialchars()` for XSS prevention
- Frontend + backend Validation and sanitization
- Session-gated admin routes

###  Customer Features
- Register as a new customer in the system
- Secure login with customer credentials
- Manage customer account 
- Place new orders with itemized details
- Receive branded email notifications when orders are ready
- Track order status in real time
- No duplicate accounts

###  Staff Features
- Secure login with staff credentials
- Manage staff account with CRUD functionality.
- Hide and show menu items to customer's menu list.
- Kitchen dashboard with **live order updates**(JavaScript)
- Update order statuses (Not set→ Received→ Preparing → Ready → Send email)
- Sending order ready mail to customer via PhpMailer.
- Order cancellation + Auto order cancellation mail to customer through PhpMailer.
- Add Order: Staff can order on behalf of customer and a backup of customer interface crash.
- Responsive interface for tablets and kitchen displays


###  Admin Features
- Secure login with admin credentials
- Manage admin profile (Create ,update,and delete Admin accounts) also  Can add new admin
- Manage menu (Add new menu items),Edit existing items.
-  Manage staff accounts (add,edit and delete).
- view and  delete orders with full control
- Publish/Unpublish menu items dynamically
- Access customer details( name ,email and id)
- Handle missing data gracefully to maintain dashboard clarity
- Genarate real_time analytics dashboards showing orser status,revenue.
- Access full customer order history
- update order status 
- Maintain restaurant structure with dynamic routing

###  Email Notifications for ready orders and cancelled orders.
- Automated flow triggered when orders are marked ready and pressed 'Send email' button.
- Auto cancellation mail sending feature when orders are cancelled by staff.



##  Project Setup

1. **Copy project folder**  
   Paste the folder `restaurant_management_system` into your `htdocs/` directory.

2. **Open in IDE**  
   Open the folder in VS Code or your preferred IDE.

3. *Create Database*  
   In phpMyAdmin, create a new database named:'brock_cafe'

4. *Import SQL*  
Import the SQL file located at project root:'brock_cafe.sql'

5. *Run the Project*  
In your browser, visit: localhost/quick_serve

## ID and Password for Staff and Admin interface:

*Staff:*
ID: 123123
Password: test123@

*Admin:*
ID: 123123
Password: test1234@




## System design:

(Single entry point based system design)

quick_serve/ 

├── app/       # controllers, models, views, core and helpers

├── assets/    # css, images, js and sounds

├── config/    # autoload, config, db, email and routes

├── storage/   # logs and uploads

├── tests/     # logs , Admin tests

├── .env

├── .htaccess

├── bootstrap.php

├── composer.json

├──composer.lock

├── index.php    # Entry point

└── README.md     # Setup and documentation


##  UI & Accessibility

- Responsive design for desktop, tablet, and kitchen displays
- Color-coded order statuses (Not set, Received, Preparing, Ready)
- Accessible forms and navigation
- Dark mode and high-contrast options



##  Team Contributions

- **Tirsana** – Database Designer & Customer Interface Developer  
-**Sanjana** – System Designer & Staff Interface Developer  
- **Nusrat** –Admin Interface Developer, responsible for building the control hub of the system with secure access.

# Documentation compiled by Sanjana (with team input)

##  License

This project is for **academic purposes** and is distributed under the MIT License.  
See `LICENSE` for details.