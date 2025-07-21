# EduHelp - School Management System

EduHelp is a web-based school management system designed for offline testing on XAMPP (Windows 11). It helps schools manage student data, generate report cards and ID cards, and communicate with parents and teachers.

## Features

- **School Management:** Register new schools and manage school information.
- **User Roles:** Superuser, Headteacher, and Teacher roles with different levels of access.
- **Student Management:** Add, edit, delete, and bulk import students.
- **Teacher Management:** Add, edit, and delete teachers.
- **Class and Subject Management:** Create and manage classes and subjects.
- **Teacher-Subject Assignment:** Assign teachers to specific subjects and classes.
- **Report Card Generation:** Generate PDF report cards for students.
- **ID Card Generation:** Generate PDF ID cards with QR codes for students and teachers.
- **Bulk SMS:** Send bulk SMS messages to parents and teachers (mock implementation).
- **Payment Integration:** Mock payment gateway for school registration.

## Technology Stack

- **Backend:** PHP 8.2
- **Frontend:** HTML, CSS, Bootstrap 5, JavaScript, jQuery
- **Database:** MySQL (MariaDB)
- **PDF Generation:** TCPDF
- **Excel Handling:** PhpOffice/PhpSpreadsheet
- **QR Code Generation:** phpqrcode

## Setup Instructions

1.  **Install XAMPP:** Make sure you have XAMPP installed with PHP 8.2 and MySQL.
2.  **Clone the repository:** Clone this repository into your `htdocs` folder (usually `C:/xampp/htdocs/`).
3.  **Create the database:**
    *   Open phpMyAdmin by navigating to `http://localhost/phpmyadmin`.
    *   Create a new database named `eduhelp`.
    *   Import the `scripts/eduhelp.sql` file to create the tables.
4.  **Install dependencies:**
    *   Open a terminal in the project root folder.
    *   Run `composer install` to install the required PHP libraries (TCPDF and PhpSpreadsheet).
5.  **Run the setup scripts:**
    *   Navigate to `http://localhost/eduhelp/scripts/setup_superuser.php` in your browser to create the superuser and the demo school.
6.  **Access the application:**
    *   Navigate to `http://localhost/eduhelp` in your browser.
    *   Log in with the superuser credentials:
        *   **Username:** superuser
        *   **Password:** password

## User Manual

### Superuser

The superuser has full access to the system. They can manage all schools and system settings.

- **Login:** Use the credentials `superuser` and `password`.
- **Dashboard:** The superuser dashboard provides an overview of the system and links to manage schools and settings.
- **Manage Schools:** View a list of all registered schools, edit their information, or delete them.
- **System Settings:** Configure system-wide settings.

### Headteacher

The headteacher has full access to their school's data. They can manage students, teachers, classes, subjects, and more.

- **Registration:** A new school can be registered from the registration page. The headteacher's account is created during this process.
- **Login:** The headteacher can log in with their email and password.
- **Dashboard:** The headteacher dashboard provides an overview of the school and links to manage different aspects of the school.
- **Manage Students:** Add, edit, delete, and bulk import students.
- **Manage Teachers:** Add, edit, and delete teachers.
- **Manage Classes:** Create and manage classes.
- **Manage Subjects:** Create and manage subjects.
- **Teacher-Subject Assignment:** Assign teachers to specific subjects and classes.
- **Generate Report Cards:** Generate PDF report cards for students.
- **Generate ID Cards:** Generate PDF ID cards for students.
- **Send Bulk SMS:** Send bulk SMS messages to parents and teachers.

### Teacher

The teacher has limited access to the system. They can only manage the classes and subjects they are assigned to.

- **Login:** Teachers can log in with their email and password, or their phone number and password.
- **Dashboard:** The teacher dashboard shows the teacher's assigned classes and subjects.
- **Enter Marks:** Enter marks for students in their assigned classes and subjects.
- **View Report Cards:** View the report cards of students in their assigned classes.
