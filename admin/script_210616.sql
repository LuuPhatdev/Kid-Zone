drop database if exists Kidzone;
create database KidZone character set utf8mb4 COLLATE utf8mb4_unicode_ci;
use KidZone;
create table admin
(
    id        int auto_increment
        primary key,
    user_name varchar(15) not null,
    password  varchar(15) not null,
    constraint user
        unique (user_name)
);

create table category
(
    id_c          tinyint auto_increment
        primary key,
    category_name varchar(50)               not null,
    description   varchar(250) charset utf8 null,
    constraint CATEGORY_NAME
        unique (category_name)
);

create table storage
(
    id_e        int auto_increment
        primary key,
    id_c        tinyint                   not null,
    name        varchar(50)               not null,
    description varchar(250) charset utf8 null,
    constraint name
        unique (name),
    constraint FK_storage_category
        foreign key (id_c) references category (id_c)
);

create table file
(
    id_f      int auto_increment
        primary key,
    id_e      int         not null,
    file_name varchar(50) not null,
    file_type tinyint(1)  not null,
    constraint file_name
        unique (file_name),
    constraint FK_file_storage
        foreign key (id_e) references storage (id_e)
);

# -----Vehicles-----

#Vehicle category
insert into category (category_name, description)
values ('vehicle', 'pictures for vehicles');

# Vehicle storage
insert into storage (id_c, name, description)
values (1, 'airplane', 'airplane');
insert into storage (id_c, name, description)
values (1, 'bike', 'bike');
insert into storage (id_c, name, description)
values (1, 'car', 'car');
insert into storage (id_c, name, description)
values (1, 'scooter', 'scooter');
insert into storage (id_c, name, description)
values (1, 'train', 'train');
insert into storage (id_c, name, description)
values (1, 'truck', 'truck');

# Vehicle file
insert into file (id_e, file_name, file_type)
values (1, 'airplane.jpg', 0);
insert into file (id_e, file_name, file_type)
values (2, 'bike.jpg', 0);
insert into file (id_e, file_name, file_type)
values (3, 'car.jpg', 0);
insert into file (id_e, file_name, file_type)
values (4, 'scooter.jpg', 0);
insert into file (id_e, file_name, file_type)
values (5, 'train.jpg', 0);
insert into file (id_e, file_name, file_type)
values (6, 'truck.png', 0);



# ---ABC---

#ABC category
insert into category(category_name, description)
values ('abc', 'sound and pic of alphabet');

# ABC storage
insert into storage(id_c, name, description)
values (2, 'A.png', 'sound of A');
insert into storage(id_c, name, description)
values (2, 'B.png', 'sound of B');
insert into storage(id_c, name, description)
values (2, 'C.png', 'sound of C');
insert into storage(id_c, name, description)
values (2, 'D.png', 'sound of D');
insert into storage(id_c, name, description)
values (2, 'E.png', 'sound of E');
insert into storage(id_c, name, description)
values (2, 'F.png', 'sound of F');
insert into storage(id_c, name, description)
values (2, 'G.png', 'sound of G');
insert into storage(id_c, name, description)
values (2, 'H.png', 'sound of H');
insert into storage(id_c, name, description)
values (2, 'I.png', 'sound of I');
insert into storage(id_c, name, description)
values (2, 'J.png', 'sound of J');
insert into storage(id_c, name, description)
values (2, 'K.png', 'sound of K');
insert into storage(id_c, name, description)
values (2, 'L.png', 'sound of L');
insert into storage(id_c, name, description)
values (2, 'M.png', 'sound of M');
insert into storage(id_c, name, description)
values (2, 'N.png', 'sound of N');
insert into storage(id_c, name, description)
values (2, 'O.png', 'sound of O');
insert into storage(id_c, name, description)
values (2, 'P.png', 'sound of P');
insert into storage(id_c, name, description)
values (2, 'Q.png', 'sound of Q');
insert into storage(id_c, name, description)
values (2, 'R.png', 'sound of R');
insert into storage(id_c, name, description)
values (2, 'S.png', 'sound of S');
insert into storage(id_c, name, description)
values (2, 'T.png', 'sound of T');
insert into storage(id_c, name, description)
values (2, 'U.png', 'sound of U');
insert into storage(id_c, name, description)
values (2, 'V.png', 'sound of V');
insert into storage(id_c, name, description)
values (2, 'W.png', 'sound of W');
insert into storage(id_c, name, description)
values (2, 'X.png', 'sound of X');
insert into storage(id_c, name, description)
values (2, 'Y.png', 'sound of Y');
insert into storage(id_c, name, description)
values (2, 'Z.png', 'sound of Z');

