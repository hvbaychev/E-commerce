Задание:

Task: Create a dynamic PHP website for selling different items
Technologies to use: PHP, MySQL, HTML, CSS, JavaScript (if needed)
You can use libraries for the front-end part e.g. Bootstrap, Sass, jQuery, TinyMCE, JS libraries
You can’t use: any PHP frameworks e.g. Symfony, Laravel...

Project description
Create a marketplace for buying and selling goods such as electronics, fashion items, furniture, household goods,
cars... The website aim is to connect sellers with buyers. Sellers post their items to reach customers who want to
purchase their products and services.
Real examples of such marketplaces: OLX, Ebay, Amazon

Project details:
- All posted items are public
- Users can:
o login 
o register 
o edit their contact information 
o create, edit, delete unlimited items for sale after they have logged in 
- Properties that users have to fill as data in their account:
o name 
o surname 
o email 
o phone number 
o city 
- Every item has:
o Item publication date
o Single/Multiple images
o Title
o Description
- Item page shows:
o All data for the item
o How to contact the seller

Concentrate mostly on the backend part. The front-end should just show that the displayed data in different
pages is actually dynamic ( it comes from DB ). However, any front-end extra work ( like adding styling,
animations, using different libraries ) will be considered as an advantage.
How to send the project: Export the database structure and all records in .sql file, archive it in .zip along with all
project files and send it. It’s also recommended to send some short instructions how to run the project.

Author: Georgi Sabev


Реализация:

1. Създаване на нужните форми и хардкодване на информацията в тях
2. Създаване на папка асет/цсс/имг/джс - като в цсс style.css, където се слага цялата информация за цсс-а на страниците
3. Създаване на style.css - като се импортира в index.html в head частта. (<link rel="stylesheet" href="assets/css/style.css">)
4. Вземане на css bootstrap - <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> и поставяне над точка 3
5. Вземане на js bundle - <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> и поставяне малко над боди-тага!
6. Вземане от fontawsome - <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/> и поставяне в head над точка 3.
7. Вземане на navbar ot bootstrap
8. Вземане на стил от гоогле - fonts.google.com положен в style.css (2-ти сменен :))
9. След създаването на нужните страници за работа (не всички в последствия излязоха още) направих датабазата (претърпя промени от първоначалната но кода го има в отделен файл)
10. Създаване на папка server, където са направени някой връзки, като connect.php (връзка с базата данни), getCoats.php(изкарване динамично на началната страница продукти coats), getFeaturedProducts.php(изкарване динамично на началната страница продукти), placeOrder.php(за поръчките) 
11. Стартиране на проекта в локален хост :  php -S localhost:8000
12. Layuots на header.php и на footer.php(няма активни функционалност)
13. Работа по логиката на страниците:
13.1. Index.php - Страницата е home, в нея се показват  Our Featured динамично като взема само 4 записа от базата данни и Dresses & Coats като взема спрямо категорията 4 продукта ако има толкова 
Активните бутони за покупа са само BUY NOW, а другите SHOP NOW  НЕ СА АКТИВНИ.
13.2. Shop.php - При влизане в страницата се виждат всички активни обяви в сайта, като има хардкоднати категории(не са през цикъл), радио бутоните за търсачката са активни и работят, може да 
се търси с тях, като дефаулт стойност е bags i 100$, също така работи и цената, която да си избереш (диапазона и като винаги взема равно или по-малко).
При избор на категория и натискане на търсене излизат продуктите спрямо зададената категория.
13.3. Contact Us - информация за мен :)
13.4. Add Product - CRUD функционалност, която позволява качване на продукт (само с една снимка), както и снимките се качват директно във файловата система в папка upload.
Може да се видят продуктите от бутона "view products", който пренасочва към->
13.5. Product.php -  Тук можете да се върнете да добавите продукт или да го изтриете, както и да се редактира, ако е натиснат бутона EDIT ->
13.6. EditPrduct.php - Тук се показва старото описание на продукта като предишни стойности и съответно всичките могат да се променят с нови.
13.7. Добавяне на продукт в кошницата - минава през бутона "buy now", като той препраща в ->
13.8. SINGLEPRODUCT.php - където се вижда категорията, името, цената, количеството (като и то може да бъде променено и да се изпрати директно в кошницата), описание на продукта
и връзка с потребителя качил продукта (телефонен номер). При натискане на бутона "add to cart"->
13.9. Cart.php - Ако продукта вече е добавен излиза съобщение, че продукта вече е добавен и няма да се добави повече и препраща директно в кошницата
Визуализира се снимка, име и цена на продукта от ляво на таблицата, както и бутон "remove", ако трябва да се премахне артикула
количеството е в средата, като то може да се променя динамично, което води и до преизчисляване на крайната цена за този артикул в subototal
Total е последното поле, където сумира цялата стойност на поръчката. Поръчката може да се изпрати от бутона "checkout"
13.10. checkout.php - изпраща към страница, където потребителя трябва да си въведе данните по негов избор, защото може адреса и получателя, както и телефоният номер да са
различни от тези, които той е дал като потребител.Цената на поръчката е показана над бутона "place order". След като са въведени всички полета може да се натисне бутона PLACE ORDER->
13.11. payment.php - където показва стойността на поръчката плюс бутон "pay now", където трябва да се развие функционалност за плащане през пейпал.(не е активен)
13.12. Account.php - показва информация за потребителя, като неговото име, поща, поръчки и разлогване, като активни са поръчките и разлогването.
Change Password - потребителя може да си смени паролата, ако желае!
Change User Info - тук потребителя може да въведе повече информация за себе си, ако желае!
Your Orders - тук се виждат всички поръчки на потребителя, като се показват номер, стойност, дали е платена - доставена и т.н. (не е активно), дата на поръчката и DETAILS->
13.13. ORDERDETAILS.PHP - тук потребителя вижда информация за поръчката, т.е. може да са повече от един артикул, като ги вижда със снимки, цена и количество.
Ако поръчката е със статус "not paid" потребителя има активен бутон за плащане, ако е с друг статус - бутона не се показва!
При натискане на "pay now" отново се отива в PAYMENT.PHP, където не е развита функционалността за разплащане.


Стартиране на проекта:

1. Зареждане на проекта
2. Зареждане на базата данни
3. Стартиране на сървър php -S localhost:8000
4. Можете и без да имате нищо налично в базата данни да започнете целият процес по работа(ваш е избора).


Това е логиката и процеса през, който минах за да направя проекта изпратен от Вас!


С пожелания за хубав ден!

Поздрави,
Христо Байчев!



