CREATE DATABASE journal_book;

USE journal_book;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE journals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    mood VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    journal_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);




# 🔥 1. USERS TABLE (UPGRADE)

👉 Password reset + profile support add කරනවා

```sql id="u1"
ALTER TABLE users 
ADD profile_pic VARCHAR(255) DEFAULT NULL,
ADD status ENUM('active','blocked') DEFAULT 'active';
```

---

# 🔥 2. JOURNALS TABLE (IMPROVED SaaS VERSION)

👉 ඔයාගේ එක already good 👍
but SaaS level එකට මෙහෙම improve කරමු:

```sql id="u2"
ALTER TABLE journals 
ADD updated_at TIMESTAMP NULL DEFAULT NULL,
ADD is_deleted TINYINT(1) DEFAULT 0;
```

---

## 💡 WHY THIS CHANGE?

✔ `updated_at` → edit tracking
✔ `is_deleted` → soft delete system (real SaaS feature)

---

# 🚀 3. NEW TABLE (IMPORTANT FOR ADVANCED APP)

## 🏷 TAGS SYSTEM (VERY PRO)

```sql id="u3"
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## 🔗 JOURNAL ↔ TAG RELATION (MANY TO MANY)

```sql id="u4"
CREATE TABLE journal_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    journal_id INT,
    tag_id INT,
    FOREIGN KEY (journal_id) REFERENCES journals(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
```

---

# 😃 4. MOOD SYSTEM (IMPROVED)

👉 string එකට වඩා ENUM better

```sql id="u5"
ALTER TABLE journals 
MODIFY mood ENUM('happy','sad','neutral','excited','stressed') DEFAULT 'neutral';
```

---

# 📊 5. (OPTIONAL BUT PRO) ANALYTICS TABLE

👉 SaaS dashboard stats සඳහා

```sql id="u6"
CREATE TABLE journal_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_entries INT DEFAULT 0,
    last_entry_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

