# 🚀 Project Migration & Presentation Guide: Student Attendance Portal

Follow these micro-steps to smoothly migrate your project from your Home PC to a College PC and present it in the best possible way.

---

## 🛠️ Step 1: Preparation (On your Home PC)

### 1.1 Export the Database
Before moving anything, you need a backup of your database.
1.  Open **XAMPP Control Panel** and ensure MySQL is running.
2.  Go to `http://localhost/phpmyadmin` in your browser.
3.  On the left sidebar, click on your database: **`attendance_portal`**.
4.  Click the **Export** tab at the top.
5.  Keep the method as **Quick** and format as **SQL**.
6.  Click **Export (Go)**. It will download a file named `attendance_portal.sql`. 
7.  **Save this file** inside your project's `database/` folder (or anywhere accessible).

### 1.2 Package the Code
1.  Go to your desktop and find the **`student-attendance-portal`** folder.
2.  Right-click the folder ➔ **Compress to ZIP file** (or use WinRAR/7-Zip).
3.  Name it `Attendance_Portal_Project.zip`.
4.  **Copy this ZIP file** and your downloaded `.sql` file to a USB Pen Drive.

---

## 💻 Step 2: Setup (On the College PC)

### 2.1 Install XAMPP (If not present)
If the college PC already has XAMPP, skip this.
1.  Download [XAMPP for Windows](https://www.apachefriends.org/download.html).
2.  Install it with default settings (usually `C:\xampp`).

### 2.2 Placement of Files
1.  Open your USB drive and copy `Attendance_Portal_Project.zip`.
2.  Navigate to the XAMPP directory: `C:\xampp\htdocs`.
3.  Paste the ZIP file here and **Extract** it.
4.  **CRITICAL:** Ensure the folder name is exactly **`student-attendance-portal`** inside `htdocs`. 
    - The path should look like: `C:\xampp\htdocs\student-attendance-portal\public\index.php`.

---

## 🗄️ Step 3: Database Import (On the College PC)

1.  Open **XAMPP Control Panel**.
2.  Click **Start** next to **Apache** and **MySQL**.
3.  Click the **Admin** button next to MySQL (or go to `http://localhost/phpmyadmin`).
4.  Click **New** on the left menu.
5.  Database Name: **`attendance_portal`** ➔ Click **Create**.
6.  Select the newly created `attendance_portal` on the left.
7.  Click the **Import** tab at the top.
8.  Click **Choose File** and select your `attendance_portal.sql` file.
9.  Scroll down and click **Import (Go)**.

---

## ⚙️ Step 4: Final Quick Check

Your project code is already designed to auto-detect if it's running on `localhost`. As long as you followed the naming conventions above, it should work instantly.

1.  Open **Chrome** or **Edge**.
2.  Visit: `http://localhost/student-attendance-portal/public/`
3.  If the page loads, you are ready!

---

## 🔥 Step 5: How to Present Like a Pro

To impress the panel, follow these "best way" tips:

1.  **F11 Fullscreen:** Once your site is open, press **F11** in Chrome/Edge to hide the browser tabs and address bar. It makes the project look like a real standalone app.
2.  **Clear Records:** If you have junk data, use your "Seed" feature to reset the database to a clean state before presenting.
3.  **PPT Back-up:** Always have 3-5 slides ready (Problem, Solution, Tech Stack, ER Diagram) just in case they ask about the theory.
4.  **Responsive Mode:** Show them the project works on "Mobile" by right-clicking ➔ **Inspect** ➔ Clicking the Mobile Icon (Ctrl+Shift+M). This shows your code is modern.
5.  **The "Live" Flex:** If the college PC has internet, show them the live version at:
    `student-attendance-portal.great-site.net`
    (Mentioning you have deployed it online always gets extra marks!)

---

### ⚠️ Troubleshooting Tips
- **Port Error:** If XAMPP Apache doesn't start, common reasons are Skype or Port 80 being used. Close Skype or change the port in `httpd.conf`.
- **Blank Page:** Check if you extracted the files correctly. There should not be a "folder inside a folder" (e.g., `htdocs/portal/portal/...`).
- **Connection Error:** Ensure your `attendance_portal` database name in phpMyAdmin matches the name in `app/config/constants.php`.
