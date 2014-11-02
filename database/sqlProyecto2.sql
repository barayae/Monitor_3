create table Levels(
	idLvl int not null, 
	nameLvl varchar(45) not null, 
		constraint pkLvl primary key(idLvl)
);
create table Privs(
	idPriv int not null, 
	namePriv varchar(15) not null,
		constraint pkPrivs primary key(idPriv)
);
create table Lvl_Priv(
	idLvl int not null, 
	idPriv int not null,
	nameTab varchar(30) not null, 
		constraint pkRLvl_Priv primary key(idLvl, idPriv, nameTab),
		constraint fk1RLvl_Priv foreign key(idLvl) references Levels(idLvl),
		constraint fk2RLvl_Priv foreign key(idPriv) references Privs(idPriv)
);

CREATE SEQUENCE seq_Lvl
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER trigger_lvl
BEFORE INSERT
ON Levels
REFERENCING NEW AS NEW
FOR EACH ROW
BEGIN
SELECT seq_Lvl.nextval INTO :NEW.idLvl FROM dual;
END;
/

insert into Levels values(1,'L1');
insert into Privs values(1,'UPDATE');
insert into Privs values(2,'DELETE');
insert into Privs values(3,'INSERT');
insert into Lvl_Priv values(1, 1, 'T1');	

select  l.idLvl, p.nameLvl    
from Lvl_Priv l, Levels p
where l.idLvl=1;

select l.idLvl, p.namePriv
from Lvl_Priv l, Levels p
where l.idLvl=1;





select  l.idLvl, p.nameLvl  from Lvl_Priv l, Levels p where p.nameLvl ='l1';

select l.nameLvl , p.nameLvl from Lvl_Priv l, Levels p where p.namelvl ='L1' and l.nameLvl = 'insert';


select l.idlvl from Lvl_Priv l, Levels p where p.namelvl ='L1';

select l.idpriv from Lvl_Priv l, privs p where p.idpriv = 1;

select  p.nameLvl  from Lvl_Priv l, Levels p where p.nameLvl ='L1';

select  p.namepriv  from Lvl_Priv l, privs p where l.idLvl = 1;

select  nametab  from lvl_priv where idLvl = 1;



