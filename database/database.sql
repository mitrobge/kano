-- Create database
CREATE DATABASE IF NOT EXISTS kano DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
SET NAMES 'utf8';

-- Select database
USE kano;

CREATE TABLE language (
    language_id    INT            NOT NULL AUTO_INCREMENT,
    language_name  VARCHAR(32)    NOT NULL,
    language_flag  VARCHAR(96)    NOT NULL,
    PRIMARY KEY (language_id),
    UNIQUE KEY idx_language_name (language_name)
);

CREATE TABLE category (
    category_id    INT          NOT NULL AUTO_INCREMENT,
    parent_id      INT,
    sorting_id     INT          NOT NULL DEFAULT 0,
    lft            INT          NOT NULL,
    rgt            INT          NOT NULL,
    PRIMARY KEY (category_id)
);

CREATE TABLE category_description (
    category_id      INT  NOT NULL,
    language_id      INT  NOT NULL,
    name             TEXT NOT NULL,
    description      TEXT NOT NULL,
    PRIMARY KEY (category_id, language_id)
);

CREATE TABLE survey (
    survey_id           INT          NOT NULL AUTO_INCREMENT,
    parent_id           INT,
    survey_sdate        DATETIME     NOT NULL,
    survey_edate        DATETIME     NOT NULL,
    added_on            DATETIME     NOT NULL,
    is_active           BOOLEAN NOT NULL DEFAULT TRUE,
    sorting_id          INT          NOT NULL DEFAULT 0,
    PRIMARY KEY (survey_id)
);

CREATE TABLE survey_description (
    survey_id          INT          NOT NULL AUTO_INCREMENT,
    language_id        INT          NOT NULL,
    name        VARCHAR(32)  NOT NULL,
    description TEXT         NOT NULL,
    PRIMARY KEY (survey_id,language_id)
);

CREATE TABLE survey_category (
    survey_id           INT         NOT NULL,
    category_id          INT         NOT NULL,
    PRIMARY KEY (survey_id, category_id)
);

CREATE TABLE survey_questions_characteristics (
    question_characteristic_id  INT          NOT NULL AUTO_INCREMENT,
    survey_id          INT          NOT NULL,
    PRIMARY KEY (question_characteristic_id)
);

CREATE TABLE survey_questions_characteristics_description (
    question_characteristic_id          INT             NOT NULL AUTO_INCREMENT,
    language_id                         INT             NOT NULL,
    question_characteristic_name        VARCHAR(32)     NOT NULL,
    PRIMARY KEY (question_characteristic_id, language_id)
);

CREATE TABLE survey_customers_characteristics (
    customers_characteristic_id     INT          NOT NULL AUTO_INCREMENT,
    survey_id                       INT          NOT NULL,
    PRIMARY KEY (customers_characteristic_id)
);

CREATE TABLE survey_customers_characteristics_description (
    customers_characteristic_id      INT             NOT NULL,
    language_id                     INT             NOT NULL,
    customer_characteristic_name    VARCHAR(32)     NOT NULL,
    PRIMARY KEY (customers_characteristic_id, language_id)
);

CREATE TABLE survey_answers (
    answer_id                   INT             NOT NULL AUTO_INCREMENT,
    survey_id                   INT             NOT NULL,
    characteristic_id           INT             NOT NULL,
    characteristic_answer_pos   INT             NOT NULL,
    characteristic_answer_neg   INT             NOT NULL,
    added_on                    DATETIME        NOT NULL,
    PRIMARY KEY (answer_id)
);

CREATE TABLE country (
    country_id            INT             NOT NULL AUTO_INCREMENT,
    name                  VARCHAR(64)     NOT NULL,
    iso_code_2            CHAR(2)         NOT NULL,
    iso_code_3            CHAR(3)         NOT NULL,
    address_format_id     INT             NOT NULL,
    PRIMARY KEY (country_id),
    KEY IDX_COUNTRY_NAME (name)
);