# ABC file
insert into file(id_e, file_name, file_type)
values (7, 'A.wav', 1);
insert into file(id_e, file_name, file_type)
values (8, 'B.wav', 1);
insert into file(id_e, file_name, file_type)
values (9, 'C.wav', 1);
insert into file(id_e, file_name, file_type)
values (10, 'D.wav', 1);
insert into file(id_e, file_name, file_type)
values (11, 'E.wav', 1);
insert into file(id_e, file_name, file_type)
values (12, 'F.wav', 1);
insert into file(id_e, file_name, file_type)
values (13, 'G.wav', 1);
insert into file(id_e, file_name, file_type)
values (14, 'H.wav', 1);
insert into file(id_e, file_name, file_type)
values (15, 'I.wav', 1);
insert into file(id_e, file_name, file_type)
values (16, 'J.wav', 1);
insert into file(id_e, file_name, file_type)
values (17, 'K.wav', 1);
insert into file(id_e, file_name, file_type)
values (18, 'L.wav', 1);
insert into file(id_e, file_name, file_type)
values (19, 'M.wav', 1);
insert into file(id_e, file_name, file_type)
values (20, 'N.wav', 1);
insert into file(id_e, file_name, file_type)
values (21, 'O.wav', 1);
insert into file(id_e, file_name, file_type)
values (22, 'P.wav', 1);
insert into file(id_e, file_name, file_type)
values (23, 'Q.wav', 1);
insert into file(id_e, file_name, file_type)
values (24, 'R.wav', 1);
insert into file(id_e, file_name, file_type)
values (25, 'S.wav', 1);
insert into file(id_e, file_name, file_type)
values (26, 'T.wav', 1);
insert into file(id_e, file_name, file_type)
values (27, 'U.wav', 1);
insert into file(id_e, file_name, file_type)
values (28, 'V.wav', 1);
insert into file(id_e, file_name, file_type)
values (29, 'W.wav', 1);
insert into file(id_e, file_name, file_type)
values (30, 'X.wav', 1);
insert into file(id_e, file_name, file_type)
values (31, 'Y.wav', 1);
insert into file(id_e, file_name, file_type)
values (32, 'Z.wav', 1);

# ---- Calculation ----

#Calculation category
insert into category (category_name, description)
VALUES ('calculation', 'pictures for calculation');

#Calculation storage
insert into storage (id_c, name, description)
values (3, 'number-1', 'number-1');
insert into storage (id_c, name, description)
values (3, 'number-2', 'number-2');
insert into storage (id_c, name, description)
values (3, 'number-3', 'number-3');
insert into storage (id_c, name, description)
values (3, 'number-4', 'number-4');
insert into storage (id_c, name, description)
values (3, 'number-5', 'number-5');
insert into storage (id_c, name, description)
values (3, 'number-6', 'number-6');
insert into storage (id_c, name, description)
values (3, 'number-7', 'number-7');
insert into storage (id_c, name, description)
values (3, 'number-8', 'number-8');
insert into storage (id_c, name, description)
values (3, 'number-9', 'number-9');
insert into storage (id_c, name, description)
values (3, 'number-0', 'number-0');
insert into storage (id_c, name, description)
values (3, 'plus-sign', 'plus-sign');
insert into storage (id_c, name, description)
values (3, 'minus-sign', 'minus-sign');
insert into storage (id_c, name, description)
values (3, 'equal-sign', 'equal-sign');

#Calculation file
insert into file (id_e, file_name, file_type)
values (33, 'bright-1.png', 0);
insert into file (id_e, file_name, file_type)
values (34, 'bright-2.png', 0);
insert into file (id_e, file_name, file_type)
values (35, 'bright-3.png', 0);
insert into file (id_e, file_name, file_type)
values (36, 'bright-4.png', 0);
insert into file (id_e, file_name, file_type)
values (37, 'bright-5.png', 0);
insert into file (id_e, file_name, file_type)
values (38, 'bright-6.png', 0);
insert into file (id_e, file_name, file_type)
values (39, 'bright-7.png', 0);
insert into file (id_e, file_name, file_type)
values (40, 'bright-8.png', 0);
insert into file (id_e, file_name, file_type)
values (41, 'bright-9.png', 0);
insert into file (id_e, file_name, file_type)
values (42, 'bright-0.png', 0);
insert into file (id_e, file_name, file_type)
values (43, 'bright-plus.png', 0);
insert into file (id_e, file_name, file_type)
values (44, 'bright-minus.png', 0);
insert into file (id_e, file_name, file_type)
values (45, 'bright-equal.png', 0);
#homepage category
insert into category(category_name, description)
values('homepage','pics for homepage use');

#homepage storage
insert into storage(id_c, name, description)
values ('4', 'abc', 'homepage pic for abc');
insert into storage(id_c, name, description)
values ('4', 'calculation', 'homepage pic for calculation');
insert into storage(id_c, name, description)
values ('4', 'vegetables', 'homepage pic for vegetables');
insert into storage(id_c, name, description)
values ('4', 'vehicles', 'homepage pic for vehicles');

#homepage file
insert into file(id_e, file_name, file_type)
values ('46', 'ABC.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('47', 'CALCULATION.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('48', 'VEGETABLES.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('49', 'VEHICLES.jpg', '0');

# ---- vegetables ----

#vegetables category
insert into category(category_name, description)
values('vegetables','pics for vegetables');

#vegetables storage
insert into storage(id_c, name, description)
values ('5', 'carrot', 'pic for carrot');
insert into storage(id_c, name, description)
values ('5', 'corn', 'pic for corn');
insert into storage(id_c, name, description)
values ('5', 'cucumber', 'pic for cucumber');
insert into storage(id_c, name, description)
values ('5', 'eggplant', 'pic for ggplant');
insert into storage(id_c, name, description)
values ('5', 'green-onion', 'pic for green-onion');
insert into storage(id_c, name, description)
values ('5', 'lettuce', 'pic for lettuce');

#vegetables file
insert into file(id_e, file_name, file_type)
values ('50', 'carrot.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('51', 'corn.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('52', 'cucumber.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('53', 'eggplant.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('54', 'green-onion.jpg', '0');
insert into file(id_e, file_name, file_type)
values ('55', 'lettuce.jpg', '0');