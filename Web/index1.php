<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Place Stat Checker</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional custom CSS for status colors */
        .peaceful {
            color: green;
            font-weight: bold;
        }
        .danger {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="">How the place is going</h1>

    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Place Name</th>
                <th scope="col">Location Link</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root"; 
            $password = "maki43499";
            $dbname = "eas";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch Place data along with Location
            $sql = "SELECT Location.Location_Name, Location.Location_where, Place.Place_Stat 
                    FROM Place 
                    JOIN Location ON Place.Place_Location = Location.Location_ID";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Location_Name']) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($row['Location_where']) . "' target='_blank'>Link</a></td>";
                    
                    // Add conditional color for Place Stat
                    if (strcasecmp($row['Place_Stat'], 'Peaceful') == 0) {
                        echo "<td class='peaceful'>" . htmlspecialchars($row['Place_Stat']) . "</td>";
                    } elseif (strcasecmp($row['Place_Stat'], 'Danger') == 0) {
                        echo "<td class='danger'>" . htmlspecialchars($row['Place_Stat']) . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($row['Place_Stat']) . "</td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No records found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
