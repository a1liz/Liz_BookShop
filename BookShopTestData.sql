/* Author */
insert into Author(IDcardnumber,authorname) values('1511001','曹雪芹');
insert into Author(IDcardnumber,authorname) values('1511002','施耐庵');

/* Press */
insert into Press(pressname,editor,addr) values('南开大学出版社','主编a','南开大学xx号');
insert into Press(pressname,editor,addr) values('天津大学出版社','主编b','天津大学xx号');

/* Books */
insert into Books(ISBN,IDcardnumber,pressname,bookname,price,publicationtime)
values('10011231031','1511001','南开大学出版社','红楼梦',25,'2015-1-1');

/* Customer */
insert into Customer(cid,cname,score,registrationtime,birthday,gender,phonenumber)
values('00001','liz',0,'2017-1-1','1998-1-4',true,'13652175562');

/* Shops */
insert into Shops(shopid,address,opendate,manager)
values(1,'滨江道28号','2016-9-18',null);

/* Employees */
insert into Employees(eid,password,shopid,ename,salary,entrytime)
values('00001',"qwer123",1,'张三',5000,'2017-1-1');

/* Storage */
insert into Storage(ISBN,shopid,storagenumber) values('10011231031',1,20);

/* StockIn */
insert into StockIn(ISBN,eid,shopid,stockinnumber,stockindate)
values('10011231031','00001',1,50,'2017-5-1');

/* Purchase */
insert into Purchase(cid,ISBN,shopid,purchasenumber,purchasedate)
values('00001','10011231031',1,30,'2017-5-2');

/* Focus */
insert into Focus(cid,ISBN) values('00001','10011231031');

/*delimiter $$
start transaction;
	delete from Storage where ISBN = any(select ISBN from Books where IDcardnumber = "1511001");
	delete from StockIn where ISBN = any(select ISBN from Books where IDcardnumber = "1511001");
	delete from Purchase where ISBN = any(select ISBN from Books where IDcardnumber = "1511001");
	delete from Focus where ISBN = any(select ISBN from Books where IDcardnumber = "1511001");	
	delete from Books where IDcardnumber = "1511001";
	delete from Author where IDcardnumber = "1511001";

commit;
end$$
delimiter ;*/