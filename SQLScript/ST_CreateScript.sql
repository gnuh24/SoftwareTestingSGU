DROP DATABASE IF EXISTS `SGU_Software_Testing`;
CREATE DATABASE IF NOT EXISTS `SGU_Software_Testing`;
USE `SGU_Software_Testing`;


/*________________________________________________________________________ TODO: Product tables_______________________________________________________________________ */
DROP TABLE IF EXISTS `Category`;
CREATE TABLE IF NOT EXISTS `Category`(
    `Id`    INT UNSIGNED        PRIMARY KEY    AUTO_INCREMENT,
    `CategoryName`  NVARCHAR(255)       NOT NULL
);

DROP TABLE IF EXISTS `Brand`;
CREATE TABLE IF NOT EXISTS `Brand`(
    `Id`       INT UNSIGNED        PRIMARY KEY    AUTO_INCREMENT,
    `BrandName`     NVARCHAR(255)       NOT NULL
);

DROP TABLE IF EXISTS `Product`;
CREATE TABLE IF NOT EXISTS `Product`(
    `Id`         INT UNSIGNED        PRIMARY KEY    AUTO_INCREMENT,
    `ProductName`       NVARCHAR(1000)      NOT NULL,
    `Status`            BOOLEAN            	NOT NULL,
    `CreateTime`        DATETIME           	NOT NULL,
    `Image`             VARCHAR(255)        NOT NULL,
    `Price`             INT UNSIGNED        NOT NULL,

    `Origin`            NVARCHAR(255)       NOT NULL,
    `Capacity`          INT UNSIGNED        NOT NULL,
    `ABV`               INT UNSIGNED        NOT NULL,
    `Quantity`          INT UNSIGNED        NOT NULL,
    `Description`       TEXT,


    `BrandId`           INT UNSIGNED   		NOT NULL,
	`CategoryId`	    INT UNSIGNED   		NOT NULL,
    FOREIGN KEY (`BrandId`)     	REFERENCES `Brand`(`Id`),
    FOREIGN KEY (`CategoryId`)  	REFERENCES `Category`(`Id`)
);


/*________________________________________________________________________ TODO: Account tables_______________________________________________________________________ */

DROP TABLE IF EXISTS `UserInformation`;
CREATE TABLE IF NOT EXISTS `UserInformation`(
    `Id`            INT UNSIGNED       PRIMARY KEY    AUTO_INCREMENT,
    `Email`         NVARCHAR(255)                   UNIQUE,
    `Address`       NVARCHAR(255),
    `Birthday`      DATE,
    `Fullname`      NVARCHAR(255),
    `Gender`        ENUM("Male", "Female", "Other"),
    `PhoneNumber`   NVARCHAR(20) 
);


DROP TABLE IF EXISTS `Account`;
CREATE TABLE IF NOT EXISTS `Account`(
    `Id`                INT UNSIGNED            PRIMARY KEY    AUTO_INCREMENT,
    `Password`          NVARCHAR(800)                               NOT NULL,
    `CreateTime`        DATETIME                                    NOT NULL,
    `Status`            BOOLEAN                                     NOT NULL,
    `Active`			BOOLEAN 		                            NOT NULL,
    `Role`              ENUM("User", "Admin")                       NOT NULL,
    -- `Type`				ENUM("FACEBOOK", "GOOGLE", "WEB", "OTHER"),
    `UserInformationId` INT UNSIGNED                                NOT NULL,
    FOREIGN KEY (`UserInformationId`) REFERENCES `UserInformation`(`Id`)
);

DROP TABLE IF EXISTS `TokenType`;
CREATE TABLE IF NOT EXISTS `TokenType`(
    `Id`                INT UNSIGNED       PRIMARY KEY    AUTO_INCREMENT,
    `TokenTypeName`     NVARCHAR(255)      NOT NULL     
);

DROP TABLE IF EXISTS `LogoutJWTToken`;
CREATE TABLE IF NOT EXISTS `LogoutJWTToken`(
    `Id`            INT UNSIGNED       PRIMARY KEY      AUTO_INCREMENT,
    `Token`         CHAR(255)          NOT NULL         UNIQUE,
    `LogoutTime`	DATETIME		   NOT NULL	
    -- `AccountId`     INT UNSIGNED       NOT NULL,
    -- FOREIGN KEY (`AccountId`) REFERENCES `Account`(`Id`)
);

DROP TABLE IF EXISTS `Token`;
CREATE TABLE IF NOT EXISTS `Token`(
    `Id`                INT UNSIGNED       PRIMARY KEY      AUTO_INCREMENT,
    `Token`             CHAR(36)           NOT NULL         UNIQUE,
    `CreateTime`	    DATETIME		   NOT NULL,
    `Expiration`    	DATETIME           NOT NULL,
    `TokenTypeId`       INT UNSIGNED       NOT NULL,
    `AccountId`         INT UNSIGNED       NOT NULL,
    FOREIGN KEY (`TokenTypeId`) REFERENCES `TokenType`(`Id`),
    FOREIGN KEY (`AccountId`) REFERENCES `Account`(`Id`)
);


