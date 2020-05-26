<?php
include('common/header.php');
$c_id=$_GET['c_id'];

if(empty($c_id)){die();}else{
    $productos = products_by_category($c_id);
}
for($i=0; $i<count($productos); $i++){
    $imagen = imagen_principal($productos[$i]['id']);
    $imagen_path = 'https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file='.$imagen[0]['level1name'].'/'.$imagen[0]['relativename'].'&entity=1';
    $productos[$i]['imagen_path'] = $imagen_path;
}

?>


<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm">
<div class="container">
<div class="card">
	<div class="card-body">
<div class="row">
	<div class="col-md-3-24"> <strong>Tu estas aquí:</strong> </div> <!-- col.// -->
	<nav class="col-md-18-24"> 
	<ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item"><a href="<?='categoria/'.$c_id.'-'.$slug?>"><?=$title?></a></li>
	</ol>  
	</nav> <!-- col.// -->
</div> <!-- row.// -->
<hr>


	</div> <!-- card-body .// -->
</div> <!-- card.// -->

<div class="padding-y-sm">
<span><?php if(isset($productos['error']) && $productos['error']['code']=='404'){echo '0 resultados para ' . $title; }else{echo count($productos) . ' resultados para ' .$title;} ?></span>	
</div>

<div class="row-sm">
    <?php 
    if(isset($productos['error']) && $productos['error']['code']=='404'){
        echo '<div align="center"><h1>NO SE ENCUENTRAN PRODUCTOS PARA ESTA SELECCIÓN</h1></div>';
    }
    else{
        for($i=0; $i <count($productos); $i++){
       echo '<div class="col-md-3 col-sm-6">
	    <figure class="card card-product">
		<div class="img-wrap"> <img src="'.$productos[$i]['imagen_path'].'"></div>
		<figcaption class="info-wrap">
			<a href="producto/'.$productos[$i]['id'].'-'.$productos[$i]['ref'].'">'.$productos[$i]['label'].'</a>
			<div class="price-wrap">
				<span class="price-new">'.formatear_moneda($productos[$i]['price']).'</span>
				<del class="price-old">'.formatear_moneda($productos[$i]['price_ttc']).'</del>
			</div> <!-- price-wrap.// -->
		</figcaption>
	        </figure> <!-- card // -->
        </div> <!-- col // --><br><br>';
       
        }
    }
   
    ?>
</div> <!-- row.// -->


</div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->

<?php include('common/footer.php'); ?>