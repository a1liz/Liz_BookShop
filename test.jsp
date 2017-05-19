<%@ page language="java" contentType="text/html; charset= utf-8"
    pageEncoding="utf-8"%>
<%@ page import="java.sql.*" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>JDBC test</title>
</head>
<body>
 <%
 Connection con;
 Statement sql;
 ResultSet rs;
 try {
	 Class.forName("com.mysql.jdbc.Driver").newInstance();
	 }
 catch(Exception e) { out.print(e);}
 try {
	 String uri = "jdbc:mysql://localhost:3306/bookshop";
	 con=DriverManager.getConnection(uri,"root","qwer123");
	 sql=con.createStatement();
	 rs=sql.executeQuery("select * from Books");
	 out.print("<table border=2>");
	 out.print("<tr>");
	 out.print("<th width=100>"+"ISBN");
	 out.print("<th width=100>"+"pressname");
	 out.print("<th width=100>"+"authorIDcard");
	 out.print("<th width=100>"+"bookname");
	 out.print("</tr>");
	 while(rs.next()) {
		 out.print("<tr>");
		 out.print("<td>"+rs.getString(1)+"</td>");
		 out.print("<td>"+rs.getString(2)+"</td>");
		 out.print("<td>"+rs.getString(3)+"</td>");
		 out.print("<td>"+rs.getString(4)+"</td>");
		 out.print("</tr>");
	 }
	 out.print("</table>");
	 con.close();
 }
 catch(SQLException e1){out.print(e1);}
 %>

</body>
</html>