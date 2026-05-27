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

<h1>Jobs Descriptions</h1>
<div class="jobs-container">
<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $skills = explode(",", $row['skills']); /* I asked claude how to split the skills into an array, this was the result of my question. */
?>
<section class="job-card">

    <h2><?php echo $row['title']; ?></h2>

    <p><?php echo $row['description']; ?></p>

    <p>Key skills include:</p>
    <ul>
        <?php foreach ($skills as $skill): ?>
            <li><?php echo trim($skill); ?></li>
        <?php endforeach; ?>
    </ul>

    <p>
        <?php echo $row['job_code']; ?> - 
        Salary: $<?php echo number_format($row['salary_min']); ?> - 
        $<?php echo number_format($row['salary_max']); ?> per year
    </p>

</section>
<?php
    }
} else {
    echo "<p>No jobs found.</p>";
}

mysqli_close($conn);
?>
</div>

<?php
include 'nav.inc';
include 'footer.inc'; ?>
</body>
</html>