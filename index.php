<?php
function autoloadClass($className)
{
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $srcClassFile = 'class' . DIRECTORY_SEPARATOR . $className . '.class.php';

    if (file_exists($srcClassFile)) {
        include "$srcClassFile";
    }
}

spl_autoload_register('autoloadClass');

$tableName = 'delivery_tariff';

$table = new Table($tableName);
$tableList = $table->getTableList();

if (!empty($_GET['edit_field']) && $_GET['action'] === 'delete') {
    $tableName = $_GET['table_name'];
    $fieldName = $_GET['edit_field'];

    $table->deleteField($tableName, $fieldName);
}

if (!empty($_POST['save_name']) && !empty($_POST['new_field_name'])) {
    $newFieldName = $_POST['new_field_name'];
    $tableName = $_GET['table_name'];
    $fieldName = $_GET['edit_field'];
    $fieldType = $_GET['type'];

    $table->editNameField($tableName, $fieldName, $newFieldName, $fieldType);
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление таблицами и базами данных</title>

    <style>
        table {
            border: 1px solid;
            border-collapse: collapse;
        }
        th {
            background: lightgray;
        }
        th, td {
            padding: 4px 8px;
            border: 1px solid;
        }
    </style>
</head>
<body>
    <h2>Список таблиц</h2>

    <ul>
        <?php foreach ($tableList as $li) :?>
        <li><a href="index.php?table_name=<?=$li['Tables_in_' . $table->getDBName()]?>"><?=$li['Tables_in_' . $table->getDBName()]?></a></li>
        <?php endforeach; ?>
    </ul>

<?php
if (!empty($_GET['table_name'])) :
    $tableName = $_GET['table_name'];
    $tableDesc = $table->getTableDescription($tableName);
?>

    <h2>Описание таблицы <?=$tableName?></h2>
    <table>
    <tr>
        <th>Название поля</th>
        <th>Тип значения</th>
        <th>NULL</th>
        <th>KEY</th>
        <th>Значение по умолчанию</th>
        <th>Extra</th>
        <th>Операции</th>
    </tr>
    <?php foreach ($tableDesc as $row) : ?>
    <tr>
        <td><?=(!empty($_GET['action']) && $_GET['edit_field'] === $row['Field'] && $_GET['action'] === 'edit_name') ?
                $table->getTextForm($row['Field']) : $row['Field']?></td>
        <td><?=$row['Type']?></td>
        <td><?=$row['Null']?></td>
        <td><?=$row['Key']?></td>
        <td><?=$row['Default']?></td>
        <td><?=$row['Extra']?></td>
        <td>
            <a href="index.php?table_name=<?=$tableName?>&edit_field=<?=$row['Field']?>&action=delete">удалить поле</a> |
            <a href="index.php?table_name=<?=$tableName?>&edit_field=<?=$row['Field']?>&type=<?=$row['Type']?>&action=edit_name">изменить название</a> |
            <a href="index.php?table_name=<?=$tableName?>&edit_field=<?=$row['Field']?>&action=edit_type">изменить тип данных</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>