CREATE TABLE customer (
    customer_id             INT             NOT NULL AUTO_INCREMENT,
    created_on              DATETIME        NOT NULL,
    gender                  CHAR(1)         NOT NULL,
    first_name              VARCHAR(32)     NOT NULL,
    last_name               VARCHAR(32)     NOT NULL,
    nickname                VARCHAR(32),
    email                   VARCHAR(96),
    password                VARCHAR(64)     NOT NULL,
    birthday                DATETIME        DEFAULT '0000-00-00 00:00:00' NOT NULL,
    street_address          VARCHAR(64)     NOT NULL,
    city                    VARCHAR(32)     NOT NULL,
    state_id                INT             ,
    postcode                VARCHAR(10)     NOT NULL,
    country_id              INT             ,
    shipping_region_id      INT             ,
    company                 VARCHAR(64),
    phone                   VARCHAR(32)     NOT NULL,
    mobile                  VARCHAR(32)     NOT NULL,
    company_name            VARCHAR(64),
    company_address         VARCHAR(64),
    profession              VARCHAR(64),
    vat_registration        VARCHAR(16),
    tax_office              VARCHAR(32),
    newsletter              CHAR(1),
    password_recover_id     VARCHAR(32),
    password_recover_start  DATETIME,
    PRIMARY KEY (customer_id),
    UNIQUE KEY idx_customer_email (email)
);

CREATE TABLE administrator (
    administrator_id    INT             NOT NULL AUTO_INCREMENT,
    first_name          VARCHAR(32)     NOT NULL,
    last_name           VARCHAR(32)     NOT NULL,
    email               VARCHAR(64),
    password            VARCHAR(96)     NOT NULL,
    created_on          DATETIME        NOT NULL,
    last_login          DATETIME,
    status              TINYINT         NOT NULL DEFAULT 0,
    language_id         INT,
    seminars_per_page   INT,
    reviews_per_page    INT,
    questions_per_page  INT,
    reports_per_page    INT,
    offers_per_page     INT,
    PRIMARY KEY (administrator_id),
    UNIQUE KEY idx_administrator_email (email)
);

CREATE TABLE permission (
    permission_id       INT             NOT NULL AUTO_INCREMENT,
    name                VARCHAR(32)     NOT NULL,
    description         VARCHAR(255),
    code_name           VARCHAR(32)     NOT NULL,
    PRIMARY KEY (permission_id),
    KEY idx_code_name (code_name)                     
);

CREATE TABLE administrator_permission (
    administrator_id        INT         NOT NULL,
    permission_id           INT         NOT NULL,
    PRIMARY KEY (administrator_id, permission_id)
);

CREATE TABLE uploaded_files (
    file_id     INT      NOT NULL AUTO_INCREMENT,
    filename    TEXT     NOT NULL,
    upload_date DATETIME NOT NULL,
    PRIMARY KEY (file_id)
);

-- changes 21/09/2015--
drop table survey_questions_characteristics_description;

CREATE TABLE survey_questions_characteristics_description (
  question_characteristic_id          INT             NOT NULL AUTO_INCREMENT,
  language_id                         INT             NOT NULL,
  question        VARCHAR(200)     NOT NULL,
  is_positive                         BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (question_characteristic_id, language_id, is_positive)
);

-- changes 21/09/2015--

-- changes 23/09/2015--

DELETE FROM survey_answers;
alter table survey_answers add column `customer_id`  INT NOT NULL;
alter table survey_answers add UNIQUE KEY idx_customer_characteristic_id (customer_id, characteristic_id);

DROP TABLE customer;

CREATE TABLE customer (
  customer_id             INT             NOT NULL AUTO_INCREMENT,
  email                   VARCHAR(96)    NOT NULL,
  PRIMARY KEY (customer_id),
  UNIQUE KEY idx_customer_email (email)
);

-- changes 23/09/2015--

-- Change DELIMITER to $$
DELIMITER $$

CREATE PROCEDURE language_get_languages()
BEGIN
    SET NAMES 'utf8';
    SELECT     *
    FROM       language;
END$$

