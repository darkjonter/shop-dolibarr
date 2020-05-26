<?php
/**
 * @author     Allware Ltda. (http://www.allware.cl)
 * @copyright  2015 Transbank S.A. (http://www.tranbank.cl)
 * @date       Jan 2015
 * @license    GNU LGPL
 * @version    2.0.1
 */

require_once( 'libwebpay/webpay.php' );
require_once( 'certificates/cert-normal.php' );
//require_once 'dbconfig.php';

/** Configuracion parametros de la clase Webpay */
$sample_baseurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$web="http://" . $_SERVER['HTTP_HOST'];
$configuration = new Configuration();
$configuration->setEnvironment($certificate['environment']);
$configuration->setCommerceCode($certificate['commerce_code']);
$configuration->setPrivateKey($certificate['private_key']);
$configuration->setPublicCert($certificate['public_cert']);
$configuration->setWebpayCert($certificate['webpay_cert']);

/** Creacion Objeto Webpay */
$webpay = new Webpay($configuration);

$action = isset($_GET["action"]) ? $_GET["action"] : 'init';

$post_array = false;

switch ($action) {

    default:

$id=$_GET['id'];
$total = 0;



include('../../include/functions.php');

$order = get_order($id);

$id_orders = $id;
$id_user_orders = $order['socid'];
$total = $order['total_ttc'];

$fehcapedido = date("Y-m-d", $order['date']);

$user = search_customer_id($id_user_orders);

$name_compra = $user['name'];
$ape_compra = '';
$user_mail = $user['email'];
$customer_note = 'Pago con WEBPAY';


/*$gsent= $db_con->prepare("SELECT * FROM pro_webpay_reserve WHERE id=$id");
$gsent->execute();
    while ($fila = $gsent->fetch(PDO::FETCH_ASSOC)) {
    
			$fechapedido = $fila['fecha'];
			$name_compra = $fila['nombre'];
			$ape_compra = $fila['apellido'];
			$user_mail = $fila['correo'];
			$customer_note = "Pago con WEBPAY";	
			//$order_state_id = $row['id'];

			$id_orders = $fila['id'];
			$id_user_orders = $fila['id'];
			//$total_orders = $row['order_total'];    

			if($tipo_cobro == 'total'){
			
			$total = $fila['monto'];
			}else if($tipo_cobro == 'garantia'){
			$total = $fila['garantia'];
			}
} */


        $tx_step = "Init";

        /** Monto de la transacción */
        $amount =$total;

        /** Orden de compra de la tienda */
        $buyOrder = $id;

        /** Código comercio de la tienda entregado por Transbank */
        $sessionId = uniqid();
        
        /** URL de retorno */
        $urlReturn = $sample_baseurl."?action=getResult";
        
        /** URL Final */
	$urlFinal  = $sample_baseurl."?action=end";

        $request = array(
            "amount"    => $amount,
            "buyOrder"  => $buyOrder,
            "sessionId" => $sessionId,
            "urlReturn" => $urlReturn,
            "urlFinal"  => $urlFinal,
        );

        /** Iniciamos Transaccion */
        $result = $webpay->getNormalTransaction()->initTransaction($amount, $buyOrder, $sessionId, $urlReturn, $urlFinal);
        
        /** Verificamos respuesta de inicio en webpay */
        if (!empty($result->token) && isset($result->token)) {
		$message = "Sesion iniciada con exito en Webpay";
		$token = $result->token;
		$next_page = $result->url;
		
		/* Graba en base de datos */
		$sql="insert into pro_webpay_webservice (token,estado,user_id,first_name,last_name,email) Values";
		$sql.=" ('".$token."','Pendiente',".$id.",'".$name_compra."','".$ape_compra."','".$user_mail."')";
		//echo $sql;
		
		//$gsent= $db_con->prepare($sql);
		//$gsent->execute();

        } else {
            $message = "webpay no disponible";
				$pagina.='<h1>Transacción Rechazada</h1>
						  <h2>OC Nº '.$id.'</h2>          
							<table class="table table-striped">
								<tr>
									<th><div class="alert alert-error">Las posibles causas de este rechazo son:</div></th>
								</tr>
									<tr>
								<td><img src="images/vineta.gif" style="margin-right: 10px;"/> Error en el ingreso de los datos de su tarjeta de cr&eacute;dito o debito (fecha y/o c&oacute;digo de seguridad). </td>
									</tr>
								<tr>
									<td><img src="images/vineta.gif" style="margin-right: 10px;"/>Su tarjeta no cuenta con saldo suficiente. </td>
								</tr>            
								<tr>
									<td><img src="images/vineta.gif" style="margin-right: 10px;"/>Tarjeta aun no habilita en el sistema financiero.</td>
								</tr>
							</table><br/><a href="http://'.$web.'">Volver al sitio Principal</a>';
        }

        $button_name = "Continuar &raquo;";
        
        break;

    case "getResult":
        
        $tx_step = "Get Result";

        if (!isset($_POST["token_ws"]))
            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_POST, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_POST, 'token_ws')
        );

        /** Rescatamos resultado y datos de la transaccion */
        $result = $webpay->getNormalTransaction()->getTransactionResult($token);
        
        /** Verificamos resultado  de transacción */
        if ($result->detailOutput->responseCode === 0) {

            /** propiedad de HTML5 (web storage), que permite almacenar datos en nuestro navegador web */
            echo '<script>window.localStorage.clear();</script>';
            echo '<script>localStorage.setItem("authorizationCode", '.$result->detailOutput->authorizationCode.')</script>';
            echo '<script>localStorage.setItem("amount", '.$result->detailOutput->amount.')</script>';
            echo '<script>localStorage.setItem("buyOrder", '.$result->buyOrder.')</script>';

            $message = "Pago ACEPTADO por webpay (se deben guardatos para mostrar voucher)";
            $next_page = $result->urlRedirection;
            $estado ="Aceptado";
            
        } else {
            $message = "Pago RECHAZADO por webpay - " . utf8_decode($result->detailOutput->responseDescription);
            $next_page = '';
            $estado ="Rechazado";
			$pagina.='<h1>Transacción Rechazada</h1>
		  <h2>OC Nº '.$result->buyOrder.'</h2>          
            <table class="table table-striped">
                <tr>
                    <th><div class="alert alert-error">Las posibles causas de este rechazo son:</div></th>
                </tr>
                    <tr>
                <td><img src="images/vineta.gif" style="margin-right: 10px;"/> Error en el ingreso de los datos de su tarjeta de cr&eacute;dito o debito (fecha y/o c&oacute;digo de seguridad). </td>
                    </tr>
                <tr>
                    <td><img src="images/vineta.gif" style="margin-right: 10px;"/>Su tarjeta no cuenta con saldo suficiente. </td>
                </tr>            
                <tr>
                    <td><img src="images/vineta.gif" style="margin-right: 10px;"/>Tarjeta aun no habilita en el sistema financiero.</td>
                </tr>
            </table><br/><a href="http://'.$web.'">Volver al sitio Principal</a>';            
        }

        $button_name = "Continuar &raquo;";
        
		/* Update en base de datos */
		$sqlU="UPDATE pro_webpay_webservice SET 
			accountingDate='".$result->accountingDate."',
			buyOrder='".$result->buyOrder."',
			cardNumber='".$result->cardDetail->cardNumber."',
			cardExpirationDate='".$result->cardDetail->cardExpirationDate."',
			authorizationCode='".$result->detailOutput->authorizationCode."',
			paymentTypeCode='".$result->detailOutput->paymentTypeCode."',
			responseCode='".$result->detailOutput->responseCode."',
			sharesNumber='".$result->detailOutput->sharesNumber."',
			amount='".$result->detailOutput->amount."',
			commerceCode='".$result->detailOutput->commerceCode."',
			sessionId='".$result->sessionId."',
			transactionDate='".$result->transactionDate."',
			VCI='".$result->VCI."',
			estado='".$estado."' WHERE `token`='$token'";
		$gsent= $db_con->prepare($sqlU);
		$gsent->execute();
			
		if($estado == "Aceptado"){
			$sqlUJ="UPDATE pro_webpay_reserve  SET 
				estado='Pago Aceptado'
				WHERE `id`='".$result->buyOrder."'";
				$gsent= $db_con->prepare($sqlUJ);
				$gsent->execute(); 
		}else{
			$sqlUJ="UPDATE pro_webpay_reserve  SET 
				estado='Pago rechazado'
				WHERE `id`='".$result->buyOrder."'";
				$gsent= $db_con->prepare($sqlUJ);
				$gsent->execute();			
			
		}        
        

        break;
    
    case "end":
        
        $post_array = true;
        
        $tx_step = "End";
        $request = "";
        $result = $_POST;
       // print_r($result);
        $message = "Transacion Finalizada";
        $next_page = $sample_baseurl."?action=nullify";
        $button_name = "Anular Transacci&oacute;n &raquo;";

		$token = $_POST["token_ws"];
			if ($token) {
					
				//DB WebPay
				$i=0;					
				$sql_webpay = "SELECT 
					user_id,
					first_name,
					last_name,
					email,
					tipo,
					transactionDate,
					buyOrder,
					cardNumber,
					cardExpirationDate,
					authorizationCode,
					paymentTypeCode,
					responseCode,
					sharesNumber,
					amount,
					accountingDate,  
					VCI, 
					sessionId, 				
					commerceCode 
					FROM pro_webpay_webservice 
					WHERE 
					token = '".$token."'";
					
				$gsent= $db_con->prepare($sql_webpay);
				$gsent->execute();	
				
				while ($row = $gsent->fetch(PDO::FETCH_ASSOC)) {
						$i++;
						//Datos transaccion
						 $tipo= $row['tipo'];
						 //$Tienda = $row['Tienda'];
						 $t_compra = $row['buyOrder']; 
						 $t_monto = $row['amount']; 
						 $tar_final = $row['cardNumber']; 
						 $cuotas = $row['sharesNumber']; 
						 $cod = $row['authorizationCode']; 
						 $pagos = $row['paymentTypeCode'];
						 $VCI = $row['VCI'];
						 $FechaCompleta = $row['transactionDate'];
						 $id_session = $row['sessionId'];	
						 $fechapago = date('d-m-Y H:s',$FechaCompleta);
						 
						 //Datos Personales
						 $user_id = $row['user_id'];
						 $name_compra = $row['first_name'];
						 $ape_compra = $row['last_name'];
						 $user_mail = $row['email'];			 
					}
					
					
					//Ver tipo de pago
					switch($pagos){
					   case VN:
						  $tipo_pago = ("Crédito");
						  $tipo_de_cuota = ("Sin Cuotas");
						  $num_cuota = ("00"); 
						  break;
					   case SI:
						  $tipo_pago = ("Crédito");
						  $tipo_de_cuota = ("Sin interés");
						  $num_cuota = $cuotas; 
						  break;
					   case S2:
						  $tipo_pago = ("Crédito");
						  $tipo_de_cuota = ("Sin interés");
						  $num_cuota = $cuotas; 
						  break;						  
					   case VC:
						  $tipo_pago = ("Crédito");
						  $tipo_de_cuota = ("Cuotas normales");
						  $num_cuota = $cuotas; 
						  break;
					   case NC:
						  $tipo_pago = ("Crédito");
						  $tipo_de_cuota = ("Sin interés");
						  $num_cuota = $cuotas; 
						  break;
					   case VD:
						  $tipo_pago = ("Débito");
						  $tipo_de_cuota = ("Venta débito");
						  $num_cuota = ("00"); 
						  break;
					 } 				

			//mysql_query("SET NAMES 'utf8'");	
			$pagina.='<h1>Comprobante de compra</h1>
			  <div class="alert">Detalle de Compra Exitosa</div>
			  <p>Estimado (a), '.$name_compra.' '.$ape_compra.', gracias por comprar en nuestra tienda utilizando WebPay Plus.</p>';	

//Detalle Compra
			$pagina.='<table class="table table-striped">
					<tr>
						<th>N&#176;</th>
						<th>ID Producto</th>
						<th>Producto</th>

						<th>Precio Total</th>
					</tr>';		
			$pagina.='<tr>
						<td>1</td>
						<td>1</td>
						<td>Cobro '.$tipo.'</td>

						<td>$ '.number_format($t_monto,0,',','.').'</td>
					</tr>';				
			$pagina.='	</table>';


//Detalle Voucher
			$pagina.='<table class="table table-striped">
						<tr>
							<th colspan="2">Detalles de la compra</th>
						</tr>
						<tr>
							<td>Numero de pedido:</td>
							<td>'.$t_compra.'</td>
						</tr>
						<tr>
							<td>Fecha del Pago: </td>
							<td>'.$FechaCompleta.'</td>
						</tr>
						<tr>
							<td>URL p&aacute;gina Web:</td>
							<td><a href="http://'.$web.'">'.$web.'</a></td>
						</tr>
						<tr>
							<td>C&oacute;digo de Autorizaci&oacute;n:</td>
							<td>'.$cod.'</td>
						</tr>
						<tr>
							<td>Tipo de Transacción:</td>
							<td>Venta</td>
						</tr>
						<tr>
							<td>N&uacute;mero de Tarjeta:</td>
							<td>XXXXXXXXXXXX-'.$tar_final.'</td>
						</tr>
						 <tr>
							<td>Tipo de Pago:</td>
							<td>'.$tipo_pago.'</td>
						</tr> 
						 <tr>
							<td>Tipo de Cuotas:</td>
							<td>'.$tipo_de_cuota.'</td>
						</tr> 			
						<tr>
							<td>Cantidad de Cuotas:</td>
							<td>'.$cuotas.'</td>
						</tr>
						 <tr>
							<td>Monto Total en Pesos:</td>
							<td>$ '.number_format($t_monto,0,',','.').'</td>
						</tr>             
					  </table>
						<a href="http://'.$web.'">Volver al sitio Principal</a>
						<p>No se realizan devoluciones ni reembolsos, pero en caso de tener alguna duda favor de contactar al mail '.$correo.'</p>';

			//Fin validacion OK
				/*----------------------------------------------------------------------
				
				Construimos email para el admin
				
				----------------------------------------------------------------------*/
					//cabeceras
					$headers1 = "MIME-Version: 1.0\r\n"; 
					$headers1 .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers1 .= "From: <".$user_mail.">\r\n"; 
					//asunto y destino
					$asunto = "Pago por metodo WebPay tienda $web";
					$destino = "".$correo."";
					//mensaje
					$mensaje = "<div align='center' style='font-size:20pt; color: red;'>";
					$mensaje .= "ORDEN DE COMPRA PAGADA (WEBPAY)";
					$mensaje .= "</div>";
					$mensaje .= $pagina;		
				
					$fecha=date("d-m-Y");
					$hora=date("H:i");
				
				
					$mensaje .= "</p><p>La orden de compra n&uacute;mero: ".$trs_orden_compra.", fue pagada con &eacute;xito en la tienda $web.<br/>";
					$mensaje .= "Datos enviados el ".$fecha." a las ".$hora.".";
					$mensaje .= "</p>";
				
					/*----------------------------------------------------------------------
					Construimos email para el cliente
					----------------------------------------------------------------------*/
				
					//cabeceras
				
					$headers2 = "MIME-Version: 1.0\r\n";
					$headers2 .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers2 .= "From: Confirmacion <".$correo.">\r\n";
					//asunto y destino
				
					$asunto2 = "Comprobante de compra ".$web;
					$destino2 = "".$user_mail."";
					//mensaje para el cliente
					$mensaje2 =$pagina;	
					$fecha=date("d-m-Y");
					$hora=date("H:i");
				
					$mensaje2 .= "</p><p>";
					$mensaje2 .= "Datos enviados el ".$fecha." a las ".$hora.".";
					$mensaje2 .= "<br>NOTA: Algunos tildes fueron omitidos en este correo.</p>";
				
					/*------------------------------------------------------------------------
					Envio de mensajes
					-------------------------------------------------------------------------*/

					//mail($destino,$asunto,$mensaje,$headers1);
					//mail($destino2,$asunto2,$mensaje2,$headers2);		

			} else {

				$pagina.='<h1>Transacción Rechazada</h1>
				<h2>OC Nº '.$result['TBK_ORDEN_COMPRA'].'</h2>				
				<table class="table table-striped">
					<tr>
						<th> <div class="alert alert-error">Las posibles causas de este rechazo son:</div></th>
					</tr>
						<tr>
					<td><img src="images/vineta.gif" style="margin-right: 10px;"/> Error en el ingreso de los datos de su tarjeta de cr&eacute;dito o debito (fecha y/o c&oacute;digo de seguridad). </td>
						</tr>
					<tr>
						<td><img src="images/vineta.gif" style="margin-right: 10px;"/>Su tarjeta no cuenta con saldo suficiente. </td>
					</tr>            
					<tr>
						<td><img src="images/vineta.gif" style="margin-right: 10px;"/>Tarjeta aun no habilita en el sistema financiero.</td>
					</tr>
				</table><br/><a href="http://'.$web.'">Volver al sitio Principal</a>';								
			}


        break;   

    
    case "nullify":
    
     $id_trans =  $_GET['id_transaccion'];
     
     if($id_trans){
	$gsent= $db_con->prepare("SELECT * FROM pro_webpay_webservice WHERE id=$id_trans");
	$gsent->execute();
	    while ($fila = $gsent->fetch(PDO::FETCH_ASSOC)) {
	    
				$authorizationCode = $fila['authorizationCode'];
				$amount = $fila['amount'];
				$buyOrder = $fila['buyOrder']; 
				$nullifyAmount = $fila['amount']; 
				$commercecode = $fila['commerceCode']; 
	}


        $tx_step = "nullify";
        
        $request = $_POST;
        
        /** Codigo de Comercio */
       // $commercecode = null;

        /** Código de autorización de la transacción que se requiere anular */
        //$authorizationCode = filter_input(INPUT_POST, 'authorizationCode');

        /** Monto autorizado de la transacción que se requiere anular */
        //$amount =  filter_input(INPUT_POST, 'amount');

        /** Orden de compra de la transacción que se requiere anular */
       // $buyOrder =  filter_input(INPUT_POST, 'buyOrder');
        
        /** Monto que se desea anular de la transacción */
        //$nullifyAmount = 200;

        $request = array(
            "authorizationCode" => $authorizationCode, // Código de autorización
            "authorizedAmount" => $amount, // Monto autorizado
            "buyOrder" => $buyOrder, // Orden de compra
            "nullifyAmount" => $nullifyAmount, // idsession local
            "commercecode" => $configuration->getCommerceCode(), // idsession local
        );
        
        $result = $webpay->getNullifyTransaction()->nullify($authorizationCode, $amount, $buyOrder, $nullifyAmount, $commercecode);
        
        /** Verificamos resultado  de transacción */
        if (!isset($result->authorizationCode)) {
            $message = "webpay no disponible";
        } else {
            $message = "Transaci&oacute;n Finalizada";
        }

        $next_page = '';
        }
        break;
}

