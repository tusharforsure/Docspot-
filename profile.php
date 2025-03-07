<?php
require_once('./connection.php');
session_start();

try {
    $conn = Teledoc::connect();

    // Fetch user details
    $query = "SELECT * FROM info WHERE user_type = 2 AND id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($user);
    // Fetch appointment details
    $query = "SELECT d.name, da.appointment_time, da.date, da.cost, da.app_id FROM doctor d INNER JOIN doctor_availablity da ON da.doc_id = d.IndexNumber WHERE da.user_id = :user_id";
    $ccstmt = $conn->prepare($query);
    $ccstmt->bindParam(':user_id', $_SESSION['user_id']);
    $ccstmt->execute();

} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

$query = "DELETE from doctor_availablity where app_id = :app_id;";
$appstmt = $conn->prepare($query);
$appstmt->bindParam(':app_id', $_POST['app_id']);
$appstmt->execute();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
 
    <style>
        /* Custom styles */
        .card {
            background-image: url('bg2.jpg'); /* Add background image */
            background-size: cover;
            background-position: center;
            padding: 30px;
            border-radius: 10px;
            margin-top: 20px; /* Add margin to the top */
        }

        

        .btn {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: bold;
        }
        body {
            background-image: url('4077.jpg'); /* Add background image */
            background-size: cover;
            background-position: center;
        }
        
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Profile</h3>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex flex-column">
                        <label for="username" class="font-weight-bold">Username:</label>
                        <input type="text" readonly class="form-control" id="username" value="<?php echo $user['name']; ?>">
                    </div>
                    <div class="form-group d-flex flex-column">
                        <br><label for="email" class="font-weight-bold">Email:</label>
                        <input type="email" readonly class="form-control" id="email" value="<?php echo $user['email']; ?>">
                    </div>
                    <!-- Table to display appointment details -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Appointment Time</th>
                                    <th>Date</th>
                                    <th>Cost</th>
                                    <th>Action</th> <!-- New column for action buttons -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user_details = $ccstmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo $user_details['name']; ?></td>
                                        <td><?php echo date('j F, Y', strtotime($user_details['appointment_time'])); ?></td>
                                        <td><?php echo date('j F, Y', strtotime($user_details['date'])); ?></td>
                                        <td><?php echo $user_details['cost']; ?></td>
                                        <td>
                                            <form method="post" action="profile.php">
                                                <input type="hidden" name="app_id" value="<?php echo $user_details['app_id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete Booking</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="position: fixed; top: 20px; right: 20px;">
        <a href="index.php" class="btn btn-primary d-block mb-2">Home</a>
        <a href="search.php" class="btn btn-success d-block">Search</a>
    </div>
</div>










<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body>
</html>
