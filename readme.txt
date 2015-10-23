
While strategic planning is being increasingly implemented in Local Government, there is currently a disconnect between strategic planning and corporate capacity. The City of Courtenay has developed and implemented a corporate capacity program based on Open Source programming. This new program allows for the development of an annual Work Plan that is based both on Council’s strategic priorities, and the City’s statutory requirements. Each year the Work Plan is collectively developed by the senior management team, and once approved by Council, is supported by the Financial Plan.  The Work Plan resides on the City’s intranet and is directly connected to individual staff timesheets providing real time analysis and feedback to department heads and managers. In combination with monthly financial status updates, the Work Plan is the CAO’s tool for oversight of managers, reporting to Council and the public, and to establish annual performance measures for Administration and senior management.

In a time of increasing demand for “Value for Money” in Local Government, as demonstrated by the creation of an Auditor General for Local Government in 2012, estimating and tracking corporate capacity enhances the use of scarce human and financial resources, and provides greater transparency, municipal performance measurement, and reporting.


David Allen
Chief Administrative Officer
City of Courtenay
Co-Chair, Asset Management BC
www.courtenay.ca 





WorkPlan.Gov setup

basic instructions for a linux server.

Create a Database called "workplan" and restore the database schema to it with the included workplan.sql using MySQL Administrator, phpmyadmin etc. 
unzip the workplan archive to your webserver and chmod 777 the templates_c directory.
you will need the php-gd libraries if you want to upload user pictures and chmod 777 the images directory.

edit the app_settings.php around line 22 to reflect your mysql settings.
you can also modify the header text, Logo and footer text.

once done browse to http://yourserver/workplan/
if you run into the infamous "white screen" you can comment out debug level on line 4 in settings.php

you can log in with :

user: admin
psswd: admin

user: Manager One
psswd: manager1

user: Manager Two
psswd: manager2

user: Manager Three
psswd: manager3

Note the  "admin" account must be record 1 (in the staff table) as there are a few hard coded references to %CURRENT_USER_ID%




Workplan uses Smarty 2 which allows a template based system. to customize reports, charts etc look into:

workplan_ver_1.19/components/templates/custom_templates