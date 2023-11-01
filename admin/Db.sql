CREATE TABLE offense_table (
    offense_id  varchar (15) PRIMARY KEY,
    name_of_offense varchar(50) NOT NULL,
    amount DECIMAL(6,2) NOT NULL
);

CREATE TABLE official_details (
    official_id varchar(20) PRIMARY KEY,
    first_name varchar(50) NOT NULL, 
    last_name varchar(50) NOT NULL,
    phone_number int(10) NOT NULL,
    email_adress varchar(50) NOT NULL, 
    `location` varchar(50)NOT NULL, 
    designated_route varchar(254) NOT NULL
);

CREATE TABLE ghana_card_details (
    ghana_card_number varchar(15) PRIMARY KEY,
    first_name varchar(50) NOT NULL,
    last_name varchar(50) NOT NULL,
    lacation varchar (50) NOT NULL,
    phone_number int(10) NOT NULL,
    email_address varchar(50) NOT NULL
);

CREATE TABLE login (
    table_id int(15) PRIMARY KEY,
    username varchar(50) NOT NULL,
    `password` varchar(50) NOT NULL, 
    official_id varchar(20) NOT NULL,
    user_type varchar (50)NOT NULL,
    FOREIGN KEY (official_id) REFERENCES official_details (official_id)
);

CREATE TABLE reported_case (
    table_id int(15) PRIMARY KEY,
    official_id varchar(50) NOT NULL, -- fk
    ghana_card_number varchar(15) NOT NULL, -- fk
    offense_id varchar (50) Not NULL, -- fk
    `status`  varchar (15) NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (official_id) REFERENCES official_details (official_id),
    FOREIGN KEY (ghana_card_number) REFERENCES ghana_card_details (ghana_card_number),  
     FOREIGN KEY (offense_id) REFERENCES offense_table (offense_id)
);

ALTER TABLE reported_case ADD COLUMN ticket_number VARCHAR(10) NOT NULL AFTER offense_id;