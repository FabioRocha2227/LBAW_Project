DROP SCHEMA IF EXISTS lbaw2273 CASCADE;
CREATE SCHEMA lbaw2273;

SET search_path TO lbaw2273;

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
drop table if exists messages;


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
  isAdmin INTEGER DEFAULT 0,
  isPublic SERIAL,
  remember_token VARCHAR(256)
);

CREATE TABLE banned(
  id SERIAL PRIMARY KEY,
  id_user INTEGER NOT NULL
);

ALTER TABLE users ALTER COLUMN isAdmin SET DEFAULT 0; 
ALTER TABLE users ADD COLUMN active INTEGER DEFAULT 1; 
ALTER TABLE users ADD COLUMN password_reset_token VARCHAR(60) NULL;

create table Groups(
  id_groups serial PRIMARY KEY,
  group_description text,
  group_name text,
  group_state integer NOT NULL,
  group_date date NOT NULL,
  id_owner integer NOT NULL
);

create table group_user(
  id SERIAL PRIMARY KEY,
  id_group integer REFERENCES Groups(id_groups),
  id_user integer REFERENCES Users(id)
);

create table Post(
  id serial PRIMARY KEY,
  id_user INTEGER ,
  post_state integer NOT NULL,
  content text,
  post_date date NOT NULL,
  isPublic INTEGER,
  id_groups integer REFERENCES Groups(id_groups)
);

create table Images(
  id_images serial PRIMARY KEY,
  path text NOT NULL,
  image_state integer NOT NULL
);

create table Comment(
  id_comment serial PRIMARY KEY,
  comment_state integer DEFAULT 0,
  content text NOT NULL,
  comment_date date NOT NULL,
  id_user integer REFERENCES users(id),
  id_post integer REFERENCES Post(id)
);


/*type=1 -> COMMENT
  type=2 -> LIKE
  type=3 -> Friend request
*/
create table Notifications(
  id_notifications serial PRIMARY KEY,
  notification_type integer NOT NULL,
  notification_date date NOT NULL,
  user_to integer NOT NULL,
  user_from integer NOT NULL,
  id_post integer 
);

create table React_Post(
  id_react_post serial PRIMARY KEY,
  user_id integer,
  react_post_date date NOT NULL,
  id_post integer REFERENCES Post(id),
  user_to integer 
);

create table react_comment(
  id_react_comment serial PRIMARY KEY,
  user_id integer,
  react_comment_date date NOT NULL,
  id_comment integer REFERENCES Post(id),
  user_to integer 
);

create table post_images(
  id_post serial REFERENCES Post(id),
  id_images serial REFERENCES Images(id_images),
  PRIMARY KEY(id_post, id_images)
);

create table comment_images(
  id_comment serial REFERENCES Comment(id_comment),
  id_images serial REFERENCES Images(id_images),
  PRIMARY KEY(id_comment, id_images)
);

create table friend (
    user_from serial REFERENCES users(id) ON DELETE CASCADE,
    user_to serial REFERENCES users(id) ON DELETE CASCADE,
    PRIMARY KEY(user_from, user_to),
    CONSTRAINT check_friend_request CHECK (user_from != user_to)
);

create table friend_request (
    id serial PRIMARY KEY,
    user_from INTEGER,
    user_to INTEGER,
    accepted INTEGER DEFAULT 0,
    requested INTEGER DEFAULT 0,
    refused INTEGER DEFAULT 0,
    CONSTRAINT fr CHECK (user_from != user_to)
);

create table user_groups_images(
  id serial REFERENCES users(id),
  id_groups serial REFERENCES Groups(id_groups),
  id_images serial REFERENCES Images(id_images),
  PRIMARY KEY(id, id_groups, id_images)
);

create table messages(
  id integer PRIMARY KEY,
  content text NOT NULL,
  sender serial REFERENCES users(id),
  msg_date date NOT NULL
);
ALTER TABLE users ADD COLUMN search tsvector;

