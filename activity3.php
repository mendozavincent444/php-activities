<?php
function conn_db(){
    try {
        $pdo = new PDO('mysql:host=localhost:3306;dbname=pointofsale_mendoza', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $exception) {
        echo "Connection Error: ", $exception->getMessage();
    }
}

function addMenu($menuName, $menuDesc, $price){
    $db = conn_db();
    $sql = "INSERT INTO ref_menu (menu_name, menu_desc, price) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$menuName, $menuDesc, $price]);
    $db = null;
}

function findMenu($id){
    $db = conn_db();
    $sql = "SELECT * FROM ref_menu WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $menus = $stmt->fetch(PDO::FETCH_ASSOC);
    $db = null;
    return $menus;
}

function viewMenus(){
    $db = conn_db();
    $sql = "SELECT * FROM ref_menu ORDER BY id ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
    return $menus;
}

function updateMenu($menuName, $menuDesc, $price, $id){
    $db = conn_db();
    $sql = "UPDATE ref_menu SET menu_name=?, menu_desc=?, price=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$menuName, $menuDesc, $price, $id]);
    $db = null;
}

function deleteMenu($id){
    $db = conn_db();
    $sql = "DELETE FROM ref_menu WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $db = null;
}

if (isset($_POST['submit'])) {
    $menuName = trim($_POST['menuName']);
    $menuDesc = trim($_POST['menuDesc']);
    $price = trim($_POST['price']);

    if (isset($_POST['updateID'])) {
        $id = $_POST['updateID'];
        updateMenu($menuName, $menuDesc, $price, $id);
    } else {
        addMenu($menuName, $menuDesc, $price);
    }
}

$rowToEdit = null;

if (isset($_POST['edit'])) {
    $editId = trim($_POST['edit']);
    $editedMenu = findMenu($editId);
    $rowToEdit = $editedMenu;
}

if (isset($_POST['delete'])) {
    $id = trim($_POST['delete']);
    deleteMenu($id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>ACTIVITY 3</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 p-2">
                <form method="post" enctype="multipart/form-data" class="w-100">
                    <h2><b><?php echo empty($rowToEdit) ? 'CREATE' : 'UPDATE' ?> MENU <?php echo empty($rowToEdit) ? '' : '#' . $rowToEdit['id'] ?></b></h2>
                    <?php if (!empty($rowToEdit)) : ?> <input name="updateID" value="<?php echo $rowToEdit['id'] ?>" hidden /><?php endif; ?>
                    <div>
                        <div class="form-group">
                            <label>Menu name: </label>
                            <input class="form-control w-100" type="text" name="menuName" value="<?php echo empty($rowToEdit) ? '' : $rowToEdit['menu_name'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Menu description: </label>
                            <textarea class="form-control w-100" name="menuDesc" rows="2"><?php echo empty($rowToEdit) ? '' : $rowToEdit['menu_desc'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Price: </label>
                            <input class="form-control w-100" type="text" name="price" value="<?php echo empty($rowToEdit) ? '' : $rowToEdit['price'] ?>" />
                        </div>
                        <button class="btn btn-primary" type="submit" name="submit" style="">Submit</button>
                        <br>
                        <br>
                    </div>
                </form>

                <div class="text-center">
                    <table class="table table-bordered table-hover w-full p-2">
                        <tr>
                            <td style="text-align: center;"><b>ID</b></td>
                            <td style="text-align: center;"><b>MENU NAME</b></td>
                            <td style="text-align: center;"><b>MENU DESCRIPTION</b></td>
                            <td style="text-align: center;"><b>PRICE</b></td>
                            <td style="text-align: center;"><b>ACTION</b></td>
                        </tr>
                        <?php
                        $rows = viewMenus();
                        foreach ($rows as $row) : ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['menu_name'] ?></td>
                                <td><?php echo $row['menu_desc'] ?></td>
                                <td><?php echo $row['price'] ?></td>
                                <td>
                                    <form method="POST">
                                        <button class="btn btn-primary" name="edit" value="<?php echo $row['id'] ?>">Edit</button>
                                        <button class="btn btn-danger" name="delete" value="<?php echo $row['id'] ?>">&#10006;</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($rows)) : ?>
                            <tr>
                                <td colspan="5" class="text-center">No menu data available...</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>