CREATE PROCEDURE language_get_language(IN inLanguageId INT)
BEGIN
    SELECT     language_name, language_flag
    FROM       language
    WHERE      language_id = inLanguageId;
END$$

CREATE PROCEDURE language_get_by_name(IN inLanguageName VARCHAR(32))
BEGIN
    SELECT     language_id, language_name, language_flag
    FROM       language
    WHERE      language_name = inLanguageName;
END$$



-- Create customer_check_existance stored procedure
CREATE PROCEDURE customer_check_login_info(IN inEmail VARCHAR(96), 
    IN inPassword VARCHAR(64))
BEGIN
    DECLARE customerId INT;
    DECLARE checkStatus INT;
    DECLARE customerFirstName VARCHAR(32);
    DECLARE customerLastName VARCHAR(32);
    DECLARE customerPassword VARCHAR(64);
    DECLARE customerPasswordRecoverId VARCHAR(32);

    SELECT  customer_id, first_name, last_name, password, 
    password_recover_id
    FROM    customer 
    WHERE   email = inEmail
    INTO    customerId, customerFirstName, 
    customerLastName, customerPassword,
    customerPasswordRecoverId;

    IF customerId IS NULL THEN
        SET checkStatus = 2;
    ELSEIF customerPassword != inPassword THEN
        SET checkStatus = 1;
    ELSEIF customerPasswordRecoverId IS NOT NULL THEN
        SET checkStatus = 3;
    ELSE
        SET checkStatus = 0;
    END IF;

    SELECT  customerId AS customer_id, 
    customerFirstName AS first_name,
    customerLastName AS last_name,
    checkStatus AS check_status;
END$$

-- Create customer_add stored procedure
CREATE PROCEDURE customer_add(IN inGender CHAR(1),
    IN inFirstName VARCHAR(32),
    IN inLastName VARCHAR(32), 
    IN inEmail VARCHAR(96), 
    IN inPassword VARCHAR(64),
    IN inStreetAddress VARCHAR(64),
    IN inCity VARCHAR(32),
    IN inStateId INT,
    IN inPostcode VARCHAR(10),
    IN inCountryId INT,
    IN inPhone VARCHAR(32),
    IN inMobile VARCHAR(32))
BEGIN
    INSERT 
    INTO    customer (created_on, gender, first_name, last_name, 
        email, password, 
        street_address, city, state_id, 
        postcode, country_id, 
        phone, mobile)
    VALUES  (NOW(), inGender, inFirstName, inLastName,  
        inEmail, inPassword,  
        inStreetAddress, inCity, inStateId, 
        inPostcode, inCountryId, 
        inPhone, inMobile);

    SELECT LAST_INSERT_ID();
END$$

-- Create utils_get_countries stored procedure
CREATE PROCEDURE utils_get_countries()
BEGIN
    SELECT  *
    FROM    country; 
END$$

-- Create utils_get_country stored procedure
CREATE PROCEDURE utils_get_country(IN inCountryId INT)
BEGIN
    SELECT  name, iso_code_2, iso_code_3, address_format_id
    FROM    country
    WHERE   country_id = inCountryId; 
END$$

-- Create utils_get_country_states stored procedure
CREATE PROCEDURE utils_get_country_states(IN inCountryId INT)
BEGIN
    SELECT  state_id, state_name
    FROM    country_state
    WHERE   country_id = inCountryId; 
END$$

-- Create utils_get_states stored procedure
CREATE PROCEDURE utils_get_states()
BEGIN
    SELECT  state_id, state_name, country_id
    FROM    country_state;
END$$

-- Create utils_get_state stored procedure
CREATE PROCEDURE utils_get_state(IN inStateId INT)
BEGIN
    SELECT  state_id, state_name, country_id
    FROM    country_state
    WHERE   state_id = inStateId; 
END$$

-- Create customer_get_customer stored procedure
CREATE PROCEDURE customer_get_customer(IN inCustomerId INT)
BEGIN
    SELECT  * 
    FROM    customer
    WHERE   customer_id = inCustomerId;
END$$