/*________________________________________________________________________ TODO: Order tables_______________________________________________________________________ */
DROP TABLE IF EXISTS `CartItem`;
CREATE TABLE IF NOT EXISTS `CartItem` (
    `ProductId`         INT UNSIGNED       NOT NULL,
    `AccountId`         INT UNSIGNED       NOT NULL,
    `Quantity`          INT UNSIGNED       NOT NULL,
    `UnitPrice`         INT UNSIGNED       NOT NULL,
    `Total`             INT UNSIGNED       NOT NULL,

    PRIMARY KEY (`ProductId`, `AccountId`),
    FOREIGN KEY (`ProductId`)     REFERENCES `Product`(`Id`),
    FOREIGN KEY (`AccountId`)     REFERENCES `Account`(`Id`)
);

DROP TABLE IF EXISTS `Order`;
CREATE TABLE IF NOT EXISTS `Order` (
    `Id`                CHAR(12)           NOT NULL    PRIMARY KEY,
    `OrderTime`         DATETIME           NOT NULL,
    `TotalPrice`        INT UNSIGNED       NOT NULL,
    `Note`              TEXT,
    `AccountId`         INT UNSIGNED,
    FOREIGN KEY (`AccountId`) REFERENCES `Account` (`Id`)
);

DROP TABLE IF EXISTS `OrderStatus`;
CREATE TABLE IF NOT EXISTS `OrderStatus` (
    `OrderId`       CHAR(12)                                                        NOT NULL,
    `Status`        ENUM("ChoDuyet", "DaDuyet", "DangGiao", "GiaoThanhCong", "Huy") NOT NULL,
    `UpdateTime`    DATETIME                                                        NOT NULL,
    PRIMARY KEY (`OrderId`, `Status`),
    FOREIGN KEY (`OrderId`) REFERENCES `Order`(`Id`)
);

DROP TABLE IF EXISTS `OrderDetail`;
CREATE TABLE IF NOT EXISTS `OrderDetail` (
    `OrderId`       CHAR(12)           NOT NULL,
    `ProductId`     INT UNSIGNED       NOT NULL,
    `Quantity`      INT UNSIGNED       NOT NULL,
    `UnitPrice`     INT UNSIGNED       NOT NULL,
    `Total`         INT UNSIGNED       NOT NULL,
    FOREIGN KEY (`OrderId`) REFERENCES `Order`(`Id`),
    FOREIGN KEY (`ProductId`)     REFERENCES `Product`(`Id`),
    PRIMARY KEY (`ProductId`, `OrderId`)
);


/*______________________________________________________________________INVENTORY_________________________________________________________________________________________ */
DROP TABLE IF EXISTS `InventoryReport`;
CREATE TABLE IF NOT EXISTS `InventoryReport` (
    `Id`           	INT UNSIGNED       	PRIMARY KEY    AUTO_INCREMENT,
    `CreateTime`   	DATETIME           	NOT NULL                    ,
    `Supplier` 		NVARCHAR(255)									,
    `SupplierPhone`	NVARCHAR(100)									,
    `TotalPrice`	INT UNSIGNED		NOT NULL
);

DROP TABLE IF EXISTS `InventoryReportStatus`;
CREATE TABLE IF NOT EXISTS `InventoryReportStatus` (
    `InventoryReportId`           	INT UNSIGNED                            NOT NULL,
    `Status`        				ENUM("ChoNhapKho", "DaNhapKho",  "Huy") NOT NULL,
    `UpdateTime`    				DATETIME                                NOT NULL,
    PRIMARY KEY (`InventoryReportId`, `Status`),
    FOREIGN KEY (`InventoryReportId`) REFERENCES `InventoryReport`(`Id`)
);

DROP TABLE IF EXISTS `InventoryReportDetail`;
CREATE TABLE IF NOT EXISTS `InventoryReportDetail` (
    `InventoryReportId`       	INT UNSIGNED       NOT NULL,
    `ProductId`        			INT UNSIGNED       NOT NULL,
    `Quantity`      			INT UNSIGNED       NOT NULL,
    `UnitPrice`     			INT UNSIGNED       NOT NULL,
    `Total`         			INT UNSIGNED       NOT NULL,
    FOREIGN KEY (`InventoryReportId`) REFERENCES `InventoryReport`(`Id`),
    FOREIGN KEY (`ProductId`)     REFERENCES `Product`(`Id`),
    PRIMARY KEY (`ProductId`, `InventoryReportId`)
);