// some scripts

// jquery ready start
$(document).ready(function() {
	// jQuery code



    
    /* ///////////////////////////////////////

    THESE FOLLOWING SCRIPTS ONLY FOR BASIC USAGE, 
    For sliders, interactions and other

    */ ///////////////////////////////////////
    

	//////////////////////// Prevent closing from click inside dropdown
    $(document).on('click', '.dropdown-menu', function (e) {
      e.stopPropagation();
    });

    ///////////////// fixed menu on scroll for desctop
    if ($(window).width() > 768) {
        
        $(window).scroll(function(){  
            if ($(this).scrollTop() > 125) {
                 $('.navbar-landing').addClass("fixed-top");
            }else{
                $('.navbar-landing').removeClass("fixed-top");
            }   
        });
    } // end if
    
	//////////////////////// Fancybox. /plugins/fancybox/
	if($("[data-fancybox]").length>0) {  // check if element exists
		$("[data-fancybox]").fancybox();
	} // end if
	
	//////////////////////// Bootstrap tooltip
	if($('[data-toggle="tooltip"]').length>0) {  // check if element exists
		$('[data-toggle="tooltip"]').tooltip()
	} // end if

    /////////////////////// Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a.page-scroll').click(function() {
        $('.navbar-toggler:visible').click();
    });

    //////////////////////// Menu scroll to section for landing
    $('a.page-scroll').click(function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({ scrollTop: $($anchor.attr('href')).offset().top - 50  }, 1000);
        event.preventDefault();
    });

    /////////////////  items slider. /plugins/slickslider/
    if ($('.slick-slider').length > 0) { // check if element exists
        $('.slick-slider').slick();
    } // end if

	/////////////////  items carousel. /plugins/owlcarousel/
    if ($('.owl-init').length > 0) { // check if element exists

       $(".owl-init").each(function(){
            
            var myOwl = $(this);
            var data_items = myOwl.data('items');
            var data_nav = myOwl.data('nav');
            var data_dots = myOwl.data('dots');
            var data_margin = myOwl.data('margin');
            var data_custom_nav = myOwl.data('custom-nav');
            var id_owl = myOwl.attr('id');

            myOwl.owlCarousel({
                loop: true,
                margin: data_margin,
                nav: eval(data_nav),
                dots: eval(data_dots),
                autoplay: false,
                items: data_items,
                navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                 //items: 4,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: data_items
                    },
                    1000: {
                        items: data_items
                    }
                }
            });

            // for custom navigation. See example page: example-sliders.html
            $('.'+data_custom_nav+'.owl-custom-next').click(function(){
                $('#'+id_owl).trigger('next.owl.carousel');
            });

            $('.'+data_custom_nav+'.owl-custom-prev').click(function(){
                $('#'+id_owl).trigger('prev.owl.carousel');
            });
           
        }); // each end.//
    } // end if
	

}); 
// jquery end

//RUT
function revisarDigito(dvr, elemento){
  dv = dvr + ""
  if( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K'){
    alert("Debe ingresar un digito verificador valido");
    document.getElementById(elemento).focus();
    document.getElementById(elemento).select();
    $('input[type="text"]').val('');
    return false;
  }
  return true;
}

function revisarDigito2(crut, elemento){
  largo = crut.length;
  if(largo<2){
    alert("Debe ingresar el rut completo")
    document.getElementById(elemento).focus();
    document.getElementById(elemento).select();
    $('input[type="text"]').val('');
    return false;
  }
  if(largo>2)
    rut = crut.substring(0, largo - 1);
  else
    rut = crut.charAt(0);
    dv = crut.charAt(largo-1);
    revisarDigito( dv, elemento );

  if ( rut == null || dv == null )
    return 0
    var dvr = '0'
    suma = 0
    mul  = 2

    for (i= rut.length -1 ; i >= 0; i--){
        suma = suma + rut.charAt(i) * mul
        if (mul == 7)
            mul = 2
        else
            mul++
    }
    res = suma % 11
    if (res==1)
        dvr = 'k'
    else if (res==0)
        dvr = '0'
    else
    {
        dvi = 11-res
        dvr = dvi + ""
    }
    if ( dvr != dv.toLowerCase() )
    {
        alert("EL rut es incorrecto");
        document.getElementById(elemento).focus();
        document.getElementById(elemento).select();
        $('input[type="text"]').val('');
        return false
    }

    return true
}

function Rut(texto, elemento){
  var tmpstr = "";
  for ( i=0; i < texto.length ; i++ )
    if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
        tmpstr = tmpstr + texto.charAt(i);
    texto = tmpstr;
    largo = texto.length;

    if ( largo < 2 ){
        alert("Debe ingresar el rut completo")
        document.getElementById(elemento).focus();
        document.getElementById(elemento).select();
        $('input[type="text"]').val('');
        return false;
    }

    for (i=0; i < largo ; i++ ){
        if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" ){
            alert("El valor ingresado no corresponde a un R.U.T valido");
            document.getElementById(elemento).focus();
            document.getElementById(elemento).select();
            $('input[type="text"]').val('');
            return false;
        }
    }

    var invertido = "";
    for ( i=(largo-1),j=0; i>=0; i--,j++ )
        invertido = invertido + texto.charAt(i);
    var dtexto = "";
    dtexto = dtexto + invertido.charAt(0);
    dtexto = dtexto + '-';
    cnt = 0;

    for ( i=1,j=2; i<largo; i++,j++ ){
        //alert("i=[" + i + "] j=[" + j +"]" );
        if ( cnt == 3 ){
            dtexto = dtexto + '.';
            j++;
            dtexto = dtexto + invertido.charAt(i);
            cnt = 1;
        }else{
           dtexto = dtexto + invertido.charAt(i);
           cnt++;
        }
    }

    invertido = "";
    for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )
        invertido = invertido + dtexto.charAt(i);

    document.getElementById(elemento).value = invertido.toLowerCase()

    if(revisarDigito2(texto, elemento))
        comprobar_rut();
        return true;
    return false;
}

function comprobar_rut(){
    var alerta = "<div class='alert alert-warning' role='alert'>";
        var action = 'comprobar_rut';
        var rut = $('#rut').val();
        var count = 0;
        if(rut!=''){
            count++;
        }else{
            alerta+='Se requiere RUT <br/>';
        }
         if(count>=1){
        $.ajax({
                type  : 'ajax',
                method : 'POST',
                url   : 'cliente.php',
                data : { rut : rut, action : action },
                async : false,
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    if(data.error){
                        console.log('error');
                        alerta+='Se requiere crear un cliente nuevo</div>';
                        $('#exampleModal').modal('show');
                        $( "#alerta_modal" ).html(alerta);
                        $('#rut2').val(rut);
                        $("#pagar-button").prop("disabled", true);
                    }else{
                      $('#id_cliente').val(data.id);   
                      $("#pagar-button").removeAttr('disabled');
                    }
                }

            });
         }
         else{
            alerta+='</div>';
            $( "#div-alert" ).html(alerta);
        }
}

