drop table if exists users;
drop table if exists Groups;
drop table if exists Post;
drop table if exists Images;
drop table if exists Comment;
drop table if exists React_comment;
drop table if exists Notifications;
drop table if exists React_Post;
drop table if exists friend;
drop table if exists post_images;
drop table if exists comment_images;
drop table if exists user_groups_images;


CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(256) NOT NULL,
  email VARCHAR(256) UNIQUE NOT NULL,
  password VARCHAR(256) NOT NULL,
  full_name VARCHAR(256),
  phone VARCHAR(9) UNIQUE,
  birthdate date,
  address text,
  civil_state text,
  gender char,
  isAdmin DEFAULT 0,
  remember_token VARCHAR(256)
);


create table Groups(
  id_groups serial PRIMARY KEY,
  group_description text,
  group_state integer NOT NULL,
  group_name text  NOT NULL,
  group_date date NOT NULL
);

create table Post(
  id_post serial PRIMARY KEY,
  post_state integer NOT NULL,
  id_user integer REFERENCES UserD(id_user),
  post_date date NOT NULL,
  id_groups integer REFERENCES Groups(id_groups)
);

create table Images(
  id_images serial PRIMARY KEY,
  path text NOT NULL,
  image_state integer NOT NULL
);

create table Comment(
  id_comment serial PRIMARY KEY,
  comment_state integer NOT NULL,
  comment_date date NOT NULL,
  id_user integer REFERENCES UserD(id_user),
  id_post integer REFERENCES Post(id_post)
);

create table React_comment(
  id_react_comment serial PRIMARY KEY,
  type integer NOT NULL,
  react_comment_date date NOT NULL,
  id_comment integer REFERENCES Comment(id_comment)
);

create table Notifications(
  id_notifications serial PRIMARY KEY,
  code text NOT NULL,
  not_date date NOT NULL 
);

create table React_Post(
  id_react_post serial PRIMARY KEY,
  type integer NOT NULL,
  react_post_date date NOT NULL,
  id_post integer REFERENCES Post(id_post)
);

create table post_images(
  id_post serial REFERENCES Post(id_post),
  id_images serial REFERENCES Images(id_images),
  PRIMARY KEY(id_post, id_images)
);

create table comment_images(
  id_comment serial REFERENCES Comment(id_comment),
  id_images serial REFERENCES Images(id_images),
  PRIMARY KEY(id_comment, id_images)
);

CREATE TABLE friend (
    user_from serial REFERENCES UserD(id_user) ON DELETE CASCADE,
    user_to serial REFERENCES UserD(id_user) ON DELETE CASCADE,
    PRIMARY KEY(user_from, user_to),
    CONSTRAINT check_friend_request CHECK (user_from != user_to)
);
create table user_groups_images(
  id_user serial REFERENCES UserD(id_user),
  id_groups serial REFERENCES Groups(id_groups),
  id_images serial REFERENCES Images(id_images),
  PRIMARY KEY(id_user, id_groups, id_images)
);

INSERT INTO users VALUES (
  DEFAULT,
  'jonh_doe',
  'admin@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Jonh Doe',
  '910000000',
  '2001-09-08',
  'porto',
  'casado',
  'M',
  1,
); -- Password is 1234. Generated using Hash::make('1234')
INSERT INTO users VALUES (
  DEFAULT,
  'rafa',
  'rafa@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
);
INSERT INTO users VALUES (
  DEFAULT,
  'ze',
  'ze@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
);

INSERT INTO users VALUES (
  DEFAULT,
  'fabio',
  'fabio@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
);

INSERT INTO Groups (id_groups,group_description,group_state,group_name,group_date) VALUES(1,'Gaming group',0,'asdasd','2022-01-10');

INSERT INTO Post (id_post,post_state,id_user,post_date,id_groups) VALUES (1,0,3,'2022-05-01',1);

INSERT INTO Comment (id_comment,comment_state,comment_date,id_user,id_post) VALUES (1,1,'2022-05-10',3,1);

INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (1,1,'2022-05-10',1);

INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (1,1,'2022-05-10',1);

INSERT INTO friend (user_from,user_to) VALUES (3,4);