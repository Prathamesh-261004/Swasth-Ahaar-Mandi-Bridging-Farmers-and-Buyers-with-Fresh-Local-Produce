CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('farmer', 'buyer'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT,
    name VARCHAR(100),
    quantity INT,
    price_per_kg FLOAT,
    unit VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES users(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT,
    produce_id INT,
    quantity INT,
    status ENUM('pending', 'shipped', 'delivered') DEFAULT 'pending',
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (produce_id) REFERENCES produce(id)
);

CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT,
    buyer_id INT,
    rating INT,
    feedback TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES users(id),
    FOREIGN KEY (buyer_id) REFERENCES users(id)
);
