<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Plasiche (Place situation Checker)</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="">What is the location situation like?</h1>

    <table class="table table-bordered mt-4" id="data-table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Place Name</th>
                <th scope="col">Location Link</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody id="place-data">
            <!-- Data will be injected here by JavaScript -->
        </tbody>
    </table>
</div>

<!-- Theme Toggle Switch -->
<div id="theme-toggle-container">
    <label class="switch">
        <input type="checkbox" id="theme-toggle">
        <span class="slider round"></span>
    </label>
    <span class="toggle-label">Dark Mode</span>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Function to load data from the server
    function loadPlaceData() {
        $.ajax({
            url: "get_place.php", // PHP script to fetch data
            method: "GET",
            success: function(data) {
                var places = JSON.parse(data);
                var html = '';

                // Loop through the places and create table rows
                for (var i = 0; i < places.length; i++) {
                    var placeName = places[i].Location_Name;
                    var locationLink = places[i].Location_where;
                    var placeStat = places[i].Place_Stat;

                    // Add conditional color classes based on the status
                    var statusClass = '';
                    if (placeStat.toLowerCase() === 'peaceful') {
                        statusClass = 'peaceful';
                    } else if (placeStat.toLowerCase() === 'danger') {
                        statusClass = 'danger';
                    }

                    html += '<tr>';
                    html += '<td>' + placeName + '</td>';
                    html += '<td><a href="' + locationLink + '" target="_blank">Link</a></td>';
                    html += '<td class="' + statusClass + '">' + placeStat + '</td>';
                    html += '</tr>';
                }

                // Inject the generated HTML into the table body
                $('#place-data').html(html);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: " + error);
            }
        });
    }

    // Call the function to load data initially
    loadPlaceData();

    // Set an interval to refresh the data every 5 seconds (5000 ms)
    setInterval(loadPlaceData, 5000);

    // Dark mode toggle functionality
    const themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('change', () => {
        document.body.classList.toggle('dark-mode');
        document.getElementById('data-table').classList.toggle('dark-mode');
    });
</script>
<div class="container mt-5">
    <p>This page is used in Patepan's thesis.</p>
</div>

</body>
</html>
