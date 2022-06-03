#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: salle
#------------------------------------------------------------

CREATE TABLE salle(
        id_salle    Int  Auto_increment  NOT NULL ,
        titre       Varchar (200) NOT NULL ,
        description Text NOT NULL ,
        photo       Varchar (200) NOT NULL ,
        pays        Varchar (20) NOT NULL ,
        ville       Varchar (20) NOT NULL ,
        adresse     Varchar (50) NOT NULL ,
        cp          Int NOT NULL ,
        capacite    Int NOT NULL ,
        categorie   enum('rénunion','bureau','formation') NOT NULL
	,CONSTRAINT salle_PK PRIMARY KEY (id_salle)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: produit
#------------------------------------------------------------

CREATE TABLE produit(
        id_produit   Int  Auto_increment  NOT NULL ,
        date_arrivee Datetime NOT NULL ,
        date_depart  Datetime NOT NULL ,
        prix         Int NOT NULL ,
        etat         enum('libre', 'reservation') NOT NULL ,
        id_salle     Int NOT NULL
	,CONSTRAINT produit_PK PRIMARY KEY (id_produit)

	,CONSTRAINT produit_salle_FK FOREIGN KEY (id_salle) REFERENCES salle(id_salle)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: membre
#------------------------------------------------------------

CREATE TABLE membre(
        id_membre           Int  Auto_increment  NOT NULL ,
        pseudo              Varchar (20) NOT NULL ,
        mdp                 Varchar (60) NOT NULL ,
        nom                 Varchar (20) NOT NULL ,
        prenom              Varchar (20) NOT NULL ,
        email               Varchar (50) NOT NULL ,
        civilite            enum('m','f') NOT NULL ,
        statut              Int NOT NULL ,
        date_enregistrement Datetime NOT NULL
	,CONSTRAINT membre_PK PRIMARY KEY (id_membre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: commande
#------------------------------------------------------------

CREATE TABLE commande(
        id_commande         Int  Auto_increment  NOT NULL ,
        id_membre           Int ,
        id_produit          Int NOT NULL ,
        prix                Int NOT NULL ,
        date_enregistrement Datetime NOT NULL
	,CONSTRAINT commande_PK PRIMARY KEY (id_commande)

	,CONSTRAINT commande_membre_FK FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
	,CONSTRAINT commande_produit0_FK FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: avis
#------------------------------------------------------------

CREATE TABLE avis(
        id_avis             Int  Auto_increment  NOT NULL ,
        commentaire         Text NOT NULL ,
        note                Int NOT NULL ,
        date_enregistrement Datetime NOT NULL ,
        id_salle            Int ,
        id_membre           Int NOT NULL
	,CONSTRAINT avis_PK PRIMARY KEY (id_avis)

	,CONSTRAINT avis_salle_FK FOREIGN KEY (id_salle) REFERENCES salle(id_salle)
	,CONSTRAINT avis_membre0_FK FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
	,CONSTRAINT avis_membre_AK UNIQUE (id_membre)
)ENGINE=InnoDB;

