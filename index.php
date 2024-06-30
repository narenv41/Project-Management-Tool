<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

// Fetch tasks from the database
$inProgressTasks = $conn->query("SELECT * FROM tasks WHERE progress < 100");
$completedTasks = $conn->query("SELECT * FROM tasks WHERE progress = 100");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="jumbotron text-center">
    <h1 class="display-4">Project Management Tool</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">
        Add Task
    </button>
</div>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h3>In Progress</h3>
            <div class="card-columns">
                <?php if ($inProgressTasks->num_rows > 0): ?>
                    <?php while($task = $inProgressTasks->fetch_assoc()): ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $task['title']; ?></h5>
                            <p class="card-text">Deadline:<?php echo $task['date']; ?></p>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo $task['progress']; ?>%;" aria-valuenow="<?php echo $task['progress']; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $task['progress']; ?>%
                                </div>
                            </div>
                            <button class="btn btn-success complete-task" data-id="<?php echo $task['id']; ?>">Complete</button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No in-progress tasks found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>Completed</h3>
            <div class="card-columns">
                <?php if ($completedTasks->num_rows > 0): ?>
                    <?php while($task = $completedTasks->fetch_assoc()): ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $task['title']; ?></h5>
                            <p class="card-text"><?php echo $task['date']; ?></p>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    100%
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No completed tasks found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="progress">Progress</label>
                        <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#addTaskForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.post('add_task.php', formData, function(response) {
                console.log(response); // Log the response for debugging
                location.reload();
            });
        });

        $('.complete-task').on('click', function() {
            var taskId = $(this).data('id');
            $.post('complete_task.php', { id: taskId }, function(response) {
                console.log(response); // Log the response for debugging
                location.reload();
            });
        });
    });
</script>

</body>
</html>
