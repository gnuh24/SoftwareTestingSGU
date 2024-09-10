USE `SGU_Software_Testing`;





INSERT INTO `Category` 	(`CategoryName`) VALUES
						('Các loại sản phẩm khác'),
						('Vodka'),
						('Tequila'),
						('Wishkey');

INSERT INTO `Brand` (`BrandName`) VALUES
					('Các thương hiệu khác'),
					('Suntory'),
					('Hanoi Wine'),
					('Beluga'),
					('Sidney Frank Importing Company'),
                    
					('Stoli'),
					('Danzka'),
					("Glen's Platinum Scoth Wishky"),
					('Tequila Clase Azul'),
					('Don Julio Gonzalez'),
                    
					('Patrón Spirits Company'),
					('Maestro Dobel Tequila'),
					('Gran Centenario'),
					('Tequila 1800'),
					('Johnnie Walker');

                    
-- INSERT INTO Product	
INSERT INTO `Product` (`Id`, `ProductName`, 						`Status`, 		`CreateTime`, 			`Image`, 							`Price`, 	`Origin`, 		`Capacity`, 	`ABV`, 		`Quantity`, 	`Description`, 					`BrandId`, `CategoryId`) VALUES
						(1, 'HaKu Vodka', 							TRUE, 			'2024-07-03 10:00:00', 'SoftwareTestingProject/hakuvodka', 					150000, 	'Japan',		 	700, 			40, 		50, 		'A smooth Japanese vodka.', 		2, 				2),
						(2, 'HaNoi VodKa', 							TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/hanoiVodka', 					200000, 	'Vietnam', 			500, 			39, 		100, 		'Classic Vietnamese vodka.', 		3, 				2),
						(3, 'Beluga Noble', 						TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/belugaNoble', 					350000, 	'Russia', 			700,			40, 		30, 		'Premium Russian vodka.', 			4, 				2),
						(4, 'Grey Goose', 							TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/greyGoose', 					450000, 	'France', 			750, 			40, 		20, 		'French luxury vodka.', 			5, 				2),
						(5, 'Beluga Allure', 						TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/belugaAllure', 				500000, 	'Russia', 			700, 			40, 		15, 		'Luxurious Russian vodka.', 		4, 				2),
						(6, 'King Robert', 							FALSE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/kingRobert', 					250000, 	'Scotland', 		750, 			43, 		25, 		'Strong Scottish vodka.', 			2, 				2),
						(7, 'Smirnoff Red Vodka', 					TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/smirnoffRedVodka', 					180000, 	'USA', 				750, 			37, 		50, 		'Popular American vodka.',			5, 				2),
						(8, 'Stolichnaya Vodka',					TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/Stolichnaya', 			220000, 	'Russia', 			700, 			38, 		40, 		'Famous Russian vodka.',			6, 				2),
						(9, 'Vodka Danzka', 						TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/vodkaDanzka', 					280000, 	'Denmark', 			700, 			40, 		30, 		'Danish vodka.', 					7, 				2),
						(10, "Glen'S Platinum", 					TRUE, 			'2024-07-02 10:00:00', 'SoftwareTestingProject/glenPlatinum', 				320000, 	'Scotland', 		700,			40, 		35, 		'Scottish vodka.', 					8, 				2),

						-- Tequila products
						(11, 'Tequila Clase Azul Reposado', 		TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/tequilaClaseAzuiReposado', 			800000, 	'Mexico', 			750,			40, 		20, 		'Premium Reposado Tequila.', 		9, 				3),
						(12, 'Don Julio 1942', 						TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/donJulio', 				1200000, 	'Mexico', 			750, 			40, 		10, 		'Luxury Añejo Tequila.', 			10, 			3),
						(13, 'Patrón Silver', 						TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/patronSilver',					700000, 	'Mexico',			750, 			40, 		25, 		'Smooth Silver Tequila.', 			11, 			3),
						(14, 'Maestro Dobel Diamante', 				FALSE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/maestroDobel', 		900000, 	'Mexico', 			750,			40, 		18, 		'Premium Cristalino Tequila.', 		12, 			3),
						(15, 'Gran Centenario Plata', 				TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/granCentenario', 		600000, 	'Mexico', 			750, 			40, 		22, 		'Smooth Plata Tequila.', 			13, 			3),
						(16, 'Tequila 1800 Añejo', 					TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/tequila1800Anejo', 			1000000, 	'Mexico', 			750, 			40, 		15, 		'Aged Añejo Tequila.', 				14, 			3),
						(17, 'Tequila Clase Azul Plata', 			TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/tequilaClaseAzuiPlata', 				850000, 	'Mexico', 			750, 			40, 		20,		 	'Premium Plata Tequila.', 			9, 				3),
						(18, 'Don Julio Blanco', 					TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/donJulioBlanco', 				950000, 	'Mexico', 			750, 			40, 		12, 		'Smooth Blanco Tequila.', 			10, 			3),
						(19, 'Patrón Añejo', 						TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/patronAnejo',					1100000, 	'Mexico', 			750, 			40, 		10, 		'Rich Añejo Tequila.', 				11, 			3),
						(20, 'Tequila 1800 Silver', 				TRUE, 			'2024-07-03 11:00:00', 'SoftwareTestingProject/Tequila1800Silver',			650000, 	'Mexico', 			750, 			40, 		25, 		'Popular Silver Tequila.', 			14, 			3),

						-- Wishkey products from Johnnie Walker
						(21, 'Johnnie Walker Red Label', 			TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerRed', 			450000, 	'Scotland', 		750, 			40, 		50, 		'Iconic Red Label Wishkey.', 		15, 			4),
						(22, 'Johnnie Walker Black Label', 			TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerBlack', 			650000, 	'Scotland', 		750, 			40, 		40, 		'Classic Black Label Wishkey.', 	15, 			4),
						(23, 'Johnnie Walker Double Black', 		TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerDoubleBlack', 	750000, 	'Scotland', 		750, 			40, 		30, 		'Smokier Double Black Wishkey.', 	15, 			4),
						(24, 'Johnnie Walker Gold Label Reserve', 	FALSE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerGold', 			900000, 	'Scotland', 		750, 			40, 		20, 		'Luxurious Gold Label Wishkey.', 	15, 			4),
						(25, 'Johnnie Walker Green Label', 			TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerGreen',			 850000, 	'Scotland', 		750, 			40, 		15, 		'Smooth Green Label Wishkey.', 		15, 			4),
						(26, 'Johnnie Walker Platinum Label', 		TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerPlatinum', 		1200000, 	'Scotland', 		750,			40, 		10, 		'Exclusive Platinum Label Wishkey.',15, 			4),
						(27, 'Johnnie Walker Blue Label', 			TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerBlue', 			2500000, 	'Scotland', 		750, 			40, 		5, 			'Rare Blue Label Wishkey.', 		15, 			4),
						(28, 'Johnnie Walker Gold Label 18', 		FALSE,			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerGold18', 		1350000, 	'Scotland', 		750, 			40, 		12, 		'Aged 18 Years Wishkey.', 			15, 			4),
						(29, 'Johnnie Walker Green Label 15', 		TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/johnnieWalkerGreen15', 		1100000, 	'Scotland', 		750,			40, 		8, 			'15-Year-Old Wishkey.', 			15, 			4),
						(30, 'Johnnie Walker King George V',		TRUE, 			'2024-07-03 12:00:00', 'SoftwareTestingProject/kingGeorgeV', 	3500000, 	'Scotland', 		750,			40, 		3, 			'Exclusive King George V Wishkey.', 15, 			4);
											
                    
			


       
-- Insert sample data into UserInformation table
INSERT INTO `UserInformation` 	(`Id`, 		`Email`, 							`Address`, 			`Birthday`, 		`Fullname`, 		`Gender`,		 `PhoneNumber`) VALUES
								(1, 		'admin@gmail.com', 					'123 Main St', 		'2004-04-01', 		'Ngô Tuấn Hưng', 	'Male', 		'123-456-7890'),
								(2, 		'nguyenphucminh880@gmail.com', 		'456 Elm St', 		'2004-11-15', 		'Nguyễn Minh Phúc', 'Male', 		'234-567-8901'),
								(3, 		'hungnt.020404@gmail.com', 			'123 Main St', 		'2004-04-01', 		'Ngô Tuấn Hưng', 	'Male', 		'123-456-7890');


                        
                        -- Insert sample data into Account table
INSERT INTO `Account` 	(`Id`,			`Password`,														 `Status`, 		`Role`,		`UserInformationId`,		`CreateTime`, 			`Active`) VALUES
						(1,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'Admin',					1,			'2023-01-01 00:00:00',			1),
						(2,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	0, 			'User',						2,			'2024-01-01 00:00:00',  		1),
						(3,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						3,			'2025-01-01 00:00:00',  		1);


-- Insert sample data into UserInformation table
INSERT INTO `TokenType` 		(`Id`, 	`TokenTypeName`) VALUES
								(1, 	'Registration'),
								(2, 	'ResetPassword'),
								(3, 	'LoginAdmin');


-- Insert sample data into the `Order` table
INSERT INTO `Order` (`Id`, 				`OrderTime`, 				`TotalPrice`, 	`Note`, 								`AccountId`, 	`Paid`, 	`PaymentOption`) VALUES
					('ORD00000001', 	'2024-01-05 09:30:00',	 	3650000, 		'Please deliver in the morning.', 				3,		false,			"COD"),
					('ORD00000002', 	'2024-01-05 10:15:00', 		1350000, 		'Gift for a friend.', 							2,		false,			"COD"),
					('ORD00000003', 	'2024-01-05 11:00:00', 		2500000, 		'Include a gift note.', 						3,		false,			"COD"),
					('ORD00000004', 	'2024-01-06 08:45:00', 		800000, 		'Deliver to office.', 							3,		false,			"COD"),
					('ORD00000005', 	'2024-01-06 09:50:00', 		950000, 		'Urgent delivery.', 							3,		false,			"COD"),
					('ORD00000006', 	'2024-01-06 10:30:00', 		1200000, 		'No special instructions.', 					2,		false,			"COD"),
					('ORD00000007', 	'2024-01-06 11:15:00', 		2200000, 		'Call before delivery.', 						2,		false,			"COD"),
					('ORD00000008', 	'2024-01-07 09:00:00', 		1600000, 		'Gift wrap the items.', 						3,		false,			"COD"),
					('ORD00000009', 	'2024-01-07 10:20:00', 		1800000, 		'Leave at the door if not at home.', 			3,		false,			"COD"),
					('ORD00000010', 	'2024-01-07 11:45:00', 		1450000, 		'Need by weekend.', 							3,		false,			"COD");



-- Insert sample data into the `OrderStatus` table
INSERT INTO `OrderStatus` (`OrderId`, `Status`, `UpdateTime`) VALUES
						('ORD00000001', 'ChoDuyet', '2024-07-05 09:31:00'),
						('ORD00000001', 'DaDuyet', '2024-07-05 10:00:00'),

						('ORD00000002', 'ChoDuyet', '2024-07-05 10:16:00'),

						('ORD00000003', 'ChoDuyet', '2024-07-05 11:01:00'),
						('ORD00000003', 'DaDuyet', '2024-07-05 11:30:00'),
						('ORD00000003', 'DangGiao', '2024-07-05 13:30:00'),

						('ORD00000004', 'ChoDuyet', '2024-07-06 08:46:00'),
						('ORD00000004', 'DaDuyet', '2024-07-06 09:00:00'),
						('ORD00000004', 'DangGiao', '2024-07-06 11:00:00'),
						('ORD00000004', 'GiaoThanhCong', '2024-07-06 13:00:00'),

						('ORD00000005', 'ChoDuyet', '2024-07-06 09:51:00'),
						('ORD00000005', 'DaDuyet', '2024-07-06 10:00:00'),


						('ORD00000006', 'ChoDuyet', '2024-07-06 10:31:00'),
						('ORD00000006', 'Huy', 		'2024-07-06 16:00:00'),


						('ORD00000007', 'ChoDuyet', '2024-07-06 11:16:00'),
						('ORD00000007', 'DaDuyet', '2024-07-06 11:30:00'),
						('ORD00000007', 'DangGiao', '2024-07-06 13:30:00'),
						('ORD00000007', 'Huy', '2024-07-06 16:00:00'),

						('ORD00000008', 'ChoDuyet', '2024-07-07 09:01:00'),
						('ORD00000008', 'DaDuyet', '2024-07-07 09:30:00'),
						('ORD00000008', 'DangGiao', '2024-07-07 11:30:00'),
						('ORD00000008', 'GiaoThanhCong', '2024-07-07 14:00:00'),

						('ORD00000009', 'ChoDuyet', '2024-07-07 10:21:00'),
						('ORD00000009', 'DaDuyet', '2024-07-07 10:45:00'),
						('ORD00000009', 'DangGiao', '2024-07-07 13:00:00'),
						('ORD00000009', 'GiaoThanhCong', '2024-07-07 15:30:00'),

						('ORD00000010', 'ChoDuyet', '2024-07-07 11:46:00'),
						('ORD00000010', 'DaDuyet', '2024-07-07 12:00:00'),
						('ORD00000010', 'DangGiao', '2024-07-07 14:00:00'),
						('ORD00000010', 'GiaoThanhCong', '2024-07-07 17:00:00');



-- Insert sample data into the `OrderDetail` table
INSERT INTO `OrderDetail` 	(`OrderId`, `ProductId`, `Quantity`, `UnitPrice`, `Total`) VALUES
							('ORD00000001', 20, 2, 650000, 1300000),
							('ORD00000001', 21, 2, 450000, 900000),
							('ORD00000001', 23, 2, 750000, 1500000),

							('ORD00000002', 15, 1, 1350000, 1350000),

							('ORD00000003', 26, 2, 1200000, 2400000),
							('ORD00000003', 10, 1, 1000000, 1000000),

							('ORD00000004', 11, 1, 800000, 800000),

							('ORD00000005', 18, 1, 950000, 950000),

							('ORD00000006', 14, 1, 1200000, 1200000),

							('ORD00000007', 27, 1, 2500000, 2500000),
							('ORD00000007', 19, 1, 1100000, 1100000),

							('ORD00000008', 16, 2, 800000, 1600000),

							('ORD00000009', 29, 1, 1100000, 1100000),
							('ORD00000009', 10, 1, 1000000, 1000000),

							('ORD00000010', 20, 2, 650000, 1300000),
							('ORD00000010', 13, 1, 700000, 700000);




-- Insert sample data into the InventoryReport table with specific CreateTime values
INSERT INTO `InventoryReport` (`CreateTime`, `Supplier`, `SupplierPhone`, `TotalPrice`) VALUES
						('2024-07-05 09:30:00', 'Supplier A', '0912345678', 2500000),
						('2024-07-05 10:00:00', 'Supplier B', '0987654321', 1800000),
						('2024-07-05 11:00:00', 'Supplier C', '0923456789', 3600000),
						('2024-07-06 08:45:00', 'Supplier D', '0934567890', 1200000),
						('2024-07-06 09:50:00', 'Supplier E', '0945678901', 1700000),
						('2024-07-06 10:30:00', 'Supplier F', '0956789012', 2000000),
						('2024-07-06 11:15:00', 'Supplier G', '0967890123', 3300000),
						('2024-07-07 09:00:00', 'Supplier H', '0978901234', 1400000),
						('2024-07-07 10:20:00', 'Supplier I', '0989012345', 2500000),
						('2024-07-07 11:45:00', 'Supplier J', '0990123456', 2200000);
   
INSERT INTO `InventoryReportStatus` (`InventoryReportId`, `Status`, `UpdateTime`) VALUES
									(1, 'ChoNhapKho', '2024-07-05 09:31:00'),
									(1, 'DaNhapKho', '2024-07-05 11:00:00'),

									(2, 'ChoNhapKho', '2024-07-05 10:01:00'),
									(2, 'DaNhapKho', '2024-07-05 12:00:00'),

									(3, 'ChoNhapKho', '2024-07-05 11:01:00'),
									(3, 'DaNhapKho', '2024-07-05 13:00:00'),

									(4, 'ChoNhapKho', '2024-07-06 08:46:00'),
									(4, 'DaNhapKho', '2024-07-06 10:00:00'),

									(5, 'ChoNhapKho', '2024-07-06 09:51:00'),
									(5, 'Huy', '2024-07-06 11:30:00'),

									(6, 'ChoNhapKho', '2024-07-06 10:31:00'),
									(6, 'DaNhapKho', '2024-07-06 12:30:00'),

									(7, 'ChoNhapKho', '2024-07-06 11:16:00'),
									(7, 'DaNhapKho', '2024-07-06 14:00:00'),

									(8, 'ChoNhapKho', '2024-07-07 09:01:00'),
									(8, 'Huy', '2024-07-07 11:00:00'),

									(9, 'ChoNhapKho', '2024-07-07 10:21:00'),
									(9, 'DaNhapKho', '2024-07-07 12:30:00'),

									(10, 'ChoNhapKho', '2024-07-07 11:46:00'),
									(10, 'Huy', '2024-07-07 14:30:00');


                                    
INSERT INTO `InventoryReportDetail` (`InventoryReportId`, `ProductId`, `Quantity`, `UnitPrice`, `Total`) VALUES
									(1, 20, 2, 600000, 1200000),
									(1, 21, 1, 1300000, 1300000),

									(2, 23, 2, 900000, 1800000),

									(3, 25, 3, 1200000, 3600000),

									(4, 14, 2, 600000, 1200000),

									(5, 22, 2, 850000, 1700000),

									(6, 18, 2, 1000000, 2000000),

									(7, 19, 2, 1650000, 3300000),

									(8, 15, 2, 700000, 1400000),

									(9, 20, 2, 1250000, 2500000),

									(10, 27, 2, 1100000, 2200000);



    



