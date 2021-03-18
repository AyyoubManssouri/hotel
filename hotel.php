 <!DOCTYPE html>
<html lang="en">
<head>
    <script src="hotel.js"></script>
    <link rel="stylesheet" type="text/css" href="hotel.css">
    <title>Hotel</title>
</head>
<body>
    <div class="form">
        <div><h1>La gestion des chambres</h1></div>

        <!-- first button -->

        <div class="popup" id="popup-1">
            <div class="overlay"></div>
            <div class="content">
            <div class="close-btn" onclick="button()">&times;</div>
            <h1>Liste des chambres:</h1>
            <table>
            <tr>
                <th>Code chambre</th>
                <th>Nombre de lit</th>
                <th>Prix</th>
            </tr>
            <?php
                $conn = mysqli_connect('localhost','root','','hotel');
                $a  = "select * from chambre";
                $data = mysqli_query($conn,$a);
                if (mysqli_num_rows($data) > 0){
                while($row = mysqli_fetch_assoc($data)) {
                    echo '<tr>';
                    echo '<td>'.$row["code_ch"].'</td>';
                    echo '<td>'.$row["nombre_lit"].'</td>';
                    echo '<td>'.$row["prix"].'</td>';
                    echo '</tr>';
                }
                }
            ?>
            </table>
            </div>
            </div>
        <button onclick="button()">Lister les chambres</button>

        <!-- second button -->

        <div class="popup" id="popup-2">
            <div class="overlay"></div>
            <div class="content">
            <div class="close-btn" onclick="button2()">&times;</div>
            <h1>Ajout d'une chambre:</h1>
            <form action="" method="post">
                <table>
                    <tr>                    
                        <td><label for="code">code:</label></td>
                        <td><input type="number" name="code" id="code" min="0" required></td>
                    </tr>
                    <tr>                    
                        <td><label for="lits">Nombre de lits:</label></td>
                        <td><input type="number" name="lits" id="lits" min="0" max="4" required></td>
                    </tr>
                    <tr>                    
                        <td><label for="prix">prix:</label></td>
                        <td><input type="number" name="prix" id="prix" min="0" required></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="ajouter">Ajouter</button></td>
                        <td><button type="reset" name="effacer">reset</button></td> 
                    </tr>
                </table>
            </form>
            <?php 
                if(isset($_POST["ajouter"])){
                    //checking if the code already exists
                    $conn = mysqli_connect('localhost','root','','hotel');
                    $exist=false;
                    $query1  = "select * from chambre";
                    $data = mysqli_query($conn,$query1);
                    if (mysqli_num_rows($data) > 0){
                        while($row = mysqli_fetch_assoc($data)) {
                            if($row["code_ch"] == $_POST["code"]){$exist = true;}
                        }
                    }
                    //end of checking
                    if($exist){
                        echo "<script>alert('code already exists!')</script>";
                    } else {
                        $query  = "insert into chambre values(".$_POST["code"].",".$_POST["lits"].",".$_POST["prix"].")";
                        mysqli_query($conn, $query);
                        header("location:hotel.php");
                    }
                }
            ?>
        </div>
        </div> 
        <button onclick="button2()">Ajouter une chambre</button>

        <!-- third button -->

        <div class="popup" id="popup-3">
            <div class="overlay"></div>
            <div class="content">
            <div class="close-btn" onclick="button3()">&times;</div>
            <h1>Suppression une chambre:</h1>
            <table>
            <tr>
                <th>Code chambre</th>
                <th>Nombre de lit</th>
                <th>Prix</th>
            </tr>
            <?php
                $conn = mysqli_connect('localhost','root','','hotel');
                $query  = "select * from chambre";
                $data = mysqli_query($conn,$query);
                if (mysqli_num_rows($data) > 0){
                    while($row = mysqli_fetch_assoc($data)) {
                        echo '<tr>';
                        echo '<td>'.$row["code_ch"].'</td>';
                        echo '<td>'.$row["nombre_lit"].'</td>';
                        echo '<td>'.$row["prix"].'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            </table>
            <form action="" method="post">
                <p>Enter the code of chamber you wanna delete:</p>
                <input type="number" name="codeDelete" min="0" required>
                <button name="ok">Supprimer</button>
            </form>
            <?php
                if(isset($_POST["ok"])){
                    $conn = mysqli_connect('localhost','root','','hotel');
                    $query  = "delete from chambre where code_ch=".$_POST["codeDelete"];
                    //checking if the code doesn't exist
                    $exist=false;
                    $query1  = "select * from chambre";
                    $data = mysqli_query($conn,$query1);
                    if (mysqli_num_rows($data) > 0){
                    while($row = mysqli_fetch_assoc($data)) {
                    if($row["code_ch"] == $_POST["codeDelete"]){$exist = true;}
                    }
                    }
                    //end of checking
                    if(!$exist){
                        echo "<script>alert('invalid code')</script>";
                    } else {
                    mysqli_query($conn, $query);
                    header("location:hotel.php");
                    }
                } 
            ?>
            </div>
            <button onclick="button3()">Supprimer une chambre</button>
        </div> 

        <!-- fourth button -->

        <div class="popup" id="popup-4">
            <div class="overlay"></div>
            <div class="content">
            <div class="close-btn" onclick="button4()">&times;</div>
            <h1>Modify the price:</h1>
            <form action="" method="post">
                <p>enter the code of the chamber you'd like to modify:</p>
                <select name="codeCh">
                <?php 
                    $conn = mysqli_connect('localhost','root','','hotel');
                    $query  = "select * from chambre";
                    $data = mysqli_query($conn,$query);
                    if (mysqli_num_rows($data) > 0){
                    while($row = mysqli_fetch_assoc($data)) {
                        echo "<option value=".$row["code_ch"].">".$row["code_ch"]."</option>";
                        }
                    }
                    ?>
                </select>
                <p>set the new price:</p>
                <input type="number" name="newPrice" min="0" required>
                <button name="update">Update</button>
            </form>
            <?php
                if (isset($_POST["update"])) {
                    $conn = mysqli_connect('localhost', 'root', '', 'hotel');
                    $query = 'update chambre set prix='.$_POST['newPrice'].' where code_ch='.$_POST['codeCh'];
                    mysqli_query($conn, $query);
                    echo "<script>alert('updated successfully!');</script>";
                } 
            ?>
            </div>
            <button onclick="button4()">Modifier une chambre</button>
        </div>    
    </div>
</body>
</html>
