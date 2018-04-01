CREATE TABLE authors
(
    authorid INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(80) NOT NULL,
    registrationdate DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(authorid)
);

CREATE TABLE notes
(
    noteid INT NOT NULL AUTO_INCREMENT,
    authorid INT NOT NULL,
    postdate DATETIME DEFAULT CURRENT_TIMESTAMP,
    note TEXT NOT NULL,
    PRIMARY KEY(noteid),
    FOREIGN KEY(authorid) REFERENCES authors(authorid)
);
