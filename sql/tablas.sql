drop table if exists videojuegos;

drop table if exists tienda;

CREATE Table videojuego(
    id int PRIMARY key AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    descripcion text not null,
    fecha date not null,
    img VARCHAR(120) not NULL
);

CREATE Table tienda(
    id int PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(10) NOT NULL,
    videojuego_id INT,
    constraint fk_tienda_videojuego FOREIGN KEY(videojuego_id) REFERENCES videojuego(id) on delete CASCADE on update CASCADE
);

