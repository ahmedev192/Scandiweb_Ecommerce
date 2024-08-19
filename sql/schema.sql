-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    type ENUM('DVD', 'Book', 'Furniture') NOT NULL
);

-- Create product_dvd table
CREATE TABLE product_dvd (
    id INT PRIMARY KEY,
    size_mb INT NOT NULL,
    FOREIGN KEY (id) REFERENCES products(id)
);

-- Create product_book table
CREATE TABLE product_book (
    id INT PRIMARY KEY,
    weight_kg DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES products(id)
);

-- Create product_furniture table
CREATE TABLE product_furniture (
    id INT PRIMARY KEY,
    height_cm DECIMAL(5, 2) NOT NULL,
    width_cm DECIMAL(5, 2) NOT NULL,
    length_cm DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES products(id)
);
