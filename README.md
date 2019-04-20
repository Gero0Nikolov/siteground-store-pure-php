# siteground-store-pure-php
SiteGround task for simple online store.

# installation
1. Clone the repository
2. In the main folder you'll find the CONFIG.php file:
	1. Database configuration
	2. Project Directory path
3. Before accessing the project URL, you'll need to run the INDEX.php script in db-init. It'll initialize the Tables in Database.
	1. You can also use the SQL dump which was added in the repository. It contains: Products and their price + discounts for a specific quantity.
	2. There is also the Sales Table which contains an example sale information for few of the products.

# folder structure
1. APIs folder contains all of the AJAX requests used in this project
2. ASSETs folder contains SCSS styles & JS scripts.
3. DB-INIT folder contains INDEX.php script which can be used for quick installation of the project.
4. Framework.php contains a very simple framework designed for the needs of this project.
5. Config.php contains all the data for the server setup: DB & Project Directory.