-- Create beehive_get_beehive_latest_status: get latest health status
CREATE PROCEDURE beehive_get_beehive_latest_status(IN inBeehiveId INT)
BEGIN
    SELECT  * 
    FROM    beehive_health_status
    WHERE   beehive_id = inBeehiveId
    ORDER BY added_on DESC LIMIT 1;
END$$

CREATE PROCEDURE administrator_has_permission(IN inAdministratorId INT, IN inPermissionCodeName VARCHAR(32))
BEGIN
    DECLARE permissionId INT;

    SELECT      p.permission_id
    FROM        permission p
    INNER JOIN  administrator_permission ap
    ON p.permission_id = ap.permission_id
    WHERE       ap.administrator_id = inAdministratorId
    AND p.code_name = inPermissionCodeName
    INTO        permissionId;

    IF permissionId IS NULL THEN
        SELECT 0;
    ELSE
        SELECT 1;
    END IF;
END$$

-- Create administrator_add_administrator stored procedure
CREATE PROCEDURE administrator_add_administrator(IN inAdminFirstName VARCHAR(32), 
    IN inAdminLastName VARCHAR(32), 
    IN inAdminEmail VARCHAR(64), 
    IN inAdminPassword VARCHAR(96))
BEGIN
    INSERT 
    INTO    administrator (first_name, last_name, 
        email, password, created_on) 
    VALUES  (inAdminFirstName, inAdminLastName, 
        inAdminEmail, inAdminPassword, NOW());

    SELECT LAST_INSERT_ID();
END$$

-- Create administrator_get_administrators stored procedure
CREATE PROCEDURE administrator_get_administrators()
BEGIN
    SELECT  administrator_id, first_name, last_name, 
    email, created_on, last_login, status 
    FROM    administrator; 
END$$

-- Create administrator_get_administrators_with_permission stored procedure
CREATE PROCEDURE administrator_get_administrators_with_permission(IN inPermissionCodeName VARCHAR(32))
BEGIN
    SELECT      a.administrator_id, first_name, last_name, 
    email, created_on, last_login, status 
    FROM        administrator a
    INNER JOIN  administrator_permission ap
    ON ap.administrator_id = a.administrator_id
    INNER JOIN  permission p
    ON p.permission_id = ap.permission_id
    WHERE       p.code_name = inPermissionCodeName;
END$$

-- Create administrator_get_administrator stored procedure
CREATE PROCEDURE administrator_get_administrator(IN inAdministratorId INT)
BEGIN
    SELECT      a.administrator_id, first_name, last_name, 
    email, created_on, last_login, status, seminars_per_page,
    reviews_per_page, questions_per_page, reports_per_page, 
    offers_per_page, GROUP_CONCAT(ap.permission_id) AS permissions_ids
    FROM        administrator a
    LEFT JOIN   administrator_permission ap
    ON ap.administrator_id = a.administrator_id
    WHERE       a.administrator_id = inAdministratorId
    GROUP BY    a.administrator_id; 
END$$

-- Create administrator_set_permissions stored procedure
CREATE PROCEDURE administrator_set_permissions(IN inAdministratorId INT, 
    IN inPermissionsIds VARCHAR(256))
