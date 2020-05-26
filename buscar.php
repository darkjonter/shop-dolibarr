<?php 
include('common/header.php'); 

if($_POST['search']){
    $productos = products_list();
$input = $_POST['search'];
for($i=0; $i<count($productos); $i++){
    $data[$i] = $productos[$i]['label'];
    
}

$result = array_filter($data, function ($item) use ($input) {
    if (stripos($item, $input) !== false) {
        return true;
    }
    return false;
});

$title='Busqueda para '.$input;

//var_dump($result);

foreach($result as $key => $value){
   $imagen = imagen_principal($productos[$key]['id']);
    $imagen_path = 'https://www.aseotalca.cl/erp/img_tienda.php?modulepart=product&attachment=0&file='.$imagen[0]['level1name'].'/'.$imagen[0]['relativename'].'&entity=1';
    $productos[$key]['imagen_path'] = $imagen_path;
} 

}
else{
    $title='';
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
	    <li class="breadcrumb-item"><a href="<?='Busqueda/'.$input?>"><?=$title?></a></li>
	</ol>  
	</nav> <!-- col.// -->
	
</div> <!-- row.// -->
<hr>


	</div> <!-- card-body .// -->
</div> <!-- card.// -->

<div class="padding-y-sm">
<span><?php if(count($result)==0){echo '0 resultados para ' . $title; }else{echo count($result) . ' resultados para ' .$title;} ?></span>	
</div>

<div class="row-sm">
    <?php 
    if(count($result)==0){
        echo '<div align="center"><h1>NO SE ENCUENTRA PRODUCTOS EN ESTA BUSQUEDA</h1></div>';
    }
    else{
       foreach($result as $key => $value){
       echo '<div class="col-md-3 col-sm-6">
	    <figure class="card card-product">
		<div class="img-wrap"> <img src="'.$productos[$key]['imagen_path'].'"></div>
		<figcaption class="info-wrap">
			<a href="producto/'.$productos[$key]['id'].'-'.$productos[$key]['ref'].'">'.$productos[$key]['label'].'</a>
			<div class="price-wrap">
				<span class="price-new">'.formatear_moneda($productos[$key]['price']).'</span>
				<del class="price-old">'.formatear_moneda($productos[$key]['price_ttc']).'</del>
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