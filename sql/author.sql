-- Set collation of database to utf8
ALTER DATABASE bhuffman1 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--create the author entity
CREATE TABLE author (
   -- create table attributes
	authorId BINARY(16) NOT NULL,
	authorAvatarUrl VARCHAR(255),
	authorActivationToken CHAR(32),
	authorEmail VARCHAR(128) NOT NULL,
	authorHash CHAR(97) NOT NULL,
	authorUsername VARCHAR(32) NOT NULL,
	-- this marks the following attributes unique
	UNIQUE(authorEmail),
	UNIQUE(authorUsername),
	-- this creates an index
	INDEX(authorEmail),
   -- this creates the primary key
	PRIMARY KEY(authorId)
	);

INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername)
	VALUE (UNHEX("ceec3bc28c9a41f5b67dbaeb3947210c"), "www.avatarurl.com", "AcTiVaTiOnToKeN", "author@email.com", "password1","authorUsername");

-- delete previous insert
DELETE FROM author WHERE authorId = UNHEX("ceec3bc28c9a41f5b67dbaeb3947210c");