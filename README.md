# 📖 Journal SaaS

A modern, secure and user-friendly personal journal management system built with PHP, MySQL, HTML, CSS and JavaScript.

Journal SaaS allows users to securely create, manage, edit and organize their personal journal entries in one beautiful dashboard.

---

## ✨ Features

### 👤 User Management

- User Registration
- Secure Login System
- Password Hashing
- Session Authentication
- Logout
- User Profile
- Profile Picture
- First Name & Last Name
- Phone Number
- Address
- About Me
- Gender
- Birth Date
- Account Status

---

### 📝 Journal Management

- Create new journal entries
- Edit journal entries
- View journal details
- Delete journal entries
- Soft delete system
- Journal date
- Created date
- Updated date
- Mood tracking
- Character counter
- User-specific journals

---

### 😊 Mood Tracking

Users can select their mood when creating a journal.

Available moods:

- 😊 Happy
- 😔 Sad
- 😐 Neutral
- 🔥 Excited
- 😫 Stressed

---

### 🏷️ Tag System

Journal entries can be organized using tags.

Features include:

- Create tags
- Assign tags to journals
- Multiple tags per journal
- User-specific tags

---

### 📊 Dashboard

The dashboard provides a quick overview of the user's journal activity.

Includes:

- Total journals
- Recent journals
- Latest journal date
- Mood information
- Quick journal creation
- Search interface
- Profile access

---

## 🎨 UI / Design

Journal SaaS uses a modern SaaS-style interface.

### Design Features

- Responsive design
- Dark modern UI
- Glassmorphism effects
- Gradient backgrounds
- Smooth animations
- Hover effects
- Modern cards
- Responsive navigation
- Mobile-friendly layout

---

## 🔐 Security

The system includes several security features:

- Password hashing using PHP `password_hash()`
- Password verification using `password_verify()`
- Prepared SQL statements
- Session-based authentication
- User authorization
- SQL injection protection
- Soft delete support

---

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend development |
| MySQL | Database |
| HTML5 | Page structure |
| CSS3 | UI design |
| JavaScript | Client-side interactions |
| XAMPP | Local development |
| Apache | Web server |
| GitHub | Version control |

---

## 📂 Project Structure

```text
journal_book/
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── dashboard.php
│
├── add.php
├── view.php
├── edit.php
├── delete.php
│
├── profile.php
├── edit_profile.php
│
├── db.php
├── style.css
│
├── uploads/
│   └── profile images
│
└── README.md
