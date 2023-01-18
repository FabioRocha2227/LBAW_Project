INSERT INTO UserD (id_user,username) VALUES (1,'admin01');
INSERT INTO UserD (id_user,username) VALUES (2,'guest01');
INSERT INTO UserD (id_user,username) VALUES (3,'joao_pinto123');
INSERT INTO UserD (id_user,username) VALUES (4,'mariaCampos92');
INSERT INTO UserD (id_user,username) VALUES (5,'antonio_Sousa44');

INSERT INTO Administrator (id_user, full_name,password,email) VALUES (1,'Carlos Pinto','admin123','admin123@gmail.com');

INSERT INTO Authenticated_user (id_user,full_name,password,email,phone,address,civil_state,gender)  VALUES(3,'Joao Pinto','5215827780863615','joaopinto123@gmail.com',912309846,'1977-04-16','single','Male');
INSERT INTO Authenticated_user (id_user,full_name,password,email,phone,address,civil_state,gender)  VALUES(4,'Maria Campos','5215827780863613','mariaCampos153@gmail.com',938920367,'2000-06-20','single','Female');
INSERT INTO Authenticated_user (id_user,full_name,password,email,phone,address,civil_state,gender)  VALUES(5,'Antonio Sousa','521582778086382','sousaAntonio44@gmail.com',919218745,'1980-04-03','single','Male');

INSERT INTO Gest_user(id_user) VALUES (2);

INSERT INTO Groups (id_groups,group_description,group_state,group_name,group_date) VALUES(1,'Gaming group',0,'asdasd','2022-01-10');

INSERT INTO Post (id_post,post_state,id_user,post_date,id_groups) VALUES (1,0,3,'2022-05-01',1);

INSERT INTO Comment (id_comment,comment_state,comment_date,id_user,id_post) VALUES (1,1,'2022-05-10',3,1);

INSERT INTO React_comment (id_react_comment,type,react_comment_date,id_comment) VALUES (1,1,'2022-05-10',1);

INSERT INTO React_Post(id_react_post,type,react_post_date,id_post) VALUES (1,1,'2022-05-10',1);

INSERT INTO friend (user_from,user_to) VALUES (3,4);
