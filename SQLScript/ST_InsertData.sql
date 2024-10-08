USE `SGU_Software_Testing`;

SELECT `ProductId`, SUM(`Quantity`) FROM `OrderDetail`
GROUP BY `ProductId`;


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
INSERT INTO `Product` (`Id`, `ProductName`, 						`Status`, 		`CreateTime`, 			`Image`, 											`Origin`, 		`Capacity`, 	`ABV`, 					`Description`, 					`BrandId`, `CategoryId`) VALUES
						(1, 'HaKu Vodka', 							TRUE, 			'2024-07-03 10:00:00', 'SoftwareTestingProject/hakuvodka', 					'Japan',		 	700, 			40, 		 		'A smooth Japanese vodka.', 		2, 				2),
						(2, 'HaNoi VodKa', 							TRUE, 			'2024-07-05 10:00:00', 'SoftwareTestingProject/hanoiVodka', 				'Vietnam', 			500, 			39, 		 		'Classic Vietnamese vodka.', 		3, 				2),
						(3, 'Beluga Noble', 						TRUE, 			'2024-07-05 10:00:00', 'SoftwareTestingProject/belugaNoble', 				'Russia', 			700,			40, 		 		'Premium Russian vodka.', 			4, 				2),
						(4, 'Grey Goose', 							TRUE, 			'2024-07-05 10:00:00', 'SoftwareTestingProject/greyGoose', 					'France', 			750, 			40, 				'French luxury vodka.', 			5, 				2),
						(5, 'Beluga Allure', 						TRUE, 			'2024-07-05 10:00:00', 'SoftwareTestingProject/belugaAllure', 				'Russia', 			700, 			40, 		 		'Luxurious Russian vodka.', 		4, 				2),
						(6, 'King Robert', 							FALSE, 			'2024-07-06 08:45:00', 'SoftwareTestingProject/kingRobert', 				'Scotland', 		750, 			43, 		 		'Strong Scottish vodka.', 			2, 				2),
						(7, 'Smirnoff Red Vodka', 					TRUE, 			'2024-07-06 08:45:00', 'SoftwareTestingProject/smirnoffRedVodka', 			'USA', 				750, 			37, 				'Popular American vodka.',			5, 				2),
						(8, 'Stolichnaya Vodka',					TRUE, 			'2024-07-06 08:45:00', 'SoftwareTestingProject/Stolichnaya', 				'Russia', 			700, 			38, 				'Famous Russian vodka.',			6, 				2),
						(9, 'Vodka Danzka', 						TRUE, 			'2024-07-06 08:45:00', 'SoftwareTestingProject/vodkaDanzka', 				'Denmark', 			700, 			40, 				'Danish vodka.', 					7, 				2),
						(10, "Glen'S Platinum", 					TRUE, 			'2024-07-06 08:45:00', 'SoftwareTestingProject/glenPlatinum', 				'Scotland', 		700,			40, 				'Scottish vodka.', 					8, 				2),

						-- Tequila products
						(11, 'Tequila Clase Azul Reposado', 		TRUE, 			'2024-07-06 09:50:00', 'SoftwareTestingProject/tequilaClaseAzuiReposado', 	'Mexico', 			750,			40, 				'Premium Reposado Tequila.', 		9, 				3),
						(12, 'Don Julio 1942', 						TRUE, 			'2024-07-06 09:50:00', 'SoftwareTestingProject/donJulio', 					'Mexico', 			750, 			40, 				'Luxury Añejo Tequila.', 			10, 			3),
						(13, 'Patrón Silver', 						TRUE, 			'2024-07-06 09:50:00', 'SoftwareTestingProject/patronSilver',				'Mexico',			750, 			40, 				'Smooth Silver Tequila.', 			11, 			3),
						(14, 'Maestro Dobel Diamante', 				FALSE, 			'2024-07-06 09:50:00', 'SoftwareTestingProject/maestroDobel', 		 		'Mexico', 			750,			40, 				'Premium Cristalino Tequila.', 		12, 			3),
						(15, 'Gran Centenario Plata', 				TRUE, 			'2024-07-06 09:50:00', 'SoftwareTestingProject/granCentenario', 			'Mexico', 			750, 			40, 		 		'Smooth Plata Tequila.', 			13, 			3),
						(16, 'Tequila 1800 Añejo', 					TRUE, 			'2024-07-07 10:30:00', 'SoftwareTestingProject/tequila1800Anejo', 			'Mexico', 			750, 			40, 		 		'Aged Añejo Tequila.', 				14, 			3),
						(17, 'Tequila Clase Azul Plata', 			TRUE, 			'2024-07-07 10:30:00', 'SoftwareTestingProject/tequilaClaseAzuiPlata', 		'Mexico', 			750, 			40, 			 	'Premium Plata Tequila.', 			9, 				3),
						(18, 'Don Julio Blanco', 					TRUE, 			'2024-07-07 10:30:00', 'SoftwareTestingProject/donJulioBlanco', 			'Mexico', 			750, 			40, 		 		'Smooth Blanco Tequila.', 			10, 			3),
						(19, 'Patrón Añejo', 						TRUE, 			'2024-07-07 10:30:00', 'SoftwareTestingProject/patronAnejo',				'Mexico', 			750, 			40, 				'Rich Añejo Tequila.', 				11, 			3),
						(20, 'Tequila 1800 Silver', 				TRUE, 			'2024-07-07 10:30:00', 'SoftwareTestingProject/Tequila1800Silver',			'Mexico', 			750, 			40, 				'Popular Silver Tequila.', 			14, 			3),

						-- Wishkey products from Johnnie Walker
						(21, 'Johnnie Walker Red Label', 			TRUE, 			'2024-07-08 11:15:00', 'SoftwareTestingProject/johnnieWalkerRed', 		 	'Scotland', 		750, 			40, 				'Iconic Red Label Wishkey.', 		15, 			4),
						(22, 'Johnnie Walker Black Label', 			TRUE, 			'2024-07-08 11:15:00', 'SoftwareTestingProject/johnnieWalkerBlack', 		'Scotland', 		750, 			40, 				'Classic Black Label Wishkey.', 	15, 			4),
						(23, 'Johnnie Walker Double Black', 		TRUE, 			'2024-07-08 11:15:00', 'SoftwareTestingProject/johnnieWalkerDoubleBlack', 	'Scotland', 		750, 			40, 				'Smokier Double Black Wishkey.', 	15, 			4),
						(24, 'Johnnie Walker Gold Label Reserve', 	FALSE, 			'2024-07-08 11:15:00', 'SoftwareTestingProject/johnnieWalkerGold', 			'Scotland', 		750, 			40, 				'Luxurious Gold Label Wishkey.', 	15, 			4),
						(25, 'Johnnie Walker Green Label', 			TRUE, 			'2024-07-08 11:15:00', 'SoftwareTestingProject/johnnieWalkerGreen',			'Scotland', 		750, 			40, 				'Smooth Green Label Wishkey.', 		15, 			4),
						(26, 'Johnnie Walker Platinum Label', 		TRUE, 			'2024-07-09 09:00:00', 'SoftwareTestingProject/johnnieWalkerPlatinum', 		'Scotland', 		750,			40, 				'Exclusive Platinum Label Wishkey.',15, 			4),
						(27, 'Johnnie Walker Blue Label', 			TRUE, 			'2024-07-09 09:00:00', 'SoftwareTestingProject/johnnieWalkerBlue', 			'Scotland', 		750, 			40, 				'Rare Blue Label Wishkey.', 		15, 			4),
						(28, 'Johnnie Walker Gold Label 18', 		FALSE,			'2024-07-09 09:00:00', 'SoftwareTestingProject/johnnieWalkerGold18', 		'Scotland', 		750, 			40, 				'Aged 18 Years Wishkey.', 			15, 			4),
						(29, 'Johnnie Walker Green Label 15', 		TRUE, 			'2024-07-09 09:00:00', 'SoftwareTestingProject/johnnieWalkerGreen15', 		'Scotland', 		750,			40, 				'15-Year-Old Wishkey.', 			15, 			4),
						(30, 'Johnnie Walker King George V',		TRUE, 			'2024-07-09 09:00:00', 'SoftwareTestingProject/kingGeorgeV', 	 			'Scotland', 		750,			40, 				'Exclusive King George V Wishkey.', 15, 			4);
											
                    
			
