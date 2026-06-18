# Pastimes Web Application

## Overview
Pastimes is a web-based application developed to allow users to buy and sell second-hand clothing online. The system provides a simple and user-friendly platform where users can register, log in, upload clothing items, and browse available items.

We developed this project as part of a Portfolio of Evidence (POE) to demonstrate web development concepts using PHP and MySQL.

---

## Features

### User Features
- Register a new account
- Login using username and password
- View available clothing items
- Add items to cart
- Remove items from cart

### Seller Features
- Upload clothing items
- Add description, price, and images

### Admin Features
- View all registered users
- Verify users before they can log in

---

## Technologies Used
- PHP
- MySQL
- HTML
- CSS
- XAMPP (Apache & MySQL)

---

## How to Run the Project

1. Install XAMPP
2. Start Apache and MySQL
3. Place the project folder inside:
4. Open phpMyAdmin and create a database: clothingstore
5. Import or create tables (`tblUser`, `tblClothes`)
6. Open your browser and go to: http://localhost/PastimesApp


   
---

## Database Structure

### tblUser
- user_id (Primary Key)
- name
- email
- username
- password (hashed)
- isVerified

### tblClothes
- clothes_id (Primary Key)
- user_id (Foreign Key)
- name
- description
- price
- image

---

## System Functionality

- Users must register before logging in
- Admin must verify users before they can access the system
- Users can upload and view clothing items
- Items are displayed with images and seller information
- Users can add items to a shopping cart

---

## Authors
 Mutshidzi Nelufule ST10440481
 Hakundwi Nelufule ST10440479


---

## Notes
This system was designed to meet the requirements of the POE and includes additional features such as image uploads and a shopping cart for improved functionality and user experience.
