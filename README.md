Develop a basic online bookstore application. Users can browse books, add to cart, and place orders. Admins can manage inventory and orders.

## ✨ Features

### For Users
- **User Registration & Login**
- **Browse Books** with Search by Title/Author
- **Add to Cart** and Manage Cart
- **Checkout & Place Order**
- **User Dashboard** to view order history

### For Admin
- **Admin Login**
- **Manage Books** - Add, Edit, Delete Books
- **Manage Orders** - View all orders and update status: Pending, Shipped, Delivered
- **Manage Users** - View and delete users
- **Dashboard Analytics** - Total Users, Total Orders, Total Sales

## 🛠️ Tech Stack
- **Frontend**: HTML, CSS, Bootstrap 5
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP / WAMP / LAMP

## 📦 Database Setup

1.  phpMyAdmin open karo
2.  `bookstore` naam se database banao
3.  Ye 4 tables import karo:

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('user','admin') DEFAULT 'user'
);

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  price DECIMAL(10,2),
  book_image VARCHAR(255)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total_price DECIMAL(10,2),
  status ENUM('Pending','Shipped','Delivered') DEFAULT 'Pending',
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  book_id INT,
  quantity INT,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);