-- Inserting 30 rows into the Batch table
INSERT INTO `Batch` (`UnitPrice`,       `Quantity`,     `ReceivingTime`, `ProductId`) VALUES
                    (180000,                95,        '2024-07-03 11:00:00', 1),

					(210000,                97,        '2024-07-05 10:00:00', 2),
					(360000,                27,         '2024-07-05 10:00:00', 3),
					(450000,                6,         '2024-07-05 10:00:00', 4),
					(520000,                9,         '2024-07-05 10:00:00', 5),

					(150000,                50,         '2024-07-05 11:00:00', 1),


					(2310000,               22,         '2024-07-06 08:45:00', 6),
					(1050000,               44,         '2024-07-06 08:45:00', 7),
					(1500000,               37,         '2024-07-06 08:45:00', 8),
					(1210000,               21,         '2024-07-06 08:45:00', 9),
					(1210000,               29,         '2024-07-06 08:45:00', 10),
					
					-- Tequila products
					(880000,                18,         '2024-07-06 09:50:00', 11),
					(1100000,               16,         '2024-07-06 09:50:00', 12),
					(770000,                23,         '2024-07-06 09:50:00', 13),
					(990000,                18,         '2024-07-06 09:50:00', 14),
					(660000,                18,         '2024-07-06 09:50:00', 15),

					(1100000,               8,         '2024-07-07 10:30:00', 16),
					(880000,                8,         '2024-07-07 10:30:00', 17),
					(990000,                8,         '2024-07-07 10:30:00', 18),
					(1100000,               8,         '2024-07-07 10:30:00', 19),
					(660000,                8,         '2024-07-07 10:30:00', 20),
					
					-- Whisky products from Johnnie Walker
					(440000,                49,         '2024-07-08 11:15:00', 21),
					(660000,                39,         '2024-07-08 11:15:00', 22),
					(770000,                29,         '2024-07-08 11:15:00', 23),
					(990000,                19,         '2024-07-08 11:15:00', 24),
					(880000,                9,         '2024-07-08 11:15:00', 25),

					(1100000,               9,         '2024-07-09 09:00:00', 26),
					(2200000,               9,         '2024-07-09 09:00:00', 27),
					(1100000,               9,         '2024-07-09 09:00:00', 28),
					(1100000,               9,         '2024-07-09 09:00:00', 29),
					(3300000,               9,         '2024-07-09 09:00:00', 30),

					(330000,               10,         '2024-08-10 10:20:00', 3),
                    (440000,               10,         '2024-08-12 11:45:00', 4);


       
