<?php
session_start();
include("../includes/db.php");

$requests = mysqli_query($conn, "SELECT * FROM admin_requests WHERE status='pending'");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Requests</title>
</head>

<body>

    <h2>Pending Admin Requests</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Approve</th>
            <th>Reject</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($requests)) { ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>

                <td>
                    <a href="approve_admin.php?id=<?php echo $row['id']; ?>">Approve</a>
                </td>

                <td>
                    <a href="reject_admin.php?id=<?php echo $row['id']; ?>">Reject</a>
                </td>

            </tr>

        <?php } ?>

    </table>

</body>

</html>