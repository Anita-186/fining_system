CREATE TABLE offenses (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(200) NOT NULL,
    amount DECIMAL(6,2) NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE officials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name varchar(50) NOT NULL, 
    last_name varchar(50) NOT NULL,
    phone_number int(10) NOT NULL,
    email_adress varchar(50) NOT NULL, 
    `role` VARCHAR(15) NOT NULL,
    `location` varchar(50)NOT NULL, 
    designated_route varchar(254),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
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
    id  INT AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL, 
    official_id INT NOT NULL,
    user_type varchar (50) NOT NULL,
    FOREIGN KEY (official_id) REFERENCES officials (id)
);

CREATE TABLE reported_cases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    official_id INT NOT NULL, -- fk
    ghana_card_number varchar(15) NOT NULL, -- fk
    offense_id INT NOT NULL, -- fk
    ticket_number VARCHAR(10) NOT NULL,
    `status`  VARCHAR (15) NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (official_id) REFERENCES officials (id),
    FOREIGN KEY (ghana_card_number) REFERENCES ghana_card_details (ghana_card_number),  
    FOREIGN KEY (offense_id) REFERENCES offenses (id)
);
