# 🗳️ Online Voting System for College

A secure and role-based online voting system built using **PHP** and **MySQL**, allowing college-level elections for students with dedicated logins for **voters**, **candidates**, and an **admin panel**.

---

## 🚀 Features

- 👨‍🏫 **Admin Panel**
  - Manage voters and candidates
  - Start/Stop the election process
  - View real-time voting results

- 🙋‍♂️ **Voter Panel**
  - Login securely with student ID
  - Cast vote only once
  - View voting confirmation

- 🧑‍💼 **Candidate Panel**
  - Register with student and Aadhar ID
  - View vote count post-election

- 🔐 Authentication using encrypted passwords (`bcrypt`)
- 📊 Voting data saved securely in relational tables
- 🧮 Enforced single vote per user via constraints
- 💾 Admin, voter, and candidate data stored in MySQL

---

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3, Bootstrap
- **Backend**: Core PHP
- **Database**: MySQL (via phpMyAdmin)
- **Encryption**: PHP `password_hash()` / `password_verify()`
- **Server**: XAMPP / Apache

---

## 🗃️ Database Schema (from `voting_system.sql`)

### 📌 Tables:
- `users` — Stores login info for all roles (`admin`, `voter`, `candidate`)
- `candidates` — Stores registered candidate profiles
- `votes` — Stores vote mappings and timestamps

### 🔐 Important Fields:
- `role` (ENUM): `'admin'`, `'voter'`, `'candidate'`
- Unique keys: `username`, `aadhar_id`, `college_reg_no`, `student_id`
- Foreign keys in `votes` table:
  - `user_id` → `users.id`
  - `candidate_id` → `candidates.id`

---

## 📥 How to Run the Project

1. 📦 Clone this repo or download it
2. 🧰 Move the project to your `htdocs` folder (XAMPP)
3. 🧬 Import `voting_system.sql` into phpMyAdmin
4. 🟢 Start **Apache** and **MySQL** using XAMPP
5. 🌐 Open your browser:
http://localhost/online-voting-system

yaml
Copy
Edit

---

## 🔐 Default Login Credentials (Demo)

| Role | Username | Password |
|------|----------|----------|
| Admin | `ahamed` | `admin123` *(change in DB or code)* |
| Voter | `bharathwaj` | *(hashed — use registration/login logic)* |
| Candidate | `bharathwaj009` | *(hashed — use registration/login logic)* |

> Passwords are hashed using `password_hash()` — to test, use your login form logic.

---

## 📸 Optional: Screenshots

_Add screenshots of login page, admin dashboard, voting panel, and results here._

---

## 📬 Author

**Ahamed Ibrahim Abdul Samadhu**  
📧 [ahamedibrahiminfo@gmail.com](mailto:ahamedibrahiminfo@gmail.com)  
🌐 [GitHub](https://github.com/AhamedIbrahim002)

---

## 📜 License

This project is for academic and educational use only.
