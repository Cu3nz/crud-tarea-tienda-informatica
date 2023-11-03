CREATE TABLE producto (
codigo INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
precio DOUBLE NOT NULL
);

INSERT INTO producto VALUES(1, 'Disco duro SATA3 1TB', 86.99);
INSERT INTO producto VALUES(2, 'Memoria RAM DDR4 8GB', 120);
INSERT INTO producto VALUES(3, 'Disco SSD 1 TB', 150.99);
INSERT INTO producto VALUES(4, 'GeForce GTX 1050Ti', 185);
INSERT INTO producto VALUES(5, 'GeForce GTX 1080 Xtreme', 755);
INSERT INTO producto VALUES(6, 'Monitor 24 LED Full HD', 202);
INSERT INTO producto VALUES(7, 'Monitor 27 LED Full HD', 245.99);
INSERT INTO producto VALUES(8, 'Portátil Yoga 520', 559);
INSERT INTO producto VALUES(9, 'Portátil Ideapd 320', 444);
INSERT INTO producto VALUES(10, 'Impresora HP Deskjet 3720', 59.99);
INSERT INTO producto VALUES(11, 'Impresora HP Laserjet Pro M26nw', 180);