CREATE TRIGGER users_search_update
  BEFORE INSERT OR UPDATE ON users
  FOR EACH ROW EXECUTE PROCEDURE
  tsvector_update_trigger(search, 'pg_catalog.english', username, email, full_name);

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
  1
); -- Password is 1234. Generated using Hash::make('1234')
INSERT INTO users VALUES (
  DEFAULT,
  'rafa',
  'rafa@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Rafael'
);
INSERT INTO users VALUES (
  DEFAULT,
  'ze',
  'ze@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Jose'
);
INSERT INTO users VALUES (
  DEFAULT,
  'fabio',
  'fabio@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Fabio'
);
INSERT INTO users VALUES (
  DEFAULT,
  'jonny',
  'jonny@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Jonny',
  '910000001',
  '2001-09-08',
  'porto',
  'casado',
  'M',
  0,
  0
);
INSERT INTO users VALUES (
  DEFAULT,
  'marta',
  'marta@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Marta',
  '910000002',
  '2001-09-08',
  'porto',
  'casado',
  'F',
  0,
  0
);

INSERT INTO users VALUES (
  DEFAULT,
  'Aniball',
  'anibal@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Anibal',
  '910120000',
  '2001-09-08',
  'porto',
  'casado',
  'M',
  0,
  0
);
INSERT INTO users VALUES (
  DEFAULT,
  'mati',
  'mati@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Matilde',
  '916690000',
  '2001-09-08',
  'porto',
  'casado',
  'F',
  0,
  0
);
INSERT INTO users VALUES (
  DEFAULT,
  'Rui',
  'rui@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Rui',
  '910000400',
  '2001-09-08',
  'porto',
  'solteiro',
  'M',
  0,
  0
);
INSERT INTO users VALUES (
  DEFAULT,
  'vasquinho',
  'vasco@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Vasco',
  '915600000',
  '2001-09-08',
  'Lisboa',
  'solteiro',
  'M',
  0,
  0
);

INSERT INTO users VALUES (
  DEFAULT,
  'guest',
  'guest@gmail.com',
   '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
);
INSERT INTO users VALUES (
  DEFAULT,
  'ze',
  'z.m.f.carvalho@gmail.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  'Jose Miguel Ferreira Carvalho',
  '938130981',
  '2001-09-20',
  'porto',
  'solteiro',
  'M',
  1,
  1
);


INSERT INTO Groups (id_groups,group_description,group_name,group_state,group_date,id_owner) VALUES(0,'Public Group','aaa',0,'2022-01-10',2);
INSERT INTO Groups (id_groups,group_description,group_name,group_state,group_date,id_owner) VALUES(1,'Gaming group','aaa',0,'2022-01-10',2);
INSERT INTO Groups (id_groups,group_description,group_name,group_state,group_date,id_owner) VALUES(2,'study group','aaa',0,'2022-01-11',2);
INSERT INTO Groups (id_groups,group_description,group_name,group_state,group_date,id_owner) VALUES(3,'soccer group','aaa',0,'2022-01-11',2);
INSERT INTO Groups (id_groups,group_description,group_name,group_state,group_date,id_owner) VALUES(4,'movie group','aaa',0,'2022-01-11',2);
INSERT INTO Groups (id_groups,group_description,group_name,group_state,group_date,id_owner) VALUES(5,'investing group','aaa',0,'2022-01-11',2);

/* gaming group*/
INSERT INTO group_user(id,id_group,id_user) VALUES (1,1,2);
INSERT INTO group_user(id,id_group,id_user) VALUES (2,1,3);
INSERT INTO group_user(id,id_group,id_user) VALUES (3,1,4);

/* study group*/
INSERT INTO group_user(id,id_group,id_user) VALUES (4,2,1);
INSERT INTO group_user(id,id_group,id_user) VALUES (5,2,2);
INSERT INTO group_user(id,id_group,id_user) VALUES (6,2,3);
INSERT INTO group_user(id,id_group,id_user) VALUES (7,2,4);
INSERT INTO group_user(id,id_group,id_user) VALUES (8,2,5);

/* investing group*/
INSERT INTO group_user(id,id_group,id_user) VALUES (9,5,2);
INSERT INTO group_user(id,id_group,id_user) VALUES (10,5,7);
INSERT INTO group_user(id,id_group,id_user) VALUES (11,5,6);

INSERT INTO banned (id,id_user) VALUES (1,2);

INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (1,2,0,'O tomé é useless ;)','2022-05-01',1,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (2,2,0,'Heath Ledger was the best joker ever, top level acting in the movie.','2022-05-01',1,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (3,1,0,'I destroyed my phone by charging and playing games at the same time. You really shouldnt use your device while it is being charged','2022-05-01',1,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (4,1,0,'I love at some point how the internet community has changed, I love this new trend with memes, I love sarcasm and funny jokes.','2022-05-01',1,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (5,3,0,'I can’t wait for new Cyber Punk, did you know that it was card game 30 years ago?','2022-05-01',0,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (6,3,0,'It is very important to have nice people at your work, otherwise life would be very hard.','2022-05-01',1,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (7,4,0,'Gamers are awesome, they are friendly, they are positive, but only when you will meet them in real life, in cyberspace things are a LITTLE bit different :D','2022-05-01',0,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (8,5,0,'I like to write different scripts from time to time, simple scripts that can resolve PC related issues.','2022-05-01',0,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (9,6,0,'Must be really hard to learn as much as you know, how much time did it cost you?', '2022-05-01',0,0);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (10,2,0,'Gaming group is the best!','2022-05-01',1,1);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (11,3,0,'My name is ze and I love the gaming group','2022-05-01',1,1);
INSERT INTO Post (id,id_user,post_state,content,post_date,isPublic,id_groups) VALUES (12,4,0,'I dont game but Im here','2022-05-01',1,1);




INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (1,0,'I agree. Tome is useless.','2022-05-10',3,1);
INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (2,0,'Heath Ledger is the best xD.','2022-05-10',1,2);
INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (3,0,'I will not play Cyberpunk because i only play tetris!','2022-05-10',4,5);
INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (4,0,'Learning takes will and I have none :(','2022-05-10',4,9);
INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (5,0,'I am a gamer and I can confirm this is true.','2022-05-10',6,7);
INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (6,0,'I agree too!','2022-05-10',4,1);
INSERT INTO Comment (id_comment,comment_state,content,comment_date,id_user,id_post) VALUES (7,0,'I 100% agree!!!!!','2022-05-10',5,1);
 
/*
INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (1,1,'2022-05-10',1);
INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (2,1,'2022-05-10',2);
INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (3,2,'2022-05-10',1);
INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (4,2,'2022-05-10',3);
INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (5,1,'2022-05-10',1);

INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (1,1,'2022-05-10',1);
INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (2,1,'2022-05-10',2);
INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (3,1,'2022-05-10',3);
INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (4,1,'2022-05-10',4);
INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (5,1,'2022-05-10',1);
*/
INSERT INTO friend (user_from,user_to) VALUES (3,4);
INSERT INTO friend (user_from,user_to) VALUES (3,2);
INSERT INTO friend (user_from,user_to) VALUES (3,5);
INSERT INTO friend (user_from,user_to) VALUES (5,2);
INSERT INTO friend (user_from,user_to) VALUES (1,2);
INSERT INTO friend (user_from,user_to) VALUES (2,4);
INSERT INTO friend (user_from,user_to) VALUES (6,4);


INSERT INTO Images(id_images,path,image_state) VALUES (1,'xscacs',1);
INSERT INTO Images(id_images,path,image_state) VALUES (2,'xscavv',1);
INSERT INTO Images(id_images,path,image_state) VALUES (3,'xscfff',1);
INSERT INTO Images(id_images,path,image_state) VALUES (4,'xsctty',1);
INSERT INTO Images(id_images,path,image_state) VALUES (5,'xsctts',1);
/*
INSERT INTO post_images (id_post,id_images) VALUES (1,1);
INSERT INTO post_images (id_post,id_images) VALUES (1,2);
INSERT INTO post_images (id_post,id_images) VALUES (2,1);
INSERT INTO post_images (id_post,id_images) VALUES (3,1);
INSERT INTO post_images (id_post,id_images) VALUES (4,1);

INSERT INTO comment_images (id_comment,id_images) VALUES (1,2);
INSERT INTO comment_images (id_comment,id_images) VALUES (2,1);
INSERT INTO comment_images (id_comment,id_images) VALUES (3,4);
INSERT INTO comment_images (id_comment,id_images) VALUES (4,2);
INSERT INTO comment_images (id_comment,id_images) VALUES (5,3);

INSERT INTO user_groups_images(id,id_groups,id_images) VALUES (1,1,1);
INSERT INTO user_groups_images(id,id_groups,id_images) VALUES (3,2,1);
INSERT INTO user_groups_images(id,id_groups,id_images) VALUES (2,1,3);
INSERT INTO user_groups_images(id,id_groups,id_images) VALUES (1,3,1);
INSERT INTO user_groups_images(id,id_groups,id_images) VALUES (4,3,2);
*/
