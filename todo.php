<?php

require_once 'app/init.php';
$itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items
    WHERE user = :user
");

$itemsQuery->execute([
    'user' => $_SESSION['user_id']
]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="./css/todo.css">
</head>
<body>
    <div class="list">
        <h1 class="header">TODO</h1>

        <?php if(!empty($items)): ?>
            <ul class="items">
                <?php foreach($items as $item): ?>
                    <li>
                        <?php if ($item['done']): ?>
                            <a href="command.php?as=notdone&item=<?php echo $item['id']; ?>" class="done-button" ></a>
                        <?php else: ?>
                            <a href="command.php?as=done&item=<?php echo $item['id']; ?>" class="item-button"></a>
                        <?php endif; ?>
                        <span class="item  <?php echo $item['done'] ? ' done' : '' ?>" ><?php echo $item['name']; ?></span>
                        <a href="command.php?as=delete&item=<?php echo $item['id']; ?>" class="delete-button">x</a>
                    </li>

                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You haven't added any items yet. </p>
        <?php endif; ?>
        <form class="item-add" action="add.php" method="post">
            <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
            <input type="submit" value="Add" class="submit">
        </form>
    </div>
</body>
</html>