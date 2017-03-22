<?php
$dsn = 'mysql:host=localhost;dbname=BookCatalog';
$username = 'php';
$password = 'php';

$db = new PDO($dsn, $username, $password);

$query = 'SELECT COURSEBOOK.book, COURSEBOOK.course, COURSE.courseTitle, COURSE.credit,
                 BOOK.bookTitle, BOOK.price, AUTHOR.firstName, AUTHOR.lastName,
                 PUBLISHER.publisher, BOOK.edition, BOOK.publishDate, BOOK.length, BOOK.isbn13,
                 BOOK.description
          FROM COURSEBOOK
          LEFT JOIN COURSE
          ON COURSEBOOK.course = COURSE.courseID
          INNER JOIN BOOK
          ON BOOK.isbn13 = COURSEBOOK.book
          INNER JOIN AUTHORBOOK 
          ON BOOK.isbn13 = AUTHORBOOK.book
          INNER JOIN AUTHOR
          ON AUTHORBOOK.author = AUTHOR.authorID
          INNER JOIN PUBLISHER
          ON BOOK.publisher = PUBLISHER.publisherID
          WHERE BOOK.isbn13 = :isbn';



$isbn = $_GET['img'];

$statement = $db->prepare($query);
$statement->bindValue(':isbn', $isbn);
$statement->execute();
$book = $statement->fetch();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>

    <!-- the head section -->
    <head>
        <title>Book Detail</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
    </head>

    <!-- the body section -->
    <body>
        <header><h1>Book Description</h1></header>
        <main>


            <table border='1'>


                <tr>
                    <td>
                
                    <?php echo '<img src=images/' . $_GET['img'] . '.jpg >'; ?>
                
                </td>
                <td>
                <p>For Course: <?php
                    echo $book['course'] . ' ' .
                    $book['courseTitle'] . ' ' . '(' .
                    $book['credit'] . ')';
                    ?> 
                </p>
                <p>Book Title: <?php echo $book['bookTitle']; ?></p>
                <p>Price: $<?php echo money_format('%i', $book['price']); ?></p>
                <p>Authors: <?php echo $book['firstName'] . ' ' . $book['lastName'] ?></p>
                <p>Publisher: <?php echo $book['publisher'] ?></p>
                <p>Edition: <?php echo $book['edition'] . ' ' . $book['publishDate']; ?></p>
                <p>Length: <?php echo $book['length'] ?></p>
                <p>ISBN-13: <?php echo $_GET['img'] ?></p>
                </td>
                </tr>
                <tr>
                    <td colspan='2'>Product Description: <?php echo $book['description'] ?></td>
                </tr>


            </table>

        </main>

    </body>
</html>

