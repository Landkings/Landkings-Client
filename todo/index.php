<?php 
    include('conn.php'); 
    include('handler_new_task.php');
	$query = "SELECT * FROM list ORDER BY id DESC";
	$result = mysqli_query($conn, $query);
?>
<!doctype html>
<html>
	<head>
		<title>TODO LIST</title>
		<meta charset="utf-8">
        <link href="foundation-icons/foundation-icons.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
        <link href="css/foundation.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
	</head>
	<body>
        <div class="row">
            <div class="small-12 columns">
                <br>
                <div class="reveal" id="NewTaskModal" data-reveal>
                    <button class="close-button" data-close aria-label="Закрыть окно" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Добавление новой задачи</h4>
                    <form action="index.php" method="POST">
                        <div class="row">
                            <div class="small-12 column">
                                <div class="form-floating-label">
                                    <input type="text" id="title" name="title">
                                    <label for="title" id="title-label">Название задачи (осталось 100 символов)</label>
                                </div>
                            </div>
                            <div class="small-12 column">
                                <div class="form-floating-label">
                                    <textarea name="description" rows="5" id="description"></textarea>
                                    <label for="textarea" id="description-label">Краткое описание задачи (осталось 255 символов)</label>
                                </div>
                            </div>
                            <div class="small-12 column">
                                <br>
                                <input type="submit" name="submit" class="button button-rounded-hover">
                            </div>
                        </div>
                    </form>
                </div>
                <p>
                    <button class="button" data-open="NewTaskModal">Добавить новую задачу</button>
                    <a href="http://progra2r.bget.ru">
                        <button class="button">В landkings</button>
                    </a>
                </p>
                <table>
                    <tr>
                        <th>Номер:</th>
                        <th>Задача:</th>
                        <th class="hide-for-small-only">Описание задачи:</th>
                        <th>Статус:</th>
                    </tr>
                    <?php
                        $cnt = 1;
                        while($row = mysqli_fetch_array($result)){
                            if ($row["status"] == 1){
                                printf("<tr class='success-task task-%s'>", $row['id']);
                            }
                            else if ($row["status"] == -1){
                                printf("<tr class='lose-task task-%s'>", $row['id']);
                            }
                            else{
                                printf("<tr class='task-%s'>", $row['id']);
                            }
                            printf("<td class='cell border-right width10'>%d</td>", $cnt);
                            printf("<td class='cell width30'>%s</td>", $row['name']);
                            printf("<td class='cell width45 hide-for-small-only'>%s</td>", $row['description']);
                            printf("
                                    <td class='cell width15'>
                                        <form action='index.php' method='POST' id='form-with-buttons'>
                                            <button type='submit' name='complete' class='success button success-button' id='id-%s'><i class='fi-clock'></i></button>
                                            <button type='submit' name='uncomplete' class='alert button lose-button' id='id-%s'><i class='fi-minus-circle'></i></button>
                                            <button type='submit' name='delete' class='secondary button delete-button' id='id-%s'><i class='fi-x-circle'></i></button>
                                        </form>
                                    </td>
                            ", $row['id'], $row['id'], $row['id']);
                            printf("</tr>");
                            $cnt += 1;
                        }
                    ?>
                </table>
            </div>
        </div>
        <script src="js/vendor/jquery.js"></script>
        <script src="js/vendor/what-input.js"></script>
        <script src="js/vendor/foundation.js"></script>
        <script src="js/app.js"></script>
        <script src="js/vendor/add_task_form.js"></script>
        <script src="js/vendor/handler_delete_button.js"></script>
        <script src="js/vendor/handler_success_button.js"></script>
        <script src="js/vendor/handler_lose_button.js"></script>
        <script src="js/vendor/handler_remain_characters.js"></script>
	</body>
</html>