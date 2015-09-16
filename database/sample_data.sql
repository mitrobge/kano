-- Select database
USE kano;

-- Populate languages
INSERT INTO language (language_id, language_name, language_flag) VALUES
    (1, 'gr', 'greek_flag.gif'),
    (2, 'en', 'UK_flag.gif');

-- Populate category table
INSERT INTO category (category_id, parent_id, lft, rgt) VALUES
    (1, NULL, 1, 14),
    (2, 1, 2, 9),
    (3, 2, 3, 6),
    (4, 3, 4, 5),
    (5, 2, 7, 8),
    (6, 1, 10, 13),
    (7, 6, 11, 12);

-- Populate category description table
INSERT INTO category_description (category_id, language_id, name, description) VALUES
    (1, 1, 'Surveys', ''),
    (1, 2, 'Έρυνες', ''),
    (2, 1, 'KANO Surveys', ''),
    (2, 2, 'KANO Έρυνες', ''),
    (3, 1, 'KANO-2015-en', ''),
    (3, 2, 'KANO-2015-gr', ''),
    (4, 1, 'KANO-2015-a-en', ''),
    (4, 2, 'KANO-2015-a-gr', ''),
    (5, 1, 'KANO-2014-en', ''),
    (5, 2, 'KANO-2014-gr', ''),
    (6, 1, 'CSS Surveys', ''),
    (6, 2, 'CSS Έρυνες', ''),
    (7, 1, 'CSS-2015-a-en', ''),
    (7, 2, 'CSS-2015-a-gr', '');

-- Populate surevy table
INSERT INTO survey (survey_id, survey_sdate, survey_edate, added_on) VALUES
    (1, '2015-01-01','2015-01-31', '2014-31-12'), 
    (2, '2014-02-01','2014-02-28', '2013-31-01'), 
    (3, '2015-02-01','2015-02-28', '2014-31-01'); 

-- Polulate survey_category table
INSERT INTO survey_category (survey_id, category_id) VALUES
    (1, 4),
    (2, 5),
    (3, 7);

-- Polulate survey_description table
INSERT INTO survey_description (survey_id, language_id, name, description) VALUES
        (1, 1, 'Kano Model Survey 2015a', 'Description of KANO Model survey 2015a'),
        (1, 2, 'Kano Model Έρευνα 2015a', 'Περιγραφή για έρευνα ΚΑΝΟ 2015a'),
        (2, 1, 'Kano Model Survey 2014', 'Description of KANO survey 2014'),
        (2, 2, 'Kano Model Έρευνα 2014', 'Περιγραφή για έρευνα ΚΑΝΟ 2014'),
        (3, 1, 'CSS Survey 2015', 'Description of CSS survey 2015'),
        (3, 2, 'CSS Έρευνα 2015', 'Περιγραφή για έρευνα survey 2015');

INSERT INTO survey_questions_characteristics (question_characteristic_id, survey_id) VALUES
        (1, 1),
        (2, 1),
        (3, 1),
        (4, 1),
        (5, 2),
        (6, 2),
        (7, 2);

INSERT INTO survey_questions_characteristics_description (question_characteristic_id, language_id, question_characteristic_name) VALUES
    (1,1,'Χαρακτηριστικό 1'),
    (1,2,'Characteristic 1'),
    (2,1,'Χαρακτηριστικό 2'),
    (2,2,'Characteristic 2'),
    (3,1,'Χαρακτηριστικό 3'),
    (3,2,'Characteristic 3'),
    (4,1,'Χαρακτηριστικό 4'),
    (4,2,'Characteristic 4'),
    (5,1,'Χαρακτηριστικό 5'),
    (5,2,'Characteristic 5'),
    (6,1,'Χαρακτηριστικό 6'),
    (6,2,'Characteristic 6'),
    (7,1,'Χαρακτηριστικό 7'),
    (7,2,'Characteristic 7');

INSERT INTO survey_customers_characteristics (customers_characteristic_id, survey_id) VALUES
        (1, 1),
        (2, 1),
        (3, 1),
        (4, 2),
        (5, 2),
        (6, 2);

