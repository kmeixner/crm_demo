CREATE TABLE organization (
	id int NOT NULL AUTO_INCREMENT,
	org_name varchar(255),
	website varchar(255),
        PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE organization ADD UNIQUE (
	org_name,
	website
);

ALTER TABLE organization ADD INDEX (org_name);

CREATE TABLE contact (
	id int NOT NULL AUTO_INCREMENT,
	firstname varchar(255),
	lastname varchar(255),
	email varchar(254),
	phone varchar(24),
        PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE contact ADD UNIQUE (
	email
);

CREATE TABLE org_contact (
	id int NOT NULL AUTO_INCREMENT,
	org_id int NOT NULL,
	contact_id int NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (org_id) REFERENCES organization(id) ON DELETE CASCADE,
	FOREIGN KEY (contact_id) REFERENCES contact(id) ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE org_contact ADD UNIQUE (
	org_id
);

ALTER TABLE org_contact ADD UNIQUE (
	contact_id
);