BEGIN
    DECLARE i INT DEFAULT 0;    -- total number of delimiters
    DECLARE ctr INT DEFAULT 0;  -- counter for the loop
    DECLARE str_len INT;        -- string length,self explanatory
    DECLARE out_str text DEFAULT '';    -- return string holder
    DECLARE temp_str text DEFAULT '';   -- temporary string holder
    DECLARE delim CHAR(1) DEFAULT ',';   -- default delimeter
    DECLARE temp_val INT;               -- temporary holder for query

    -- First clear existing permissions
    DELETE
    FROM    administrator_permission
    WHERE   administrator_id = inAdministratorId;   

    -- get length
    SET str_len=LENGTH(inPermissionsIds);    

    SET i = (LENGTH(inPermissionsIds)-LENGTH(REPLACE(
                inPermissionsIds, delim, '')))/LENGTH(delim) + 1;    
    -- get total number delimeters and add 1
    -- add 1 since total separated values are 1 more than the number of delimiters

    -- start of while loop
    WHILE(ctr<i) DO
        -- add 1 to the counter, which will also be used to get the value of the string
        SET ctr=ctr+1; 

        -- get value separated by delimiter using ctr as the index
        SET temp_str = REPLACE(SUBSTRING(SUBSTRING_INDEX(inPermissionsIds, delim, ctr), 
                LENGTH(SUBSTRING_INDEX(inPermissionsIds, delim,ctr - 1)) + 1), delim, '');

        -- query real value and insert into temporary value holder, temp_str contains the exploded ID           
        SELECT  permission_id 
        INTO    temp_val 
        FROM    permission 
        WHERE   permission_id = temp_str;

        -- insert permission_id to the administrator_permission table
        IF temp_val IS NOT NULL THEN
            INSERT 
            INTO    administrator_permission (administrator_id, permission_id) 
            VALUES  (inAdministratorId, temp_val);
        END IF;
END WHILE;
-- end of while loop
END$$

CREATE PROCEDURE administrator_get_available_permissions()
BEGIN
    SELECT      permission_id, name, description, code_name
    FROM        permission;
END$$

-- Create administrator_update_details stored procedure
CREATE PROCEDURE administrator_change_password(IN inAdministratorId INT, 
    IN inAdminNewPassword VARCHAR(96))
BEGIN
    UPDATE  administrator 
    SET     password = inAdminNewPassword
    WHERE   administrator_id = inAdministratorId;
END$$

-- Create administrator_check_login_info stored procedure
CREATE PROCEDURE administrator_check_login_info(IN inEmail VARCHAR(64), 
    IN inPassword VARCHAR(96))
BEGIN
    DECLARE administratorId INT;
    DECLARE checkStatus INT;
    DECLARE administratorStatus TINYINT;
    DECLARE administratorFirstName VARCHAR(32);
    DECLARE administratorLastName VARCHAR(32);
    DECLARE administratorPassword VARCHAR(96);

    SELECT  administrator_id, first_name, last_name, password, status
    FROM    administrator 
    WHERE   email = inEmail
    INTO    administratorId, administratorFirstName, 
    administratorLastName, administratorPassword, 
    administratorStatus;

    IF administratorId IS NULL THEN
        SET checkStatus = 2;
    ELSEIF administratorPassword != inPassword THEN
        SET checkStatus = 1;
    ELSEIF administratorStatus = 0 THEN -- blocked
        SET checkStatus = 3;
    ELSE
        SET checkStatus = 0;
        UPDATE administrator
        SET    last_login = NOW()
        WHERE  administrator_id = administratorId;
    END IF;

    SELECT  administratorId AS administrator_id, 
    administratorFirstName AS first_name,
    administratorLastName AS last_name,
    checkStatus AS check_status;
END$$

-- Create surveys_get_categories stored procedure: Returns the subcategories of a category
CREATE PROCEDURE surveys_get_categories(IN inParentId INT, IN inLanguageId INT)
BEGIN
    SELECT      c.category_id, c.parent_id, cd.name, cd.description, 
    (SELECT COUNT(*) 
        FROM   category c2 
        WHERE  c2.parent_id = c.category_id) AS subcategories_count,
    (SELECT    COUNT(*) 
        FROM       survey s 
        INNER JOIN survey_category sc 
        ON s.survey_id = sc.survey_id 
        WHERE      sc.category_id = c.category_id) AS products_count
    FROM        category c
    INNER JOIN  category_description cd
    ON c.category_id = cd.category_id
    WHERE       language_id = inLanguageId
    AND parent_id <=> inParentId
    ORDER BY    c.sorting_id;
END$$


-- Create catalog_check_category_name stored procedure
CREATE PROCEDURE surveys_check_category_name(IN inParentId INT, IN inCategoryId INT, 
    IN inCategoryName VARCHAR(100), IN inLanguageId INT)
