CREATE DATABASE ProductManagement;
USE ProductManagement;

-- Staff table (for authentication)
CREATE TABLE tbStaffs (
    stID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Gen ENUM('Male','Female','Other'),
    Dob DATE,
    Position VARCHAR(50),
    Salary DECIMAL(10,2),
    Stopwork BOOLEAN DEFAULT 0,
    Username VARCHAR(50) UNIQUE,
    PasswordHash VARCHAR(255),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Suppliers
CREATE TABLE tbSuppliers (
    supID INT AUTO_INCREMENT PRIMARY KEY,
    Supplier VARCHAR(100) NOT NULL,
    SupAdd VARCHAR(255),
    SupCon VARCHAR(50),
    Status BOOLEAN DEFAULT 1
);

-- Products (with auto‑increment ProID and image column)
CREATE TABLE tbProducts (
    ProID INT AUTO_INCREMENT PRIMARY KEY,
    ProCode VARCHAR(50) NOT NULL UNIQUE,
    ProName VARCHAR(100) NOT NULL,
    Qty INT DEFAULT 0,
    UPIS DECIMAL(10,2),
    SUP DECIMAL(10,2),
    Status BOOLEAN DEFAULT 1,
    supID INT,
    ProductImage VARCHAR(255),
    FOREIGN KEY (supID) REFERENCES tbSuppliers(supID) ON DELETE SET NULL
);

-- Customers
CREATE TABLE tbCustomers (
    cusID INT AUTO_INCREMENT PRIMARY KEY,
    CusName VARCHAR(100) NOT NULL,
    CusContact VARCHAR(100),
    Status BOOLEAN DEFAULT 1
);

-- Orders
CREATE TABLE tbOrders (
    OrID INT AUTO_INCREMENT PRIMARY KEY,
    OrdDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    stID INT,
    FullName VARCHAR(100),
    cusID INT,
    cusName VARCHAR(100),
    Total DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (stID) REFERENCES tbStaffs(stID),
    FOREIGN KEY (cusID) REFERENCES tbCustomers(cusID)
);

-- Order Details
CREATE TABLE tbOrderDetails (
    DetailID INT AUTO_INCREMENT PRIMARY KEY,
    OrID INT,
    ProID INT,
    Quantity INT NOT NULL,
    UnitPrice DECIMAL(10,2) NOT NULL,
    Subtotal DECIMAL(10,2) GENERATED ALWAYS AS (Quantity * UnitPrice) STORED,
    FOREIGN KEY (OrID) REFERENCES tbOrders(OrID),
    FOREIGN KEY (ProID) REFERENCES tbProducts(ProID)
);

-- Payments
CREATE TABLE tbPayments (
    PayCode VARCHAR(50) PRIMARY KEY,
    PayDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    stID INT,
    FullName VARCHAR(100),
    OrID INT,
    Amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (stID) REFERENCES tbStaffs(stID),
    FOREIGN KEY (OrID) REFERENCES tbOrders(OrID)
);

-- Insert sample staff (password 'admin123' hashed)
INSERT INTO tbStaffs (FullName, Gen, Dob, Position, Salary, Username, PasswordHash) VALUES
('Admin', 'Male', '1990-01-01', 'Admin', 5000, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample suppliers
INSERT INTO tbSuppliers (Supplier, SupAdd, SupCon, Status) VALUES
('Tech Solutions', '123 Tech Street', '555-1234', 1),
('Global Supplies', '456 Supply Ave', '555-5678', 1);

-- Insert sample products
INSERT INTO tbProducts (ProCode, ProName, Qty, UPIS, SUP, supID, ProductImage) VALUES
('LAP001', 'Gaming Laptop', 10, 800.00, 1200.00, 1, NULL),
('PHN001', 'Smartphone', 25, 400.00, 699.00, 2, NULL);