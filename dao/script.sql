create table admin
(
    id        int auto_increment
        primary key,
    user_name varchar(15) null,
    password  varchar(15) null,
    constraint user
        unique (user_name)
);

create table category
(
    id_c          tinyint auto_increment
        primary key,
    category_name varchar(50)               null,
    description   varchar(250) charset utf8 null
);

create table storage
(
    id_e        int auto_increment
        primary key,
    id_c        tinyint                   null,
    name        varchar(50)               null,
    description varchar(250) charset utf8 null,
    constraint FK_STORAGE_CATEGORY
        foreign key (id_c) references category (id_c)
);

create table file
(
    id_f      int auto_increment
        primary key,
    id_e      int         null,
    file_name varchar(50) null,
    file_type tinyint(1)  null,
    constraint FK_FILE_STORAGE
        foreign key (id_e) references storage (id_e)
);