-- Insert sample data into UserInformation table
INSERT INTO `UserInformation` 	(`Id`, 		`Email`, 							`Address`, 			`Birthday`, 		`Fullname`, 		`Gender`,		 `PhoneNumber`) VALUES
								(1, 		'admin@gmail.com', 					'123 Main St', 		'2004-04-01', 		'Ngô Tuấn Hưng', 	'Male', 		'123-456-7890'),
								(2, 		'nguyenphucminh880@gmail.com', 		'456 Elm St', 		'2004-11-15', 		'Nguyễn Minh Phúc', 'Male', 		'234-567-8901'),
								(3, 		'hungnt.020404@gmail.com', 			'123 Main St', 		'2004-04-01', 		'Ngô Tuấn Hưng', 	'Male', 		'123-456-7890'),
								(4, 		'admin004@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 004', 			'Male', 		'123-456-7890'),
								(5, 		'admin005@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 005', 			'Male', 		'123-456-7890'),
								(6, 		'user006@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 006', 			'Male', 		'123-456-7890'),
								(7, 		'user007@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 007', 			'Male', 		'123-456-7890'),
								(8, 		'user008@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 008', 			'Male', 		'123-456-7890'),
								(9, 		'user009@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 009', 			'Male', 		'123-456-7890'),
								(10, 		'user010@gmail.com', 				'123 Main St', 		'2004-04-01', 		'Mr 010', 			'Male', 		'123-456-7890');


                        
                        -- Insert sample data into Account table