INSERT INTO survey_customers_characteristics_description (customers_characteristic_id, language_id, customer_characteristic_name) VALUES
    (1,1,'Χαρακτηριστικό πελάτη 1'),
    (1,2,'Characteristic customer 1'),
    (2,1,'Χαρακτηριστικό πελάτη 2'),
    (2,2,'Characteristic customer 2'),
    (3,1,'Χαρακτηριστικό πελάτη 3'),
    (3,2,'Characteristic customer 3'),
    (4,1,'Χαρακτηριστικό πελάτη 4'),
    (4,2,'Characteristic customer 4'),
    (5,1,'Χαρακτηριστικό πελάτη 5'),
    (5,2,'Characteristic customer 5'),
    (6,1,'Χαρακτηριστικό πελάτη 6'),
    (6,2,'Characteristic customer 6'),
    (7,1,'Χαρακτηριστικό πελάτη 7'),
    (7,2,'Characteristic customer 7');

INSERT INTO survey_answers (answer_id, survey_id,characteristic_id, characteristic_answer_pos, characteristic_answer_neg, added_on) VALUES
    (1, 1, 1, 2, 3, '2015-01-15'),
    (2, 1, 2, 1, 5, '2015-01-15'),
    (3, 1, 3, 4, 4, '2015-01-15'),
    (4, 1, 1, 2, 1, '2015-01-15'),
    (5, 1, 2, 2, 2, '2015-01-15'),
    (6, 1, 3, 4, 2, '2015-01-15'),
    (7, 1, 1, 2, 1, '2015-01-15'),
    (8, 1, 2, 2, 2, '2015-01-15'),
    (9, 1, 3, 4, 2, '2015-01-15');

INSERT INTO customer (customer_id, created_on, gender, first_name, last_name, email, password, street_address, city, postcode, state_id, phone, mobile) VALUES
        (1, NOW(), 'm', 'Dimitris', 'Mitrovgenis', 'dmitrovgenis@eparxis.com', 'd3412c2a20d033149b775ce49de2ae56c750a9a3', 'Akrothoon 28', 'Athens', '11142', 1, '2130040156', '6932009943');
        

