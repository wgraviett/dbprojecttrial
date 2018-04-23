Student Application Management System (SAMS)
======
Mizzou 2018 Spring Database Project Final Partners: Wesley Graviett (WAGKYF) Samantha Warren (SLWGYF)

We designed a Student Application Managment Sytem that is designed for educational institutions to manage graduate or undergraduate applications and or regular departmental forms. In many smaller departments around campus the use of paper forms and office assistants manually typing in data is still widely implemented, so we're attempting to streamline the current process. Our system will allow for a department to recreate their forms electronically and have the student records automatically recorded, easily searchable, and allow for electronic status such as approved or denied.
 
 The application offers two different permission levels (views) such as for an Advisor or a Student. The advisor view displays all applications within the system and offers the options for the advisor to view the application in detail, Approve or Deny the application with time stamp, or to delete the application. Deleting an application can be easily removed from an advisor view if the department wishes to retain all applications for historical purposes. The *Add Application* button will allow an advisor to create an application with a student present or act as a way for the advisor to view details of the form a student is filling out. For example, often times students will call with questions about an application and the advisor will be able to click the *Add Application* button and follow along with the student.   
 
When a student navigates to the application website, they must create a user account by clicking *Create User*. Within the create user form entry, the student will enter all basic information about themselves such as name, address, birthdate, phone number,etc. This data will be recorded and used to prepopulate their application forms. If a user already has an existing account the application will alert them that an account already exists for their StudentID or LoginID. Once a user account is created, they will be redirected to the main login site. Once logged in, the student has the option to *Add Application* where they select which program and the respective form fields are shown. Currently the system is demonstrating a concept of one question for all fields. During customization a department can provide detailed requirements. Once the student submits their form, the entry is displayed on their view and they can view the status of the application or retract the application. A student can apply to as many departments as they want and all entries will appear in their view.  

Table: Users


|Field| Type| NULL| Key| Default| Extra |
|-----|-----|-----|----|--------|-------|
|id   |int(11)|NO|Pri|None| AUTO_INCREMENT|
|First_Name|varchar(25)|NO||||
|Last_Name|varchar(25)|NO||||
|Email|varchar(25)|NO||||
|studentId|varchar(8)|NO||||
|PermissionID|enum('student','Admin','Advisor')|Yes|NO|student||
|Password|varchar(255)|||||
|Street_Address|varchar(100)|Yes||||
|City|varchar(40)|Yes||||
|State|varchar(2)|Yes||||
|Zipcode|varchar(5)|Yes||||
|County|varchar(10)|Yes||||
|loginID|varchar(25)|Yes||||


The image below depicts the Entity Relationship Diagram of our Student Application Management System. There a three databases that store data related to the users, applications, and different programs offered. 
![ERD_Diagram](http://wesleygdatabase.epizy.com/MVCSammy/DatabaseERDV1.jpg)

the schema for the database (the table definitions).
an entity relationship diagram (ERD) for the database.
an explanation of where the app is doing create, read, update, and delete (Links to an external site.)Links to an external site. (explain how the app meets the requirements for supporting CRUD)
