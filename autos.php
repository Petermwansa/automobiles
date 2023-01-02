<?php
require_once "pdo.php";


$failure = false;  // If we have no POST data

$user;


if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {

    if ( !is_numeric(strlen($_POST['year'])) || !is_numeric(strlen($_POST['mileage']))) {
        $failure = "Mileage and year must be numeric";
    } else if (strlen($_POST['make']) < 1) {
        $failure = "Make is required";
    }
    else {
        $sql = "INSERT INTO autos (make, year, mileage)
        VALUES (:make, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']));
    }
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
    <head>
        <title>Peter Mwansa</title>
    </head>
    <body>
        <h1>Automobiles</h1>
        <?php
            if ( $failure !== true ) {
                // Look closely at the use of single and double quotes
                echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
            }
        ?>
        <form method="post">
            <p>Make: 
                <input type="text" name="make" size="30">
            </p>
            <p>Year:
                <input type="text" name="year" size="30">
            </p>
            <p>Mileage:
                <input type="text" name="mileage" size="30">
            </p>
            <button type="submit">Add</button>
        </form>
        <table>
            <?php
                foreach ( $rows as $row) {
                    echo "<tr><td>";
                    echo($row['make']);
                    echo "</td><td>";
                    echo($row['year']);
                    echo "</td><td>";
                    echo($row['mileage']);
                    echo "</td></tr>";
                }
            ?>
        </table>
    </body>
</html>