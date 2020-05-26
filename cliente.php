<?php 
include('include/functions.php');
if($_POST){
    if($_POST['action']=='comprobar_rut'){
        $rut = $_POST['rut'];
        $cliente = search_customer($rut);
        if($cliente['error']){
            echo json_encode($cliente);
        }else{
            $id_cliente['id'] = $cliente[0]['id'];
            echo json_encode($id_cliente); 
        }
        
        
    }
    elseif($_POST['action']=='crear_cliente'){
        foreach($_POST as $key => $value){
            $$key = $value;
        }
        $buscar = search_customer($rut);
        if($buscar['error']['code']=='404'){
            $crear = create_customer($name, $address, $phone, $rut, $email);
            $data['id_cliente'] = $crear;
            echo json_encode($data);
        }
        else{
            echo json_encode($buscar);
        }
    }
    
}

?>