//echo "<h2>Step: " . $tx_step . "</h2>";
$cert_null=0;
if (!isset($request) || !isset($result) || !isset($message) || !isset($next_page)) {

    $result = "Ocurri&oacute; un error al procesar tu solicitud";
    $cert_null=1;
    //echo "<div style = 'background-color:lightgrey;'><h3>result</h3>$result;</div><br/><br/>";
    //echo "<a href='.'>&laquo; volver a index</a>";
    
/*$pagina.='<h1>Transacción Rechazada</h1>
		  <h2>OC Nº '.$id.'</h2>          
			<table class="table table-striped">
				<tr>
					<th><div class="alert alert-error">Las posibles causas de este rechazo son:</div></th>
				</tr>
					<tr>
				<td><img src="images/vineta.gif" style="margin-right: 10px;"/> Error en el ingreso de los datos de su tarjeta de cr&eacute;dito o debito (fecha y/o c&oacute;digo de seguridad). </td>
					</tr>
				<tr>
					<td><img src="images/vineta.gif" style="margin-right: 10px;"/>Su tarjeta no cuenta con saldo suficiente. </td>
				</tr>            
				<tr>
					<td><img src="images/vineta.gif" style="margin-right: 10px;"/>Tarjeta aun no habilita en el sistema financiero.</td>
				</tr>
			</table><br/><a href="http://'.$web.'">Volver al sitio Principal</a>';    */
    
   // die;
}

