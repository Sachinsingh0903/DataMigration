
step1: start the server (xampp,wampp).
step2: Create a database name it as mytable.
step3: create table excel_data.
step4: create a spreadsheet.
step5: save file in root directory.
step6: download and save library to root directory.
step7: open web page and can run the project 


What i was enable to do:


Below query will fetch the details for further query 
-SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='mytable'
//store it in a array
//eg:temp[]=details
-SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema='mytable' AND table_name=temp
abc
-excellattri=[name ,fname,lname]
dbattri=[name,fname,lastname]

-by comapring excelattri(database table attribute) by spradsheet attributes you will get a attributes that are same in both table.

-after comapring you can insert the data as you insert previously.    


"i tried to solve this but i was unable to do so you can find the above query solution in FURTHERPROCESS.PHP"