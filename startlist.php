<?php
require_once("config.php");
require_once ("db.php");

db::connect(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);

$error_message_insert = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $category = $_POST["category"];
    $pb = $_POST["pb"];

    if (empty($name) || empty($surname) || empty($category) || empty($pb)) {
        $error_message_insert = "All fields are required.";
    } else {
        db::query("INSERT INTO startlist (name, surname, category, pb) VALUES (?,?,?,?)", $name, $surname, $category, $pb);
    }
}

$filter_name = isset($_GET['filter-name']) ? $_GET['filter-name'] : '';
$filter_surname = isset($_GET['filter-surname']) ? $_GET['filter-surname'] : '';
$filter_category = isset($_GET['filter-category']) ? $_GET['filter-category'] : '';

$filter_sql = "SELECT * FROM startlist WHERE 1=1";

if (!empty($filter_name)) {
    $filter_sql .= " AND name LIKE '%$filter_name%'";
}
if (!empty($filter_surname)) {
    $filter_sql .= " AND surname LIKE '%$filter_surname%'";
}
if (!empty($filter_category)) {
    $filter_sql .= " AND category = '$filter_category'";
}

$data = db::queryAll($filter_sql);


if (empty($data)) {
    $error_message = "No records found.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startlist | JumpDBThrow</title>
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
        <h2 class="mb-4">Insert a New Athlete</h2>
        <?php if (!empty($error_message_insert)): ?>
            <div class="alert alert-danger"><?php echo $error_message_insert; ?></div>
        <?php endif; ?>
        <form method="post" class="mb-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" class="form-control">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control">
                    <option value="MZI">Men</option>
                    <option value="JKY">Juniors</option>
                    <option value="DCI">Youth</option>
                    <option value="ZKY">Girls</option>
                    <option value="ZCI">Boys</option>
                    <option value="VTY">Veteran Women</option>
                    <option value="ZNY">Women</option>
                    <option value="MZK">Younger Girls</option>
                    <option value="JRI">Junior Boys</option>
                    <option value="VRI">Veteran Men</option>
                    <option value="MZC">Younger Boys</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pb">Personal Best</label>
                <input type="text" id="pb" name="pb" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr class="mb-4">

        <h2 class="mb-4">Filter</h2>
        <form method="get" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="filter-name">Name</label>
                    <input type="text" id="filter-name" name="filter-name" class="form-control" value="<?php echo $filter_name; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="filter-surname">Surname</label>
                    <input type="text" id="filter-surname" name="filter-surname" class="form-control" value="<?php echo $filter_surname; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="filter-category">Category</label>
                    <select name="filter-category" id="filter-category" class="form-control">
                        <option value="">Select Category</option>
                        <option value="MZI" <?php if ($filter_category == 'MZI') echo 'selected'; ?>>Men</option>
                        <option value="JKY" <?php if ($filter_category == 'JKY') echo 'selected'; ?>>Juniors</option>
                        <option value="DCI" <?php if ($filter_category == 'DCI') echo 'selected'; ?>>Youth</option>
                        <option value="ZKY" <?php if ($filter_category == 'ZKY') echo 'selected'; ?>>Girls</option>
                        <option value="ZCI" <?php if ($filter_category == 'ZCI') echo 'selected'; ?>>Boys</option>
                        <option value="VTY" <?php if ($filter_category == 'VTY') echo 'selected'; ?>>Veteran Women</option>
                        <option value="ZNY" <?php if ($filter_category == 'ZNY') echo 'selected'; ?>>Women</option>
                        <option value="MZK" <?php if ($filter_category == 'MZK') echo 'selected'; ?>>Younger Girls</option>
                        <option value="JRI" <?php if ($filter_category == 'JRI') echo 'selected'; ?>>Junior Boys</option>
                        <option value="VRI" <?php if ($filter_category == 'VRI') echo 'selected'; ?>>Veteran Men</option>
                        <option value="MZC" <?php if ($filter_category == 'MZC') echo 'selected'; ?>>Younger Boys</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="startlist.php" class="btn btn-secondary ml-2">Reset</a>
        </form>

        <hr class="mb-4">

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php else: ?>
            <h2 class="mb-4">Start List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Identification Number</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Category</th>
                        <th>Personal Best</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $d): ?>
                        <tr>
                            <td><?php echo $d["id"]; ?></td>
                            <td><?php echo $d["name"]; ?></td>
                            <td><?php echo $d["surname"]; ?></td>
                            <td><?php echo $d["category"]; ?></td>
                            <td><?php echo $d["pb"]; ?> cm</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>
