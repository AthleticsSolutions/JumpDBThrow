<?php
require_once("config.php");
require_once ("db.php");

db::connect(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);


$winners_query = "SELECT s.category, s.name, s.surname, s.pb, r.result FROM startlist s LEFT JOIN results r ON s.id = r.startlist_id WHERE r.result IS NOT NULL GROUP BY s.id ORDER BY s.category, r.result DESC";
$winners_data = db::queryAll($winners_query);


$category_winners = array();


foreach ($winners_data as $winner) {
    $category = $winner["category"];
    if (!isset($category_winners[$category])) {
        $category_winners[$category] = array();
    }

    if (count($category_winners[$category]) < 3) {
        $category_winners[$category][] = $winner;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winners | JumpDBThrow</title>
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

        .podium {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .place {
            flex: 1;
            text-align: center;
            padding: 20px;
            background-color: #222; 
            border-radius: 10px;
            margin: 10px;
        }

        .place h4 {
            margin-bottom: 10px;
            font-size: 24px; 
        }

        .place p {
            margin: 5px 0;
        }



        .result {
            color: #ffcc00; 
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
        <h2 class="mb-4">Winners</h2>

        <?php foreach ($category_winners as $category => $winners): ?>
            <h3><?php echo $category; ?></h3>
            <div class="podium">
                <div class="place">
                    <h4>2nd</h4>
                    <?php if (isset($winners[1])): ?>
                        <p><?php echo $winners[1]["name"] . " " . $winners[1]["surname"]; ?></p>
                       
                        <?php if ($winners[1]["result"] > $winners[1]["pb"]): ?>
                       
                        <?php endif; ?>
                        <p class="result"><?php echo $winners[1]["result"]; ?> cm</p>
                        <br>
                        <p class="text-muted">Personal Best: <?php echo $winners[1]["pb"]; ?> cm</p>
                    <?php endif; ?>
                </div>
                <div class="place">
                    <h4>1st</h4>
                    <?php if (isset($winners[0])): ?>
                        <p><?php echo $winners[0]["name"] . " " . $winners[0]["surname"]; ?></p>
                        
                        <?php if ($winners[0]["result"] > $winners[0]["pb"]): ?>
                  
                        <?php endif; ?>
                        <p class="result"><?php echo $winners[0]["result"]; ?> cm</p>
                        <br>
                        <p class="text-muted">Personal Best: <?php echo $winners[0]["pb"]; ?> cm</p>
                    <?php endif; ?>
                </div>
                <div class="place">
                    <h4>3rd</h4>
                    <?php if (isset($winners[2])): ?>
                        <p><?php echo $winners[2]["name"] . " " . $winners[2]["surname"]; ?></p>
                      
                        <?php if ($winners[2]["result"] > $winners[2]["pb"]): ?>
                   
                        <?php endif; ?>
                        <p class="result"><?php echo $winners[2]["result"]; ?> cm</p>
                        <br>
                        <p class="text-muted">Personal Best: <?php echo $winners[2]["pb"]; ?> cm</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>
