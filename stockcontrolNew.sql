create database stockcontrol;

use stockcontrol;

create table Users (
id_user int(11) not null auto_increment primary key,
nombre_u varchar(35) not null,
nombre varchar(35) not null,
apellido varchar(35) not null,
ci int(11) not null,
pass varchar(250) not null,
class varchar(11),
genero varchar(11),
targetProd double not null,
img_profile varchar(255)
);

select * from Users;

alter table Users add targetProd double not null;

create table Movements (
id_movement int(11) auto_increment primary key not null,
nombre varchar(50) not null,
code int(12) not null,
move varchar(11) not null,
qty int(11) not null,
tipoStock int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null
);

create table equipos (
id_equipo int(11) primary key auto_increment not null,
nameEq varchar(255) not null
); 

create table SpareParts(
id_code int(11) auto_increment primary key not null,
code int(11) not null,
name varchar(100) not null,
id_equip int(11) not null
);
alter table SpareParts add constraint fk_equipos FOREIGN KEY (`id_equip`) REFERENCES equipos(`id_equipo`);

create table tipostock(
id_stock int(11) primary key auto_increment,
nameTipoStock varchar(255) not null
);

create table spendingtiloreps(
CustomId int(255) not null auto_increment primary key,
Usu varchar(35) not null,
Date datetime not null,
CodRep int(12) not null,
qty int(12) not null
);

create table equipos_repuestos (
id int AUTO_INCREMENT,
repuesto_id int not null,
equipo_id int not null,
primary key(id),
foreign key (repuesto_id) references SpareParts(id_code),
foreign key (equipo_id) references equipos(id_equipo)
);

create table repuestos_estados (
id int auto_increment,
id_repuesto int not null,
id_estado int not null,
qty int(25),
primary key(id),
foreign key (id_repuesto) references SpareParts(id_code),
foreign key (id_estado) references tipoStock(id_stock)
);

create table planillaUsuario (
id_reparacion int(255) primary key auto_increment not null,
usuario_id int(11) not null,
escuela int(11) not null,
serie varchar(255) not null,
repuesto_id varchar(255) not null,
isFlasheo int(11) not null,
isFlasheoCap int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null,
foreign key (usuario_id) references Users(id_user)
);

create table tipoStockSalida (
id_stockSalida int(11) primary key auto_increment not null,
repuesto_id int(11) not null,
tipoStockSalida varchar(255),
qty int(255),
foreign key (repuesto_id) references SpareParts(id_code) 
);

create table ordenesTotales(
id_orden int(11) primary key auto_increment not null,
nOrden varchar(255) not null,
usuario_id int(11) not null,
escuela int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null,
foreign key (usuario_id) references Users (id_user)
);

create table ordenRepuestos (
id_order int(255) primary key auto_increment not null,
repuestos varchar(255),
user_id int(11) not null,
orden_id int(255) not null,
equipo_id int(255) not null,
isFlash int(11) not null,
isFlashCap int(11) not null,
isFinished int(11) not null,
foreign key (user_id) references users(id_user),
foreign key (orden_id) references ordenesTotales(id_orden),
foreign key (equipo_id) references equipos(id_equipo)
);

create table planillaPendientes(
id_orden int(11) primary key auto_increment not null,
nOrden varchar(255) not null,
usuario varchar(255) not null,
repuestoFalt int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null
);

create table planillaDestruccionesTotales(
id_orden int(11) primary key auto_increment not null,
nOrden varchar(255) not null,
usuario varchar(255) not null,
repuestoFalt int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null
);

create table planillaUsuario (
id_reparacion int(255) primary key auto_increment not null,
usuario_id int(11) not null,
escuela int(11) not null,
serie varchar(255) not null,
repuesto_id varchar(255),
isFlasheo int(11) not null,
isFlasheoCap int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null,
foreign key (usuario_id) references Users(id_user)
);

create table tipoStockSalida (
id_stockSalida int(11) primary key auto_increment not null,
repuesto_id int(11) not null,
tipoStockSalida varchar(255),
qty int(255),
foreign key (repuesto_id) references SpareParts(id_code) 
);

create table ordenesTotales(
id_orden int(11) primary key auto_increment not null,
nOrden varchar(255) not null,
usuario_id int(11) not null,
escuela int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null,
foreign key (usuario_id) references Users (id_user)
);

create table ordenRepuestos (
id_order int(255) primary key auto_increment not null,
repuestos varchar(255),
user_id int(11) not null,
orden_id int(255) not null,
equipo_id int(255) not null,
isFinished int(11) not null,
isFlash int(11) not null,
isFlashCap int(11) not null,
foreign key (user_id) references users(id_user),
foreign key (orden_id) references ordenesTotales(id_orden),
foreign key (equipo_id) references equipos(id_equipo)
);

create table planillaPendientes(
id_orden int(11) primary key auto_increment not null,
nOrden varchar(255) not null,
usuario varchar(255) not null,
repuestoFalt int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null
);

create table planillaDestruccionesTotales(
id_orden int(11) primary key auto_increment not null,
nOrden varchar(255) not null,
usuario varchar(255) not null,
repuestoFalt int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null
);