INSERT INTO `Account` 	(`Id`,			`Password`,														 `Status`, 		`Role`,		`UserInformationId`,		`CreateTime`, 			`Active`) VALUES
						(1,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'Admin',					1,			'2023-01-01 00:00:00',			1),
						(2,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	0, 			'User',						2,			'2024-01-01 00:00:00',  		1),
						(3,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						3,			'2024-01-01 00:00:00',  		1),
						(4,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'Admin',					4,			'2024-01-01 00:00:00',  		1),
						(5,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'Admin',					5,			'2024-01-01 00:00:00',  		1),
						(6,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						6,			'2024-01-01 00:00:00',  		1),
						(7,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						7,			'2024-01-01 00:00:00',  		1),
						(8,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						8,			'2024-01-01 00:00:00',  		1),
						(9,				'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						9,			'2024-01-01 00:00:00',  		1),
						(10,			'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', 	1, 			'User',						10,			'2024-01-01 00:00:00',  		1);



-- Insert additional sample data into the `Order` table without `Paid` and `PaymentOption`
INSERT INTO `Order` (`Id`, 			`OrderTime`, 			`TotalPrice`, 	`Note`, 					`AccountId`) VALUES
					('ORD00000001', '2024-07-01 08:30:00', 570000, 			'Urgent delivery', 						3),
					('ORD00000002', '2024-07-01 09:00:00', 1710000, 		'Gift wrap the items', 					3),					
					('ORD00000003', '2024-07-01 10:30:00', 3350000, 		'Include a thank you note', 			3),
					('ORD00000004', '2024-07-01 11:00:00', 3600000, 		'Deliver before 6 PM', 					3),
					('ORD00000005', '2024-07-02 08:00:00', 7260000, 		'Contact customer before delivery', 	3),
					
					('ORD00000006', '2024-07-02 09:30:00', 3080000, 		'Handle with care', 					3),
					('ORD00000007', '2024-07-02 11:00:00', 1760000, 		'Leave at reception', 					3),
					('ORD00000008', '2024-07-03 08:15:00', 1760000, 		'Include gift note', 					3),
					('ORD00000009', '2024-07-03 10:00:00', 1870000, 		'Call before delivery', 				3),
					('ORD00000010', '2024-07-03 11:30:00', 770000, 			'Pack items separately', 				3),

					('ORD00000011', '2024-07-08 09:00:00', 1100000, 		'Delivery after 5 PM.', 				6),
					('ORD00000012', '2024-07-08 10:30:00', 1760000, 		'Include a thank you note.', 			6),
					('ORD00000013', '2024-07-08 11:45:00', 1980000, 		'Deliver to the address on file.', 		7),
					('ORD00000014', '2024-07-09 08:30:00', 3300000, 		'No rush delivery.', 					7),
					('ORD00000015', '2024-07-09 09:45:00', 4400000, 		'Contact customer before delivery.', 	7),
					
					('ORD00000016', '2024-07-09 11:00:00', 390000, 			'Gift wrap the items.', 				8),
					('ORD00000017', '2024-07-10 08:00:00', 1710000,			'Deliver before noon.', 				8),
					('ORD00000018', '2024-07-10 09:30:00', 3350000, 		'Leave at the office reception.', 		9),
					('ORD00000019', '2024-07-10 11:15:00', 3600000, 		'Include a personalized message.', 		10),
					('ORD00000020', '2024-07-11 09:00:00', 7260000, 		'Check if the customer is home.', 		3),

					('ORD00000021', '2024-07-11 10:30:00', 570000, 		'Gift item should be packed separately.', 	3),
					('ORD00000022', '2024-07-11 11:45:00', 1710000, 		'Deliver after 6 PM.', 						2),
					('ORD00000023', '2024-07-12 08:30:00', 3350000, 			'Include a thank you note.', 				6),
					('ORD00000024', '2024-07-12 09:45:00', 3600000, 		'Call before delivery.',					9),
					('ORD00000025', '2024-07-12 11:00:00', 7260000, 		'Deliver to the alternate address.', 		3),
					
					('ORD00000026', '2024-07-13 08:00:00', 3080000, 		'Ensure timely delivery.', 					2),
					('ORD00000027', '2024-07-13 09:30:00', 1760000, 		'No special instructions.', 				3),
					('ORD00000028', '2024-07-13 11:15:00', 1760000, 		'Contact customer to confirm delivery.', 	1),
					('ORD00000029', '2024-07-14 08:00:00', 1870000, 		'Deliver before noon.', 					2),
					('ORD00000030', '2024-07-14 09:30:00', 770000, 		'Pack items carefully.', 					3);


-- Insert additional sample data into the `OrderStatus` table
INSERT INTO `OrderStatus` 		(`OrderId`, 	`Status`, 			`UpdateTime`) VALUES
								('ORD00000001', 'ChoDuyet', 		'2024-09-01 08:31:00'),
								('ORD00000001', 'DaDuyet', 			'2024-09-01 09:00:00'),
								('ORD00000001', 'DangGiao', 		'2024-09-01 10:00:00'),

								('ORD00000002', 'ChoDuyet', 		'2024-09-01 09:01:00'),
								('ORD00000002', 'DaDuyet', 			'2024-09-01 09:30:00'),
								('ORD00000002', 'DangGiao', 		'2024-09-01 11:00:00'),

								('ORD00000003', 'ChoDuyet', 		'2024-09-01 10:31:00'),
								('ORD00000003', 'DaDuyet', 			'2024-09-01 11:00:00'),
								('ORD00000003', 'DangGiao', 		'2024-09-01 12:30:00'),
								('ORD00000003', 'GiaoThanhCong', 	'2024-09-01 14:00:00'),

								('ORD00000004', 'ChoDuyet', 		'2024-09-01 11:01:00'),
								('ORD00000004', 'DaDuyet', 			'2024-09-01 11:30:00'),
								('ORD00000004', 'DangGiao', 		'2024-09-01 13:00:00'),
								('ORD00000004', 'GiaoThanhCong', 	'2024-09-01 15:00:00'),

								('ORD00000005', 'ChoDuyet', 		'2024-09-02 08:01:00'),
								('ORD00000005', 'DaDuyet', 			'2024-09-02 08:30:00'),
								('ORD00000005', 'Huy', 				'2024-09-02 10:00:00'),

								('ORD00000006', 'ChoDuyet', 		'2024-09-02 09:31:00'),
								('ORD00000006', 'DaDuyet', 			'2024-09-02 10:00:00'),
								('ORD00000006', 'DangGiao', 		'2024-09-02 11:30:00'),
								('ORD00000006', 'GiaoThanhCong', 	'2024-09-02 13:00:00'),

								('ORD00000007', 'ChoDuyet', 		'2024-09-02 11:16:00'),
								('ORD00000007', 'DaDuyet', 			'2024-09-02 11:45:00'),
								('ORD00000007', 'DangGiao', 		'2024-09-02 13:00:00'),
								('ORD00000007', 'GiaoThanhCong', 	'2024-09-02 15:00:00'),

								('ORD00000008', 'ChoDuyet', 		'2024-09-03 08:01:00'),

								('ORD00000009', 'ChoDuyet', 		'2024-09-03 09:31:00'),
								('ORD00000009', 'DaDuyet', 			'2024-09-03 10:00:00'),
								('ORD00000009', 'DangGiao', 		'2024-09-03 11:30:00'),
								('ORD00000009', 'GiaoThanhCong', 	'2024-09-03 13:00:00'),

								('ORD00000010', 'ChoDuyet', 		'2024-09-03 11:16:00'),
								('ORD00000010', 'Huy', 				'2024-09-03 11:45:00'),
						
                        
								('ORD00000011', 'ChoDuyet', 		'2024-09-08 09:01:00'),
								('ORD00000011', 'DaDuyet', 			'2024-09-08 09:30:00'),
								('ORD00000011', 'DangGiao', 		'2024-09-08 11:00:00'),
								('ORD00000011', 'GiaoThanhCong', 	'2024-09-08 13:00:00'),

								('ORD00000012', 'ChoDuyet', 		'2024-09-08 10:31:00'),
								('ORD00000012', 'DaDuyet', 			'2024-09-08 11:00:00'),
								('ORD00000012', 'DangGiao', 		'2024-09-08 12:30:00'),
								('ORD00000012', 'GiaoThanhCong', 	'2024-09-08 14:00:00'),

								('ORD00000013', 'ChoDuyet', 		'2024-09-08 11:16:00'),
								('ORD00000013', 'DaDuyet', 			'2024-09-08 11:45:00'),
								('ORD00000013', 'DangGiao', 		'2024-09-08 13:00:00'),
								('ORD00000013', 'GiaoThanhCong', 	'2024-09-08 15:00:00'),

								('ORD00000014', 'ChoDuyet', 		'2024-09-09 08:01:00'),
								('ORD00000014', 'DaDuyet', 			'2024-09-09 08:30:00'),
								('ORD00000014', 'DangGiao', 		'2024-09-09 10:00:00'),
								('ORD00000014', 'GiaoThanhCong', 	'2024-09-09 12:00:00'),

								('ORD00000015', 'ChoDuyet', 		'2024-09-09 09:31:00'),
								('ORD00000015', 'DaDuyet', 			'2024-09-09 10:00:00'),
								('ORD00000015', 'DangGiao', 		'2024-09-09 11:30:00'),
								('ORD00000015', 'GiaoThanhCong', 	'2024-09-09 13:00:00'),

								('ORD00000016', 'ChoDuyet', 		'2024-09-09 11:16:00'),
								('ORD00000016', 'DaDuyet', 			'2024-09-09 11:45:00'),
								('ORD00000016', 'DangGiao', 		'2024-09-09 13:00:00'),
								('ORD00000016', 'GiaoThanhCong', 	'2024-09-09 15:00:00'),

								('ORD00000017', 'ChoDuyet', 		'2024-09-10 08:01:00'),
								('ORD00000017', 'DaDuyet', 			'2024-09-10 08:30:00'),
								('ORD00000017', 'DangGiao', 		'2024-09-10 10:00:00'),
								('ORD00000017', 'GiaoThanhCong', 	'2024-09-10 12:00:00'),

								('ORD00000018', 'ChoDuyet', 		'2024-09-10 09:31:00'),
								('ORD00000018', 'DaDuyet', 			'2024-09-10 10:00:00'),
								('ORD00000018', 'DangGiao', 		'2024-09-10 11:30:00'),
								('ORD00000018', 'GiaoThanhCong', 	'2024-09-10 13:00:00'),

								('ORD00000019', 'ChoDuyet', 		'2024-09-10 11:16:00'),
								('ORD00000019', 'DaDuyet', 			'2024-09-10 11:45:00'),
								('ORD00000019', 'DangGiao', 		'2024-09-10 13:00:00'),
								('ORD00000019', 'GiaoThanhCong', 	'2024-09-10 15:00:00'),

								('ORD00000020', 'ChoDuyet', 		'2024-09-11 08:01:00'),
								('ORD00000020', 'DaDuyet', 			'2024-09-11 08:30:00'),
								('ORD00000020', 'DangGiao', 		'2024-09-11 10:00:00'),
								('ORD00000020', 'GiaoThanhCong', 	'2024-09-11 12:00:00'),

								('ORD00000021', 'ChoDuyet', 		'2024-09-11 09:31:00'),
								('ORD00000021', 'DaDuyet', 			'2024-09-11 10:00:00'),
								('ORD00000021', 'DangGiao', 		'2024-09-11 11:30:00'),
								('ORD00000021', 'GiaoThanhCong', 	'2024-09-11 13:00:00'),

								('ORD00000022', 'ChoDuyet', 		'2024-09-11 11:16:00'),
								('ORD00000022', 'DaDuyet', 			'2024-09-11 11:45:00'),
								('ORD00000022', 'DangGiao', 		'2024-09-11 13:00:00'),
								('ORD00000022', 'GiaoThanhCong', 	'2024-09-11 15:00:00'),

								('ORD00000023', 'ChoDuyet', 		'2024-09-12 08:01:00'),
								('ORD00000023', 'DaDuyet', 			'2024-09-12 08:30:00'),
								('ORD00000023', 'DangGiao', 		'2024-09-12 10:00:00'),
								('ORD00000023', 'GiaoThanhCong', 	'2024-09-12 12:00:00'),

								('ORD00000024', 'ChoDuyet', 		'2024-09-12 09:31:00'),
								('ORD00000024', 'DaDuyet', 			'2024-09-12 10:00:00'),
								('ORD00000024', 'DangGiao', 		'2024-09-12 11:30:00'),
								('ORD00000024', 'GiaoThanhCong', 	'2024-09-12 13:00:00'),

								('ORD00000025', 'ChoDuyet', 		'2024-09-12 11:16:00'),
								('ORD00000025', 'DaDuyet', 			'2024-09-12 11:45:00'),
								('ORD00000025', 'DangGiao', 		'2024-09-12 13:00:00'),
								('ORD00000025', 'GiaoThanhCong', 	'2024-09-12 15:00:00'),

								('ORD00000026', 'ChoDuyet', 		'2024-09-13 08:01:00'),
								('ORD00000026', 'DaDuyet', 			'2024-09-13 08:30:00'),
								('ORD00000026', 'DangGiao', 		'2024-09-13 10:00:00'),
								('ORD00000026', 'GiaoThanhCong', 	'2024-09-13 12:00:00'),

								('ORD00000027', 'ChoDuyet', 		'2024-09-13 09:31:00'),
								('ORD00000027', 'DaDuyet', 			'2024-09-13 10:00:00'),
								('ORD00000027', 'DangGiao', 		'2024-09-13 11:30:00'),
								('ORD00000027', 'GiaoThanhCong', 	'2024-09-13 13:00:00'),

								('ORD00000028', 'ChoDuyet', 		'2024-09-13 11:16:00'),

								('ORD00000029', 'ChoDuyet', 		'2024-09-14 08:01:00'),

								('ORD00000030', 'ChoDuyet', 		'2024-09-14 09:31:00');




-- Insert sample data into the `OrderDetail` table
INSERT INTO `OrderDetail` 	(`OrderId`, 	         `ProductId`,    `Quantity`, `UnitPrice`,    `Total`) VALUES
							
                            ('ORD00000001',                 1,             2,      180000,     360000),
							('ORD00000001',                 2,             1,      210000,     210000),

							('ORD00000002',                 3,             1,      360000,     360000),
							('ORD00000002',                 4,             3,      450000,    1350000),

							('ORD00000003',                 5,             2,       520000,   1040000),
							('ORD00000003',                 6,             1,       2310000,  2310000),

							('ORD00000004',                 7,             2,       1050000,  2100000),
							('ORD00000004',                 8,             1,       1500000,  1500000),

							('ORD00000005',                 9,              3,      1210000, 3630000),
							('ORD00000005',                 10,             2,      1210000, 3630000),


							('ORD00000006',                 11,             1,       880000,   880000),
							('ORD00000006',                 12,             2,       1100000, 2200000),


							('ORD00000007',                 13,             1,        770000, 770000),
							('ORD00000007',                 14,             1,        990000, 990000),

							('ORD00000008',                 15,             1,        660000,  660000),
							('ORD00000008',                 16,             1,        1100000, 1100000),

							('ORD00000009',                 17,             1,          880000, 880000),
							('ORD00000009',                 18,             1,          990000, 990000),

							('ORD00000010',                 19,             1,          110000, 110000),
							('ORD00000010',                 20,             1,          660000, 660000),



							('ORD00000011',                 21,             1,          440000, 440000),
							('ORD00000011',                 22,             1,          660000, 660000),

							('ORD00000012',                 23,             1,          770000, 770000),
							('ORD00000012',                 24,             1,          990000, 990000),

							('ORD00000013',                 25,             1,          880000, 880000),
							('ORD00000013',                 26,             1,         1100000, 1100000),

							('ORD00000014',                 27,             1,          2200000, 2200000),
							('ORD00000014',                 28,             1,          1100000, 1100000),

							('ORD00000015',                 29,             1,          1100000, 1100000),
							('ORD00000015',                 30,             1,          3300000, 3300000),




							('ORD00000016',                 1,              1,          180000,   180000),
							('ORD00000016',                 2,              1,          210000,   210000),

							('ORD00000017',                 3,             1,           360000,     360000),
							('ORD00000017',                 4,             3,           450000,    1350000),

							('ORD00000018',                 5,             2,           520000,   1040000),
							('ORD00000018',                 6,             1,           2310000,  2310000),

							('ORD00000019',                 7,             2,           1050000,  2100000),
							('ORD00000019',                 8,             1,           1500000,  1500000),

							('ORD00000020',                 9,              3,          1210000, 3630000),
							('ORD00000020',                 10,             2,          1210000, 3630000),




							('ORD00000021',                 1,             2,      180000,     360000),
							('ORD00000021',                 2,             1,      210000,     210000),

							('ORD00000022',                 3,             1,      360000,     360000),
							('ORD00000022',                 4,             3,      450000,    1350000),

							('ORD00000023',                 5,             2,       520000,   1040000),
							('ORD00000023',                 6,             1,       2310000,  2310000),

							('ORD00000024',                 7,             2,       1050000,  2100000),
							('ORD00000024',                 8,             1,       1500000,  1500000),

							('ORD00000025',                 9,              3,      1210000, 3630000),
							('ORD00000025',                 10,             2,      1210000, 3630000),


							('ORD00000026',                 11,             1,       880000,   880000),
							('ORD00000026',                 12,             2,       1100000, 2200000),


							('ORD00000027',                 13,             1,        770000, 770000),
							('ORD00000027',                 14,             1,        990000, 990000),

							('ORD00000028',                 15,             1,        660000,  660000),
							('ORD00000028',                 16,             1,        1100000, 1100000),

							('ORD00000029',                 17,             1,          880000, 880000),
							('ORD00000029',                 18,             1,          990000, 990000),

							('ORD00000030',                 19,             1,          110000, 110000),
							('ORD00000030',                 20,             1,          660000, 660000);




-- Insert sample data into the InventoryReport table with specific CreateTime values
INSERT INTO `InventoryReport`   (`CreateTime`,          `Supplier`,             `SupplierPhone`,    `TotalPrice`) VALUES
								('2024-07-03 11:00:00', 'Supplier A',           '0912345678',         15000000),
								('2024-07-05 10:00:00', 'Supplier B',           '0987654321',         38125000),
								('2024-07-05 11:00:00', 'Supplier C',           '0923456789',          6000000),
								('2024-07-06 08:45:00', 'Supplier D',           '0934567890',        197750000),
								('2024-07-06 09:50:00', 'Supplier E',           '0945678901',         93500000),
								('2024-07-07 10:30:00', 'Supplier F',           '0956789012',         43000000),
								('2024-07-08 11:15:00', 'Supplier G',           '0967890123',         91000000),
								('2024-07-09 09:00:00', 'Supplier H',           '0978901234',         80000000),
								('2024-08-10 10:20:00', 'Supplier I',           '0989012345',         3000000),
								('2024-08-12 11:45:00', 'Supplier J',           '0990123456',         4000000);

                                    
INSERT INTO `InventoryReportDetail` (`InventoryReportId`,   `ProductId`, `Quantity`, `UnitPrice`,   `Profit`,       `Total`) VALUES
									(                   1,           1,        100,      150000,         20,         15000000),

									(                   2,          2,         100,      175000,         20,         17500000),
									(                   2,          3,          30,      300000,         20,         9000000),
									(                   2,          4,          15,      375000,         20,         5625000),
									(                   2,          5,          15,      400000,         30,         6000000),


									(                   3,          1,          50,      120000,         20,         6000000),


									(                   4,          6,          25,      1650000,        40,         41250000),
									(                   4,          7,          50,      700000,         50,         35000000),
									(                   4,          8,          40,      1250000,        20,         50000000),
									(                   4,          9,          30,      1100000,        10,         33000000),
									(                   4,         10,          35,      1100000,        10,         38500000),

                                    (                   5,         11,          20,      800000,         10,         16000000),
									(                   5,         12,          20,      1000000,        10,         20000000),
									(                   5,         13,          25,      700000,         10,         17500000),
									(                   5,         14,          20,      900000,         10,         18000000),
									(                   5,         15,          20,      600000,         10,         12000000),

                                    (                   6,         16,          10,      1000000,        10,         10000000),
									(                   6,         17,          10,      800000,         10,         8000000),
									(                   6,         18,          10,      900000,         10,         9000000),
									(                   6,         19,          10,      1000000,        10,         10000000),
									(                   6,         20,          10,      600000,         10,         6000000),

                                    (                   7,         21,          50,      400000,         10,         20000000),
									(                   7,         22,          40,      600000,         10,         24000000),
									(                   7,         23,          30,      700000,         10,         21000000),
									(                   7,         24,          20,      900000,         10,         18000000),
									(                   7,         25,          10,      800000,         10,         8000000),

                                    (                   8,         26,          10,      1000000,         10,         10000000),
									(                   8,         27,          10,      2000000,         10,         20000000),
									(                   8,         28,          10,      1000000,         10,         10000000),
									(                   8,         29,          10,      1000000,         10,         10000000),
									(                   8,         30,          10,      3000000,         10,         30000000),

                                    (                   9,         3,          10,     300000,         10,          30000000),

									(                  10,         4,          10,      400000,         10,         40000000);



    



