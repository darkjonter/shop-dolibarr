<?php 
include('../include/functions.php');
include 'Cart.php';
$slug=$_GET['slug'];
$categorias = categories_list();
if(empty($slug)){}else{
    
    $title= str_replace('-',' ',$slug);
}

$products_header = products_list();

for($i=0; $i<count($products_header); $i++){
    $search_products[$i] = $products_header[$i]['label'];
}

?>

<!DOCTYPE HTML>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Bootstrap-ecommerce by Vosidiy">
<base href="https://www.aseotalca.cl/tienda/">
<title>ASEO TALCA - <?=$title?> </title>

<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">

<!-- jQuery -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Bootstrap4 files-->
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="fonts/fontawesome/css/fontawesome-all.min.css" type="text/css" rel="stylesheet">

<!-- plugin: fancybox  -->
<script src="plugins/fancybox/fancybox.min.js" type="text/javascript"></script>
<link href="plugins/fancybox/fancybox.min.css" type="text/css" rel="stylesheet">

<!-- plugin: owl carousel  -->
<link href="plugins/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="plugins/owlcarousel/assets/owl.theme.default.css" rel="stylesheet">
<script src="plugins/owlcarousel/owl.carousel.min.js"></script>

<!-- custom style -->
<link href="css/ui.css" rel="stylesheet" type="text/css"/>
<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />

<!-- custom javascript -->
<script src="js/script.js" type="text/javascript"></script>

<script>
$(function() {
var availableTags = <?php echo json_encode($search_products); ?>;
    $( "#search" ).autocomplete({
    source: availableTags
    });
});
</script>


</head>
<body>
    
<header class="section-header">
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
  	<a class="navbar-brand" href="#"><img class="logo" src="images/logos/aseotalca-image.png" alt="logotipo AseoTalca" title="ASEOTALCA"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTop">
      <ul class="navbar-nav mr-auto">
          <li><a class="nav-link" href="#">Sobre Nosotros </a></li>
          <li><a class="nav-link" href="#">Contacto </a></li>
          <li><a class="nav-link" href="#">Términos y condiciones</a></li>
          
      </ul>
   </div>  <!-- collapse.// -->
  </div>
</nav>

<section class="header-main shadow-sm">
	<div class="container">
<div class="row-sm align-items-center">
	<div class="col-lg-4-24 col-sm-3">
	<div class="category-wrap dropdown py-1">
		<button type="button" class="btn btn-light  dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-bars"></i> Categorias</button>
		<div class="dropdown-menu">
		    <?php foreach($categorias as $key => $value) {
		        
		        echo '<a class="dropdown-item" href="categoria/'.$key.'-'.str_replace(' ','-',$value).'">'. $value. '</a>';
		    } ?>
			
		</div>
	</div> 
	</div>
	<div class="col-lg-11-24 col-sm-8">
			<form action="buscar.php" class="py-1" method="POST">
				<div class="input-group w-100">
					<!--<select class="custom-select"  name="category_name">
						<option value="">All type</option>
						<option value="">Special</option>
						<option value="">Only best</option>
						<option value="">Latest</option>
					</select> -->
				    <input type="text" class="form-control" name="search" id="search" style="width:80%;" placeholder="Buscar productos....">
				    <div class="input-group-append">
				      <button class="btn btn-warning" type="submit">
				        <i class="fa fa-search"></i> Búsqueda 
				      </button>
				    </div>
			    </div>
			</form> <!-- search-wrap .end// -->
	</div> <!-- col.// -->
	<div class="col-lg-9-24 col-sm-12">
		<div class="widgets-wrap float-right row no-gutters py-1">
		<!--	<div class="col-auto">
			<div class="widget-header dropdown">
				<a href="#" data-toggle="dropdown" data-offset="20,10">
					<div class="icontext">
						<div class="icon-wrap"><i class="text-warning icon-sm fa fa-user"></i></div>
						<div class="text-wrap text-dark">
							Sign in <br>
							My account <i class="fa fa-caret-down"></i> 
						</div>
					</div>
				</a>
				<div class="dropdown-menu">
					<form class="px-4 py-3">
						<div class="form-group">
						  <label>Email address</label>
						  <input type="email" class="form-control" placeholder="email@example.com">
						</div>
						<div class="form-group">
						  <label>Password</label>
						  <input type="password" class="form-control" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary">Sign in</button>
						</form>
						<hr class="dropdown-divider">
						<a class="dropdown-item" href="#">Have account? Sign up</a>
						<a class="dropdown-item" href="#">Forgot password?</a>
				</div> <!--  dropdown-menu .// -->
			<!--</div> --> <!-- widget-header .// -->
			<!--</div> <!-- col.// -->
			<div class="col-auto">
				<a href="viewCart.php" class="widget-header">
					<div class="icontext">
						<div class="icon-wrap"><i class="text-warning icon-sm fa fa-shopping-cart"></i></div>
						<div class="text-wrap text-dark">
							Mi <br> Carrito (<?php echo $_SESSION['cart_contents']['total_items']?$_SESSION['cart_contents']['total_items']:'0'; ?>)
						</div>
					</div>
				</a>
			</div> <!-- col.// -->
		<!--	<div class="col-auto">
				<a href="#" class="widget-header">
					<div class="icontext">
						<div class="icon-wrap"><i class="text-warning icon-sm  fa fa-heart"></i></div>
						<div class="text-wrap text-dark">
							<span class="small round badge badge-secondary">0</span>
							<div>Favorites</div>
						</div>
					</div>
				</a>
			</div> <!-- col.// -->
		</div> <!-- widgets-wrap.// row.// -->
	</div> <!-- col.// -->
</div> <!-- row.// -->
	</div> <!-- container.// -->
</section> <!-- header-main .// -->
</header> <!-- section-header.// -->