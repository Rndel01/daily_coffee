

CREATE TABLE coffee (
    coffee_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category ENUM('hot', 'cold', 'non-coffee') NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255)
);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    contact_number VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Customer') DEFAULT 'Customer'
);

CREATE TABLE transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    coffee_id INT NOT NULL,
    quantity INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Completed', 'Cancelled') DEFAULT 'Pending',

    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (coffee_id) REFERENCES coffee(coffee_id)
);

INSERT INTO coffee (name, category, price, image) VALUES
('Daily Coffee', 'cold', 150.00, 'daily_coffee.jpg'),
('Matcha', 'cold', 160.00, 'matcha.jpg'),
('Oreo Latte', 'cold', 140.00, 'oreo.jpg'),
('Caramel Macchiato', 'cold', 130.00, 'caramel.jpg'),
('Salted Caramel', 'cold', 130.00, 'salted-caramel.jpg'),
('Spanish Latte', 'cold', 130.00, 'spanish.jpg'),

('Salted Caramel', 'hot', 140.00, 'salted-caramel.jpg'),
('Spanish Latte', 'hot', 140.00, 'spanish.jpg'),
('Chocolate Milk', 'hot', 140.00, 'chocolate.jpg'),
('Caramel Macchiato', 'hot', 140.00, 'caramel.jpg'),

('Oreo Matcha', 'non-coffee', 160.00, 'oreo.jpg'),
('Matcha Latte', 'non-coffee', 150.00, 'matcha.jpg'),
('Oreo Milk', 'non-coffee', 130.00, 'oreo.jpg'),
('Chocolate Milk', 'non-coffee', 120.00, 'chocolate.jpg');