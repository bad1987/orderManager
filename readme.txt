mise a jour de l'application

1) mise a jour de la base de donnees
	creer une nouvelle colonne dans la table users

		"alter table users 
		add column isAdmin TINYINT(1) DEFAULT 0"

2) faire passer un compte en compte utilisateur

	"update users set isAdmin = 1 where username = 'targeted username'"

3) check database credentials

4) create a new table
CREATE TABLE IF NOT EXISTS `orderManager`.`categorie` (
  `cat_id` INT NOT NULL,
  `cat_Ref` VARCHAR(45) NULL,
  `cat_Design` VARCHAR(45) NULL,
  PRIMARY KEY (`cat_id`))
ENGINE = InnoDB;

alter table users 
add column cat_Ref varchar(45) DEFAULT 'CLI'

insert into categorie(cat_id,cat_Ref,cat_Design)
values(null,'CLI','CLIENT');
insert into categorie(cat_id,cat_Ref,cat_Design)
values(null,'COM','COMMERCIAL');
insert into categorie(cat_id,cat_Ref,cat_Design)
values(null,'ADM','ADMINISTRATOR');


#les modifications a partir du 22/02/19
ajouter la colonne prix article dans la table de selection du client
fichiers modifiers:commande.js,dashboard.php

//nouvelle table client
CREATE TABLE IF NOT EXISTS `orderManager`.`clients` (
  `client_id` INT NOT NULL AUTO_INCREMENT,
  `CL_Ref` VARCHAR(45) NULL,
  `CL_Intitule` VARCHAR(191) NULL,
  PRIMARY KEY (`client_id`))
ENGINE = InnoDB;