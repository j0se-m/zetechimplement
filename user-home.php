
<?php
include 'user-nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// Define the query based on the filter
$sql = "SELECT events.*, crud.first_name FROM events INNER JOIN crud ON events.user_id = crud.id";
if ($filter == 'approved') {
    $sql .= " WHERE events.approved = 1";
} elseif ($filter == 'disapproved') {
    $sql .= " WHERE events.approved = 0";
}
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-bottom: 30px;
        }
        .card {
            height: auto;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-bottom: 30px;
            position: relative; /* Ensure card is relative positioned */
            padding-bottom: 60px; /* Space for buttons */
        }
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #1C1D3C;
        }
        .btn-edit, .btn-delete {
            margin-right: 5px;
        }
        .btn-container {
            position: absolute;
            bottom: 15px; /* Adjust as necessary for spacing */
            right: 15px;  /* Adjust as necessary for spacing */
            display: flex;
            gap: 10px; /* Space between buttons */
        }
        .card-text small {
            display: block;
            margin-bottom: 10px; /* Ensure space for the buttons */
        }
        .filter-form {
            margin-bottom: 20px;
        }
        /* Smaller buttons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="POST" class="filter-form">
        <div class="form-group">
            <label for="filter">Filter Events:</label>
            <select name="filter" id="filter" class="form-control">
                <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Events</option>
                <option value="approved" <?php echo $filter == 'approved' ? 'selected' : ''; ?>>Approved Events</option>
                <option value="disapproved" <?php echo $filter == 'Pending' ? 'selected' : ''; ?>>Disapproved Events</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Apply Filter</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-lg-4 col-md-6 mt-5">';
            echo '<div class="card h-100">';
            if (!empty($row['image'])) {
                $image_url = "uploads/" . $row['image'];
            } else {
                $image_url = "path_to_placeholder_image.jpg";
            }
            echo '<img src="' . $image_url . '" class="card-img-top" style="object-fit: cover; height: 150px;" alt="' . $row['name'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['name'] . '</h5>';
            echo '<p class="card-text">' . substr($row['description'], 0, 100) . '...</p>';
            echo '<p class="card-text"><small class="text-muted">Posted by ' . htmlspecialchars($row['first_name']) . ' on ' . date('F j, Y', strtotime($row['created_at'])) . '</small></p>';
            echo '<div class="btn-container">';
            echo '<a href="user-readmore.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Read More</a>';

            // Show edit and delete buttons only if the event is posted by the current user and not approved yet
            if ($row['user_id'] == $user_id && $row['approved'] == 0) {
                echo '<a href="edit-event.php?id=' . $row['id'] . '" class="btn btn-warning btn-edit btn-sm">Edit</a>';
                echo '<a href="delete-event.php?id=' . $row['id'] . '" class="btn btn-danger btn-delete btn-sm" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a>';
            } else if ($row['user_id'] != $user_id) {
                // Join Event button for events posted by other users
                echo '<a href="join-event.php?id=' . $row['id'] . '" class="btn btn-success btn-sm">Join Event</a>';
            }

            echo '</div>'; // Close btn-container
            echo '</div>'; // Close card-body
            echo '</div>'; // Close card
            echo '</div>'; // Close col
        }
        echo '</div>'; // Close row
    } else {
        echo "No events found";
    }
    $conn->close();
    ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include 'footer.php';
?>