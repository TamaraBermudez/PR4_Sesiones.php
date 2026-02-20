<?php
session_start();

if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [
        'milk' => 0,
        'soft_drink' => 0
    ];
}

//q el nombre se guarde
if (!isset($_SESSION['worker_name'])) {
    $_SESSION['worker_name'] = "";
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //para cambiar el nom
    if (isset($_POST['worker_name'])) {
        $_SESSION['worker_name'] = $_POST['worker_name'];
    }

    $product = $_POST['product'];
    $quantity = (int)$_POST['quantity'];

    //con esto añadimos las unidades
    if (isset($_POST['add'])) {
        if ($quantity > 0) {
            $_SESSION['inventory'][$product] += $quantity;
        }
    }

    //control de errores (lo puse porq me daba un error muy raro)
    if (isset($_POST['remove'])) {
        if ($quantity > $_SESSION['inventory'][$product]) {
            $error_message = "Error: No puedes quitar más unidades de las que hay.";
        } else {
            $_SESSION['inventory'][$product] -= $quantity;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exercise 02 - Supermarket</title>
</head>
<body>

    <h1>Supermarket management</h1>

    <form method="post" action="Exercise02.php">
        <p>
            Worker name: 
            <input type="text" name="worker_name" value="<?php echo htmlspecialchars($_SESSION['worker_name']); ?>">
        </p>

        <h3>Choose product:</h3>
        <select name="product">
            <option value="milk">Milk</option>
            <option value="soft_drink">Soft Drink</option>
        </select>

        <h3>Product quantity:</h3>
        <input type="number" name="quantity" min="1">
        <br><br>

        <button type="submit" name="add">add</button>
        <button type="submit" name="remove">remove</button>
        <button type="reset">reset</button>
    </form>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <h2>Inventory:</h2>
    <p>worker: <?php echo htmlspecialchars($_SESSION['worker_name']); ?></p>
    <p>units milk: <?php echo $_SESSION['inventory']['milk']; ?></p>
    <p>units soft drink: <?php echo $_SESSION['inventory']['soft_drink']; ?></p>

</body>
</html>