/* Respuesta de Salida - Vista WEB */
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sistema de pago WebPay Plus</title>
<meta name="description" content="Sistema de pago Webpay plus"/>
<meta name="keywords" content="webpay plus, joomlaempresa"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<!--<link rel="stylesheet" type="text/css" href="css/style.css"/>-->
<link rel="stylesheet" type="text/css" href="css/siimple.css"/>
<style>
.bg{
  background-image: url(https://webpay3g.transbank.cl/webpayserver/imagenes/background.gif);
}
</style>
</head>
<body<?php if($estado =="Aceptado"){echo ' class="bg"';} ?>>
	<div id="container" <?php if($estado =="Aceptado"){echo 'style="display: none;';} ?>>
		<div id="site_content">
                      <?=$pagina?>
<?php
     if($action == 'init' and $cert_null==0) {
     

			echo 'Detalle de la compra<br>';
			echo "<table>"; 
			echo "<tr><td>Nombre</td><td>$name_compra</td></tr>";
			echo "<tr><td>Apellido</td><td>$ape_compra </td></tr>";
			echo "<tr><td>OC</td><td>$id_orders </td></tr>";
			echo "<tr><td>Total</td><td>$total </td></tr>";
			echo "<tr><td>Tipo</td><td>Cobro $tipo_cobro </td></tr>";
			echo "</table>";

			
}

?>
<!-- <div style="background-color:lightyellow;">
	<h3>request</h3>
	<?php  var_dump($request); ?>
</div>
<div style="background-color:lightgrey;">
	<h3>result</h3>
	<?php  var_dump($result); ?>
</div>
<p><samp><?php  echo $message; ?></samp></p>
-->
<?php if (strlen($next_page) && $post_array) { ?>

       <!-- <form action="<?php echo $next_page; ?>" method="post" id="form-input">
            <input type="hidden" name="authorizationCode" id="authorizationCode" value="">
            <input type="hidden" name="amount" id="amount" value="">
            <input type="hidden" name="buyOrder" id="buyOrder" value="">
            <input type="submit" value="<?php echo $button_name; ?>">
        </form>

        <script>
            
            var authorizationCode = localStorage.getItem('authorizationCode');
            document.getElementById("authorizationCode").value = authorizationCode;
            
            var amount = localStorage.getItem('amount');
            document.getElementById("amount").value = amount;
            
            var buyOrder = localStorage.getItem('buyOrder');
            document.getElementById("buyOrder").value = buyOrder;
            
            localStorage.clear();
            
        </script>-->
        
<?php  } elseif (strlen($next_page)) { ?>
    <form name="myForm" id="myForm" action="<?php echo $next_page; ?>" method="post">
    
    <input type="hidden" name="token_ws" value="<?php echo ($token); ?>">
    <input type="submit" value="<?php echo $button_name; ?>">
</form>
<?php
     if($action != 'init') {
     ?>
				<script>

				var auto_refresh = setInterval(
				function()
				{
				submitform();
				}, 1000);

				function submitform()
				{
				  //alert('test');
				  document.myForm.submit();
				}
				</script>
<?php } ?>				
<?php } ?>

<br>
<a href=".">&laquo; volver a reservas</a>
		</div>
	</div>
	<blockquote <?php if($estado =="Aceptado"){echo 'style="display: none;';} ?>>Desarrollado por <a href="http://www.cristiancisternas.com">Cristian Cisternas</a></blockquote>
</body>