<?php  
include('common/header.php'); 
$productos = products_list();
//print_r(count($productos));
//for($i=0; $i<$productos;)

for($i=0; $i<count($productos); $i++){
    $imagen = imagen_principal($productos[$i]['id']);
    $imagen_path = 'https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file='.$imagen[0]['level1name'].'/'.$imagen[0]['relativename'].'&entity=1';
    $productos[$i]['imagen_path'] = $imagen_path;
}

?>
<!-- ========================= SECTION MAIN ========================= -->
<section class="section-main bg padding-y-sm">
<div class="container">
<div class="card">
	<div class="card-body">
<div class="row row-sm">
	<aside class="col-md-3" id='categorias'>
<h5 class="text-uppercase">Categorias</h5>

	<ul class="menu-category">
	    <?php foreach($categorias as $key => $value) {
		        
		        echo '<li> <a href="categoria/'.$key.'-'.str_replace(' ','-',$value).'">'. $value. '</a></li>';
		    } ?>
		
			</ul>
		</li>
	</ul>

	</aside> <!-- col.// -->
	<div class="col-md-6">

<!-- ================= main slide ================= -->
<div class="owl-init slider-main owl-carousel" data-items="1" data-nav="true" data-dots="false">
	<div class="item-slide">
		<img src="images/banners/slide1.jpg">
	</div>
	<div class="item-slide">
		<img src="images/banners/slide2.jpg">
	</div>
	<div class="item-slide">
		<img src="images/banners/slide3.jpg">
	</div>
</div>
<!-- ============== main slidesow .end // ============= -->

	</div> <!-- col.// -->
	<aside class="col-md-3">

<h6 class="title-bg bg-secondary"> Productos destacados</h6>
<div style="height:280px;">
    <?php
    $random_destacados = array_rand($productos, 3);
    for($i=0; $i<count($random_destacados); $i++){
        echo '<figure class="itemside has-bg border-bottom" style="height: 33%;">
		<img class="img-bg" src="'.$productos[$random_destacados[$i]]['imagen_path'].'">
		<figcaption class="p-2">
			<h6 class="title">'.cortar_string($productos[$random_destacados[$i]]['label'], 20).'</h6>
			<a href="producto/'.$productos[$random_destacados[$i]]['id'].'-'.$productos[$random_destacados[$i]]['ref'].'">Ir Ahora</a>
		</figcaption>
	</figure>';
    
    }
    ?>
	
</div>

	</aside>
</div> <!-- row.// -->
	</div> <!-- card-body .// -->
</div> <!-- card.// -->

<figure class="mt-3 banner p-3 bg-secondary">
	<div class="text-lg text-center white">Useful banner can be here</div>
</figure>

</div> <!-- container .//  -->
</section>
<!-- ========================= SECTION MAIN END// ========================= -->







<!-- ========================= SECTION ITEMS ========================= -->
<section class="section-request bg padding-y-sm">
<div class="container">
<header class="section-heading heading-line"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<h4 class="title-section bg text-uppercase">Productos Recomendados</h4>
</header>

<div class="row-sm">
    <?php 
    $claves_aleatorias = array_rand($productos, 12);
    
    for($i=0; $i <count($claves_aleatorias); $i++){
        echo '<div class="col-md-2">
	<figure class="card card-product">
		<div class="img-wrap"> <img src="'.$productos[$claves_aleatorias[$i]]['imagen_path'].'"></div>
		<figcaption class="info-wrap">
			<h6 class="title "><a href="producto/'.$productos[$claves_aleatorias[$i]]['id'].'-'.$productos[$claves_aleatorias[$i]]['ref'].'">'.$productos[$claves_aleatorias[$i]]["label"].'</a></h6>
			
			<div class="price-wrap">
				<span class="price-new">'.formatear_moneda($productos[$claves_aleatorias[$i]]['price_ttc']).'</span>
				<!--<del class="price-old">'.formatear_moneda($productos[$claves_aleatorias[$i]]['price_ttc']).'</del>-->
			</div> <!-- price-wrap.// -->
			
		</figcaption>
	</figure> <!-- card // -->
</div> <!-- col // -->';
    }
    
    ?>

</div> <!-- row.// -->


</div><!-- container // -->
</section>
<!-- ========================= SECTION ITEMS .END// ========================= -->




<?php include('common/footer.php'); ?>