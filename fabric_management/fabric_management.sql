SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

--
-- Dumping data for table `users` 

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

CREATE TABLE IF NOT EXISTS fabrics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fabric_type VARCHAR(255),
    purchase_date DATE,
    total_length_inches INT,
    total_length_yards DECIMAL(10, 2),
    image_path VARCHAR(255),
    thumbnail_path VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS accessories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accessory_type VARCHAR(255),
    purchase_date DATE,
    quantity INT,
	quantity_bought INT,
    image_path VARCHAR(255),
    thumbnail_path VARCHAR(255)
);

CREATE TABLE user_actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    fabric_id INT,
    accessory_id INT,
    action_type ENUM('cut', 'take_out'),
    amount INT,
    action_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (fabric_id) REFERENCES fabrics(id),
    FOREIGN KEY (accessory_id) REFERENCES accessories(id)
);
