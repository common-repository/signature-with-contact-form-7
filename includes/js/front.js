
jQuery(document).ready(function() {

     $x=1;

    var signatur_id = jQuery(".ocswcf_signature").length;
    jQuery('.ocswcf_signature').each( function(){

        
          //alert( $x);
         if($x == 1){

            var mycuone= jQuery('.ocswcf_signature');
            var color=mycuone.find(".oc_signature-pad").attr("color");
            var backcolor=mycuone.find(".oc_signature-pad").attr("backcolor");
            var width=mycuone.find(".oc_signature-pad").attr("width");
            var height=mycuone.find(".oc_signature-pad").attr("height");
            var custnameca=mycuone.find(".oc_signature-pad").attr("name");
           
            var canvas = document.getElementById("oc_signature-pad_"+custnameca);
            canvas.setAttribute("width", width);
            canvas.setAttribute("height", height);

            var signaturePad = new SignaturePad(document.getElementById("oc_signature-pad_"+custnameca), {
                                  backgroundColor: backcolor,
                                  penColor: color,
                                });

            jQuery(document).on('touchstart touchend click', "#oc_signature-pad_"+custnameca, function(event){
                if(event.handled === false) return
                event.stopPropagation();
                event.preventDefault();
                event.handled = true;

                // Do your magic here
                var data = signaturePad.toDataURL('image/png');
                jQuery("input[name="+custnameca+"]").val(data);

            });

            mycuone.find(".clearButton").click(function(){
                signaturePad.clear();
                jQuery("input[name="+custnameca+"]").val("");
            });


         }else{
            
            jQuery(this).html("<p>Multiple Signaturepad is Valid in pro version of signature contact form 7 <a href='https://www.xeeshop.com/product/signature-with-contact-form-7-pro/' target='_blank'>Click here Get Pro Version</a></p>");

         }

        $x++;
    });

    document.addEventListener( 'wpcf7mailsent', function( event ) {
        jQuery('.ocswcf_signature').each( function(){
            var custnameca=jQuery(this).find(".oc_signature-pad").attr("name");
            var color=jQuery(this).find(".oc_signature-pad").attr("color");
            var backcolor=jQuery(this).find(".oc_signature-pad").attr("backcolor");
            var signaturePad = new SignaturePad(document.getElementById("oc_signature-pad_"+custnameca), {
                backgroundColor: backcolor,
                penColor: color,
            });
            var custnameca= jQuery(this).find(".oc_signature-pad").attr("name");
            signaturePad.clear();
            jQuery("input[name="+custnameca+"]").val("");
        });
    }, false );
   
})

