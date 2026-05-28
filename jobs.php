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
<?php
require_once("settings.php");
$query = "SELECT * FROM jobs";
$result = mysqli_query($conn, $query); 
include 'header.inc';
?>
<h2>Jobs Descriptions</h2>
<div class="jobs-container">
<?php

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $skills = explode(",", $row['skills']); /* I asked claude how to split the skills into an array, this was the result of my question. */
?>
        <section class="job-card">
<?php
echo '<h2>' . $row['title'] . '</h2>';
echo '<h3>' . $row['job_code'] . '</h3>';
echo '<p>' . $row['description'] . '</p>';

echo '<p>Key skills include:</p>';
echo '<ul>';
        foreach ($skills as $skill): 
            echo '<li>' . trim($skill) . '</li>';
        endforeach;
echo '</ul>';

echo '<p>';
echo '        Salary: $' . number_format($row['salary_min']) . ' - ';
echo '$' . number_format($row['salary_max']) . ' per year';
echo '</p>';
echo '<br><br>';
echo '</section>';

    }
} else {
    echo "<p>No jobs found.</p>";
}

mysqli_close($conn);
?>

<?php
include 'nav.inc';
include 'footer.inc'; ?>
