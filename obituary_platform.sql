CREATE TABLE obituaries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100),
    date_of_birth DATE,
    date_of_death DATE,
    content TEXT,
    author VARCHAR(100),
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    slug VARCHAR(255) UNIQUE
);
