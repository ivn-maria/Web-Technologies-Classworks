<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Таблица за умножение</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i = 2; $i < 10; $i++) {
                    echo "<tr>";

                    for($j = 1; $j < 10; $j++) {
                        echo "<td>" . $i*$j . "</td>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>

</html>