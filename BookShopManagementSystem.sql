/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2017/5/15 19:57:00                           */
/*==============================================================*/


drop trigger if exists purchaseTrigger;

drop trigger if exists StockTrigger;

drop procedure if exists purchaseProc;

drop table if exists Author;

drop table if exists Books;

drop table if exists Customer;

drop table if exists Employees;

drop table if exists Focus;

drop table if exists Press;

drop table if exists Purchase;

drop table if exists Shops;

drop table if exists StockIn;

drop table if exists Storage;

/*==============================================================*/
/* Table: Author                                                */
/*==============================================================*/
create table Author
(
   IDcardnumber         varchar(16) not null,
   authorname           varchar(16),
   primary key (IDcardnumber)
);

/*==============================================================*/
/* Table: Books                                                 */
/*==============================================================*/
create table Books
(
   ISBN                 varchar(18) not null,
   pressname            varchar(16),
   IDcardnumber         varchar(16),
   bookname             varchar(16),
   price                float,
   publicationtime      date,
   primary key (ISBN)
);

/*==============================================================*/
/* Table: Customer                                              */
/*==============================================================*/
create table Customer
(
   cid                  varchar(16) not null,
   cname                varchar(16),
   score                int,
   registrationtime     date,
   birthday             date,
   gender               bool,
   phonenumber          varchar(16),
   primary key (cid)
);

/*==============================================================*/
/* Table: Employees                                             */
/*==============================================================*/
create table Employees
(
   eid                  varchar(16) not null,
   shopid               int,
   ename                varchar(16),
   salary               int,
   entrytime            date,
   primary key (eid)
);

/*==============================================================*/
/* Table: "Focus"                                                */
/*==============================================================*/
create table Focus
(
   cid                  varchar(16) not null,
   ISBN                 varchar(18) not null,
   primary key (cid, ISBN)
);

/*==============================================================*/
/* Table: Press                                                 */
/*==============================================================*/
create table Press
(
   pressname            varchar(16) not null,
   editor               varchar(16),
   addr                 varchar(16),
   primary key (pressname)
);

/*==============================================================*/
/* Table: Purchase                                              */
/*==============================================================*/
create table Purchase
(
   cid                  varchar(16) not null,
   ISBN                 varchar(18) not null,
   shopid               int not null,
   purchasenumber       int,
   purchasedate         date not null,
   primary key (cid, ISBN, shopid, purchasedate)
);

/*==============================================================*/
/* Table: Shops                                                 */
/*==============================================================*/
create table Shops
(
   shopid               int not null,
   address              varchar(16),
   opendate             date,
   manager              varchar(16),
   primary key (shopid)
);

/*==============================================================*/
/* Table: StockIn                                               */
/*==============================================================*/
create table StockIn
(
   ISBN                 varchar(18) not null,
   eid                  varchar(16) not null,
   shopid               int not null,
   stockinnumber        int not null,
   stockindate          date not null,
   primary key (ISBN, eid, shopid, stockindate)
);

/*==============================================================*/
/* Table: Storage                                               */
/*==============================================================*/
create table Storage
(
   ISBN                 varchar(18) not null,
   shopid               int not null,
   storagenumber        int,
   primary key (ISBN, shopid)
);

alter table Books add constraint FK_write foreign key (IDcardnumber)
      references Author (IDcardnumber) on delete restrict on update restrict;

alter table Books add constraint FK_publish foreign key (pressname)
      references Press (pressname) on delete restrict on update restrict;

alter table Employees add constraint FK_work foreign key (shopid)
      references Shops (shopid) on delete restrict on update restrict;

alter table Focus add constraint FK_like foreign key (cid)
      references Customer (cid) on delete restrict on update restrict;

alter table Focus add constraint FK_like2 foreign key (ISBN)
      references Books (ISBN) on delete restrict on update restrict;

alter table Purchase add constraint FK_purchase foreign key (cid)
      references Customer (cid) on delete restrict on update restrict;

alter table Purchase add constraint FK_purchase2 foreign key (ISBN)
      references Books (ISBN) on delete restrict on update restrict;

alter table Purchase add constraint FK_purchase3 foreign key (shopid)
      references Shops (shopid) on delete restrict on update restrict;

alter table StockIn add constraint FK_StockIn foreign key (ISBN)
      references Books (ISBN) on delete restrict on update restrict;

alter table StockIn add constraint FK_StockIn2 foreign key (eid)
      references Employees (eid) on delete restrict on update restrict;

alter table StockIn add constraint FK_StockIn3 foreign key (shopid)
      references Shops (shopid) on delete restrict on update restrict;

alter table Storage add constraint FK_storage foreign key (ISBN)
      references Books (ISBN) on delete restrict on update restrict;

alter table Storage add constraint FK_storage2 foreign key (shopid)
      references Shops (shopid) on delete restrict on update restrict;

alter table StockIn add constraint CK_StockIn check(stockinnumber > 0);

alter table Purchase add constraint CK_purchase check (purchasenumber > 0);

/*--使用触发器--*/
delimiter $$
create trigger purchaseTrigger after insert
on Purchase for each row
begin
    IF exists (select * from Storage 
    	where Storage.storagenumber < new.purchasenumber 
    	and new.ISBN = Storage.ISBN 
    	and new.shopid = Storage.shopid) 
    then 
    	signal sqlstate '22003' set message_text = "库存量不应该为负数.";
    ELSE
    update Storage set Storage.storagenumber = Storage.storagenumber - new.purchasenumber 
    where new.ISBN = Storage.ISBN and new.shopid = Storage.shopid;
    end if;
end$$

create trigger StockInTrigger after insert
on StockIn for each row
begin
    IF NOT EXISTS (select * from Storage 
    	where Storage.ISBN = new.ISBN and Storage.shopid = new.shopid)
   	then insert into Storage(ISBN,shopid,storagenumber) 
    values(new.ISBN,new.shopid,new.stockinnumber);
    ELSE
    update Storage Set Storage.storagenumber = new.stockinnumber + Storage.storagenumber 
    where Storage.ISBN = new.ISBN AND Storage.shopid = new.shopid;
    end if;
end$$

/*--使用存储过程--*/
create procedure purchaseProc(IN nPurchaseNum int, IN nISBN varchar(18), IN nshopid int )
begin
start transaction;
	select @originNum := purchasenumber from Purchase
	where ISBN = nISBN and shopid = nshopid;
	update Purchase set Purchase.purchasenumber = nPurchaseNum
	where Purchase.ISBN = nISBN and Purchase.shopid = nshopid;
	update Storage set Storage.storagenumber =
	Storage.storagenumber + nPurchaseNum - @originNum
	where Storage.ISBN = nISBN and Storage.shopid = nshopid;
	IF exists (
		select * from Storage 
		where Storage.sotragenumber < 0 
		and Storage.ISBN = nISBN 
		and Storage.shopid = nshopid) 
	then
		signal sqlstate 'HY000' set message_text = "库存量不应该为负数.";
		rollback;
	end if;
commit;
end$$
delimiter ;































