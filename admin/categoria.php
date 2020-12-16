<?php
	include("../functions.php");
	include("addCategoria.php");
	include("addProduct.php");
	include("deleteCategoria.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Categoria</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index.php">Restaurante|Administrador</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!------------------ Sidebar ------------------->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel de Control</span>
          </a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link" href="categoria.php">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Categoria</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sales.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Ventas</span></a>
        </li>

        <li class="nav-item">
		<a class="nav-link" href="Employees.php">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Empleados</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-power-off"></i>
            <span>Cerrar Sesión</span>
          </a>
        </li>

      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.php">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">Categoria</li>
          </ol>

          <!-- Page Content -->
          <h1>Administración de Categorias</h1>
          <hr>
          <p>Seccion de Categorias del Restaurante, puedes Agregar, Modificar o Eliminar categorias.</p>

          <div class="card mb-3 border-primary">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Lista de Categorias
              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addCatModal">Agregar Categoría</button>

          </div>
            <div class="card-body">

            	<?php 
					$catQuery = "SELECT * FROM categoria";

					if ($catResult = $sqlconnection->query($catQuery)) {

						if ($catResult->num_rows == 0) {
							echo "<center><label>Sin productos agregados por el momento.</label></center>";
						}

						while($catRow = $catResult->fetch_array(MYSQLI_ASSOC)) {?>

							<div class="card mb-3 border-primary">
					            <div class="card-header">

					              <i class="fas fa-chart-area"></i>
					              <?php echo $catRow["nombre"]; ?>
  					              <button class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#deleteModal" data-category="<?php echo $catRow["nombre"];?>" data-catid="<?php echo $catRow["codigo"];?>">Eliminar</button> <!-- elimina categoria-->
  					              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addProdModal" data-category="<?php echo $catRow["nombre"];?>" data-catid="<?php echo $catRow["codigo"];?>">Agregar</button><!--agrega producto-->

					          	</div>
					            <div class="card-body">

                			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<tr>
									<td>#</td>
									<td>Nombre de Producto</td>
									<td>Precio </td>
									<td>Opciones</td>
								</tr>
							<?php
								$productQuery = "SELECT * FROM productos WHERE cate_cod = " . $catRow["codigo"];

								if ($productResult = $sqlconnection->query($productQuery)) {

									if ($productResult->num_rows == 0) {
											echo "<td colspan='4' class='text-center'>Sin productos agregados en esta Categoria.</td>";
										}

									$productCount = 1;
									while($productRow = $productResult->fetch_array(MYSQLI_ASSOC)) {	?>

										<tr>
											<td><?php echo $productCount++; ?></td>
			        						<td><?php echo $productRow["nombre"] ?></td>
			        						<td><?php echo $productRow["price"] ?></td>
			        						<td>
			        							<a href="#editProductModal" data-toggle="modal" data-prodname="<?php echo $productRow["nombre"] ?>" data-prodprice="<?php echo $productRow["price"] ?>" data-catcod="<?php echo $catRow["codigo"] ?>" data-prodcot="<?php echo $productRow["codigo"] ?>">Editar </a>
			        							<a href="deleteProduct.php?prodCod=<?php echo $productRow["codigo"] ?>&catCod=<?php echo $catRow["codigo"] ?>"> Eliminar</a></td> 
										</tr>

									<?php
									}
								}

								else {
									die("Algo malo paso");
								}
							?>
							</table>
							</div>
					    </div>

						<?php
						}
					}

					else {
						die("Algo malo paso");
					}
				 ?>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">0 to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="logout.php">Cerrar Sesión</a>
          </div>
        </div>
      </div>
    </div>

	<!-- Add Categorai Modal -->
	<div class="modal fade" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="addCatModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="addCatModalLabel">Agregar Categoría</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="addcatform" method="POST">
	        	<div class="form-group">
		            <label class="col-form-label">Categoría:</label>
		            <input type="text" required="required" class="form-control" name="categoria" placeholder="Ingresa el nombre de la Categoría" >
		        </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="addcatform" class="btn btn-success" name="addcategoria">Agregar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Agregando Productos-->
	<div class="modal fade" id="addProdModal" tabindex="-1" role="dialog" aria-labelledby="addProdModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="addProdModalLabel"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="addProdform" method="POST">
	        	<div class="form-group">
		            <label class="col-form-label">Nombre:</label>
		            <input type="text" required="required" class="form-control" name="prodName" placeholder="Nombre del producto" >
		        </div>
		        <div class="form-group">
		            <label class="col-form-label">Precio:</label>
		            <input type="text" required="required" class="form-control" name="price"  >
		            <input type="hidden" name="category" id="categoria">
		        </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="addProdform" class="btn btn-success" name="addProd">Agregar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Editando productos -->
	<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="addProdModalLabel">Editar Producto</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="editProductform" action="editProduct.php" method="POST">
	        	<div class="form-group">
		            <label class="col-form-label">Nombre:</label>
		            <input type="text" required="required" id="prodName" class="form-control" name="prodName" placeholder="Nombre del Producto" >
		        </div>
		        <div class="form-group">
		            <label class="col-form-label">Precio: </label>
		            <input type="text" required="required" id="prodPrice" class="form-control" name="prodPrice" placeholder="" >
		            <input type="hidden" name="cateCod" id="cateCod">
		            <input type="hidden" name="prodCod" id="prodCod">
		        </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="editProductform" class="btn btn-primary" name="editprod">Editar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">¿Realmente desea eliminar la Categoría?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
          	<form id="deleteCategoryform" method="POST">
          		<input type="hidden" name="catID" id="catid">
          	</form>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="deleteCategoryform" class="btn btn-danger" name="deleteCat">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <script>

    	$('#addProdModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); 
			  var id = button.data('catid'); 
			  var category = button.data('category');

			  var modal = $(this);
			  modal.find('.modal-title').text('Nueva Producto | ' + category );
			  modal.find('.modal-body #categoria').val(id);
		});

		$('#editProductModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); 

			  var catecod = button.data('catcod'); // extrayendo información de los atributos data
			  var prodcod = button.data('prodcot');
			  var prodname = button.data('prodname');
			  var prodprice = button.data('prodprice');

			  var modal = $(this);
			  modal.find('.modal-body #cateCod').val(catecod);
			  modal.find('.modal-body #prodCod').val(prodcod);
			  modal.find('.modal-body #prodName').val(prodname);
			  modal.find('.modal-body #prodPrice').val(prodprice);
		});


		$('#deleteModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); 
			  var id = button.data('catid'); 
			  var category = button.data('category');

			  var modal = $(this);
			  modal.find('.modal-body').html('Presiona "Eliminar" y procederá a eliminar la lista completa');
			  modal.find('.modal-footer #catid').val(id);
		});
    </script>

    <script type="text/javascript">
	    window.setTimeout(function() {
	        $(".alert").fadeTo(500, 0).slideUp(500, function() {
	            $(this).hide();
	        });
	    }, 1000);
	</script> 

  </body>

</html>