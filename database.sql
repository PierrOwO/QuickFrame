CREATE TABLE users (
    unique_id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NULL,
    last_name VARCHAR(255) NULL,
    login VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    password VARCHAR(255) NULL,
    sn VARCHAR(255) NULL,
    pin INT NULL,
    status INT NULL,
    created_at DATE NULL
);
