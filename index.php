<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
       <?php

        $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
        $conexion = new PDO('mysql:host=localhost;dbname=final_8046', 'root', '', $pdo_options);

        if (isset($_POST["accion"])){
            // echo "Quieres " . $_POST["accion"];
             if ($_POST["accion"] == "Crear"){
                 $insert = $conexion->prepare("INSERT INTO alumno (Carnet, Nombre, Grado, Telefono) VALUES
                 (:Carnet,:Nombre,:Grado,:Telefono)");
                 $insert->bindValue('Carnet', $_POST['Carnet']);
                 $insert->bindValue('Nombre', $_POST['Nombre']);
                 $insert->bindValue('Grado', $_POST['Grado']);
                 $insert->bindValue('Telefono', $_POST['Telefono']);
                 $insert->execute();
             }
             if ($_POST["accion"] == "Editado"){
                $update = $conexion->prepare("UPDATE alumno SET Nombre=:Nombre, Grado=:Grado, 
                Telefono=:Telefono WHERE Carnet=:Carnet");
                $update->bindValue('Carnet', $_POST['Carnet']);
                $update->bindValue('Nombre', $_POST['Nombre']);
                $update->bindValue('Grado', $_POST['Grado']);
                $update->bindValue('Telefono', $_POST['Telefono']);
                $update->execute();
                header("Refresh: 0");

            }
        }

        $select = $conexion->query("SELECT Carnet, Nombre, Grado, Telefono FROM alumno");
       ?>

        <?php if (isset($_POST["accion"]) && $_POST["accion"] == "Editar" ) { ?>
                <form method="POST">
                    <input type="text" name="Carnet" value="<?php echo $_POST["Carnet"] ?>" placeholder="Ingrese el carnet"/>
                    <input type="text" name="Nombre" placeholder="Ingrese el nombre"/>
                    <input type="text" name="Grado" placeholder="Ingrese su grado"/>
                    <input type="text" name="Telefono" placeholder="Ingrese su telefono"/>
                    <input type="hidden" name="accion" value="Editado"/>
                    <button type="submit">Guardar</button>
                </form>
            <?php }else { ?>
                <form method="POST">
                    <input type="text" name="Carnet" placeholder="Ingrese el carnet"/>
                    <input type="text" name="Nombre" placeholder="Ingrese el nombre"/>
                    <input type="text" name="Grado" placeholder="Ingrese su grado"/>
                    <input type="text" name="Telefono" placeholder="Ingrese su telefono/>
                    <input type="hidden" name="accion" value="Crear"/>
                    <button type="submit">Crear</button>
                </form>


            <?php } ?>

                    <table border="1">
                    <thead>
                    <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Grado</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                     </thead>
                    <tbody>
                        <?php foreach($select->fetchAll() as $alumno) { ?>
                            <tr>
                            <td> <?php echo $alumno["Carnet"] ?> </td>
                            <td> <?php echo $alumno["Nombre"] ?> </td>
                            <td> <?php echo $alumno["Grado"] ?> </td>
                            <td> <?php echo $alumno["Telefono"] ?> </td>
                            <td> <form method="POST"> 
                                    <button type="submit">Editar</button>
                                    <input type="hidden" name="accion" value="Editar"/>
                                    <input type="hidden" name="Carnet" value="<?php echo $alumno ["Carnet"] ?>"/>

                                </form>
                            </td>
                            </tr>
                         <?php } ?>
                    </tbody>
            </table>
</body>
</html>