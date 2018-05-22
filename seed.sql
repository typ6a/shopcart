CREATE TABLE IF NOT EXISTS products (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  price float NOT NULL DEFAULT '0',
  rate float NOT NULL DEFAULT '0',
  rates_count int NOT NULL DEFAULT '0',
  picture varchar(255)
);

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS rates (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    value int NOT NULL,
    user_id int NOT NULL,
    product_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (id, name, price, rate, rates_count, picture) VALUES
(1, 'Apple', 0.3, 0, 0, 'images/apple.jpg'),
(2, 'Beer', 2, 0, 0, 'images/beer.jpg'),
(3, 'Chese', 3.74, 0, 0, 'images/chese.jpg'),
(4, 'Water', 1, 0, 0, 'images/water.jpg');

INSERT INTO users (username, password) VALUES
('admin', '$2y$10$HbjeY68saD0mZDuKVt4H...TJhMd6.vWqMqYeWOZyCeGfEXtm2lmm'); --123


