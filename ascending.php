<?php

$dsn = 'mysql:host=localhost;dbname=BookCatalog';
$username = 'php';
$password = 'php';

$db = new PDO($dsn, $username, $password);

$page = 0;

$query = 'SELECT courseID, courseTitle, isbn13, 
          bookTitle, price, credit
          FROM COURSEBOOK
          LEFT JOIN BOOK
          ON COURSEBOOK.book = BOOK.isbn13
          INNER JOIN COURSE
          ON COURSE.courseID = COURSEBOOK.course
          ORDER BY courseID DESC
          LIMIT ' . $page .', 6';

$statement = $db->prepare($query);
$statement->execute();
$products = $statement->fetchAll();
$statement->closeCursor();

$queryAll = 'SELECT courseID, courseTitle, isbn13, 
          bookTitle, price, credit
          FROM COURSEBOOK
          LEFT JOIN BOOK
          ON COURSEBOOK.book = BOOK.isbn13
          INNER JOIN COURSE
          ON COURSE.courseID = COURSEBOOK.course';

$statement1 = $db->prepare($queryAll);
$statement1->execute();
$products1 = $statement1->fetchAll();
$statement1->closeCursor();

$number = count($products1);
$pages = ceil($number / 6);

?>

<!DOCTYPE html>
<html>

    <!-- the head section -->
    <head>
        <title>Book Catalog</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
    </head>

    <!-- the body section -->
    <body>
        <header><h1>CIS Department Book Catalog</h1></header>
        <main>
            
            <table border="1">
                <tr>
                    <th><?php echo '<a href=ascending.php'?>>Course #</a></th>
                    <th>Course Title</th> 
                    <th>Book Image</th>
                    <th>Book Title</th>
                    <th><?php echo '<a href=display.php?price=ASC'?>>Price</a></th>
                </tr>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><a href="http://www.cpp.edu/~cba/computer-information-systems/curriculum/courses.shtml">
                            <?php echo $product['courseID'] ?></a></td>
                        <td>
                            <?php echo $product['courseTitle'] . 
                                 ' (' . $product['credit'] . ')'; ?> 
                        </td>
                        <td>
                            <a href='/NetBeansProject/book_description.php?img=<?php echo $product['isbn13']?>'>
                                <?php echo '<img src=/NetBeansProject/images/' . 
                                        $product['isbn13'] . '.jpg >'; ?>
                            </a>
                        </td>
                        <td><?php echo $product['bookTitle']; ?></td>
                        <td>$<?php echo money_format('%i', $product['price']); ?></td>
                    </tr>
                <?php } ?>

            </table>
            
            
            <?php for ($i = 1; $i < $pages + 1; $i++) { ?>
            <a href="index.php?page=<?php echo $i ?>"><?php echo $i?></a>
            <?php } ?>

        </main>

    </body>
</html>