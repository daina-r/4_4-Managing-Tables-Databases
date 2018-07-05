<?php
class Table extends Connection
{
    /*Конструктор создает новую таблицу, если ее нет в БД*/
    public function __construct($tableName)
    {
        $sqlCreate =
            "CREATE TABLE IF NOT EXISTS `$tableName` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(50) NOT NULL,
              `cost` tinyint(5) NOT NULL DEFAULT '0',
              `using` tinyint(4) NOT NULL DEFAULT '0',
              PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $statement = $this->getConnection()->prepare($sqlCreate);
        $statement->execute();
    }

    /*Возвращает ассоциативный массив со списком таблиц из БД*/
    public function getTableList()
    {
        $sqlShowTables = "SHOW TABLES";
        $statement = $this->getConnection()->prepare($sqlShowTables);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /*Возвращает ассоциативный массив с описанием таблицы*/
    public function getTableDescription($tableName)
    {
        $sqlTableDesc = "DESCRIBE `$tableName`";
        $statement = $this->getConnection()->prepare($sqlTableDesc);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /*Удаляет поле из таблицы*/
    public function deleteField($tableName, $fieldName)
    {
        $sqlDelete ="ALTER TABLE `$tableName` DROP COLUMN `$fieldName`" ;
        $statement = $this->getConnection()->prepare($sqlDelete);
        $statement->execute();
    }

    /*Возвращает форму для изменения названия поля*/
    public function getTextForm($fieldName)
    {
        return
        "<form method='post'>
            <input name='new_field_name' type='text' value='$fieldName'>
            <input name='save_name' type='submit' value='Сохранить'>
         </form>";
    }

    /*Изменяет название поля*/
    public function editNameField($tableName, $fieldName, $newFieldName, $fieldType)
    {
        $sqlUpdate = "ALTER TABLE `$tableName` CHANGE `$fieldName` `$newFieldName` $fieldType";
        $statement = $this->getConnection()->prepare($sqlUpdate);
        $statement->execute();
        header("Location: index.php?table_name=$tableName");
    }
}