<?php

// LindseysPT DB Installation Script
// Delete this script after installation

// Connection details
$host = '';
$user = '';
$pws = '';

$pdo = new PDO("mysql:host={$host}", $user, $pws);

// Create the database
$pdo->exec('CREATE DATABASE IF NOT EXISTS LindseysPT');

// Create the tables
$tables = [
    'CREATE TABLE IF NOT EXISTS LindseysPT.Users (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(254) NOT NULL,
        password CHAR(60) NOT NULL,
        forename VARCHAR(50) NOT NULL,
        surname VARCHAR(50) NOT NULL,
        privilege_level TINYINT UNSIGNED NOT NULL DEFAULT 2,
        UNIQUE KEY (email)
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.Addresses (
        address_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        full_name VARCHAR(120) NOT NULL,
        address_line VARCHAR(200) NOT NULL,
        town_city VARCHAR(50) NOT NULL,
        county VARCHAR(50) NOT NULL,
        postcode VARCHAR(7) NOT NULL,
        phone_number VARCHAR(11) NULL,
        FOREIGN KEY (user_id) REFERENCES LindseysPT.Users (user_id) ON UPDATE CASCADE ON DELETE CASCADE
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.Products (
        product_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(70) NOT NULL,
        product_description TEXT NOT NULL,
        stock_level INT UNSIGNED DEFAULT 0,
        product_views INT UNSIGNED DEFAULT 0,
        price DECIMAL(5, 2) NOT NULL,
        preview_photo VARCHAR(70) NOT NULL
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.Purchases (
        purchase_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        FOREIGN KEY (user_id) REFERENCES LindseysPT.Users (user_id) ON UPDATE CASCADE ON DELETE NO ACTION
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.PurchasedProducts (
        purchase_id INT UNSIGNED NOT NULL,
        product_id INT UNSIGNED NOT NULL,
        quantity INT UNSIGNED DEFAULT 1,
        PRIMARY KEY (purchase_id, product_id),
        FOREIGN KEY (purchase_id) REFERENCES LindseysPT.Purchases (purchase_id) ON UPDATE CASCADE ON DELETE NO ACTION,
        FOREIGN KEY (product_id) REFERENCES LindseysPT.Products (product_id) ON UPDATE CASCADE ON DELETE NO ACTION
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.WebPages (
        web_page VARCHAR(40) NOT NULL PRIMARY KEY,
        page_title VARCHAR(50) NOT NULL,
        page_description VARCHAR(255) NOT NULL,
        page_keywords VARCHAR(255) NOT NULL
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.WebPageContent (
        web_content_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        web_page VARCHAR(40) NOT NULL,
        content TEXT NOT NULL,
        content_order TINYINT(3) UNSIGNED DEFAULT 1,
        FOREIGN KEY (web_page) REFERENCES LindseysPT.WebPages (web_page) ON UPDATE CASCADE ON DELETE CASCADE
    )ENGINE = InnoDB;',
    'CREATE TABLE IF NOT EXISTS LindseysPT.Posts (
        post_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        post_title VARCHAR(100) NOT NULL,
        post_content TEXT NOT NULL,
        post_date DATETIME NOT NULL,
        post_views INT UNSIGNED DEFAULT 0,
        user_id INT UNSIGNED NOT NULL,
        FOREIGN KEY (user_id) REFERENCES LindseysPT.Users (user_id) ON UPDATE CASCADE ON DELETE NO ACTION
    )ENGINE = InnoDB;'
];

foreach ($tables as $table)
    $pdo->exec($table);

// Populate the tables

$rows = [
    'INSERT INTO LindseysPT.WebPages VALUES
    ("index", "Personal Training | Lindsey\'s PT", "Personal training and health", "personal trainer, pt, fitness"),
    ("about", "About Me | Lindsey\'s PT", "My name is Lindsey and I am a personal trainer from Southampton.", "Southampton, personal trainer"),
    ("register", "User Registration | Lindsey\'s PT", "Sign up for an account.", ""),
    ("login", "User Login | Lindsey\'s PT", "Log in to your account.", ""),
    ("products", "Products | Lindsey\'s PT", "View all products sold by Lindsey.", ""),
    ("product", " | Lindsey\'s PT", "", ""),
    ("posts", "Blog Roll | Lindsey\'s PT", "Posts about fitness and health.", ""),
    ("post", " | Lindsey\'s PT", "", ""),
    ("contact", "Contact Me | Lindsey\'s PT", "Contact me with any questions.", ""),
    ("admin", "Admin - DashBoard | Lindsey\'s PT", "", "")',

    'INSERT INTO LindseysPT.WebPageContent VALUES
    (NULL, "index", "<p>Content placeholder 1</p>", 1),
    (NULL, "index", "<p>Content placeholder 2</p>", 2),
    (NULL, "index", "<p>Content placeholder 3</p>", 3),
    (NULL, "about", "<p>Content placeholder 1</p>", 1),
    (NULL, "about", "<p>Content placeholder 2</p>", 2),
    (NULL, "about", "<p>Content placeholder 3</p>", 3)'
];

foreach ($rows as $row)
    if ($pdo->exec($row) == 0)
        die('Installation failed (on row insertion)');

echo 'Done!';
