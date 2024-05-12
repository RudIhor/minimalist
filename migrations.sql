-- users table
CREATE TABLE IF NOT EXISTS users
(
    id            BIGINT AUTO_INCREMENT PRIMARY KEY,
    first_name    VARCHAR(255),
    last_name     VARCHAR(255) DEFAULT null,
    username      VARCHAR(255) DEFAULT null,
    is_premium    TINYINT      DEFAULT 0,
    language_code VARCHAR(10),
    created_at    DATETIME,
    updated_at    DATETIME
);
