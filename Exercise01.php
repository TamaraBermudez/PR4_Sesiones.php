<?php
session_start();

//iniciamos el array si no existe (si existe ps na)
if (!isset($_SESSION['numeros'])) {
    $_SESSION['numeros'] = [10, 20, 30];
}

$mensaje_average = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //modifica el array (es lo q hace q cuando le das al boton, cumpla su función)
    if (isset($_POST['modify'])) {
        $pos = $_POST['position'];
        $val = $_POST['new_value'];

        //solo se actualiza si no esta vacio
        if ($val !== "" && isset($_SESSION['numeros'][$pos])) {
            $_SESSION['numeros'][$pos] = (int)$val;
        }
    }

    //esto es lo q calcula el promedio
    if (isset($_POST['average'])) {
        $mensaje_average = "Average: " . number_format(array_sum($_SESSION['numeros']) / 3, 2);
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Modify array saved in session</h1>

    <form method="post">
        <label>Position to modify:</label>
        <select name="position">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <br><br>

        <label>New value:</label>
        <input type="number" name="new_value"> 
        <br><br>

        <button type="submit" name="modify">Modify</button>
        <button type="submit" name="average">Average</button>
        <button type="reset">Reset</button>
    </form>

    <p>Current array: <?php echo implode(", ", $_SESSION['numeros']); ?></p>
    <p><?php echo $mensaje_average; ?></p>
</body>
</html>