

# 🏋️‍♂️ Gym Attendance System

The Gym Attendance System is a PHP-based web application designed to streamline gym member management and attendance tracking. Utilizing RFID technology, the system allows for efficient member registration, real-time attendance monitoring, and administrative control, enhancing the overall management of gym operations.

---

## 🚀 Features

* **RFID Integration**: Seamlessly read and process RFID tags for member identification.
* **Member Registration**: Register new gym members with personal details and RFID tag assignments.
* **Attendance Tracking**: Monitor and record member check-ins and check-outs in real-time.
* **User Management**: Edit and delete member information as needed.
* **Admin Authentication**: Secure login system for administrators to manage the platform.
* **Database Management**: Store and retrieve member and attendance data using MySQL.

---

## 🛠️ Technologies Used

* **Frontend**: HTML, CSS, JavaScript
* **Backend**: PHP
* **Database**: MySQL
* **RFID Hardware**: Compatible with standard RFID readers
---

## 📁 Project Structure

* `admin_login.php`: Admin login interface.
* `registration.php`: Member registration form.
* `insertDB.php`: Script to insert new member data into the database.
* `user data.php`: Display registered member information.
* `user data edit page.php`: Form to edit existing member details.
* `user data delete page.php`: Script to delete member records.
* `read tag.php`: Read RFID tags and display UID.
* `getUID.php`: Fetch UID from the RFID reader.
* `UIDContainer.php`: Container to hold the UID value.
* `database.php`: Database connection script.
* `sql12719550.sql`: SQL file to set up the necessary database tables.

---

## ⚙️ Setup Instructions

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/syazamm/Gym-Attendance-System.git
   ```



2. **Set Up the Database**:

   * Import the `sql12719550.sql` file into your MySQL database to create the required tables.
   * Update `database.php` with your database credentials.

3. **Configure the Web Server**:

   * Ensure you have a PHP-supported web server (e.g., XAMPP, WAMP).
   * Place the project files in the server's root directory (e.g., `htdocs` for XAMPP).

4. **Connect RFID Reader**:

   * Set up your RFID reader hardware and ensure it's connected to the system.
   * Modify `getUID.php` and related scripts if necessary to match your hardware specifications.

5. **Access the Application**:

   * Navigate to `http://localhost/Gym-Attendance-System/admin_login.php` in your web browser.
   * Log in using the admin credentials to start managing the system.

---




