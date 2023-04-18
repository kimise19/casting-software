<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$studentname=$_POST['fullanme'];
$roolid=$_POST['rollid']; 
$studentemail=$_POST['emailid']; 
$gender=$_POST['gender']; 
$classid=$_POST['class']; 
$dob=$_POST['dob']; 
$status=1;
$foto_1=$_FILES['image']['name']; 
//print_r($desc_1, );
$sql="INSERT INTO  tblstudents(StudentName,RollId,StudentEmail,Gender,ClassId,DOB,Status,descripcion, img) VALUES(:studentname,:roolid,:studentemail,:gender,:classid,:dob,:status,:foto_1)";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$query->bindParam(':studentemail',$studentemail,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':foto_1',$foto_1,PDO::PARAM_STR);
$query->execute();

$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Participante Ingresado Exitósamentes";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Participantes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php');?>
                <!-- /.left-sidebar -->

                <div class="main-page">

                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Agregar participantes</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Inicio</a></li>

                                    <li class="active">Agregar participantes</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Diligencia la información de los participantes</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if($msg){?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Bien hecho!</strong><?php echo htmlentities($msg); ?>
                                        </div><?php } 
                                            else if($error){?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>oh rayos!!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Nombre
                                                    Completo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="fullanme" class="form-control"
                                                        id="fullanme" required="required" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="numero" class="col-sm-2 control-label">Cédula</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="rollid" class="form-control" id="rollid"
                                                        onblur="validarCedula();" maxlength="10" required="required"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Correo</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="emailid" class="form-control" id="email"
                                                        required="required" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Género</label>
                                                <div class="col-sm-10">
                                                    <input type="radio" name="gender" value="Male" required="required"
                                                        checked="">Hombre <input type="radio" name="gender"
                                                        value="Female" required="required">Mujer <input type="radio"
                                                        name="gender" value="Other" required="required">Otro
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Proyecto a
                                                    calificar</label>
                                                <div class="col-sm-10">
                                                    <select name="class" class="form-control" id="default"
                                                        required="required">
                                                        <option value="">Selecciona proyecto</option>
                                                        <?php $sql = "SELECT * from tblclasses";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                                if($query->rowCount() > 0)
                                                                {
                                                                foreach($results as $result)
                                                                {   ?>
                                                        <option value="<?php echo htmlentities($result->id); ?>">
                                                            <?php echo htmlentities($result->ClassName); ?>&nbsp;
                                                            Section-<?php echo htmlentities($result->Section); ?>
                                                        </option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label">Fecha de
                                                    Nacimiento</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="dob" class="form-control" id="date">
                                                </div>
                                            </div>
                                            <!-- SUBIR FOTO DE PERFIL   -->
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Foto de perfil</label>
                                                <div class="col-sm-10">
                                                    <label for="imagen"></label>
                                                    <input type="file" name="image" id="image">
                                                </div>

                                            </div>
                                            <!-- FIN  SUBIR FOTO DE PERFIL   -->
                                            <!-- <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Descripcion</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="desc" class="form-control" id="desc">
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary">Agregar</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script>
        function validarCedula() {
            var cedula = document.getElementById("rollid").value;

            // Eliminamos cualquier carácter que no sea un número
            cedula = cedula.replace(/[^0-9]/g, '');

            // Verificamos si la longitud de la cédula es válida
            if (cedula.length != 10) {
                alert('La cédula debe tener 10 dígitos');
                return false;
            }

            // Validamos la cédula usando el algoritmo de validación del Registro Civil del Ecuador
            var suma = 0;
            var multi = 2;

            for (var i = 8; i >= 0; i--) {
                var producto = parseInt(cedula.charAt(i)) * multi;
                if (producto > 9) {
                    producto -= 9;
                }
                suma += producto;
                multi = multi == 2 ? 1 : 2;
            }

            var verificador = 10 - (suma % 10);

            if (verificador != parseInt(cedula.charAt(9))) {
                alert('La cédula es inválida');
                return false;
            }

            alert('La cédula es válida');
            return true;
        }
        </script>
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
        $(function($) {
            $(".js-states").select2();
            $(".js-states-limit").select2({
                maximumSelectionLength: 2
            });
            $(".js-states-hide").select2({
                minimumResultsForSearch: Infinity
            });
        });
        </script>
</body>

</html>
<?PHP } ?>