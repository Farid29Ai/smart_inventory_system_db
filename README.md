# Smart Inventory System

Smart Inventory System is a web-based inventory and office supplies requisition system developed using **CakePHP** and **MySQL**. This system allows administrators to manage inventory items, staff accounts, vendors, categories, requisitions, requisition items, stock transactions, and monthly reports. Staff can browse item catalog, submit requisition requests, view request status, and manage their profile.

---

## Project Information

**Project Name:** Smart Inventory System  
**System Type:** Office Supplies Requisition and Inventory Management System  
**Framework:** CakePHP  
**Database:** MySQL  
**Local Server:** Laragon  
**Language:** PHP, HTML, CSS, JavaScript  
**UI Theme:** Light Mode and Dark Mode  

---

## Main Features

### Admin Features
- Admin Login
- Admin Management
- Staff Management
- Category Management
- Item Catalog Management
- Vendor Management
- Requisition Management
- Requisition Item Management
- Stock Transaction Management
- Monthly Report
- Export Report to PDF
- Approve / Reject Staff Requisition
- Light Mode and Dark Mode

### Staff Features
- Staff Login
- My Profile
- Item Catalog
- Search Item by Category
- Submit Item Requisition
- My Requests
- View Request Status
- Edit Pending Request
- Delete Own Request
- Light Mode and Dark Mode

---

## Default Login Account

Use the account below to login into the system.

### Admin Login

| Role | Email | Password |
| Admin | admin@gmail.com | 12345 |

Admin login page is used to access the administrator dashboard and manage the whole system.

### Staff Login

| Role | Email | Password |
| Staff | ali@gmail.com | 12345 |

Staff login page is used to access staff dashboard, item catalog, profile, and requisition request pages.

## 1. Download the Project from GitHub

Open the GitHub repository page.

Click the green button:

```text
Code
```

Then choose:

```text
Download ZIP
```

After the download is completed, extract the ZIP file.

Rename the extracted folder to:

```text
smart_inventory_system_db
```

Move the folder into the Laragon `www` directory:

```text
C:\laragon\www\smart_inventory_system_db
```

The project folder must be placed inside the `www` folder so that Laragon can run the system using localhost.

---

## 2. Start Laragon

Open Laragon and start the required services.

Make sure these services are running:

```text
Apache
MySQL
```

If Apache and MySQL are running successfully, the system can connect to localhost and phpMyAdmin.

---

## 3. Install Composer Dependencies

This system uses CakePHP. The `vendor` folder is not uploaded to GitHub because it is large and can be generated again using Composer.

Open Command Prompt or Terminal inside the project folder:

```text
C:\laragon\www\smart_inventory_system_db
```

Then run this command:

```bash
composer install
```

Wait until the installation is completed. If the command finishes without error, all CakePHP dependencies have been installed successfully.

---

## 4. Import the Database

Open phpMyAdmin in your browser:

```text
http://localhost/phpmyadmin
```

Create a new database with this name:

```text
smart_inventory_system_db
```

After that, import the database file provided in this project:

```text
database.sql
```

Steps to import the database:

```text
phpMyAdmin
→ New
→ Create database
→ smart_inventory_system_db
→ Import
→ Choose database.sql
→ Go
```

Wait until phpMyAdmin shows a success message. This means the database has been imported successfully.

---

## 5. Configure Database Connection

The file `config/app_local.php` is not uploaded to GitHub because it usually contains local database settings and sensitive information.

To create it, go to this folder:

```text
config
```

Find this file:

```text
app_local.example.php
```

Copy the file and paste it in the same folder.

Rename the copied file to:

```text
app_local.php
```

Then open `app_local.php` and set the database connection like this:

```php
'Datasources' => [
    'default' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'smart_inventory_system_db',
    ],
],
```

For Laragon, the default MySQL username is usually `root` and the password is usually empty.

Make sure the database name is exactly:

```text
smart_inventory_system_db
```

---

## 6. Run the System

After completing all setup steps, open the system in your browser:

```text
http://localhost/smart_inventory_system_db/
```

If everything is set up correctly, the Smart Inventory System homepage or login page will appear.

---

## Successful Setup Checklist