BEGIN
    IF inCategoryId IS NULL THEN
        SELECT      c.category_id 
        FROM        category c
        INNER JOIN  category_description cd
        ON cd.category_id = c.category_id 
        WHERE       c.parent_id <=> inParentId
        AND cd.language_id = inLanguageId
        AND cd.name = inCategoryName;
    ELSE
        SELECT      c.category_id 
        FROM        category c
        INNER JOIN  category_description cd
        ON cd.category_id = c.category_id 
        WHERE       c.parent_id <=> inParentId
        AND c.category_id != inCategoryId
        AND cd.language_id = inLanguageId
        AND cd.name = inCategoryName;
    END IF;
END$$

-- Create surveys_add_category stored procedure
CREATE PROCEDURE surveys_add_category(IN inParentId INT)
BEGIN
    DECLARE myRight INT;
    DECLARE myLeft INT;
    DECLARE maxRight INT;
    DECLARE categoryId INT;

    IF inParentId IS NULL THEN
        SELECT  MAX(rgt)
        FROM    category
        INTO    maxRight;
        IF maxRight IS NULL THEN
            INSERT 
            INTO    category (parent_id, lft, rgt) 
            VALUES  (NULL,  1, 2);
        ELSE
            INSERT 
            INTO    category (parent_id, lft, rgt) 
            VALUES  (NULL, maxRight + 1, maxRight + 2);
        END IF;
    ELSE
        SELECT  lft 
        FROM    category
        WHERE   category_id = inParentId
        INTO    myLeft;

        UPDATE  category 
        SET     rgt = rgt + 2 
        WHERE   rgt > myLeft;

        UPDATE  category 
        SET     lft = lft + 2 
        WHERE   lft > myLeft;

        INSERT 
        INTO    category (parent_id, lft, rgt) 
        VALUES  (inParentId, myLeft + 1, myLeft + 2);
    END IF;

    SELECT  LAST_INSERT_ID() INTO categoryId;
    SELECT categoryId;

END$$

-- Create surveys_set_category_name stored procedure
CREATE PROCEDURE surveys_set_category_name(IN inCategoryId INT, IN inCategoryName VARCHAR(100), IN inLanguageId INT)
BEGIN
    INSERT
    INTO    category_description (category_id, language_id, name)
    VALUES  (inCategoryId, inLanguageId, inCategoryName);
END$$

-- Create surveys_get_category stored procedure: Returns details for a specific category (name)
CREATE PROCEDURE surveys_get_category(IN inCategoryId INT, IN inLanguageId INT)
BEGIN
    SELECT      c.category_id, c.parent_id, cd.name, cd2.name AS parent_name, 
    cd.description
    FROM        category c
    INNER JOIN  category_description cd
    ON c.category_id = cd.category_id
    LEFT JOIN   category_description cd2
    ON c.parent_id = cd2.category_id
    WHERE       cd.language_id = inLanguageId
    AND COALESCE(cd2.language_id, inLanguageId) = inLanguageId
    AND c.category_id = inCategoryId;
END$$

CREATE PROCEDURE surveys_get_category_name(IN inCategoryId INT, IN inLanguageId INT)
BEGIN
    SELECT 	name
    FROM	category_description
    WHERE	category_id = inCategoryId
    AND language_id = inLanguageId;
END$$

CREATE PROCEDURE surveys_get_category_details(IN inCategoryId INT, IN inLanguageId INT)
BEGIN
    SELECT 	description
    FROM	category_description
    WHERE	category_id = inCategoryId
    AND language_id = inLanguageId;
END$$

CREATE PROCEDURE surveys_get_survey_name(IN inSurveyId INT, IN inLanguageId INT)
BEGIN
    SELECT 	name
    FROM	survey_description
    WHERE	survey_id = inSurveyId
    AND language_id = inLanguageId;
END$$

CREATE PROCEDURE surveys_get_survey_description(IN inSurveyId INT, IN inLanguageId INT)
BEGIN
    SELECT 	description
    FROM	survey_description
    WHERE	survey_id = inSurveyId
    AND language_id = inLanguageId;
