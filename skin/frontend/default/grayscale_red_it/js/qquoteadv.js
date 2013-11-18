function prepareIE(height, overflow) {
  bod = document.getElementsByTagName('body')[0];
  bod.style.height = height;
  bod.style.overflow = overflow;

  htm = document.getElementsByTagName('html')[0];
  htm.style.height = height;
  htm.style.overflow = overflow;
}

function initMsg() {
  bod = document.getElementsByTagName('body')[0];
  overlay = document.createElement('div');
  overlay.id = 'overlay';
 
  bod.appendChild(overlay);
  $('overlay').style.display = 'block';
  try{
    $('lightbox1').style.display = 'block';
  }catch(e){}
  prepareIE("auto", "auto");
}
function cancelMsg() {
  bod = document.getElementsByTagName('body')[0];
  olddiv = document.getElementById('overlay');
  if(overlay){
	bod.removeChild(olddiv);
  }
}

function addQuote(url, ajax) {
  frmAdd2Cart = $('product_addtocart_form');
  if(frmAdd2Cart) {
	var validator = new Validation(frmAdd2Cart);
	if(validator)
	  if (validator.validate()){ 
              if(ajax == 1){
                initMsg()
                lightbox2 = document.createElement('div');
                lightbox2.id = "lightbox2";
                overlay.appendChild(lightbox2);
                
                lightboxload = document.createElement('div');
                lightboxload.id = "lightboxload";
                lightbox2.appendChild(lightboxload);
                frmValues = frmAdd2Cart.serialize(true);
                new Ajax.Request(url, {
                    parameters: frmValues,
                    method: 'post',
                    evalJSON : 'force',
                    onSuccess: function(transport) {
                      data = transport.responseJSON;
                      if(data['result'] == 1){
                         $$('a.top-link-qquoteadv')[0].update(data['itemstext']); 
                         document.getElementById('lightbox2').innerHTML =data['html'] ;
                      }else{
                        document.location.href= data['producturl']
                      }
                    }
                  });
              }else{
                frmAdd2Cart.writeAttribute('action', url);
		frmAdd2Cart.submit();
              }
	  }
  }
}

function addQuoteList(url, ajax) {
  
    if(url.indexOf("c2qredirect") != -1){
         document.location.href= url;
    }else{
        
        if(ajax == 1){
          initMsg()
          lightbox2 = document.createElement('div');
          lightbox2.id = "lightbox2";
          overlay.appendChild(lightbox2);

          lightboxload = document.createElement('div');
          lightboxload.id = "lightboxload";
          lightbox2.appendChild(lightboxload);



          new Ajax.Request(url, {
              method: 'post',
              evalJSON : 'force',
              onSuccess: function(transport) {
                data = transport.responseJSON;
                if(data['result'] == 1){
                   $$('a.top-link-qquoteadv')[0].update(data['itemstext']); 
                   document.getElementById('lightbox2').innerHTML =data['html'] ;
                }else{
                  document.location.href= data['producturl']
                }
              }
            });
        }else{
          frmAdd2Cart.writeAttribute('action', url);
          frmAdd2Cart.submit();
        }
    }

}

function isExistUserEmail(event, url, errorMsg){ 
  elmEmail		  = Event.element(event);
  elmEmailMsg	  = $('email_message');
  loaderEmailDiv  = $("please-wait");
  btnSubm		  = $('submitOrder')
  
  if(btnSubm) {btnSubm.disabled=false; }
  
  val = $F(elmEmail);  //$F('customer:email'); 
  var pars = 'email=' +  val;
  
  //loader
  loaderEmailDiv.show();
  
  new Ajax.Request( url, {
	method: 'post',
	parameters: pars,
	//onCreate: function() {  },
	onSuccess: function( transport ){	 
	  var responseStr = transport.responseText;
	  if(responseStr=='exists'){
		elmEmailMsg.show();
		elmEmailMsg.innerHTML=errorMsg;
		elmEmailMsg.addClassName("validation-advice");

		if($('advice-required-entry-customer:email')) $('advice-required-entry-customer:email').hide();
		if($('advice-validate-email-customer:email')) $('advice-validate-email-customer:email').hide();

		elmEmail.addClassName('validation-failed');
        if(btnSubm){ 
			btnSubm.setStyle({background: '#dddddd'});
			btnSubm.disabled=true;
		}

	  }else{
		elmEmailMsg.hide();
		elmEmailMsg.removeClassName("validation-advice");
	  }  
	  loaderEmailDiv.hide();
	},
	onFailure: function() {  
	  loaderEmailDiv.hide(); 
	  alert('Connection Error. Try again later.');
	}	     	
  });	
  
  return(false);
}