The system is successfully installed if all the items below are completed:

```text
✓ Laragon Apache is running
✓ Laragon MySQL is running
✓ Project folder is inside C:\laragon\www
✓ composer install has been completed
✓ Database smart_inventory_system_db has been created
✓ database.sql has been imported successfully
✓ config/app_local.php has been created
✓ Database connection in app_local.php is correct
✓ System opens using http://localhost/smart_inventory_system_db/
✓ Admin can login successfully
✓ Staff can login successfully
```

---

## Common Problems and Solutions

### 1. Vendor Folder Missing

If the system shows an error about missing CakePHP files or the `vendor` folder, run this command inside the project folder:

```bash
composer install
```

This will install all required CakePHP dependencies.

### 2. Database Connection Error

If the system shows a database connection error, open this file:

```text
config/app_local.php
```

Check the database settings. Make sure the database name is:

```text
smart_inventory_system_db
```

Also make sure MySQL is running in Laragon.

### 3. Page Not Found

If the page cannot be opened, make sure the project folder is located at:

```text
C:\laragon\www\smart_inventory_system_db
```

Then open this URL:

```text
http://localhost/smart_inventory_system_db/
```

Do not place the project outside the Laragon `www` folder.

### 4. Login Not Working

If admin or staff login does not work, make sure the database has been imported successfully. Also make sure the email and password used for login exist in the database.

Check the admin and staff tables in phpMyAdmin.

### 5. app_local.php Missing

If `app_local.php` is missing, copy this file:

```text
config/app_local.example.php
```

Then rename the copied file to:

```text
config/app_local.php
```

After that, update the database connection settings.

---

## Important GitHub Notes

The following files and folders are not uploaded to GitHub because they are generated automatically or contain local computer settings:

```text
vendor
tmp
logs
config/app_local.php
.env
.codex
.agents
```

To run the system on another computer, the user must run:

```bash
composer install
```

and create their own:

```text
config/app_local.php
```

---

## Recommended .gitignore

The `.gitignore` file should contain:

```gitignore
/vendor/
/tmp/
/logs/
/config/app_local.php
/config/.env
.env

/.codex/
/.agents/

Thumbs.db
.DS_Store
```

This prevents unnecessary and sensitive files from being uploaded to GitHub.

---

## Folder Structure

The main folder structure of this project is:

```text
smart_inventory_system_db/
├── bin/
├── config/
├── plugins/
├── resources/
├── src/
├── templates/
├── tests/
├── webroot/
├── database.sql
├── composer.json
├── composer.lock
├── README.md
└── .gitignore
```

---

## How to Use the System

### Admin Flow

1. Open the system using localhost.
2. Click Admin Login.
3. Enter the admin email and password.
4. After login, admin will be redirected to the admin dashboard.
5. Admin can manage staff, admin accounts, categories, vendors, item catalog, requisitions, requisition items, stock transactions and reports.
6. Admin can approve or reject requisition requests submitted by staff.
7. Admin can export monthly reports to PDF.

### Staff Flow

1. Open the system using localhost.
2. Click Staff Login.
3. Enter the staff email and password.
4. After login, staff will be redirected to the staff dashboard.
5. Staff can view item catalog.
6. Staff can search items by category.
7. Staff can submit requisition requests.
8. Staff can view their request status.
9. Staff can edit or delete their own pending requests.
10. Staff can update their profile information.

---

## Report Feature

The system includes a monthly requisition report feature. Admin can search reports by month and year. The report displays request information such as staff name, item name, quantity requested, quantity approved, request status and request date. Admin can also export the report into PDF format.

---

## Stock Transaction Feature

The Stock Transaction module records stock movement in the system.

Stock transaction types include:

```text
Stock In
Stock Out
Adjustment
```

Stock In is used when new stock is added. Stock Out is used when stock is deducted. Adjustment is used when admin needs to update stock quantity manually.

---

## User Roles

### Admin

Admin has full access to the system. Admin can manage all system data, approve or reject requests and generate reports.

### Staff

Staff has limited access. Staff can view items, request items, check request status and manage their own profile.



## Database Setup

The database file is included in this project.

```text
database.sql
