<?php

require_once ("db.php");
db::connect("localhost", "athleticsdb", "root", "");

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['results'] as $startlist_id => $result) {
        if (empty ($result) || !is_numeric($result)) {
            $error_message = "The result must be a number.";
            break;
        } else {

            db::query("UPDATE results SET result = ? WHERE startlist_id = ?", $result, $startlist_id);
        }
    }
}

$data = db::queryAll("SELECT s.*, r.result FROM startlist s LEFT JOIN results r ON s.id = r.startlist_id GROUP BY s.id");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results | JumpDBThrow</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }

        .navbar {
            background-color: #212529;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .nav-item {
            margin-right: 10px;
        }

        .nav-link {
            color: #ffffff;
        }

        .nav-link:hover {
            color: #cccccc;
        }

        .form-control {
            background-color: #343a40;
            border-color: #6c757d;
            color: #ffffff;
        }

        .table {
            background-color: #343a40;
            color: #ffffff;
        }

        .table th,
        .table td {
            border-color: #6c757d;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand">JumpDBThrow</a>
            <ul class="navbar-nav ml-auto d-flex flex-row">
                <li class="nav-item">
                    <a href="startlist.php" class="nav-link">Start List</a>
                </li>
                <li class="nav-item">
                    <a href="results.php" class="nav-link">Results</a>
                </li>
                <li class="nav-item">
                    <a href="winners.php" class="nav-link">Winners</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container py-4">
        <h2 class="mb-4">Results</h2>
        <?php if (!empty ($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table class="table">
                <thead>
                    <tr>
                        <th>Identification Number</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Category</th>
                        <th>Personal Best</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $d) { ?>
                        <tr>
                            <td>
                                <?php echo $d["id"]; ?>
                            </td>
                            <td>
                                <?php echo $d["name"]; ?>
                            </td>
                            <td>
                                <?php echo $d["surname"]; ?>
                            </td>
                            <td>
                                <?php echo $d["category"]; ?>
                            </td>
                            <td>
                                <?php echo $d["pb"]; ?> cm
                            </td>
                            <td><input type="number" name="results[<?php echo $d["id"]; ?>]" class="form-control"
                                    value="<?php echo $d["result"]; ?>"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Save Results</button>
        </form>
    </div>

</body>

</html>