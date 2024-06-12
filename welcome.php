<?php
include 'user-nav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">View Events</h5>
                        <p class="card-text">Click here to view upcoming events.</p>
                        <a href="user-home.php" class="btn btn-primary">View Events</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Post Event</h5>
                        <p class="card-text">Click here to post a new event.</p>
                        <a href="user-post-event.php" class="btn btn-primary">Post Event</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">view the invites</h5>
                        <p class="card-text">Click here to view the invited events.</p>
                        <a href="view-invite.php" class="btn btn-primary">view invites</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
