<?php

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<html>
    <body>
        <h1>Add user</h1>
        <form action="index.php" method="post">
            First name: <input type="text" name="firstname"><br>
            Last name: <input type="text" name="lastname"><br>
            <input type="submit" value="Add user">
        </form>
        <?php
            // Handle form submission to add user
            if (isset($_POST["firstname"]) && isset($_POST["lastname"])) {
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];

                $sql = "INSERT INTO users (firstname, lastname) VALUES ('$firstname', '$lastname')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        ?>

        <br>
        <hr>
        <br>

        <h1>Search by first name</h1>
        <form action="index.php" method="get">
            Search by first name: <input type="text" name="search_firstname"><br>
            <input type="submit" value="Search">
        </form>
        <?php
            // Handle form submission to search for user by first name
            if (isset($_GET["search_firstname"])) {
                $search_firstname = $_GET["search_firstname"];

                $sql = "SELECT lastname FROM users WHERE firstname='$search_firstname'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "Last name: " . $row["lastname"] . "<br>";
                    }
                } else {
                    echo "0 results";
                }
            }
        ?>

        <br>
        <hr>
        <br>


        <h1>All users</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
            </tr>
            <?php

                // Display all users
                $sql = "SELECT id, firstname, lastname FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["id"]."</td>
                                <td>".$row["firstname"]."</td>
                                <td>".$row["lastname"]."</td>
                            </tr>";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
            ?>
        </table>

        <br>
        <hr>
        <br>

        <h1>Try integration</h1>
        <form action="index.php" method="get">
            Input name to try the integration: <input type="text" name="int_name"><br>
            <input type="submit" value="Send">
        </form>
        <?php
            // Handle form submission to search for user by first name
            if (isset($_GET["int_name"])) {
                $name = $_GET["int_name"];

                $response = file_get_contents("http://".$_ENV['BACKEND_2_API']."?name=" . $name);
                echo $response."<br>";
                $response = file_get_contents("http://".$_ENV['BACKEND_1_API']);
                echo $response."<br>";


            }
        ?>

        <?php

        


        ?>
    </body>
</html>    