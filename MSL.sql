/* 
 * Author: Anıl Doğru
 * Date:   23.11.2017
 */

CREATE TABLE UserTitles (
	TitleName VARCHAR(32) NOT NULL UNIQUE,
	PRIMARY KEY (TitleName)
);

CREATE TABLE User (
	UserName VARCHAR(32) NOT NULL UNIQUE,
	UserEmail VARCHAR(32) NOT NULL UNIQUE,
	Name VARCHAR(32) NOT NULL,
	Surname VARCHAR(32) NOT NULL,
	Password VARCHAR(32) NOT NULL,
	TitleName VARCHAR(32) NOT NULL DEFAULT 'Customer',
	PRIMARY KEY (UserName),
	FOREIGN KEY (TitleName) REFERENCES UserTitles (TitleName) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE Employee (
	UserName VARCHAR(32) NOT NULL UNIQUE,
	Salary FLOAT UNSIGNED NOT NULL,
	FOREIGN KEY (UserName) REFERENCES User (UserName) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Pages (
	PageName VARCHAR(32) NOT NULL UNIQUE,
	PageDescription VARCHAR(64) NOT NULL,
	PRIMARY KEY (PageName)
);

CREATE TABLE Roles (
    RoleID INT AUTO_INCREMENT NOT NULL UNIQUE,
	TitleName VARCHAR(32) NOT NULL,
	PageName VARCHAR(32) NOT NULL,
    PRIMARY KEY (RoleID),
	FOREIGN KEY (TitleName) REFERENCES UserTitles (TitleName) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (PageName) REFERENCES Pages (PageName) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE Brand (
	BrandID INT AUTO_INCREMENT NOT NULL UNIQUE,
	BrandName VARCHAR(32) NOT NULL,
	PRIMARY KEY (BrandID)
);

CREATE TABLE Product (
	ProductID INT AUTO_INCREMENT NOT NULL UNIQUE,
	ProductName VARCHAR(32) NOT NULL,
	Stock INT UNSIGNED NOT NULL,
	Price FLOAT UNSIGNED NOT NULL,
	Cost FLOAT UNSIGNED NOT NULL,
	BrandID INT NOT NULL,
	FOREIGN KEY (BrandID) REFERENCES Brand (BrandID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Review (
	UserName VARCHAR(32) NOT NULL,
	ProductID INT NOT NULL,
	ReviewPoint INT UNSIGNED NOT NULL,
	FOREIGN KEY (UserName) REFERENCES User (UserName) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (ProductID) REFERENCES Product (ProductID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE SaleState (
	StateID INT AUTO_INCREMENT NOT NULL UNIQUE,
	StateDescription VARCHAR(32) NOT NULL,
	PRIMARY KEY (StateID)
);

CREATE TABLE Sales (
	SaleID INT AUTO_INCREMENT NOT NULL UNIQUE,
	SaleState INT NOT NULL DEFAULT 1,
	UserName VARCHAR(32) NOT NULL,
	ProductID INT NOT NULL,
	Amount INT UNSIGNED NOT NULL,
	CreatedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
	ChangedDate DATETIME ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (SaleID),
	FOREIGN KEY (UserName) REFERENCES User (UserName) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (ProductID) REFERENCES Product (ProductID) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO UserTitles (TitleName) VALUES ('Customer');
INSERT INTO UserTitles (TitleName) VALUES ('Employee');
INSERT INTO UserTitles (TitleName) VALUES ('Manager');

INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_MAIN', 'Home');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_ACCOUNTING', 'Accounting');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PROFILE', 'Profile');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PRODUCT_ADD', 'Create Product');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PRODUCT_UPDATE', 'Update Product');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PRODUCT_DISPLAY', 'Display Product');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PRODUCT_DISPLAYDETAIL', 'Display Product Detail');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PRODUCT_SEARCH', 'Search Product');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_EMPLOYEE_ADD', 'Create Employee');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_EMPLOYEE_UPDATE', 'Update Employee');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_EMPLOYEE_DISPLAY', 'Display Employee');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_EMPLOYEE_SEARCH', 'Search Employee');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_BRAND_ADD', 'Create Brand');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_BRAND_UPDATE', 'Update Brand');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_BRAND_DISPLAY', 'Display Brand');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_BRAND_SEARCH', 'Search Brand');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_USER_UPDATE', 'Update User');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_USER_DISPLAY', 'Display User');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_USER_SEARCH', 'Search User');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_SHOPPING_CART', 'Shopping Cart');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PURCHASE_HISTORY', 'Purchase History');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PURCHASE_DISPLAY', 'Display Purchase');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PURCHASE_UPDATE', 'Update Purchase');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PURCHASE_SEARCH', 'Search Purchase');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_PURCHASE_CONFIRMATION', 'Confirm Purchase');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_RETURN_DISPLAY', 'Display Return');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_RETURN_HISTORY', 'Return History');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_RETURN_SEARCH', 'Search Return');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_RETURN_CONFIRMATION', 'Confirm Return');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_STOCKDEMAND_SEARCH', 'Search Stock Demands');
INSERT INTO Pages (PageName, PageDescription) VALUES ('PAGE_STOCKDEMAND_CONFIRMATION', 'Confirm Stock Demands');

INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_ACCOUNTING', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PRODUCT_ADD', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PRODUCT_UPDATE', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PRODUCT_UPDATE', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PRODUCT_DISPLAYDETAIL', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PRODUCT_DISPLAYDETAIL', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_EMPLOYEE_ADD', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_EMPLOYEE_UPDATE', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_EMPLOYEE_DISPLAY', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_EMPLOYEE_SEARCH', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_BRAND_ADD', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_BRAND_UPDATE', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_USER_UPDATE', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_USER_UPDATE', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_USER_DISPLAY', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_USER_DISPLAY', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_USER_SEARCH', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_USER_SEARCH', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PURCHASE_SEARCH', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_PURCHASE_CONFIRMATION', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_RETURN_SEARCH', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_RETURN_CONFIRMATION', 'Employee');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_STOCKDEMAND_SEARCH', 'Manager');
INSERT INTO Roles (PageName, TitleName) VALUES ('PAGE_STOCKDEMAND_CONFIRMATION', 'Manager');

INSERT INTO SaleState (StateDescription) VALUES ('Preparing Shopping Cart');
INSERT INTO SaleState (StateDescription) VALUES ('Awaiting Purchase Confirmation');
INSERT INTO SaleState (StateDescription) VALUES ('Purchase Completed');
INSERT INTO SaleState (StateDescription) VALUES ('Awaiting Return Confirmation');
INSERT INTO SaleState (StateDescription) VALUES ('Return Completed');

CREATE VIEW Accounting AS 
	SELECT UserName, (Name + ' ' + Surname) AS FullName, BrandID, BrandName, ProductID, ProductName, Price, Cost, (Price - Cost) AS UnitProfit, Amount, (Amount * (Price - Cost)) AS Profit, ChangedDate AS PurchasedDate, Stock 
    FROM (Sales natural join (Product natural join Brand)) natural join User 
    WHERE SaleState = 3 ORDER BY ChangedDate DESC;
    
CREATE VIEW Employees AS 
	SELECT UserName, Name, Surname, UserEmail, TitleName, Salary 
    FROM Employee natural join User 
    WHERE TitleName != 'Customer' ORDER BY TitleName, UserName ASC;

DELIMITER $$
CREATE PROCEDURE AddUser (
	UserName VARCHAR(32),
    UserEmail VARCHAR(32),
    Name VARCHAR(32),
    Surname VARCHAR(32), 
    Password VARCHAR(32), 
    TitleName VARCHAR(32)
    )
BEGIN
	DECLARE EXIT HANDLER FOR SQLWARNING BEGIN
		SET @exiting = 1;
    END;
    
    INSERT INTO User (UserName, UserEmail, Name, Surname, Password, TitleName) VALUES (UserName, UserEmail, Name, Surname, MD5(Password), TitleName);
    SELECT * FROM User WHERE User.UserName = UserName;
END$$

CREATE PROCEDURE AddEmployee(
	UserName VARCHAR(32),
    UserEmail VARCHAR(32),
    Name VARCHAR(32),
    Surname VARCHAR(32), 
    Password VARCHAR(32), 
    TitleName VARCHAR(32), 
	Salary FLOAT
    )
Adding:BEGIN
	DECLARE EXIT HANDLER FOR SQLWARNING BEGIN
		ROLLBACK;
		SET @exiting = 1;
    END;
    
	IF (TitleName = 'Customer') THEN
		SELECT 'Title cannot be Customer' AS Error;
		LEAVE Adding;
	END IF;
    
	START TRANSACTION;
		INSERT INTO User (UserName, UserEmail, Name, Surname, Password, TitleName) VALUES (UserName, UserEmail, Name, Surname, MD5(Password), TitleName);
		INSERT INTO Employee (UserName, Salary) VALUES (UserName, ABS(Salary));
        SELECT * FROM Employees WHERE Employees.UserName = UserName;
	COMMIT;
END$$

CREATE FUNCTION ChangePassword(
	UserName VARCHAR(32),
	OldPassword VARCHAR(32),
    	NewPassword VARCHAR(32)
    )
    RETURNS BOOL
BEGIN
	IF NOT EXISTS (SELECT * FROM User WHERE User.UserName = UserName AND User.Password = MD5(OldPassword)) THEN
		RETURN FALSE;
	ELSE 
		UPDATE User SET Password = MD5(NewPassword) WHERE User.UserName = UserName;
		RETURN TRUE;
    	END IF;
END$$

CREATE FUNCTION CheckRole(
	UserName VARCHAR(32),
    PageName VARCHAR(32)
    )
    RETURNS BOOL
BEGIN
    IF (SELECT count(TitleName) FROM Roles WHERE Roles.PageName = PageName) = 0 THEN
		RETURN TRUE;
	ELSE 
		RETURN EXISTS (SELECT * FROM Roles natural join User WHERE Roles.PageName = PageName AND User.UserName = UserName);
	END IF;
END$$
DELIMITER ;

CALL AddEmployee('anil.true', 'anil.dogru@ozu.edu.tr', 'Anıl', 'Doğru', '123456', 'Manager', 5000);
