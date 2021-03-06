<?php include 'common/header.php'; ?>

<style>
.accordion {
  background-color: white;
  color: black;
  font-weight:bold;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: 1px solid gray;
  border-radius:10px;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
  margin-top: 12px;
}

.active, .accordion:hover {
  background-color: #ccc;
}

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.img-help-center {
    object-fit:contain;
}
.accordion:after {
  content: '\02795'; /* Unicode character for "plus" sign (+) */
  font-size: 13px;
  color: #777;
  float: right;
  margin-left: 5px;
}
.active:after {
  content: "\2796"; /* Unicode character for "minus" sign (-) */
}
.ico_tam{
    font-size:4em;
}
.faqs-question {
    color:darkslategray;
}
.title-faqs {
    border-bottom:1px solid #0198ff;
}
</style>
<div class="container mt-5 mb-5">
    <div class="row">
        <aside class="question col-12 col-lg-3 border-right">
            <h3 class="title-faqs mb-4 font-weight-bold">CENTRO DE AYUDA</h3>
            <div class="faqs">
                <a href="centro_de_ayuda/como_comprar.php" class="faqs-question d-block mb-4 border-bottom">Como comprar</a>
                <a href="centro_de_ayuda/Estado_pedido.php" class="faqs-question d-block mb-4 border-bottom">Estado de mi pedido</a>
                <a href="centro_de_ayuda/Formas_de_pago.php" class="faqs-question d-block mb-4 border-bottom">Formas de pago</a>
                <a href="centro_de_ayuda/Envio_y_Entrega.php" class="faqs-question d-block mb-4 border-bottom">Envio y entrega</a>
                <a href="centro_de_ayuda/reembolso.php" class="faqs-question font-weight-bold ml-4 d-block mb-4 border-bottom">Reembolsos</a>
            </div>
        </aside>
        <div class="answers col-12 col-lg-9">
            <h3 class="title-answers border-bottom pb-4 font-weight-bold">REEMBOLSOS</h3>
            <div class="frecuentes mt-4">
                
                <button class="accordion shadow">¿Como devuelvo un producto?</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
    
                <button class="accordion shadow">¿Puedo regresar todos los productos?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
    
                <button class="accordion shadow">¿Qué hacer si el producto llega dañado?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
                <button class="accordion shadow">¿Se puede cambiar un producto?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
                <button class="accordion shadow">¿Qué hacer si el producto llega dañado?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
                <button class="accordion shadow">¿Cuanto tiempo tengo para realizar una devolución?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
                 <button class="accordion shadow">¿Cual es el costo por devolución?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
                <button class="accordion shadow">Condiciones del producto y el empaque</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
                <button class="accordion shadow">¿Cuanto tiempo tarda una devolución?</button>
                <div class="panel">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                
            </div>
        </div>
    </div>
</div>




















<div class=container>
    <h2 class="text-center"> ¡ Si aun encuentras dudas de  nuestros procesos contacta con nosotros !</h2>
    <div class="row d-flex justify-content-around">
        <div class="text-center">
            
            <i class="fas fa-fax ico_tam"></i>
            <p class="h4">Llamanos al <br> 
            <span class="text-info">600 600 3010</span><br>
             si necesitas ayuda.</p>
        </div>
         <div class="text-center">
             <i class="fas fa-phone-volume ico_tam animated bounce infinite"></i>
            <p class="h4">Llamanos al <br> 
            <span class="text-info">600 600 3010</span><br>
             si necesitas ayuda.</p>
        </div>
    </div >
    
    
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>






<?php include 'common/footer.php'; ?>