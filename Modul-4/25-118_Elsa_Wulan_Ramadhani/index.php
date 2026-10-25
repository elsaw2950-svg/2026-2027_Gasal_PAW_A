
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Personal Information</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff0f5;
            margin: 0;
            padding: 40px 15px;
        }

        .container {
            max-width: 550px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px #e8b8ca;
        }

        h2 {
            color: #c04d7c;
        }

        .field {
            margin-bottom: 15px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #694455;
        }

        input[type="text"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #e5b7c8;
            border-radius: 6px;
        }

        .choice label {
            display: inline-block;
            margin-right: 12px;
            font-weight: normal;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"] {
            background: #d85f91;
            color: white;
        }

        input[type="reset"] {
            background: #f3dce6;
        }

        .error {
            color: #b4234d;
        }

        .success {
            color: #247a45;
        }
    </style>
</head>
<body>

<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    require 'validate.inc';

    validateName($errors, $_POST, 'surname');

    if (!empty($errors)) {
        echo '<div class="container error">';
        echo '<h2>There are some errors</h2>';

        foreach ($errors as $field => $message) {
            echo '<p>' . htmlspecialchars($field) . ': '
                . htmlspecialchars($message) . '</p>';
        }

        echo '</div>';

        include 'form.inc';

    } else {
        echo '<div class="container success">';
        echo '<h2>Submission Successful!</h2>';
        echo '<p>Your form has been submitted without errors.</p>';
        echo '<a href="index.php">Back to Form</a>';
        echo '</div>';
    }

} else {
    include 'form.inc';
}
?>

</body>
</html>
