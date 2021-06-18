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
    active tinyint(1)  not null,
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
    active tinyint(1)  not null,
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
    active tinyint(1)  not null,
    constraint file_name
        unique (file_name),
    constraint FK_file_storage
        foreign key (id_e) references storage (id_e)
);

# -----Vehicles-----

#Vehicle category
insert into category (category_name, description, active)
values ('vehicle', 'pictures for vehicles', 1);

# Vehicle storage
insert into storage (id_c, name, description, active)
values (1, 'airplane', 'airplane', 1);
insert into storage (id_c, name, description, active)
values (1, 'bike', 'bike', 1);
insert into storage (id_c, name, description, active)
values (1, 'car', 'car', 1);
insert into storage (id_c, name, description, active)
values (1, 'scooter', 'scooter', 1);
insert into storage (id_c, name, description, active)
values (1, 'train', 'train', 1);
insert into storage (id_c, name, description, active)
values (1, 'truck', 'truck', 1);

# Vehicle file
insert into file (id_e, file_name, file_type, active)
values (1, 'airplane.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (2, 'bike.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (3, 'car.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (4, 'scooter.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (5, 'train.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (6, 'truck.png', 0, 1);



# ---ABC---

#ABC category
insert into category(category_name, description, active)
values ('abc', 'sound and pic of alphabet', 1);

# ABC storage
insert into storage(id_c, name, description, active)
values (2, 'A.png', 'sound of A', 1);
insert into storage(id_c, name, description, active)
values (2, 'B.png', 'sound of B', 1);
insert into storage(id_c, name, description, active)
values (2, 'C.png', 'sound of C', 1);
insert into storage(id_c, name, description, active)
values (2, 'D.png', 'sound of D', 1);
insert into storage(id_c, name, description, active)
values (2, 'E.png', 'sound of E', 1);
insert into storage(id_c, name, description, active)
values (2, 'F.png', 'sound of F', 1);
insert into storage(id_c, name, description, active)
values (2, 'G.png', 'sound of G', 1);
insert into storage(id_c, name, description, active)
values (2, 'H.png', 'sound of H', 1);
insert into storage(id_c, name, description, active)
values (2, 'I.png', 'sound of I', 1);
insert into storage(id_c, name, description, active)
values (2, 'J.png', 'sound of J', 1);
insert into storage(id_c, name, description, active)
values (2, 'K.png', 'sound of K', 1);
insert into storage(id_c, name, description, active)
values (2, 'L.png', 'sound of L', 1);
insert into storage(id_c, name, description, active)
values (2, 'M.png', 'sound of M', 1);
insert into storage(id_c, name, description, active)
values (2, 'N.png', 'sound of N', 1);
insert into storage(id_c, name, description, active)
values (2, 'O.png', 'sound of O', 1);
insert into storage(id_c, name, description, active)
values (2, 'P.png', 'sound of P', 1);
insert into storage(id_c, name, description, active)
values (2, 'Q.png', 'sound of Q', 1);
insert into storage(id_c, name, description, active)
values (2, 'R.png', 'sound of R', 1);
insert into storage(id_c, name, description, active)
values (2, 'S.png', 'sound of S', 1);
insert into storage(id_c, name, description, active)
values (2, 'T.png', 'sound of T', 1);
insert into storage(id_c, name, description, active)
values (2, 'U.png', 'sound of U', 1);
insert into storage(id_c, name, description, active)
values (2, 'V.png', 'sound of V', 1);
insert into storage(id_c, name, description, active)
values (2, 'W.png', 'sound of W', 1);
insert into storage(id_c, name, description, active)
values (2, 'X.png', 'sound of X', 1);
insert into storage(id_c, name, description, active)
values (2, 'Y.png', 'sound of Y', 1);
insert into storage(id_c, name, description, active)
values (2, 'Z.png', 'sound of Z', 1);

# ABC file
insert into file(id_e, file_name, file_type, active)
values (7, 'A.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (8, 'B.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (9, 'C.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (10, 'D.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (11, 'E.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (12, 'F.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (13, 'G.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (14, 'H.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (15, 'I.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (16, 'J.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (17, 'K.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (18, 'L.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (19, 'M.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (20, 'N.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (21, 'O.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (22, 'P.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (23, 'Q.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (24, 'R.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (25, 'S.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (26, 'T.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (27, 'U.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (28, 'V.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (29, 'W.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (30, 'X.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (31, 'Y.wav', 1, 1);
insert into file(id_e, file_name, file_type, active)
values (32, 'Z.wav', 1, 1);

# ---- Calculation ----

#Calculation category
insert into category (category_name, description, active)
VALUES ('calculation', 'pictures for calculation', 1);

#Calculation storage
insert into storage (id_c, name, description, active)
values (3, 'number-1', 'number-1', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-2', 'number-2', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-3', 'number-3', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-4', 'number-4', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-5', 'number-5', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-6', 'number-6', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-7', 'number-7', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-8', 'number-8', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-9', 'number-9', 1);
insert into storage (id_c, name, description, active)
values (3, 'number-0', 'number-0', 1);
insert into storage (id_c, name, description, active)
values (3, 'plus-sign', 'plus-sign', 1);
insert into storage (id_c, name, description, active)
values (3, 'minus-sign', 'minus-sign', 1);
insert into storage (id_c, name, description, active)
values (3, 'equal-sign', 'equal-sign', 1);

#Calculation file
insert into file (id_e, file_name, file_type, active)
values (33, 'bright-1.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (34, 'bright-2.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (35, 'bright-3.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (36, 'bright-4.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (37, 'bright-5.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (38, 'bright-6.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (39, 'bright-7.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (40, 'bright-8.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (41, 'bright-9.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (42, 'bright-0.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (43, 'bright-plus.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (44, 'bright-minus.png', 0, 1);
insert into file (id_e, file_name, file_type, active)
values (45, 'bright-equal.png', 0, 1);
#homepage category
insert into category(category_name, description, active)
values('homepage','pics for homepage use', 1);

#homepage storage
insert into storage(id_c, name, description, active)
values ('4', 'abc', 'homepage pic for abc', 1);
insert into storage(id_c, name, description, active)
values ('4', 'calculation', 'homepage pic for calculation', 1);
insert into storage(id_c, name, description, active)
values ('4', 'vegetables', 'homepage pic for vegetables', 1);
insert into storage(id_c, name, description, active)
values ('4', 'vehicles', 'homepage pic for vehicles', 1);

#homepage file
insert into file(id_e, file_name, file_type, active)
values ('46', 'ABC.jpg', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('47', 'CALCULATION.jpg', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('48', 'VEGETABLES.jpg', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('49', 'VEHICLES.jpg', '0', 1);

# ---- vegetables ----

#vegetables category
insert into category(category_name, description, active)
values('vegetables','pics for vegetables', 1);

#vegetables storage
insert into storage(id_c, name, description, active)
values ('5', 'carrot', 'pic for carrot', 1);
insert into storage(id_c, name, description, active)
values ('5', 'corn', 'pic for corn', 1);
insert into storage(id_c, name, description, active)
values ('5', 'cucumber', 'pic for cucumber', 1);
insert into storage(id_c, name, description, active)
values ('5', 'eggplant', 'pic for ggplant', 1);
insert into storage(id_c, name, description, active)
values ('5', 'green-onion', 'pic for green-onion', 1);
insert into storage(id_c, name, description, active)
values ('5', 'lettuce', 'pic for lettuce', 1);

#vegetables file
insert into file(id_e, file_name, file_type, active)
values ('50', 'carrot.png', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('51', 'corn.png', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('52', 'cucumber.png', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('53', 'eggplant.png', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('54', 'green-onion.png', '0', 1);
insert into file(id_e, file_name, file_type, active)
values ('55', 'lettuce.png', '0', 1);