END$$

CREATE PROCEDURE surveys_get_survey_details(IN inSurveyId INT, IN inLanguageId INT)
BEGIN
    SELECT       s.survey_id, sd.name, sd.description
    FROM         survey s
    INNER JOIN   survey_description sd
    ON sd.survey_id = s.survey_id
    WHERE        s.survey_id = inSurveyId
    AND sd.language_id = inLanguageId;
END$$

-- Create surveys_get_surveys stored procedure: Returns the surveys for a specific category
CREATE PROCEDURE surveys_get_surveys(IN inCategoryId INT, IN inLanguageId INT)
BEGIN
    SELECT      s.survey_id, sd.name, sd.description
    FROM        survey s
    INNER JOIN  survey_description sd
    ON s.survey_id = sd.survey_id
    INNER JOIN  survey_category sc
    ON s.survey_id = sc.survey_id
    WHERE       sd.language_id = inLanguageId
    AND sc.category_id = inCategoryId
    ORDER BY    s.sorting_id;
END$$

-- Create catalog_update_category stored procedure
CREATE PROCEDURE surveys_update_category(IN inCategoryId INT,
    IN inCategoryName VARCHAR(100),
    IN inCategoryDescription MEDIUMTEXT,
    IN inLanguageId INT)
BEGIN
    INSERT
    INTO    category_description (category_id, name, description, language_id)
    VALUES  (inCategoryId, inCategoryName, inCategoryDescription, inLanguageId)
    ON DUPLICATE KEY UPDATE name = inCategoryName, description = inCategoryDescription;
END$$


-- Create surveys_delete_category stored procedure
CREATE PROCEDURE surveys_delete_category(IN inCategoryId INT, IN inForceDelete BOOLEAN)
BEGIN
    DECLARE myLeft INT;
    DECLARE myRight INT;
    DECLARE myWidth INT;
    DECLARE surveyCategoryRowsCount INT;

    SELECT  lft, rgt, rgt - lft + 1
    FROM    category
    WHERE   category_id = inCategoryId
    INTO    myLeft, myRight, myWidth;

    IF inForceDelete = false THEN 
        SELECT      COUNT(*)
        FROM        survey s
        INNER JOIN  survey_category pc 
        ON s.survey_id = sc.survey_id
        WHERE       sc.category_id IN 
        (SELECT category_id
            FROM   category
            WHERE  lft BETWEEN myLeft AND myRight)
        INTO        surveyCategoryRowsCount;
    END IF;

    IF surveyCategoryRowsCount = 0 OR inForceDelete = true THEN
        IF inForceDelete = true THEN
            CALL surveys_delete_category_surveys(inCategoryId);
        END IF;

        DELETE
        FROM    category_description
        WHERE   category_id IN 
        (SELECT category_id
            FROM   category
            WHERE  lft BETWEEN myLeft AND myRight);

        DELETE  
        FROM    category 
        WHERE   lft BETWEEN myLeft AND myRight;

        UPDATE  category 
        SET     rgt = rgt - myWidth 
        WHERE   rgt > myRight;

        UPDATE  category 
        SET     lft = lft - myWidth 
        WHERE   lft > myRight;

        SELECT  1;
    ELSE
        SELECT  -1;
    END IF;
END$$

-- Create surveys_delete_category_surveys stored procedure
CREATE PROCEDURE surveys_delete_category_surveys(IN inCategoryId INT)
BEGIN

    DECLARE myLeft INT;
    DECLARE myRight INT;

    DROP TABLE IF EXISTS survey_tmp;
    CREATE TABLE survey_tmp (
        survey_id             INT,
        PRIMARY KEY (survey_id)
    );

    SELECT  lft, rgt
    FROM    category
    WHERE   category_id = inCategoryId
    INTO    myLeft, myRight;

    INSERT
    INTO    survey_tmp (survey_id)
    SELECT      s.survey_id 
    FROM        survey s 
    INNER JOIN  survey_category sc 
    ON sc.survey_id = s.survey_id 
    WHERE       sc.category_id IN 
    (SELECT category_id
        FROM   category
        WHERE  lft BETWEEN myLeft AND myRight);

    DELETE 
    FROM    survey_category 
    WHERE   survey_id IN (SELECT survey_id FROM survey_tmp);

    DELETE 
    FROM    survey_description 
    WHERE   survey_id IN (SELECT survey_id FROM survey_tmp);

    DELETE 
    FROM    survey 
    WHERE   survey_id IN (SELECT survey_id FROM survey_tmp);    
