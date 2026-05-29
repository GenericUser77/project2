<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Ayden Joel Rao">
    <meta description="A page to show enquires to managers only.">
    <title>Manage</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>


<?php
/*
=========================================================
manage.php
---------------------------------------------------------
this page allows a manager to:
1. list all eois
2. list eois by job reference
3. search by applicant first name / last name
4. delete all eois by a given job reference
5. change an eoi status
6. choose a sort field for results
=========================================================
*/

/* ------------------------------------------------------
   start session
   ------------------------------------------------------
   needed for login authentication
------------------------------------------------------ */

session_start();

require_once("settings.php");
require_once("jobs.php");
require("jobs.sql");
require("eoi.sql");



/* ------------------------------------------------------
   database connection
------------------------------------------------------ */

$conn = new mysqli($host, $user, $pwd, $sql_db);


/* check if connection failed */
if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}


/* ------------------------------------------------------
   delete eois by job reference
------------------------------------------------------ */

if (isset($_POST['delete_job_ref'])) {

    // get the job reference entered by manager
    $job_ref = $_POST['delete_job_ref'];

    // sql query to delete matching eois
    $delete_sql = "DELETE FROM eoi WHERE job_reference = ?";

    // prepare statement for security
    $stmt = $conn->prepare($delete_sql);

    // bind parameter
    $stmt->bind_param("s", $job_ref);

    // execute query
    $stmt->execute();

    echo "<p>eois deleted for job reference: $job_ref</p>";

    // close statement
    $stmt->close();
}


/* ------------------------------------------------------
   update eoi status
------------------------------------------------------ */

if (isset($_POST['update_status'])) {

    // get form values
    $eoi_id = $_POST['eoi_id'];
    $new_status = $_POST['new_status'];

    // sql query to update status
    $update_sql = "UPDATE eoi SET status = ? WHERE EOInumber = ?";

    // prepare statement
    $stmt = $conn->prepare($update_sql);

    // bind parameters
    $stmt->bind_param("si", $new_status, $eoi_id);

    // execute query
    $stmt->execute();

    echo "<p>status updated successfully.</p>";

    // close statement
    $stmt->close();
}


/* ------------------------------------------------------
   search / list eois
------------------------------------------------------ */

// default sql query
$sql = "SELECT * FROM eoi WHERE 1=1";

// array to store parameters
$params = [];
$types = "";


/* ------------------------------------------------------
   filter by job reference
------------------------------------------------------ */

if (!empty($_GET['job_reference'])) {

    $sql .= " AND job_reference = ?";

    $params[] = $_GET['job_reference'];
    $types .= "s";
}


/* ------------------------------------------------------
   filter by first name
------------------------------------------------------ */

if (!empty($_GET['first_name'])) {

    $sql .= " AND first_name LIKE ?";

    $params[] = "%" . $_GET['first_name'] . "%";
    $types .= "s";
}


/* ------------------------------------------------------
   filter by last name
------------------------------------------------------ */

if (!empty($_GET['last_name'])) {

    $sql .= " AND last_name LIKE ?";

    $params[] = "%" . $_GET['last_name'] . "%";
    $types .= "s";
}


/* ------------------------------------------------------
   sorting results
------------------------------------------------------ */

// allowed sort fields for security
$allowed_sort_fields = [
    "EOInumber",
    "job_reference",
    "first_name",
    "last_name",
    "status"
];

// default sort field
$sort_field = "EOInumber";

// if user selected a valid sort field
if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowed_sort_fields)) {
    $sort_field = $_GET['sort'];
}

// add order by to sql query
$sql .= " ORDER BY $sort_field";


/* ------------------------------------------------------
   prepare and execute search query
------------------------------------------------------ */

$stmt = $conn->prepare($sql);

/* if parameters exist, bind them */
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

/* execute query */
$stmt->execute();

/* get results */
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage EOIs</title>

    <style>

        body {
            font-family: Arial;
            margin: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        form {
            margin-bottom: 25px;
        }

    </style>

</head>

<body>

<?php include 'nav.inc'; ?>

<h1>Manage EOIs</h1>

<!-- logout link -->
<p><a href="manage.php?logout=true">Logout</a></p>


<!-- =====================================================
     search form
===================================================== -->

<h2>Search EOIs</h2>

<form method="GET" action="manage.php">

    <label>Job Reference:</label>
    <input type="text" name="job_reference">

    <br><br>

    <label>First Name:</label>
    <input type="text" name="first_name">

    <br><br>

    <label>Last Name:</label>
    <input type="text" name="last_name">

    <br><br>

    <label>Sort By:</label>

    <select name="sort">

        <option value="EOInumber">EOI Number</option>
        <option value="job_reference">Job Reference</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="status">Status</option>

    </select>

    <br><br>

    <input type="submit" value="Search EOIs">

</form>


<!-- =====================================================
     delete eois form
===================================================== -->

<h2>Delete EOIs by Job Reference</h2>

<form method="POST" action="manage.php">

    <label>Job Reference:</label>

    <input type="text" name="delete_job_ref" required>

    <input type="submit" value="Delete EOIs">

</form>


<!-- =====================================================
     update status form
===================================================== -->

<h2>Update EOI Status</h2>

<form method="POST" action="manage.php">

    <label>EOI Number:</label>

    <input type="number" name="eoi_id" required>

    <br><br>

    <label>New Status:</label>

    <select name="new_status">

        <option value="New">New</option>
        <option value="Current">Current</option>
        <option value="Final">Final</option>

    </select>

    <br><br>

    <input type="submit" name="update_status" value="Update Status">

</form>


<!-- =====================================================
     display results table
===================================================== -->

<h2>EOI Results</h2>

<table>

    <tr>
        <th>EOI Number</th>
        <th>Job Reference</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Status</th>
    </tr>

    <?php
    // loop through all returned records
    while ($row = $result->fetch_assoc()) {
    ?>

    <tr>

        <td><?php echo $row['EOInumber']; ?></td>
        <td><?php echo $row['job_reference']; ?></td>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['last_name']; ?></td>
        <td><?php echo $row['status']; ?></td>

    </tr>

    <?php
    }
    ?>

</table>

<?php include 'footer.inc';
include("nav.inc") ?>


</body>
</html>

<?php
/* close database connection */
$conn->close();
?>