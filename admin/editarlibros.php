<?php
  require_once('conexion.php');
  $conn =mysqli_connect($host, $user, $pw, $db);
  
  if(isset($_SESSION['idusuario'])==false){
      header('location: index.php');
  }


 if(isset($_REQUEST['guardar'])){
    
     
     $nombre=mysqli_real_escape_string($conn,$_REQUEST['nombre'] ?? '');    
     $isbn=mysqli_real_escape_string($conn,$_REQUEST['isbn'] ?? '');
     $precio=mysqli_real_escape_string($conn,$_REQUEST['precio'] ?? '');    
     $descripcion=mysqli_real_escape_string($conn,$_REQUEST['descripcion'] ?? '');
     $idlibro=mysqli_real_escape_string($conn,$_REQUEST['idlibro'] ?? '');

        
        $sql="UPDATE libros SET
        nombre='".$nombre."',isbn='".$isbn."',
        precio='".$precio."',descripcion='".$descripcion."'
        WHERE idlibro='".$idlibro."';";

        if ($_FILES["file1"]["error"] > 0)	{
        } else 	{

          $nom_archivo=$_FILES['file1']['name']; // Para conocer el nombre del archivo
          $ruta = "images/" . $nom_archivo;  // La ruta del archivo contiene el nuevo nombre y el tipo de extension
          $archivo = $_FILES['file1']['tmp_name']; //el arhivo a subir
          $subir=move_uploaded_file($archivo, $ruta); //se sube el archivo
          include 'conexion.php';
          $sql="UPDATE libros SET imagen='$ruta' WHERE idlibro='".$idlibro."' ";
          //$conexion->query($sentencia_img) or die ("Error al actualizar datos".mysqli_error($conexion));
        }


        $result=mysqli_query($conn,$sql);

        if($result){
            echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=libros&mensaje=Libro '.$nombre.' Actualizado">';

        }else{
       ?>

         <div class="alert alert-danger" role="alert">
            Error al actualizar usuario <?php echo mysqli_error($conn); ?>
         </div>
         <?php
        }
      } 
      
      //consulta a la tabla libro
      $idlibro= mysqli_real_escape_string($conn,$_REQUEST['idlibro']?? '');
      $sql = "SELECT idlibro, nombre, isbn, precio, descripcion,imagen 
      FROM libros WHERE idlibro = '".$idlibro."';";
      $result=mysqli_query($conn,$sql);
      $row=mysqli_fetch_assoc($result);


    ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Libros</h1>
        </div><!-- /.col -->          
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
        <section class="content">      
            <div class="row">
            <div class="col-12">
                <div class="card">
          <!--crear usuario-->
                        <div class="card-body">
                            <form action="panel.php?modulo=editarLibro" method="post" id="editarLibro" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?php echo $row['nombre']?>">
                            </div>
                           
                            <div class="form-group">
                                <label for="ISBN">ISBN</label>
                                <input type="text" name="isbn" id="isbn" class="form-control" placeholder="ISBN" value="<?php echo $row['isbn']?>">
                            </div>
                            <div class="form-group">
                                <label for="Precio">Precio</label>
                                <input type="text" name="precio" id="precio" class="form-control" placeholder="Precio" value="<?php echo $row['precio']?>">
                            </div>
                           
                            <div class="form-group">
                                <label for="Descripcion">Descripcion</label>
                               <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="10" placeholder="Descripción"><?php echo $row['descripcion']?></textarea>                           </div>
                            </div>
                            <div class="form-group">
                              <label for="Imagen">Imagen</label>        
                              <input type="file" name="file1" id="file1">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="idlibro" value="<?php echo $row['idlibro'] ?>"> 
                                <button type="submit" name="guardar" class="btn btn-primary">Crear Libro</button>
                                <button type="reset"  class="btn btn-danger">Cancelar Libro</button>
                                
                            </div>                
                        </form>
                    </div>

            
            </div>
          </div>
        </div>            
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->