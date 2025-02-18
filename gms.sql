-- Table to store user information
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    PasswordHash VARCHAR(255),  -- For storing hashed passwords
    DateCreated DATETIME DEFAULT CURRENT_TIMESTAMP,
    LastLogin DATETIME
);


-- Table to store classes
CREATE TABLE Classes (
    ClassID INT PRIMARY KEY AUTO_INCREMENT,
    ClassName VARCHAR(100),
    Description TEXT,
    ClassDate DATETIME,
    Capacity INT
);

    -- Table to store bookings
CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    ClassID INT,
    BookingStatus ENUM('New', 'Approved', 'Cancelled') DEFAULT 'New',
    BookingDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (ClassID) REFERENCES Classes(ClassID)
);

-- Table to store admin information
CREATE TABLE Admins (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    PasswordHash VARCHAR(255),
    DateCreated DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table to store inquiries
CREATE TABLE Inquiries (
    InquiryID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    InquiryMessage TEXT,
    IsRead BOOLEAN DEFAULT FALSE,
    InquiryDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Insert into Users table
INSERT INTO Users (FullName, Email, PasswordHash, DateCreated)
VALUES 
    ('John Doe', 'john@example.com', 'hashed_password1', CURRENT_TIMESTAMP),
    ('Jane Smith', 'jane@example.com', 'hashed_password2', CURRENT_TIMESTAMP),
    ('Alice Brown', 'alice@example.com', 'hashed_password3', CURRENT_TIMESTAMP),
    ('Bob White', 'bob@example.com', 'hashed_password4', CURRENT_TIMESTAMP),
    ('Charlie Green', 'charlie@example.com', 'hashed_password5', CURRENT_TIMESTAMP);

-- Insert into Admins table
INSERT INTO Admins (FullName, Email, PasswordHash, DateCreated) 
VALUES ('Admin', 'admin1@example.com', 'hashed_password1', CURRENT_TIMESTAMP);

-- Insert into Classes table
INSERT INTO Classes (ClassName, Description, ClassDate, Capacity)
VALUES 
    ('Yoga', 'A relaxing yoga class', '2025-02-20 10:00:00', 20),
    ('HIIT', 'High Intensity Interval Training', '2025-02-21 09:00:00', 15),
    ('Zumba', 'Dance your way to fitness', '2025-02-22 18:00:00', 25),
    ('Pilates', 'Core strength workout', '2025-02-23 17:00:00', 20),
    ('Spin', 'Intense cycling session', '2025-02-24 07:00:00', 30);


-- Insert into Bookings table
INSERT INTO Bookings (UserID, ClassID, BookingStatus, BookingDate)
VALUES
    (1, 1, 'New', CURRENT_TIMESTAMP),
    (2, 2, 'Approved', CURRENT_TIMESTAMP),
    (3, 3, 'Cancelled', CURRENT_TIMESTAMP),
    (4, 4, 'New', CURRENT_TIMESTAMP),
    (5, 5, 'Approved', CURRENT_TIMESTAMP);

-- Insert into Inquiries table
INSERT INTO Inquiries (UserID, InquiryMessage, IsRead, InquiryDate)
VALUES
    (1, 'What are the available yoga timings?', FALSE, CURRENT_TIMESTAMP),
    (2, 'How much is the HIIT class fee?', FALSE, CURRENT_TIMESTAMP),
    (3, 'Can I cancel a booking?', TRUE, CURRENT_TIMESTAMP),
    (4, 'Are there any new fitness programs?', FALSE, CURRENT_TIMESTAMP),
    (5, 'What are the timings for Pilates?', TRUE, CURRENT_TIMESTAMP);

INSERT INTO Users (FullName, Email, PasswordHash, DateCreated)
VALUES ('New User', 'newuser@example.com', 'new_password_hash', CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE FullName = VALUES(FullName), PasswordHash = VALUES(PasswordHash), LastLogin = CURRENT_TIMESTAMP;

UPDATE Bookings
SET BookingStatus = 'Approved'
WHERE BookingID = 1;

UPDATE Inquiries
SET IsRead = TRUE
WHERE InquiryID = 1;

-- Insert new class into Classes table
INSERT INTO Classes (ClassName, Description, ClassDate, Capacity)
VALUES ('CrossFit', 'Intense functional fitness', '2025-03-01 11:00:00', 20);

-- Insert new booking for the new class
INSERT INTO Bookings (UserID, ClassID, BookingStatus, BookingDate)
VALUES (1, 6, 'New', CURRENT_TIMESTAMP);