INSERT INTO country VALUES 
    (1,'Afghanistan','AF','AFG','1'),
    (2,'Albania','AL','ALB','1'),
    (3,'Algeria','DZ','DZA','1'),
    (4,'American Samoa','AS','ASM','1'),
    (5,'Andorra','AD','AND','1'),
    (6,'Angola','AO','AGO','1'),
    (7,'Anguilla','AI','AIA','1'),
    (8,'Antarctica','AQ','ATA','1'),
    (9,'Antigua and Barbuda','AG','ATG','1'),
    (10,'Argentina','AR','ARG','1'),
    (11,'Armenia','AM','ARM','1'),
    (12,'Aruba','AW','ABW','1'),
    (13,'Australia','AU','AUS','1'),
    (14,'Austria','AT','AUT','5'),
    (15,'Azerbaijan','AZ','AZE','1'),
    (16,'Bahamas','BS','BHS','1'),
    (17,'Bahrain','BH','BHR','1'),
    (18,'Bangladesh','BD','BGD','1'),
    (19,'Barbados','BB','BRB','1'),
    (20,'Belarus','BY','BLR','1'),
    (21,'Belgium','BE','BEL','1'),
    (22,'Belize','BZ','BLZ','1'),
    (23,'Benin','BJ','BEN','1'),
    (24,'Bermuda','BM','BMU','1'),
    (25,'Bhutan','BT','BTN','1'),
    (26,'Bolivia','BO','BOL','1'),
    (27,'Bosnia and Herzegowina','BA','BIH','1'),
    (28,'Botswana','BW','BWA','1'),
    (29,'Bouvet Island','BV','BVT','1'),
    (30,'Brazil','BR','BRA','1'),
    (31,'British Indian Ocean Territory','IO','IOT','1'),
    (32,'Brunei Darussalam','BN','BRN','1'),
    (33,'Bulgaria','BG','BGR','1'),
    (34,'Burkina Faso','BF','BFA','1'),
    (35,'Burundi','BI','BDI','1'),
    (36,'Cambodia','KH','KHM','1'),
    (37,'Cameroon','CM','CMR','1'),
    (38,'Canada','CA','CAN','1'),
    (39,'Cape Verde','CV','CPV','1'),
    (40,'Cayman Islands','KY','CYM','1'),
    (41,'Central African Republic','CF','CAF','1'),
    (42,'Chad','TD','TCD','1'),
    (43,'Chile','CL','CHL','1'),
    (44,'China','CN','CHN','1'),
    (45,'Christmas Island','CX','CXR','1'),
    (46,'Cocos (Keeling) Islands','CC','CCK','1'),
    (47,'Colombia','CO','COL','1'),
    (48,'Comoros','KM','COM','1'),
    (49,'Congo','CG','COG','1'),
    (50,'Cook Islands','CK','COK','1'),
    (51,'Costa Rica','CR','CRI','1'),
    (52,'Cote D\'Ivoire','CI','CIV','1'),
    (53,'Croatia','HR','HRV','1'),
    (54,'Cuba','CU','CUB','1'),
    (55,'Cyprus','CY','CYP','1'),
    (56,'Czech Republic','CZ','CZE','1'),
    (57,'Denmark','DK','DNK','1'),
    (58,'Djibouti','DJ','DJI','1'),
    (59,'Dominica','DM','DMA','1'),
    (60,'Dominican Republic','DO','DOM','1'),
    (61,'East Timor','TP','TMP','1'),
    (62,'Ecuador','EC','ECU','1'),
    (63,'Egypt','EG','EGY','1'),
    (64,'El Salvador','SV','SLV','1'),
    (65,'Equatorial Guinea','GQ','GNQ','1'),
    (66,'Eritrea','ER','ERI','1'),
    (67,'Estonia','EE','EST','1'),
    (68,'Ethiopia','ET','ETH','1'),
    (69,'Falkland Islands (Malvinas)','FK','FLK','1'),
    (70,'Faroe Islands','FO','FRO','1'),
    (71,'Fiji','FJ','FJI','1'),
    (72,'Finland','FI','FIN','1'),
    (73,'France','FR','FRA','1'),
    (74,'France, Metropolitan','FX','FXX','1'),
    (75,'French Guiana','GF','GUF','1'),
    (76,'French Polynesia','PF','PYF','1'),
    (77,'French Southern Territories','TF','ATF','1'),
    (78,'Gabon','GA','GAB','1'),
    (79,'Gambia','GM','GMB','1'),
    (80,'Georgia','GE','GEO','1'),
    (81,'Germany','DE','DEU','5'),
    (82,'Ghana','GH','GHA','1'),
    (83,'Gibraltar','GI','GIB','1'),
    (84,'Greece','GR','GRC','1'),
    (85,'Greenland','GL','GRL','1'),
    (86,'Grenada','GD','GRD','1'),
    (87,'Guadeloupe','GP','GLP','1'),
    (88,'Guam','GU','GUM','1'),
    (89,'Guatemala','GT','GTM','1'),
    (90,'Guinea','GN','GIN','1'),
    (91,'Guinea-bissau','GW','GNB','1'),
    (92,'Guyana','GY','GUY','1'),
    (93,'Haiti','HT','HTI','1'),
    (94,'Heard and Mc Donald Islands','HM','HMD','1'),
    (95,'Honduras','HN','HND','1'),
    (96,'Hong Kong','HK','HKG','1'),
    (97,'Hungary','HU','HUN','1'),
    (98,'Iceland','IS','ISL','1'),
    (99,'India','IN','IND','1'),
    (100,'Indonesia','ID','IDN','1'),
    (101,'Iran (Islamic Republic of)','IR','IRN','1'),
    (102,'Iraq','IQ','IRQ','1'),
    (103,'Ireland','IE','IRL','1'),
    (104,'Israel','IL','ISR','1'),
    (105,'Italy','IT','ITA','1'),
    (106,'Jamaica','JM','JAM','1'),
    (107,'Japan','JP','JPN','1'),
    (108,'Jordan','JO','JOR','1'),
    (109,'Kazakhstan','KZ','KAZ','1'),
    (110,'Kenya','KE','KEN','1'),
    (111,'Kiribati','KI','KIR','1'),
    (112,'Korea, Democratic People\'s Republic of','KP','PRK','1'),
    (113,'Korea, Republic of','KR','KOR','1'),
    (114,'Kuwait','KW','KWT','1'),
    (115,'Kyrgyzstan','KG','KGZ','1'),
    (116,'Lao People\'s Democratic Republic','LA','LAO','1'),
    (117,'Latvia','LV','LVA','1'),
    (118,'Lebanon','LB','LBN','1'),
    (119,'Lesotho','LS','LSO','1'),
    (120,'Liberia','LR','LBR','1'),
    (121,'Libyan Arab Jamahiriya','LY','LBY','1'),
    (122,'Liechtenstein','LI','LIE','1'),
    (123,'Lithuania','LT','LTU','1'),
    (124,'Luxembourg','LU','LUX','1'),
    (125,'Macau','MO','MAC','1'),
    (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD','1'),
    (127,'Madagascar','MG','MDG','1'),
    (128,'Malawi','MW','MWI','1'),
    (129,'Malaysia','MY','MYS','1'),
    (130,'Maldives','MV','MDV','1'),
    (131,'Mali','ML','MLI','1'),
    (132,'Malta','MT','MLT','1'),
    (133,'Marshall Islands','MH','MHL','1'),
    (134,'Martinique','MQ','MTQ','1'),
    (135,'Mauritania','MR','MRT','1'),
    (136,'Mauritius','MU','MUS','1'),
    (137,'Mayotte','YT','MYT','1'),
    (138,'Mexico','MX','MEX','1'),
    (139,'Micronesia, Federated States of','FM','FSM','1'),
    (140,'Moldova, Republic of','MD','MDA','1'),
    (141,'Monaco','MC','MCO','1'),
    (142,'Mongolia','MN','MNG','1'),
    (143,'Montserrat','MS','MSR','1'),
    (144,'Morocco','MA','MAR','1'),
    (145,'Mozambique','MZ','MOZ','1'),
    (146,'Myanmar','MM','MMR','1'),
    (147,'Namibia','NA','NAM','1'),
    (148,'Nauru','NR','NRU','1'),
    (149,'Nepal','NP','NPL','1'),
    (150,'Netherlands','NL','NLD','1'),
    (151,'Netherlands Antilles','AN','ANT','1'),
    (152,'New Caledonia','NC','NCL','1'),
    (153,'New Zealand','NZ','NZL','1'),
    (154,'Nicaragua','NI','NIC','1'),
    (155,'Niger','NE','NER','1'),
    (156,'Nigeria','NG','NGA','1'),
    (157,'Niue','NU','NIU','1'),
    (158,'Norfolk Island','NF','NFK','1'),
    (159,'Northern Mariana Islands','MP','MNP','1'),
    (160,'Norway','NO','NOR','1'),
    (161,'Oman','OM','OMN','1'),
    (162,'Pakistan','PK','PAK','1'),
    (163,'Palau','PW','PLW','1'),
    (164,'Panama','PA','PAN','1'),
    (165,'Papua New Guinea','PG','PNG','1'),
    (166,'Paraguay','PY','PRY','1'),
    (167,'Peru','PE','PER','1'),
    (168,'Philippines','PH','PHL','1'),
    (169,'Pitcairn','PN','PCN','1'),
    (170,'Poland','PL','POL','1'),
    (171,'Portugal','PT','PRT','1'),
    (172,'Puerto Rico','PR','PRI','1'),
    (173,'Qatar','QA','QAT','1'),
    (174,'Reunion','RE','REU','1'),
    (175,'Romania','RO','ROM','1'),
    (176,'Russian Federation','RU','RUS','1'),
    (177,'Rwanda','RW','RWA','1'),
    (178,'Saint Kitts and Nevis','KN','KNA','1'),
    (179,'Saint Lucia','LC','LCA','1'),
    (180,'Saint Vincent and the Grenadines','VC','VCT','1'),
    (181,'Samoa','WS','WSM','1'),
    (182,'San Marino','SM','SMR','1'),
    (183,'Sao Tome and Principe','ST','STP','1'),
    (184,'Saudi Arabia','SA','SAU','1'),
    (185,'Senegal','SN','SEN','1'),
    (186,'Seychelles','SC','SYC','1'),
    (187,'Sierra Leone','SL','SLE','1'),
    (188,'Singapore','SG','SGP', '4'),
    (189,'Slovakia (Slovak Republic)','SK','SVK','1'),
    (190,'Slovenia','SI','SVN','1'),
    (191,'Solomon Islands','SB','SLB','1'),
    (192,'Somalia','SO','SOM','1'),
    (193,'South Africa','ZA','ZAF','1'),
    (194,'South Georgia and the South Sandwich Islands','GS','SGS','1'),
    (195,'Spain','ES','ESP','3'),
    (196,'Sri Lanka','LK','LKA','1'),
    (197,'St. Helena','SH','SHN','1'),
    (198,'St. Pierre and Miquelon','PM','SPM','1'),
    (199,'Sudan','SD','SDN','1'),
    (200,'Suriname','SR','SUR','1'),
    (201,'Svalbard and Jan Mayen Islands','SJ','SJM','1'),
    (202,'Swaziland','SZ','SWZ','1'),
    (203,'Sweden','SE','SWE','1'),
    (204,'Switzerland','CH','CHE','1'),
    (205,'Syrian Arab Republic','SY','SYR','1'),
    (206,'Taiwan','TW','TWN','1'),
    (207,'Tajikistan','TJ','TJK','1'),
    (208,'Tanzania, United Republic of','TZ','TZA','1'),
    (209,'Thailand','TH','THA','1'),
    (210,'Togo','TG','TGO','1'),
    (211,'Tokelau','TK','TKL','1'),
    (212,'Tonga','TO','TON','1'),
    (213,'Trinidad and Tobago','TT','TTO','1'),
    (214,'Tunisia','TN','TUN','1'),
    (215,'Turkey','TR','TUR','1'),
    (216,'Turkmenistan','TM','TKM','1'),
    (217,'Turks and Caicos Islands','TC','TCA','1'),
    (218,'Tuvalu','TV','TUV','1'),
    (219,'Uganda','UG','UGA','1'),
    (220,'Ukraine','UA','UKR','1'),
    (221,'United Arab Emirates','AE','ARE','1'),
    (222,'United Kingdom','GB','GBR','1'),
    (223,'United States','US','USA', '2'),
    (224,'United States Minor Outlying Islands','UM','UMI','1'),
    (225,'Uruguay','UY','URY','1'),
    (226,'Uzbekistan','UZ','UZB','1'),
    (227,'Vanuatu','VU','VUT','1'),
    (228,'Vatican City State (Holy See)','VA','VAT','1'),
    (229,'Venezuela','VE','VEN','1'),
    (230,'Viet Nam','VN','VNM','1'),
    (231,'Virgin Islands (British)','VG','VGB','1'),
    (232,'Virgin Islands (U.S.)','VI','VIR','1'),
    (233,'Wallis and Futuna Islands','WF','WLF','1'),
    (234,'Western Sahara','EH','ESH','1'),
    (235,'Yemen','YE','YEM','1'),
    (236,'Yugoslavia','YU','YUG','1'),
    (237,'Zaire','ZR','ZAR','1'),
    (238,'Zambia','ZM','ZMB','1'),
    (239,'Zimbabwe','ZW','ZWE','1');

INSERT INTO permission (permission_id, name, description, code_name) VALUES 
    (1, 'Διαχείριση Τομέων', 'Permission to modify catalog', 'ADMIN_CATALOG'),
    (2, 'Διαχείριση Εκπαίδευσης', 'Permission to modify catalog', 'ADMIN_CATALOG_EDU'),
    (3, 'Διαχείριση Διαχειριστών', 'Permission to modify administrators', 'ADMIN_ADMINS'),
    (4, 'Διαχείριση Κεντρικού Banner', 'Permission to modify banner', 'ADMIN_BANNER'),
    (5, 'Διαχείριση Αρχείων', 'Permission to modify files', 'ADMIN_FILES'),
    (6, 'Διαχείριση Newsletter', 'Permission to modify newsletter', 'ADMIN_NEWSLETTER'),
    (7, 'Διαχείριση TÜV TIMES', 'Permission to modify TÜV TIMES', 'ADMIN_TUVTIMES'),
    (8, 'Διαχείριση Οργανισμού', 'Permission to modify organization', 'ADMIN_ORGANIZATION'),
    (9, 'Διαχείριση Ενημέρωσης', 'Permission to modify Contact', 'ADMIN_CONTACT'),
    (10, 'Διαχείριση Διαπιστεύσεων', 'Permission to modify accreditations', 'ADMIN_ACCREDITATIONS'),
    (11, 'Διαχείριση Όρων Χρήσης', 'Permission to modify terms', 'ADMIN_TERMS'),
    (12, 'Διαχείριση Νέων', 'Permission to modify news', 'ADMIN_NEWS'),
    (13, 'Διαχείριση επικοινωνίας', 'Permission to modify contact', 'ADMIN_CONTACT');

INSERT INTO administrator (administrator_id, first_name, last_name, email, password, created_on, status) VALUES
    (1, 'Administrator', 'Eparxis', 'admin@eparxis.com', 'e2f15c2918039de4eb9d1a64858344bc78180bc1', NOW(), 1);

INSERT INTO administrator_permission (administrator_id, permission_id) VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),  
    (1, 5),  
    (1, 6),  
    (1, 7),  
    (1, 8),  
    (1, 9),  
    (1, 10),  
    (1, 11),
    (1, 12),
    (1, 13);