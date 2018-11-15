<?php
use \MongoDB\BSON\ObjectID as MongoId;
// including the database connection file
include_once("index.php");
 
if(isset($_POST['update']))
{    
    $id = $_POST['id'];
    $user = array (
                'nis' => $_POST['nis'],
                'nama' => $_POST['name'],
                'kelas' => $_POST['class'],
                'pk3' => $_POST['pk3'],
                'pk5' => $_POST['pk5'],
                'pk8' => $_POST['pk8'],
            );
    
    // checking empty fields
    $errorMessage = '';
    foreach ($user as $key => $value) {
        if (empty($value)) {
            $errorMessage .= $key . ' field is empty<br />';
        }
    }
            
    if ($errorMessage) {
        // print error message & link to the previous page
        echo '<span style="color:red">'.$errorMessage.'</span>';
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";    
    } else {
        //updating the 'users' table/collection
        $db->tsiswa->updateOne(
                        array('_id' => new MongoId($id)),
                        array('$set' => $user)
                    );
        
        //redirectig to the display page. In our case, it is index.php
        header("Location: index.php");
    }
} // end if $_POST
?>
<?php
//getting id from url
$id = $_GET['id'];
 
//selecting data associated with this particular id
$result = $db->tsiswa->findOne(array('_id' => new MongoId($id)));
 
$nis = $result['nis'];
$nama = $result['nama'];
$kelas = $result['kelas'];
$pk3 = $result['pk3'];
$pk5 = $result['pk5'];
$pk8 = $result['pk8'];
?>
<html>
<head>    
    <title>Edit Data</title>
</head>
 
<body>
    <a href="index.php">Home</a>
    <br/><br/>
    
    <form name="form1" method="post" action="edit.php">
        <table border="0">
            <tr> 
                <td>Nis</td>
                <td><input type="text" name="nis" value="<?php echo $nis;?>"></td>
            </tr>
            <tr> 
                <td>Nama</td>
                <td><input type="text" name="name" value="<?php echo $nama;?>"></td>
            </tr>
            <tr> 
                <td>Kelas</td>
                <td><input type="text" name="class" value="<?php echo $kelas;?>"></td>
            </tr>
            <tr> 
                <td>PK3</td>
                <td><input type="text" name="pk3" value="<?php echo $pk3;?>"></td>
            </tr>
            <tr> 
                <td>PK5</td>
                <td><input type="text" name="pk5" value="<?php echo $pk5;?>"></td>
            </tr>
            <tr> 
                <td>PK8</td>
                <td><input type="text" name="pk8" value="<?php echo $pk8;?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo $_GET['id'];?>"></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>