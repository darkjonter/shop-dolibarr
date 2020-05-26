  <?php
include('common/header.php');
$p_id=$_GET['p_id'];

if(empty($p_id)){die();}else{
    $producto = products_detail($p_id);
}

//echo "<pre>";
//print_r($producto);
//echo "</pre>";

$producto_imagenes = images_list($p_id);

?>

<!-- ========================= SECTION TOPBAR ========================= -->
<section class="section-topbar border-top padding-y-sm">
<div class="container">
	<span>Proveedor: ASEOTALCA, Ltd.</span> &nbsp  <span class="text-warning">2 años</span>
	
</div> <!-- container.// -->
</section>
<!-- ========================= SECTION TOPBAR .// ========================= -->

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm">
<div class="container">
<nav class="mb-3">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="<?='producto/'.$p_id.'-'.$slug?>"><?=$title?></a></li>
    
</ol> 
</nav>

<div class="row">
<div class="col-xl-10 col-md-9 col-sm-12">


<main class="card">
	<div class="row no-gutters">
		<aside class="col-sm-6 border-right">
<article class="gallery-wrap"> 
<div class="img-big-wrap">
  <div> <a href="https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file=<?=$producto_imagenes[0]['level1name']?>/<?=$producto_imagenes[0]['relativename']?>&entity=1" data-fancybox=""><img src="https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file=<?=$producto_imagenes[0]['level1name']?>/<?=$producto_imagenes[0]['relativename']?>&entity=1"></a></div>
</div> <!-- slider-product.// -->
<div class="img-small-wrap">
    <?php 
    for($i=0; $i<count($producto_imagenes); $i++){
        echo '<div class="item-gallery"><a href="https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file='.$producto_imagenes[$i]['level1name'].'/'.$producto_imagenes[$i]['relativename'].'&entity=1" data-fancybox=""><img src="https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file='.$producto_imagenes[$i]['level1name'].'/'.$producto_imagenes[$i]['relativename'].'&entity=1"></a></div>';
    }
    ?>
 <!-- <div class="item-gallery"><a href="images/items/1.jpg" data-fancybox=""><img src="images/items/1.jpg"></a></div>
  <div class="item-gallery"><a href="images/items/2.jpg" data-fancybox=""><img src="images/items/2.jpg"></a></div>
  <div class="item-gallery"> <img src="images/items/3.jpg"></div>
  <div class="item-gallery"> <img src="images/items/4.jpg"></div> -->
</div> <!-- slider-nav.// -->
</article> <!-- gallery-wrap .end// -->
		</aside>
		<aside class="col-sm-6">
<article class="card-body">
<!-- short-info-wrap -->
	<h3 class="title mb-3"><?=$producto['label']?></h3>

<div class="mb-3"> 
	<var class="price h3 text-warning"> 
		<span class="currency"></span><span class="num"><?= formatear_moneda($producto['price_ttc']);?></span>
	</var> 
	<span>c/u</span> 
</div> <!-- price-detail-wrap .// -->
<dl>
<!--  <dt>Descripción</dt>
  <dd></dd> -->
</dl>
<dl class="row">
  <dt class="col-sm-3">Peso:</dt>
  <dd class="col-sm-9"><?=$producto['volume']?></dd>

  

  
</dl>
<!--<div class="rating-wrap">

	<ul class="rating-stars">
		<li style="width:80%" class="stars-active"> 
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> 
		</li>
		<li>
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> 
		</li>
	</ul>
	<div class="label-rating">132 reviews</div>
	<div class="label-rating">154 orders </div>
</div>  --> <!-- rating-wrap.// -->
<hr>
	<div class="row">
		<div class="col-sm-5">
			<dl class="dlist-inline">
			  <form action="cartAction.php" method="POST">
			  <dt>Cantidad: </dt>
			  <dd> 
			  	<select class="form-control form-control-sm" style="width:70px;" name="cantidad">
			  		<option> 1 </option>
			  		<option> 2 </option>
			  		<option> 3 </option>
			  	</select>
			  </dd>
			</dl>  <!-- item-property .// -->
		</div> <!-- col.// -->
	<!--	<div class="col-sm-7">
			<dl class="dlist-inline">
				  <dt>Size: </dt>
				  <dd>
				  	<label class="form-check form-check-inline">
					  <input class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="option2" type="radio">
					  <span class="form-check-label">SM</span>
					</label>
					<label class="form-check form-check-inline">
					  <input class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="option2" type="radio">
					  <span class="form-check-label">MD</span>
					</label>
					<label class="form-check form-check-inline">
					  <input class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="option2" type="radio">
					  <span class="form-check-label">XXL</span>
					</label>
				  </dd>
			</dl>  <!-- item-property .// -->
	<!--	</div> <!-- col.// -->
	</div> <!-- row.// -->
	<hr>
	<a href="#" class="btn  btn-warning"> <i class="fa fa-envelope"></i> Contactar </a>
	
            <input type="hidden" name="id" value="<?=$producto['id']?>">
            <input type="hidden" name="action" value="addToCart">
            <input type="submit" class="btn  btn-outline-warning" value="Agregar al Carrito">
    </form>
<!--	<a href="#" class="btn  btn-outline-warning"> Agregar al Carrito </a> -->
<!-- short-info-wrap .// -->
</article> <!-- card-body.// -->
		</aside> <!-- col.// -->
	</div> <!-- row.// -->
</main> <!-- card.// -->

<!-- PRODUCT DETAIL -->
<article class="card mt-3">
	<div class="card-body">
		<h4>Detalles: </h4>
	<p><?=nl2br($producto['description'])?></p>
	</div> <!-- card-body.// -->
</article> <!-- card.// -->

<!-- PRODUCT DETAIL .// -->

</div> <!-- col // -->
<aside class="col-xl-2 col-md-3 col-sm-12">
<div class="card">
	<div class="card-header">
	    Garantía de compra
	</div>
	<div class="card-body small">
		 <span>Chile | AseoTalca</span> 
		 <hr>
		 Aqui algo bonito por escribir <br> 
		 Cosas del vendedor o la marca?
		 
		 <a href="">Visitar página o perfil?</a>
		 
	</div> <!-- card-body.// -->
</div> <!-- card.// -->
<div class="card mt-3">
	<div class="card-header">
	    Quizas te pueda interesar
	</div>
	<div class="card-body row">
	    <?php
	    $productos = products_list();
    $random_destacados = array_rand($productos, 3);
    for($i=0; $i<count($random_destacados); $i++){
        echo '<div class="col-md-12 col-sm-3">
	<figure class="item border-bottom mb-3">
			<a href="#" class="img-wrap"> <img src="images/items/2.jpg" class="img-md"></a>
			<figcaption class="info-wrap">
				<a href="#" class="title">'.cortar_string($productos[$random_destacados[$i]]['label'], 100).'</a>
				<div class="price-wrap mb-3">
					<span class="price-new">'.formatear_moneda($productos[$random_destacados[$i]]['price'], 20).'</span> <del class="price-old">'.formatear_moneda($productos[$random_destacados[$i]]['price_ttc'], 20).'</del>
				</div> <!-- price-wrap.// -->
			</figcaption>
	</figure> <!-- card-product // -->
</div> <!-- col.// -->';
    
    }
    ?>

	</div> <!-- card-body.// -->
</div> <!-- card.// -->
</aside> <!-- col // -->
</div> <!-- row.// -->



</div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->
<?php include('common/footer.php'); ?>