END$$

CREATE PROCEDURE files_upload_file(IN inFIleName VARCHAR(100))
BEGIN
    INSERT
    INTO    uploaded_files (filename, upload_date)
    VALUES  (inFileName, NOW());
END$$

CREATE PROCEDURE files_get_files()
BEGIN
    SELECT *
    FROM    uploaded_files
    ORDER BY upload_date DESC;
END$$

CREATE PROCEDURE check_if_file_exists(IN inFileName VARCHAR(100))
BEGIN
    SELECT EXISTS (SELECT 1 from uploaded_files where  filename=inFileName);
END$$

CREATE PROCEDURE files_delete_file(IN inFileId INT)
BEGIN
    DELETE 
    FROM uploaded_files
    WHERE file_id = inFileId;
END$$

CREATE PROCEDURE surveys_get_active_surveys(IN inLanguageId INT)
  BEGIN
    SELECT      s.survey_id, d.name, d.description
    FROM        survey s
      JOIN        survey_description d on d.survey_id = s.survey_id
    WHERE       d.language_id = inLanguageId
                AND now() between survey_sdate and s.survey_edate
    ORDER BY    s.sorting_id, s.survey_id;
END$$

CREATE PROCEDURE surveys_get_survey_data(IN surveyId INT, IN inLanguageId INT)
  BEGIN
    SELECT s.survey_id id, d.name, d.description, sqc.question_characteristic_id qid, sqcd.question, sqcd.is_positive
    FROM survey s join kano.survey_description d on d.survey_id = s.survey_id
      join survey_questions_characteristics sqc on sqc.survey_id = s.survey_id
      join kano.survey_questions_characteristics_description sqcd on sqcd.question_characteristic_id = sqc.question_characteristic_id
      and sqcd.language_id = d.language_id
      and d.language_id = inLanguageId and s.survey_id = surveyId
    order by qid, is_positive desc;
  END$$

CREATE PROCEDURE surveys_get_customer_survey_answers(IN surveyId INT, IN customerEmail VARCHAR(50))
  BEGIN
    select sa.answer_id, sa.survey_id, sa.characteristic_id, sa.characteristic_answer_pos,
      sa.characteristic_answer_neg, sa.added_on, sa.customer_id
    from kano.survey_answers sa join kano.customer c on sa.customer_id = c.customer_id
    where sa.survey_id = surveyId and c.email = customerEmail;
  END$$

CREATE PROCEDURE survey_submit_answer(IN customerEmail VARCHAR(50),
                                      IN surveyId INT,
                                      IN characteristicId INT,
                                      IN positiveAnswer INT,
                                      IN negativeAnswer INT,
                                      OUT result INT)
  BEGIN

    DECLARE cId int;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
    ROLLBACK;
    /*GET DIAGNOSTICS CONDITION 1
    @p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
    SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';*/
    END;

    START TRANSACTION;

    set result = 0;

    select customer_id INTO cId from customer where email =  customerEmail;

    if(cId is null)
    then
      INSERT INTO customer (email) VALUES (customerEmail);
      SELECT LAST_INSERT_ID() INTO cId;
    end if;

    INSERT
    INTO  kano.survey_answers (survey_id, characteristic_id, characteristic_answer_pos,
                               characteristic_answer_neg, added_on, customer_id)
    VALUES (surveyId, characteristicId, positiveAnswer, negativeAnswer, now(), cId);
    COMMIT;
    set result = 1;
  END$$

-- Change back DELIMITER to ;
DELIMITER ;
