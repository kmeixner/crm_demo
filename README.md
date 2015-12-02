## CRM DEMO ##

**Purpose:**

* Given to me as an assignment to demonstrate my coding skills.  

**Technology:**

* Backend: PHP, MySQL
* Frontend: HTML5, CSS3, JavaScript, JQuery

**Installation:**

1. Ensure your web server has PHP and MySQL installed, please refer to the [PHP](http://php.net/manual/en/install.php) and [MySQL](http://dev.mysql.com/doc/refman/5.7/en/installing.html) manuals to learn how to do this.
2. Run the table building SQL commands in install/sql.sql to construct the database system
3. Copy the code into the desired location on your web server.
4. Edit the constants in the api/settings.inc.php file as per your database configuration.

**Features:**

* Allows a contact to be created, edited and deleted
* Allows an organization to be created, edited and deleted
* Allows a contact to be assigned to represent and organization and also unassigned

Note: These features match the product requirements given in the assignment.

**Limitations:**

Due to time constraints and simplicity of the demo the following assumptions have been made:

* An login authentication system would be handled outside of this application, ie: a person would have to be logged in somewhere else to view this page.
* The contact and organization lists are small enough to display on one page, ie: it is assumed that no paging is required
* Only one contact can be assigned for a given organization and vica-versa
