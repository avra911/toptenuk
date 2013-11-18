$mtkb(function($){
	if (typeof(Magen_filterslider) == "undefined") return;
	function reload(url) {
        $.blockUI({ message:null, overlayCSS: {opacity:0.16, zIndex:99999} });
        $('.col-main').first().load(url, function(){
            $.unblockUI(); 
        });
    }
	function filterProduct(){
		var ids = $("#category").val(); 
		var filtervalue = $("#slider").slider('values');
		var baseurl= $('#filter_url').val(); 
		var remainurl='mtcolinusadmin/filter/view?min='+ filtervalue[0] +'&max='+ filtervalue[1] +'&id='+ids ; 
		var correctbaseurl=baseurl + remainurl; 
		if ( Magen_filterslider.params != '' ) {
            correctbaseurl += '&' + Magen_filterslider.params;
        }
		reload(correctbaseurl); 
	}
	$("#slider").slider({range:true,
		min:0,
		max:$("#max-price").val(),
		values:[Magen_filterslider.filter_min,Magen_filterslider.filter_max],
		slide: function( event, ui ) {
			$( "#filter_min" ).html(Magen_filterslider.currency+ui.values[ 0 ]);
			$( "#filter_max" ).html(Magen_filterslider.currency+ui.values[ 1 ] );
		},
		create: function(){
			filterProduct(); 
		},
		stop: function(event, ui){
			$.cookie("filterslider_min_"+Magen_filterslider.category_id, ui.values[0], { path: '/' });
            $.cookie("filterslider_max_"+Magen_filterslider.category_id, ui.values[1], { path: '/' });
			filterProduct(); 
		}
	});
});