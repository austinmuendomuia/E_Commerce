CREATE TABLE users (
    user_id VARCHAR(20) PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATE
);
CREATE TABLE products (
    product_id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    category VARCHAR(50)
);
CREATE TABLE product_images (
    image_id VARCHAR(20) PRIMARY KEY,
    product_id VARCHAR(20),
    image_url VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
CREATE TABLE product_item (
    item_id VARCHAR(20) PRIMARY KEY,
    product_id VARCHAR(20),
    sku VARCHAR(100),
    stock_qty INT,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
CREATE TABLE cart (
    cart_id VARCHAR(20) PRIMARY KEY,
    user_id VARCHAR(20),
    created_at DATE,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
CREATE TABLE orders (
    order_id VARCHAR(20) PRIMARY KEY,
    user_id VARCHAR(20),
    total_amount DECIMAL(10, 2),
    order_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
CREATE TABLE order_items (
    item_id VARCHAR(20) PRIMARY KEY,
    order_id VARCHAR(20),
    product_id VARCHAR(20),
    quantity INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
CREATE TABLE reviews (
    review_id VARCHAR(20) PRIMARY KEY,
    user_id VARCHAR(20),
    product_id VARCHAR(20),
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
CREATE TABLE payments (
    payment_id VARCHAR(20) PRIMARY KEY,
    order_id VARCHAR(20),
    amount DECIMAL(10, 2),
    payment_method VARCHAR(20),
    status VARCHAR(20),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

INSERT INTO users (user_id, username, email, password, created_at) VALUES
('user_83714', 'Abdiwilly', 'abdiwilly@example.com', 'abdiwilly123', '2024-12-22'),
('user_29381', 'JoyN', 'joyn@example.com', 'joyn123', '2025-01-05'),
('user_58923', 'JoyM', 'joym@example.com', 'joym123', '2025-02-17'),
('user_91382', 'Austin', 'austin@example.com', 'austin123', '2025-03-03'),
('user_21987', 'Joe', 'joe@example.com', 'joe123', '2025-04-11'),
('user_88231', 'Okwudili', 'okwudili@example.com', 'okwudili123', '2025-03-21'),
('user_19345', 'Akinyi', 'akinyi@example.com', 'akinyi123', '2025-01-28'),
('user_64782', 'Kioko', 'kioko@example.com', 'kioko123', '2025-02-12'),
('user_33764', 'Mutua', 'mutua@example.com', 'mutua123', '2025-04-02'),
('user_76029', 'Ndira', 'ndira@example.com', 'ndira123', '2025-03-09');

INSERT INTO products (product_id, name, description, price, category) VALUES
('PRD_001A', 'Wireless Mouse', 'Ergonomic and fast.', 1200.50, 'Electronics'),
('PRD_002B', 'Bluetooth Speaker', 'Loud and portable.', 3400.00, 'Electronics'),
('PRD_003C', 'Leather Wallet', 'Stylish and slim.', 899.99, 'Accessories'),
('PRD_004D', 'Running Shoes', 'Comfortable fit.', 4500.00, 'Footwear'),
('PRD_005E', 'Water Bottle', 'BPA-Free, 1L.', 500.00, 'Home'),
('PRD_006F', 'Laptop Stand', 'Aluminum build.', 2300.00, 'Office'),
('PRD_007G', 'Desk Lamp', 'LED with USB port.', 1800.00, 'Office'),
('PRD_008H', 'Notebook', 'A5 size, 200 pages.', 150.00, 'Stationery'),
('PRD_009I', 'USB Flash Drive', '64GB USB 3.0.', 1200.00, 'Electronics'),
('PRD_010J', 'Phone Tripod', 'Adjustable height.', 2100.00, 'Photography');

INSERT INTO product_images (image_id, product_id, image_url) VALUES
('IMG_1', 'PRD_001A', 'img/mouse.jpg'),
('IMG_2', 'PRD_002B', 'img/speaker.jpg'),
('IMG_3', 'PRD_003C', 'img/wallet.jpg'),
('IMG_4', 'PRD_004D', 'img/shoes.jpg'),
('IMG_5', 'PRD_005E', 'img/bottle.jpg'),
('IMG_6', 'PRD_006F', 'img/stand.jpg'),
('IMG_7', 'PRD_007G', 'img/lamp.jpg'),
('IMG_8', 'PRD_008H', 'img/notebook.jpg'),
('IMG_9', 'PRD_009I', 'img/usb.jpg'),
('IMG_10', 'PRD_010J', 'img/tripod.jpg');

INSERT INTO product_item (item_id, product_id, sku, stock_qty) VALUES
('ITM_1A', 'PRD_001A', 'SKU_MOUSE_001', 50),
('ITM_2B', 'PRD_002B', 'SKU_SPKR_002', 35),
('ITM_3C', 'PRD_003C', 'SKU_WALL_003', 75),
('ITM_4D', 'PRD_004D', 'SKU_SHOE_004', 40),
('ITM_5E', 'PRD_005E', 'SKU_BOTT_005', 100),
('ITM_6F', 'PRD_006F', 'SKU_LSTD_006', 20),
('ITM_7G', 'PRD_007G', 'SKU_LAMP_007', 30),
('ITM_8H', 'PRD_008H', 'SKU_NOTE_008', 150),
('ITM_9I', 'PRD_009I', 'SKU_USB_009', 60),
('ITM_10J', 'PRD_010J', 'SKU_TRPD_010', 25);

INSERT INTO cart (cart_id, user_id, created_at) VALUES
('CRT_100A', 'USR_A1X9', '2025-06-01'),
('CRT_101B', 'USR_B2Y8', '2025-06-01'),
('CRT_102C', 'USR_C3Z7', '2025-06-02'),
('CRT_103D', 'USR_D4W6', '2025-06-02'),
('CRT_104E', 'USR_E5V5', '2025-06-03'),
('CRT_105F', 'USR_F6U4', '2025-06-03'),
('CRT_106G', 'USR_G7T3', '2025-06-04'),
('CRT_107H', 'USR_H8S2', '2025-06-04'),
('CRT_108I', 'USR_I9R1', '2025-06-05'),
('CRT_109J', 'USR_J0Q0', '2025-06-05');
INSERT INTO orders (order_id, user_id, total_amount, order_date) VALUES
('ORD_001A', 'USR_A1X9', 3400.00, '2025-06-01'),
('ORD_002B', 'USR_B2Y8', 899.99, '2025-06-01'),
('ORD_003C', 'USR_C3Z7', 1200.50, '2025-06-02'),
('ORD_004D', 'USR_D4W6', 4500.00, '2025-06-02'),
('ORD_005E', 'USR_E5V5', 500.00, '2025-06-03'),
('ORD_006F', 'USR_F6U4', 2300.00, '2025-06-03'),
('ORD_007G', 'USR_G7T3', 1800.00, '2025-06-04'),
('ORD_008H', 'USR_H8S2', 150.00, '2025-06-04'),
('ORD_009I', 'USR_I9R1', 2100.00, '2025-06-05'),
('ORD_010J', 'USR_J0Q0', 1200.00, '2025-06-05');
INSERT INTO order_items (item_id, order_id, product_id, quantity, price) VALUES
('OI_1', 'ORD_001A', 'PRD_002B', 1, 3400.00),
('OI_2', 'ORD_002B', 'PRD_003C', 1, 899.99),
('OI_3', 'ORD_003C', 'PRD_001A', 1, 1200.50),
('OI_4', 'ORD_004D', 'PRD_004D', 1, 4500.00),
('OI_5', 'ORD_005E', 'PRD_005E', 1, 500.00),
('OI_6', 'ORD_006F', 'PRD_006F', 1, 2300.00),
('OI_7', 'ORD_007G', 'PRD_007G', 1, 1800.00),
('OI_8', 'ORD_008H', 'PRD_008H', 1, 150.00),
('OI_9', 'ORD_009I', 'PRD_010J', 1, 2100.00),
('OI_10', 'ORD_010J', 'PRD_009I', 1, 1200.00);
INSERT INTO reviews (review_id, user_id, product_id, rating, comment) VALUES
('REV_01', 'USR_A1X9', 'PRD_001A', 5, 'Works great!'),
('REV_02', 'USR_B2Y8', 'PRD_002B', 4, 'Good sound quality.'),
('REV_03', 'USR_C3Z7', 'PRD_003C', 3, 'Looks nice, feels okay.'),
('REV_04', 'USR_D4W6', 'PRD_004D', 5, 'Super comfortable.'),
('REV_05', 'USR_E5V5', 'PRD_005E', 4, 'Keeps my water cold.'),
('REV_06', 'USR_F6U4', 'PRD_006F', 3, 'Bit wobbly but works.'),
('REV_07', 'USR_G7T3', 'PRD_007G', 5, 'Bright and handy.'),
('REV_08', 'USR_H8S2', 'PRD_008H', 4, 'Smooth paper.'),
('REV_09', 'USR_I9R1', 'PRD_009I', 5, 'Very fast.'),
('REV_10', 'USR_J0Q0', 'PRD_010J', 4, 'Sturdy and tall.');
INSERT INTO payments (payment_id, order_id, amount, payment_method, status) VALUES
('PAY_01', 'ORD_001A', 3400.00, 'Mpesa', 'Completed'),
('PAY_02', 'ORD_002B', 899.99, 'Card', 'Completed'),
('PAY_03', 'ORD_003C', 1200.50, 'Mpesa', 'Completed'),
('PAY_04', 'ORD_004D', 4500.00, 'Card', 'Pending'),
('PAY_05', 'ORD_005E', 500.00, 'Mpesa', 'Completed'),
('PAY_06', 'ORD_006F', 2300.00, 'Card', 'Completed'),
('PAY_07', 'ORD_007G', 1800.00, 'Mpesa', 'Completed'),
('PAY_08', 'ORD_008H', 150.00, 'Mpesa', 'Completed'),
('PAY_09', 'ORD_009I', 2100.00, 'Card', 'Completed'),
('PAY_10', 'ORD_010J', 1200.00, 'Mpesa', 'Pending');
