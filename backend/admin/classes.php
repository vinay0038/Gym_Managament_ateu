<?php
//include '../admin_auth.php';
include '../database/database.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM classes WHERE id=$id");
}

$classes = $conn->query("SELECT * FROM classes");
?>

<h2>Manage Classes</h2>
<form method="POST" action="process_class.php">
    <input type="text" name="name" placeholder="Class Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="text" name="schedule" placeholder="Schedule" required>
    <input type="text" name="trainer" placeholder="Trainer Name" required>
    <button type="submit">Add Class</button>
</form>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Schedule</th>
        <th>Trainer</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $classes->fetch_assoc()): ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['schedule'] ?></td>
        <td><?= $row['trainer'] ?></td>
        <td>
            <a href="classes.php?delete=<?= $row['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
