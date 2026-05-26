<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Robin Ellul Romero">
    <meta description="A page to show and describe the jobs of the company.">
    <title>Jobs</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<?php require_once("settings.php");
$query = "SELECT * FROM jobs";
$result = mysqli_query($conn, $query); ?>

<h1>Job Listings</h1>


<?php
include 'nav.inc';
include 'footer.inc'; ?>
</body>
</html>