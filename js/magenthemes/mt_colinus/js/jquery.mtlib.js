(function($){
	$.easing['jswing'] = $.easing['swing']; 
$.extend( $.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert($.easing.default);
		return $.easing[$.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - $.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return $.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return $.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});
})(jQuery);

(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);

jQuery.cookie = function(name, value, options) {

    if (typeof value != 'undefined') { // name and value given, set cookie

        options = options || {};

        if (value === null) {

            value = '';

            options.expires = -1;

        }

        var expires = '';

        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {

            var date;

            if (typeof options.expires == 'number') {

                date = new Date();

                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));

            } else {

                date = options.expires;

            }

            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE

        }

        // CAUTION: Needed to parenthesize options.path and options.domain

        // in the following expressions, otherwise they evaluate to undefined

        // in the packed version for some reason...

        var path = options.path ? '; path=' + (options.path) : '';

        var domain = options.domain ? '; domain=' + (options.domain) : '';

        var secure = options.secure ? '; secure' : '';

        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');

    } else { // only name given, get cookie

        var cookieValue = null;

        if (document.cookie && document.cookie != '') {

            var cookies = document.cookie.split(';');

            for (var i = 0; i < cookies.length; i++) {

                var cookie = jQuery.trim(cookies[i]);

                // Does this cookie string begin with the name we want?

                if (cookie.substring(0, name.length + 1) == (name + '=')) {

                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));

                    break;

                }

            }

        }

        return cookieValue;

    }

};



//MT Lightbox

LightboxOptions = Object.extend({

    fileLoadingImage:        '',     

    fileBottomNavCloseImage: '',



    overlayOpacity: 0.8,   // controls transparency of shadow overlay



    animate: true,         // toggles resizing animations

    resizeSpeed: 7,        // controls the speed of the image resizing animations (1=slowest and 10=fastest)



    borderSize: 10,         //if you adjust the padding in the CSS, you will need to update this variable



	// When grouping images this is used to write: Image # of #.

	// Change it for non-english localization

	labelImage: "Image",

	labelOf: "of"

}, window.LightboxOptions || {});



// -----------------------------------------------------------------------------------



var Lightbox = Class.create();



Lightbox.prototype = {

    imageArray: [],

    activeImage: undefined,

    

    // initialize()

    // Constructor runs on completion of the DOM loading. Calls updateImageList and then

    // the function inserts html at the bottom of the page which is used to display the shadow 

    // overlay and the image container.

    //

    initialize: function() {    

        

        this.updateImageList();

        

        this.keyboardAction = this.keyboardAction.bindAsEventListener(this);



        if (LightboxOptions.resizeSpeed > 10) LightboxOptions.resizeSpeed = 10;

        if (LightboxOptions.resizeSpeed < 1)  LightboxOptions.resizeSpeed = 1;



	    this.resizeDuration = LightboxOptions.animate ? ((11 - LightboxOptions.resizeSpeed) * 0.15) : 0;

	    this.overlayDuration = LightboxOptions.animate ? 0.2 : 0;  // shadow fade in/out duration



        // When Lightbox starts it will resize itself from 250 by 250 to the current image dimension.

        // If animations are turned off, it will be hidden as to prevent a flicker of a

        // white 250 by 250 box.

        var size = (LightboxOptions.animate ? 250 : 1) + 'px';

        



        // Code inserts html at the bottom of the page that looks similar to this:

        //

        //  <div id="overlay"></div>

        //  <div id="lightbox">

        //      <div id="outerImageContainer">

        //          <div id="imageContainer">

        //              <img id="lightboxImage">

        //              <div style="" id="hoverNav">

        //                  <a href="#" id="prevLink"></a>

        //                  <a href="#" id="nextLink"></a>

        //              </div>

        //              <div id="loading">

        //                  <a href="#" id="loadingLink">

        //                      <img src="images/loading.gif">

        //                  </a>

        //              </div>

        //          </div>

        //      </div>

        //      <div id="imageDataContainer">

        //          <div id="imageData">

        //              <div id="imageDetails">

        //                  <span id="caption"></span>

        //                  <span id="numberDisplay"></span>

        //              </div>

        //              <div id="bottomNav">

        //                  <a href="#" id="bottomNavClose">

        //                      <img src="images/close.gif">

        //                  </a>

        //              </div>

        //          </div>

        //      </div>

        //  </div>





        var objBody = $$('body')[0];



		objBody.appendChild(Builder.node('div',{id:'overlay'}));

	

        objBody.appendChild(Builder.node('div',{id:'lightbox'}, [

            Builder.node('div',{id:'outerImageContainer'}, 

                Builder.node('div',{id:'imageContainer'}, [

                    Builder.node('img',{id:'lightboxImage'}), 

                    Builder.node('div',{id:'hoverNav'}, [

                        Builder.node('a',{id:'prevLink', href: '#' }),

                        Builder.node('a',{id:'nextLink', href: '#' })

                    ]),

                    Builder.node('div',{id:'loading'}, 

                        Builder.node('a',{id:'loadingLink', href: '#' }, 

                            Builder.node('img', {src: LightboxOptions.fileLoadingImage})

                        )

                    )

                ])

            ),

            Builder.node('div', {id:'imageDataContainer'},

                Builder.node('div',{id:'imageData'}, [

                    Builder.node('div',{id:'imageDetails'}, [

                        Builder.node('span',{id:'caption'}),

                        Builder.node('span',{id:'numberDisplay'})

                    ]),

                    Builder.node('div',{id:'bottomNav'},

                        Builder.node('a',{id:'bottomNavClose', href: '#' },

                            Builder.node('img', { src: LightboxOptions.fileBottomNavCloseImage })

                        )

                    )

                ])

            )

        ]));





		$('overlay').hide().observe('click', (function() { this.end(); }).bind(this));

		$('lightbox').hide().observe('click', (function(event) { if (event.element().id == 'lightbox') this.end(); }).bind(this));

		//$('outerImageContainer').setStyle({ width: size, height: size });

		$('prevLink').observe('click', (function(event) { event.stop(); this.changeImage(this.activeImage - 1); }).bindAsEventListener(this));

		$('nextLink').observe('click', (function(event) { event.stop(); this.changeImage(this.activeImage + 1); }).bindAsEventListener(this));

		$('loadingLink').observe('click', (function(event) { event.stop(); this.end(); }).bind(this));

		$('bottomNavClose').observe('click', (function(event) { event.stop(); this.end(); }).bind(this));



        var th = this;

        (function(){

            var ids = 

                'overlay lightbox outerImageContainer imageContainer lightboxImage hoverNav prevLink nextLink loading loadingLink ' + 

                'imageDataContainer imageData imageDetails caption numberDisplay bottomNav bottomNavClose';   

            $w(ids).each(function(id){ th[id] = $(id); });

        }).defer();

    },



    //

    // updateImageList()

    // Loops through anchor tags looking for 'lightbox' references and applies onclick

    // events to appropriate links. You can rerun after dynamically adding images w/ajax.

    //

    updateImageList: function() {   

        this.updateImageList = Prototype.emptyFunction;



        document.observe('click', (function(event){

            var targetP = event.findElement('p[class^=product-image]');

            if(targetP) {

                var elementA = $$('a.mt-a-lighbox')[0];

                

                //var target = event.findElement('a[rel^=lightbox]') || event.findElement('area[rel^=lightbox]');

                if (elementA) {

                    event.stop();

                    this.start(elementA);

                }

            }

        }).bind(this));

    },

    

    //

    //  start()

    //  Display overlay and lightbox. If image is part of a set, add siblings to imageArray.

    //

    start: function(imageLink) {    



        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'hidden' });



        // stretch overlay to fill page and fade in

        var arrayPageSize = this.getPageSize();

        $('overlay').setStyle({ width: arrayPageSize[0] + 'px', height: arrayPageSize[1] + 'px' });



        new Effect.Appear(this.overlay, { duration: this.overlayDuration, from: 0.0, to: LightboxOptions.overlayOpacity });



        this.imageArray = [];

        var imageNum = 0;       



        if ((imageLink.rel == 'lightbox')){

            // if image is NOT part of a set, add single image to imageArray

            this.imageArray.push([imageLink.href, imageLink.title]);         

        } else {

            // if image is part of a set..

            this.imageArray = 

                $$(imageLink.tagName + '[href][rel="' + imageLink.rel + '"]').

                collect(function(anchor){ return [anchor.href, anchor.title]; }).

                uniq();

            

            while (this.imageArray[imageNum][0] != imageLink.href) { imageNum++; }

        }



        // calculate top and left offset for the lightbox 

        var arrayPageScroll = document.viewport.getScrollOffsets();

        var lightboxTop = arrayPageScroll[1] + (document.viewport.getHeight() / 10);

        var lightboxLeft = arrayPageScroll[0];

        this.lightbox.setStyle({ top: lightboxTop + 'px', left: lightboxLeft + 'px' }).show();

        

        this.changeImage(imageNum);

    },



    //

    //  changeImage()

    //  Hide most elements and preload image in preparation for resizing image container.

    //

    changeImage: function(imageNum) {   

        

        this.activeImage = imageNum; // update global var



        // hide elements during transition

        if (LightboxOptions.animate) this.loading.show();

        this.lightboxImage.hide();

        this.hoverNav.hide();

        this.prevLink.hide();

        this.nextLink.hide();

		// HACK: Opera9 does not currently support scriptaculous opacity and appear fx

        this.imageDataContainer.setStyle({opacity: .0001});

        this.numberDisplay.hide();      

        

        var imgPreloader = new Image();

        

        // once image is preloaded, resize image container





        imgPreloader.onload = (function(){

            this.lightboxImage.src = this.imageArray[this.activeImage][0];

            this.resizeImageContainer(imgPreloader.width, imgPreloader.height);

        }).bind(this);

        imgPreloader.src = this.imageArray[this.activeImage][0];

    },



    //

    //  resizeImageContainer()

    //

    resizeImageContainer: function(imgWidth, imgHeight) {



        // get current width and height

        var widthCurrent  = this.outerImageContainer.getWidth();

        var heightCurrent = this.outerImageContainer.getHeight();



        // get new width and height

        var widthNew  = (imgWidth  + LightboxOptions.borderSize * 2);

        var heightNew = (imgHeight + LightboxOptions.borderSize * 2);



        // scalars based on change from old to new

        var xScale = (widthNew  / widthCurrent)  * 100;

        var yScale = (heightNew / heightCurrent) * 100;



        // calculate size difference between new and old image, and resize if necessary

        var wDiff = widthCurrent - widthNew;

        var hDiff = heightCurrent - heightNew;



        if (hDiff != 0) new Effect.Scale(this.outerImageContainer, yScale, {scaleX: false, duration: this.resizeDuration, queue: 'front'}); 

        if (wDiff != 0) new Effect.Scale(this.outerImageContainer, xScale, {scaleY: false, duration: this.resizeDuration, delay: this.resizeDuration}); 



        // if new and old image are same size and no scaling transition is necessary, 

        // do a quick pause to prevent image flicker.

        var timeout = 0;

        if ((hDiff == 0) && (wDiff == 0)){

            timeout = 100;

            if (Prototype.Browser.IE) timeout = 250;   

        }



        (function(){

            this.prevLink.setStyle({ height: imgHeight + 'px' });

            this.nextLink.setStyle({ height: imgHeight + 'px' });

            this.imageDataContainer.setStyle({ width: widthNew + 'px' });



            //-----------------



            this.showImage();

        }).bind(this).delay(timeout / 1000);

    },

    

    //

    //  showImage()

    //  Display image and begin preloading neighbors.

    //

    showImage: function(){

        this.loading.hide();

        new Effect.Appear(this.lightboxImage, { 

            duration: this.resizeDuration, 

            queue: 'end', 

            afterFinish: (function(){ this.updateDetails(); }).bind(this) 

        });

        this.preloadNeighborImages();

    },



    //

    //  updateDetails()

    //  Display caption, image number, and bottom nav.

    //

    updateDetails: function() {

    

        // if caption is not null

        if (this.imageArray[this.activeImage][1] != ""){

            this.caption.update(this.imageArray[this.activeImage][1]).show();

        }

        

        // if image is part of set display 'Image x of x' 

        if (this.imageArray.length > 1){

            this.numberDisplay.update( LightboxOptions.labelImage + ' ' + (this.activeImage + 1) + ' ' + LightboxOptions.labelOf + '  ' + this.imageArray.length).show();

        }



        new Effect.Parallel(

            [ 

                new Effect.SlideDown(this.imageDataContainer, { sync: true, duration: this.resizeDuration, from: 0.0, to: 1.0 }), 

                new Effect.Appear(this.imageDataContainer, { sync: true, duration: this.resizeDuration }) 

            ], 

            { 

                duration: this.resizeDuration, 

                afterFinish: (function() {

	                // update overlay size and update nav

	                var arrayPageSize = this.getPageSize();

	                this.overlay.setStyle({ height: arrayPageSize[1] + 'px' });

	                this.updateNav();

                }).bind(this)

            } 

        );

    },



    //

    //  updateNav()

    //  Display appropriate previous and next hover navigation.

    //

    updateNav: function() {



        this.hoverNav.show();               



        // if not first image in set, display prev image button

        if (this.activeImage > 0) this.prevLink.show();



        // if not last image in set, display next image button

        if (this.activeImage < (this.imageArray.length - 1)) this.nextLink.show();

        

        this.enableKeyboardNav();

    },



    //

    //  enableKeyboardNav()

    //

    enableKeyboardNav: function() {

        document.observe('keydown', this.keyboardAction); 

    },



    //

    //  disableKeyboardNav()

    //

    disableKeyboardNav: function() {

        document.stopObserving('keydown', this.keyboardAction); 

    },



    //

    //  keyboardAction()

    //

    keyboardAction: function(event) {

        var keycode = event.keyCode;



        var escapeKey;

        if (event.DOM_VK_ESCAPE) {  // mozilla

            escapeKey = event.DOM_VK_ESCAPE;

        } else { // ie

            escapeKey = 27;

        }



        var key = String.fromCharCode(keycode).toLowerCase();

        

        if (key.match(/x|o|c/) || (keycode == escapeKey)){ // close lightbox

            this.end();

        } else if ((key == 'p') || (keycode == 37)){ // display previous image

            if (this.activeImage != 0){

                this.disableKeyboardNav();

                this.changeImage(this.activeImage - 1);

            }

        } else if ((key == 'n') || (keycode == 39)){ // display next image

            if (this.activeImage != (this.imageArray.length - 1)){

                this.disableKeyboardNav();

                this.changeImage(this.activeImage + 1);

            }

        }

    },



    //

    //  preloadNeighborImages()

    //  Preload previous and next images.

    //

    preloadNeighborImages: function(){

        var preloadNextImage, preloadPrevImage;

        if (this.imageArray.length > this.activeImage + 1){

            preloadNextImage = new Image();

            preloadNextImage.src = this.imageArray[this.activeImage + 1][0];

        }

        if (this.activeImage > 0){

            preloadPrevImage = new Image();

            preloadPrevImage.src = this.imageArray[this.activeImage - 1][0];

        }

    

    },



    //

    //  end()

    //

    end: function() {

        this.disableKeyboardNav();

        this.lightbox.hide();

        new Effect.Fade(this.overlay, { duration: this.overlayDuration });

        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'visible' });

    },



    //

    //  getPageSize()

    //

    getPageSize: function() {

	        

	     var xScroll, yScroll;

		

		if (window.innerHeight && window.scrollMaxY) {	

			xScroll = window.innerWidth + window.scrollMaxX;

			yScroll = window.innerHeight + window.scrollMaxY;

		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac

			xScroll = document.body.scrollWidth;

			yScroll = document.body.scrollHeight;

		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari

			xScroll = document.body.offsetWidth;

			yScroll = document.body.offsetHeight;

		}

		

		var windowWidth, windowHeight;

		

		if (self.innerHeight) {	// all except Explorer

			if(document.documentElement.clientWidth){

				windowWidth = document.documentElement.clientWidth; 

			} else {

				windowWidth = self.innerWidth;

			}

			windowHeight = self.innerHeight;

		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode

			windowWidth = document.documentElement.clientWidth;

			windowHeight = document.documentElement.clientHeight;

		} else if (document.body) { // other Explorers

			windowWidth = document.body.clientWidth;

			windowHeight = document.body.clientHeight;

		}	

		

		// for small pages with total height less then height of the viewport

		if(yScroll < windowHeight){

			pageHeight = windowHeight;

		} else { 

			pageHeight = yScroll;

		}

	

		// for small pages with total width less then width of the viewport

		if(xScroll < windowWidth){	

			pageWidth = xScroll;		

		} else {

			pageWidth = windowWidth;

		}



		return [pageWidth,pageHeight];

	}

}



document.observe('dom:loaded', function () { new Lightbox(); });



//Scroller

(function($) {

    // Default configuration properties.

    var defaults = {

        vertical: false,

        rtl: false,

        start: 1,

        offset: 1,

        size: null,

        scroll: 3,

        visible: null,

        animation: 'normal',

        easing: 'swing',

        auto: 0,

        wrap: null,

        initCallback: null,

        setupCallback: null,

        reloadCallback: null,

        itemLoadCallback: null,

        itemFirstInCallback: null,

        itemFirstOutCallback: null,

        itemLastInCallback: null,

        itemLastOutCallback: null,

        itemVisibleInCallback: null,

        itemVisibleOutCallback: null,

        animationStepCallback: null,

        buttonNextHTML: '<div></div>',

        buttonPrevHTML: '<div></div>',

        buttonNextEvent: 'click',

        buttonPrevEvent: 'click',

        buttonNextCallback: null,

        buttonPrevCallback: null,

        itemFallbackDimension: null

    }, windowLoaded = false;



    $(window).bind('load.jcarousel', function() { windowLoaded = true; });



    /**

     * The jCarousel object.

     *

     * @constructor

     * @class jcarousel

     * @param e {HTMLElement} The element to create the carousel for.

     * @param o {Object} A set of key/value pairs to set as configuration properties.

     * @cat Plugins/jCarousel

     */

    $.jcarousel = function(e, o) {

        this.options    = $.extend({}, defaults, o || {});



        this.locked          = false;

        this.autoStopped     = false;



        this.container       = null;

        this.clip            = null;

        this.list            = null;

        this.buttonNext      = null;

        this.buttonPrev      = null;

        this.buttonNextState = null;

        this.buttonPrevState = null;



        // Only set if not explicitly passed as option

        if (!o || o.rtl === undefined) {

            this.options.rtl = ($(e).attr('dir') || $('html').attr('dir') || '').toLowerCase() == 'rtl';

        }



        this.wh = !this.options.vertical ? 'width' : 'height';

        this.lt = !this.options.vertical ? (this.options.rtl ? 'right' : 'left') : 'top';



        // Extract skin class

        var skin = '', split = e.className.split(' ');



        for (var i = 0; i < split.length; i++) {

            if (split[i].indexOf('jcarousel-skin') != -1) {

                $(e).removeClass(split[i]);

                skin = split[i];

                break;

            }

        }



        if (e.nodeName.toUpperCase() == 'UL' || e.nodeName.toUpperCase() == 'OL') {

            this.list      = $(e);

            this.clip      = this.list.parents('.jcarousel-clip');

            this.container = this.list.parents('.jcarousel-container');

        } else {

            this.container = $(e);

            this.list      = this.container.find('ul,ol').eq(0);

            this.clip      = this.container.find('.jcarousel-clip');

        }



        if (this.clip.size() === 0) {

            this.clip = this.list.wrap('<div></div>').parent();

        }



        if (this.container.size() === 0) {

            this.container = this.clip.wrap('<div></div>').parent();

        }



        if (skin !== '' && this.container.parent()[0].className.indexOf('jcarousel-skin') == -1) {

            this.container.wrap('<div class=" '+ skin + '"></div>');

        }



        this.buttonPrev = $('.jcarousel-prev', this.container);



        if (this.buttonPrev.size() === 0 && this.options.buttonPrevHTML !== null) {

            this.buttonPrev = $(this.options.buttonPrevHTML).appendTo(this.container);

        }



        this.buttonPrev.addClass(this.className('jcarousel-prev'));



        this.buttonNext = $('.jcarousel-next', this.container);



        if (this.buttonNext.size() === 0 && this.options.buttonNextHTML !== null) {

            this.buttonNext = $(this.options.buttonNextHTML).appendTo(this.container);

        }



        this.buttonNext.addClass(this.className('jcarousel-next'));



        this.clip.addClass(this.className('jcarousel-clip')).css({

            position: 'relative'

        });



        this.list.addClass(this.className('jcarousel-list')).css({

            overflow: 'hidden',

            position: 'relative',

            top: 0,

            margin: 0,

            padding: 0

        }).css((this.options.rtl ? 'right' : 'left'), 0);



        this.container.addClass(this.className('jcarousel-container')).css({

            position: 'relative'

        });



        if (!this.options.vertical && this.options.rtl) {

            this.container.addClass('jcarousel-direction-rtl').attr('dir', 'rtl');

        }



        var di = this.options.visible !== null ? Math.ceil(this.clipping() / this.options.visible) : null;

        var li = this.list.children('li');



        var self = this;



        if (li.size() > 0) {

            var wh = 0, j = this.options.offset;

            li.each(function() {

                self.format(this, j++);

                wh += self.dimension(this, di);

            });



            this.list.css(this.wh, (wh + 100) + 'px');



            // Only set if not explicitly passed as option

            if (!o || o.size === undefined) {

                this.options.size = li.size();

            }

        }



        // For whatever reason, .show() does not work in Safari...

        this.container.css('display', 'block');

        this.buttonNext.css('display', 'block');

        this.buttonPrev.css('display', 'block');



        this.funcNext   = function() { self.next(); };

        this.funcPrev   = function() { self.prev(); };

        this.funcResize = function() { 

            if (self.resizeTimer) {

                clearTimeout(self.resizeTimer);

            }



            self.resizeTimer = setTimeout(function() {

                self.reload();

            }, 100);

        };



        if (this.options.initCallback !== null) {

            this.options.initCallback(this, 'init');

        }



        if (!windowLoaded && $.browser.safari) {

            this.buttons(false, false);

            $(window).bind('load.jcarousel', function() { self.setup(); });

        } else {

            this.setup();

        }

    };



    // Create shortcut for internal use

    var $jc = $.jcarousel;



    $jc.fn = $jc.prototype = {

        jcarousel: '0.2.8'

    };



    $jc.fn.extend = $jc.extend = $.extend;



    $jc.fn.extend({

        /**

         * Setups the carousel.

         *

         * @method setup

         * @return undefined

         */

        setup: function() {

            this.first       = null;

            this.last        = null;

            this.prevFirst   = null;

            this.prevLast    = null;

            this.animating   = false;

            this.timer       = null;

            this.resizeTimer = null;

            this.tail        = null;

            this.inTail      = false;



            if (this.locked) {

                return;

            }



            this.list.css(this.lt, this.pos(this.options.offset) + 'px');

            var p = this.pos(this.options.start, true);

            this.prevFirst = this.prevLast = null;

            this.animate(p, false);



            $(window).unbind('resize.jcarousel', this.funcResize).bind('resize.jcarousel', this.funcResize);



            if (this.options.setupCallback !== null) {

                this.options.setupCallback(this);

            }

        },



        /**

         * Clears the list and resets the carousel.

         *

         * @method reset

         * @return undefined

         */

        reset: function() {

            this.list.empty();



            this.list.css(this.lt, '0px');

            this.list.css(this.wh, '10px');



            if (this.options.initCallback !== null) {

                this.options.initCallback(this, 'reset');

            }



            this.setup();

        },



        /**

         * Reloads the carousel and adjusts positions.

         *

         * @method reload

         * @return undefined

         */

        reload: function() {

            if (this.tail !== null && this.inTail) {

                this.list.css(this.lt, $jc.intval(this.list.css(this.lt)) + this.tail);

            }



            this.tail   = null;

            this.inTail = false;



            if (this.options.reloadCallback !== null) {

                this.options.reloadCallback(this);

            }



            if (this.options.visible !== null) {

                var self = this;

                var di = Math.ceil(this.clipping() / this.options.visible), wh = 0, lt = 0;

                this.list.children('li').each(function(i) {

                    wh += self.dimension(this, di);

                    if (i + 1 < self.first) {

                        lt = wh;

                    }

                });



                this.list.css(this.wh, wh + 'px');

                this.list.css(this.lt, -lt + 'px');

            }



            this.scroll(this.first, false);

        },



        /**

         * Locks the carousel.

         *

         * @method lock

         * @return undefined

         */

        lock: function() {

            this.locked = true;

            this.buttons();

        },



        /**

         * Unlocks the carousel.

         *

         * @method unlock

         * @return undefined

         */

        unlock: function() {

            this.locked = false;

            this.buttons();

        },



        /**

         * Sets the size of the carousel.

         *

         * @method size

         * @return undefined

         * @param s {Number} The size of the carousel.

         */

        size: function(s) {

            if (s !== undefined) {

                this.options.size = s;

                if (!this.locked) {

                    this.buttons();

                }

            }



            return this.options.size;

        },



        /**

         * Checks whether a list element exists for the given index (or index range).

         *

         * @method get

         * @return bool

         * @param i {Number} The index of the (first) element.

         * @param i2 {Number} The index of the last element.

         */

        has: function(i, i2) {

            if (i2 === undefined || !i2) {

                i2 = i;

            }



            if (this.options.size !== null && i2 > this.options.size) {

                i2 = this.options.size;

            }



            for (var j = i; j <= i2; j++) {

                var e = this.get(j);

                if (!e.length || e.hasClass('jcarousel-item-placeholder')) {

                    return false;

                }

            }



            return true;

        },



        /**

         * Returns a jQuery object with list element for the given index.

         *

         * @method get

         * @return jQuery

         * @param i {Number} The index of the element.

         */

        get: function(i) {

            return $('>.jcarousel-item-' + i, this.list);

        },



        /**

         * Adds an element for the given index to the list.

         * If the element already exists, it updates the inner html.

         * Returns the created element as jQuery object.

         *

         * @method add

         * @return jQuery

         * @param i {Number} The index of the element.

         * @param s {String} The innerHTML of the element.

         */

        add: function(i, s) {

            var e = this.get(i), old = 0, n = $(s);



            if (e.length === 0) {

                var c, j = $jc.intval(i);

                e = this.create(i);

                while (true) {

                    c = this.get(--j);

                    if (j <= 0 || c.length) {

                        if (j <= 0) {

                            this.list.prepend(e);

                        } else {

                            c.after(e);

                        }

                        break;

                    }

                }

            } else {

                old = this.dimension(e);

            }



            if (n.get(0).nodeName.toUpperCase() == 'LI') {

                e.replaceWith(n);

                e = n;

            } else {

                e.empty().append(s);

            }



            this.format(e.removeClass(this.className('jcarousel-item-placeholder')), i);



            var di = this.options.visible !== null ? Math.ceil(this.clipping() / this.options.visible) : null;

            var wh = this.dimension(e, di) - old;



            if (i > 0 && i < this.first) {

                this.list.css(this.lt, $jc.intval(this.list.css(this.lt)) - wh + 'px');

            }



            this.list.css(this.wh, $jc.intval(this.list.css(this.wh)) + wh + 'px');



            return e;

        },



        /**

         * Removes an element for the given index from the list.

         *

         * @method remove

         * @return undefined

         * @param i {Number} The index of the element.

         */

        remove: function(i) {

            var e = this.get(i);



            // Check if item exists and is not currently visible

            if (!e.length || (i >= this.first && i <= this.last)) {

                return;

            }



            var d = this.dimension(e);



            if (i < this.first) {

                this.list.css(this.lt, $jc.intval(this.list.css(this.lt)) + d + 'px');

            }



            e.remove();



            this.list.css(this.wh, $jc.intval(this.list.css(this.wh)) - d + 'px');

        },



        /**

         * Moves the carousel forwards.

         *

         * @method next

         * @return undefined

         */

        next: function() {

            if (this.tail !== null && !this.inTail) {

                this.scrollTail(false);

            } else {

                this.scroll(((this.options.wrap == 'both' || this.options.wrap == 'last') && this.options.size !== null && this.last == this.options.size) ? 1 : this.first + this.options.scroll);

            }

        },



        /**

         * Moves the carousel backwards.

         *

         * @method prev

         * @return undefined

         */

        prev: function() {

            if (this.tail !== null && this.inTail) {

                this.scrollTail(true);

            } else {

                this.scroll(((this.options.wrap == 'both' || this.options.wrap == 'first') && this.options.size !== null && this.first == 1) ? this.options.size : this.first - this.options.scroll);

            }

        },



        /**

         * Scrolls the tail of the carousel.

         *

         * @method scrollTail

         * @return undefined

         * @param b {Boolean} Whether scroll the tail back or forward.

         */

        scrollTail: function(b) {

            if (this.locked || this.animating || !this.tail) {

                return;

            }



            this.pauseAuto();



            var pos  = $jc.intval(this.list.css(this.lt));



            pos = !b ? pos - this.tail : pos + this.tail;

            this.inTail = !b;



            // Save for callbacks

            this.prevFirst = this.first;

            this.prevLast  = this.last;



            this.animate(pos);

        },



        /**

         * Scrolls the carousel to a certain position.

         *

         * @method scroll

         * @return undefined

         * @param i {Number} The index of the element to scoll to.

         * @param a {Boolean} Flag indicating whether to perform animation.

         */

        scroll: function(i, a) {

            if (this.locked || this.animating) {

                return;

            }



            this.pauseAuto();

            this.animate(this.pos(i), a);

        },



        /**

         * Prepares the carousel and return the position for a certian index.

         *

         * @method pos

         * @return {Number}

         * @param i {Number} The index of the element to scoll to.

         * @param fv {Boolean} Whether to force last item to be visible.

         */

        pos: function(i, fv) {

            var pos  = $jc.intval(this.list.css(this.lt));



            if (this.locked || this.animating) {

                return pos;

            }



            if (this.options.wrap != 'circular') {

                i = i < 1 ? 1 : (this.options.size && i > this.options.size ? this.options.size : i);

            }



            var back = this.first > i;



            // Create placeholders, new list width/height

            // and new list position

            var f = this.options.wrap != 'circular' && this.first <= 1 ? 1 : this.first;

            var c = back ? this.get(f) : this.get(this.last);

            var j = back ? f : f - 1;

            var e = null, l = 0, p = false, d = 0, g;



            while (back ? --j >= i : ++j < i) {

                e = this.get(j);

                p = !e.length;

                if (e.length === 0) {

                    e = this.create(j).addClass(this.className('jcarousel-item-placeholder'));

                    c[back ? 'before' : 'after' ](e);



                    if (this.first !== null && this.options.wrap == 'circular' && this.options.size !== null && (j <= 0 || j > this.options.size)) {

                        g = this.get(this.index(j));

                        if (g.length) {

                            e = this.add(j, g.clone(true));

                        }

                    }

                }



                c = e;

                d = this.dimension(e);



                if (p) {

                    l += d;

                }



                if (this.first !== null && (this.options.wrap == 'circular' || (j >= 1 && (this.options.size === null || j <= this.options.size)))) {

                    pos = back ? pos + d : pos - d;

                }

            }



            // Calculate visible items

            var clipping = this.clipping(), cache = [], visible = 0, v = 0;

            c = this.get(i - 1);

            j = i;



            while (++visible) {

                e = this.get(j);

                p = !e.length;

                if (e.length === 0) {

                    e = this.create(j).addClass(this.className('jcarousel-item-placeholder'));

                    // This should only happen on a next scroll

                    if (c.length === 0) {

                        this.list.prepend(e);

                    } else {

                        c[back ? 'before' : 'after' ](e);

                    }



                    if (this.first !== null && this.options.wrap == 'circular' && this.options.size !== null && (j <= 0 || j > this.options.size)) {

                        g = this.get(this.index(j));

                        if (g.length) {

                            e = this.add(j, g.clone(true));

                        }

                    }

                }



                c = e;

                d = this.dimension(e);

                if (d === 0) {

                    throw new Error('jCarousel: No width/height set for items. This will cause an infinite loop. Aborting...');

                }



                if (this.options.wrap != 'circular' && this.options.size !== null && j > this.options.size) {

                    cache.push(e);

                } else if (p) {

                    l += d;

                }



                v += d;



                if (v >= clipping) {

                    break;

                }



                j++;

            }



             // Remove out-of-range placeholders

            for (var x = 0; x < cache.length; x++) {

                cache[x].remove();

            }



            // Resize list

            if (l > 0) {

                this.list.css(this.wh, this.dimension(this.list) + l + 'px');



                if (back) {

                    pos -= l;

                    this.list.css(this.lt, $jc.intval(this.list.css(this.lt)) - l + 'px');

                }

            }



            // Calculate first and last item

            var last = i + visible - 1;

            if (this.options.wrap != 'circular' && this.options.size && last > this.options.size) {

                last = this.options.size;

            }



            if (j > last) {

                visible = 0;

                j = last;

                v = 0;

                while (++visible) {

                    e = this.get(j--);

                    if (!e.length) {

                        break;

                    }

                    v += this.dimension(e);

                    if (v >= clipping) {

                        break;

                    }

                }

            }



            var first = last - visible + 1;

            if (this.options.wrap != 'circular' && first < 1) {

                first = 1;

            }



            if (this.inTail && back) {

                pos += this.tail;

                this.inTail = false;

            }



            this.tail = null;

            if (this.options.wrap != 'circular' && last == this.options.size && (last - visible + 1) >= 1) {

                var m = $jc.intval(this.get(last).css(!this.options.vertical ? 'marginRight' : 'marginBottom'));

                if ((v - m) > clipping) {

                    this.tail = v - clipping - m;

                }

            }



            if (fv && i === this.options.size && this.tail) {

                pos -= this.tail;

                this.inTail = true;

            }



            // Adjust position

            while (i-- > first) {

                pos += this.dimension(this.get(i));

            }



            // Save visible item range

            this.prevFirst = this.first;

            this.prevLast  = this.last;

            this.first     = first;

            this.last      = last;



            return pos;

        },



        /**

         * Animates the carousel to a certain position.

         *

         * @method animate

         * @return undefined

         * @param p {Number} Position to scroll to.

         * @param a {Boolean} Flag indicating whether to perform animation.

         */

        animate: function(p, a) {

            if (this.locked || this.animating) {

                return;

            }



            this.animating = true;



            var self = this;

            var scrolled = function() {

                self.animating = false;



                if (p === 0) {

                    self.list.css(self.lt,  0);

                }



                if (!self.autoStopped && (self.options.wrap == 'circular' || self.options.wrap == 'both' || self.options.wrap == 'last' || self.options.size === null || self.last < self.options.size || (self.last == self.options.size && self.tail !== null && !self.inTail))) {

                    self.startAuto();

                }



                self.buttons();

                self.notify('onAfterAnimation');



                // This function removes items which are appended automatically for circulation.

                // This prevents the list from growing infinitely.

                if (self.options.wrap == 'circular' && self.options.size !== null) {

                    for (var i = self.prevFirst; i <= self.prevLast; i++) {

                        if (i !== null && !(i >= self.first && i <= self.last) && (i < 1 || i > self.options.size)) {

                            self.remove(i);

                        }

                    }

                }

            };



            this.notify('onBeforeAnimation');



            // Animate

            if (!this.options.animation || a === false) {

                this.list.css(this.lt, p + 'px');

                scrolled();

            } else {

                var o = !this.options.vertical ? (this.options.rtl ? {'right': p} : {'left': p}) : {'top': p};

                // Define animation settings.

                var settings = {

                    duration: this.options.animation,

                    easing:   this.options.easing,

                    complete: scrolled

                };

                // If we have a step callback, specify it as well.

                if ($.isFunction(this.options.animationStepCallback)) {

                    settings.step = this.options.animationStepCallback;

                }

                // Start the animation.

                this.list.animate(o, settings);

            }

        },



        /**

         * Starts autoscrolling.

         *

         * @method auto

         * @return undefined

         * @param s {Number} Seconds to periodically autoscroll the content.

         */

        startAuto: function(s) {

            if (s !== undefined) {

                this.options.auto = s;

            }



            if (this.options.auto === 0) {

                return this.stopAuto();

            }



            if (this.timer !== null) {

                return;

            }



            this.autoStopped = false;



            var self = this;

            this.timer = window.setTimeout(function() { self.next(); }, this.options.auto * 1000);

        },



        /**

         * Stops autoscrolling.

         *

         * @method stopAuto

         * @return undefined

         */

        stopAuto: function() {

            this.pauseAuto();

            this.autoStopped = true;

        },



        /**

         * Pauses autoscrolling.

         *

         * @method pauseAuto

         * @return undefined

         */

        pauseAuto: function() {

            if (this.timer === null) {

                return;

            }



            window.clearTimeout(this.timer);

            this.timer = null;

        },



        /**

         * Sets the states of the prev/next buttons.

         *

         * @method buttons

         * @return undefined

         */

        buttons: function(n, p) {

            if (n == null) {

                n = !this.locked && this.options.size !== 0 && ((this.options.wrap && this.options.wrap != 'first') || this.options.size === null || this.last < this.options.size);

                if (!this.locked && (!this.options.wrap || this.options.wrap == 'first') && this.options.size !== null && this.last >= this.options.size) {

                    n = this.tail !== null && !this.inTail;

                }

            }



            if (p == null) {

                p = !this.locked && this.options.size !== 0 && ((this.options.wrap && this.options.wrap != 'last') || this.first > 1);

                if (!this.locked && (!this.options.wrap || this.options.wrap == 'last') && this.options.size !== null && this.first == 1) {

                    p = this.tail !== null && this.inTail;

                }

            }



            var self = this;



            if (this.buttonNext.size() > 0) {

                this.buttonNext.unbind(this.options.buttonNextEvent + '.jcarousel', this.funcNext);



                if (n) {

                    this.buttonNext.bind(this.options.buttonNextEvent + '.jcarousel', this.funcNext);

                }



                this.buttonNext[n ? 'removeClass' : 'addClass'](this.className('jcarousel-next-disabled')).attr('disabled', n ? false : true);



                if (this.options.buttonNextCallback !== null && this.buttonNext.data('jcarouselstate') != n) {

                    this.buttonNext.each(function() { self.options.buttonNextCallback(self, this, n); }).data('jcarouselstate', n);

                }

            } else {

                if (this.options.buttonNextCallback !== null && this.buttonNextState != n) {

                    this.options.buttonNextCallback(self, null, n);

                }

            }



            if (this.buttonPrev.size() > 0) {

                this.buttonPrev.unbind(this.options.buttonPrevEvent + '.jcarousel', this.funcPrev);



                if (p) {

                    this.buttonPrev.bind(this.options.buttonPrevEvent + '.jcarousel', this.funcPrev);

                }



                this.buttonPrev[p ? 'removeClass' : 'addClass'](this.className('jcarousel-prev-disabled')).attr('disabled', p ? false : true);



                if (this.options.buttonPrevCallback !== null && this.buttonPrev.data('jcarouselstate') != p) {

                    this.buttonPrev.each(function() { self.options.buttonPrevCallback(self, this, p); }).data('jcarouselstate', p);

                }

            } else {

                if (this.options.buttonPrevCallback !== null && this.buttonPrevState != p) {

                    this.options.buttonPrevCallback(self, null, p);

                }

            }



            this.buttonNextState = n;

            this.buttonPrevState = p;

        },



        /**

         * Notify callback of a specified event.

         *

         * @method notify

         * @return undefined

         * @param evt {String} The event name

         */

        notify: function(evt) {

            var state = this.prevFirst === null ? 'init' : (this.prevFirst < this.first ? 'next' : 'prev');



            // Load items

            this.callback('itemLoadCallback', evt, state);



            if (this.prevFirst !== this.first) {

                this.callback('itemFirstInCallback', evt, state, this.first);

                this.callback('itemFirstOutCallback', evt, state, this.prevFirst);

            }



            if (this.prevLast !== this.last) {

                this.callback('itemLastInCallback', evt, state, this.last);

                this.callback('itemLastOutCallback', evt, state, this.prevLast);

            }



            this.callback('itemVisibleInCallback', evt, state, this.first, this.last, this.prevFirst, this.prevLast);

            this.callback('itemVisibleOutCallback', evt, state, this.prevFirst, this.prevLast, this.first, this.last);

        },



        callback: function(cb, evt, state, i1, i2, i3, i4) {

            if (this.options[cb] == null || (typeof this.options[cb] != 'object' && evt != 'onAfterAnimation')) {

                return;

            }



            var callback = typeof this.options[cb] == 'object' ? this.options[cb][evt] : this.options[cb];



            if (!$.isFunction(callback)) {

                return;

            }



            var self = this;



            if (i1 === undefined) {

                callback(self, state, evt);

            } else if (i2 === undefined) {

                this.get(i1).each(function() { callback(self, this, i1, state, evt); });

            } else {

                var call = function(i) {

                    self.get(i).each(function() { callback(self, this, i, state, evt); });

                };

                for (var i = i1; i <= i2; i++) {

                    if (i !== null && !(i >= i3 && i <= i4)) {

                        call(i);

                    }

                }

            }

        },



        create: function(i) {

            return this.format('<li></li>', i);

        },



        format: function(e, i) {

            e = $(e);

            var split = e.get(0).className.split(' ');

            for (var j = 0; j < split.length; j++) {

                if (split[j].indexOf('jcarousel-') != -1) {

                    e.removeClass(split[j]);

                }

            }

            e.addClass(this.className('jcarousel-item')).addClass(this.className('jcarousel-item-' + i)).css({

                'float': (this.options.rtl ? 'right' : 'left'),

                'list-style': 'none'

            }).attr('jcarouselindex', i);

            return e;

        },



        className: function(c) {

            return c + ' ' + c + (!this.options.vertical ? '-horizontal' : '-vertical');

        },



        dimension: function(e, d) {

            var el = $(e);



            if (d == null) {

                return !this.options.vertical ?

                       (el.outerWidth(true) || $jc.intval(this.options.itemFallbackDimension)) :

                       (el.outerHeight(true) || $jc.intval(this.options.itemFallbackDimension));

            } else {

                var w = !this.options.vertical ?

                    d - $jc.intval(el.css('marginLeft')) - $jc.intval(el.css('marginRight')) :

                    d - $jc.intval(el.css('marginTop')) - $jc.intval(el.css('marginBottom'));



                $(el).css(this.wh, w + 'px');



                return this.dimension(el);

            }

        },



        clipping: function() {

            return !this.options.vertical ?

                this.clip[0].offsetWidth - $jc.intval(this.clip.css('borderLeftWidth')) - $jc.intval(this.clip.css('borderRightWidth')) :

                this.clip[0].offsetHeight - $jc.intval(this.clip.css('borderTopWidth')) - $jc.intval(this.clip.css('borderBottomWidth'));

        },



        index: function(i, s) {

            if (s == null) {

                s = this.options.size;

            }



            return Math.round((((i-1) / s) - Math.floor((i-1) / s)) * s) + 1;

        }

    });



    $jc.extend({

        /**

         * Gets/Sets the global default configuration properties.

         *

         * @method defaults

         * @return {Object}

         * @param d {Object} A set of key/value pairs to set as configuration properties.

         */

        defaults: function(d) {

            return $.extend(defaults, d || {});

        },



        intval: function(v) {

            v = parseInt(v, 10);

            return isNaN(v) ? 0 : v;

        },



        windowLoaded: function() {

            windowLoaded = true;

        }

    });



    /**

     * Creates a carousel for all matched elements.

     *

     * @example $("#mycarousel").jcarousel();

     * @before <ul id="mycarousel" class="jcarousel-skin-name"><li>First item</li><li>Second item</li></ul>

     * @result

     *

     * <div class="jcarousel-skin-name">

     *   <div class="jcarousel-container">

     *     <div class="jcarousel-clip">

     *       <ul class="jcarousel-list">

     *         <li class="jcarousel-item-1">First item</li>

     *         <li class="jcarousel-item-2">Second item</li>

     *       </ul>

     *     </div>

     *     <div disabled="disabled" class="jcarousel-prev jcarousel-prev-disabled"></div>

     *     <div class="jcarousel-next"></div>

     *   </div>

     * </div>

     *

     * @method jcarousel

     * @return jQuery

     * @param o {Hash|String} A set of key/value pairs to set as configuration properties or a method name to call on a formerly created instance.

     */

    $.fn.jcarousel = function(o) {

        if (typeof o == 'string') {

            var instance = $(this).data('jcarousel'), args = Array.prototype.slice.call(arguments, 1);

            return instance[o].apply(instance, args);

        } else {

            return this.each(function() {

                var instance = $(this).data('jcarousel');

                if (instance) {

                    if (o) {

                        $.extend(instance.options, o);

                    }

                    instance.reload();

                } else {

                    $(this).data('jcarousel', new $jc(this, o));

                }

            });

        }

    };



})(jQuery);

(function($) {                
$.fn.jCarouselLite = function(o) {
    o = $.extend({
        btnPrev: null,
        btnNext: null,
        btnGo: null,
        mouseWheel: false,
        auto: null, 
        hoverPause: false,
        speed: 200,
        easing: null,
        countItem: null,
        vertical: false,
        circular: true,
        visible: 3,
        start: 0,
        scroll: 1, 
        beforeStart: null,
        afterEnd: null
    }, o || {});
    return this.each(function() {  
     
        var running = false, animCss=o.vertical?"top":"left", sizeCss=o.vertical?"height":"width";
        var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = tLi.size(), v = o.visible;
        if(o.circular && o.countItem > v) {
            ul.prepend(tLi.slice(tl-v-1+1).clone())
              .append(tLi.slice(0,v).clone());
            o.start += v;
        }
        
        var li = $("li", ul), itemLength = li.size(), curr = o.start;
        div.css("visibility", "visible");
        
        li.css({overflow: "hidden", float: o.vertical ? "none" : "left"});
        ul.css({margin: "0", padding: "0", position: "relative", "list-style-type": "none", "z-index": "1"});
        div.css({overflow: "hidden", position: "relative", "z-index": "2", left: "0px"});
        
        var liSize = o.vertical ? height(li) : width(li);   // Full li size(incl margin)-Used for animation
        var ulSize = liSize * itemLength;                   // size of full ul(total length, not just for the visible items)
        var divSize = liSize * v;                           // size of entire div(total length for just the visible items)
        
        li.css({width: li.width(), height: li.height()});
        ul.css(sizeCss, ulSize+"px").css(animCss, -(curr*liSize)); 
        div.css(sizeCss, divSize+"px"); 
        
        if(o.fancybox>0){
            li.find('.ic_caption').css('display','none');
            li.find('.product-name').css('display','none');
            li.find('.ic_caption').css({'color':o.caption_color,'background-color':o.caption_bgcolor,'bottom':'0px','width':li.width()});
            li.find('.product-name').css({'color':o.caption_color,'background-color':o.caption_bgcolor,'top':'0px','width':li.width()});
            li.find('.overlay').css('background-color',o.overlay_bgcolor); 
            li.hover(
                function () {
                	$(this).stop();
                    if((navigator.appVersion).indexOf('MSIE 7.0') > 0)
                    $('.overlay',$(this)).show();
                    else
                    $('.overlay',$(this)).fadeIn();
                    if(!o.showcaption)
                        $(this).find('.ic_caption').slideDown(500); 
                        $('.product-name',$(this)).slideDown(500);	
                },
                function () {
                	$(this).stop();
                    if((navigator.appVersion).indexOf('MSIE 7.0') > 0)
                    $('.overlay',$(this)).hide();
                    else
                    $('.overlay',$(this)).fadeOut();
                    if(!o.showcaption)
                        $(this).find('.ic_caption').slideUp(200); 
                        $('.product-name',$(this)).slideUp(200);
                }
            );
        }
        
        li.each(function(i,es){
            setTimeout(function()
            {
                $(es).removeClass('loading');
                $(es).find('div.catpanel').css('visibility','visible').animate({opacity:1}, 1000);
            },
            500*(i+1));
        });
        if(o.btnPrev)
            $(o.btnPrev).click(function() {
                return go(curr-o.scroll);
            }); 
        if(o.btnNext)
            $(o.btnNext).click(function() {
                return go(curr+o.scroll);
            }); 
        if(o.btnGo)
            $.each(o.btnGo, function(i, val) {
                $(val).click(function() {
                    return go(o.circular ? o.visible+i : i);
                });
            }); 
        if(o.mouseWheel && div.mousewheel)
            div.mousewheel(function(e, d) {
                return d>0 ? go(curr-o.scroll) : go(curr+o.scroll);
            }); 
        if(o.auto)
            setInterval(function() {
                go(curr+o.scroll);
            }, o.auto+o.speed); 
        function vis() {
            return li.slice(curr).slice(0,v);
        }; 
        var isMouseOver = false;
		if(o.hoverPause){ 
			$(this).mouseover(function(){ 
				isMouseOver = true;
			}).mouseout(function(){
				isMouseOver = false;
			});
		} 
        function go(to) {
            if(!running && !isMouseOver && o.countItem > v) {
                if(o.beforeStart)
                    o.beforeStart.call(this, vis()); 
                if(o.circular) {            // If circular we are in first or last, then goto the other end
                     
                    if(to<=o.start-v-1) {           // If first, then goto last
                        ul.css(animCss, -((itemLength-(v*2))*liSize)+"px");
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be lesser depending on the number of elements.
                        curr = to==o.start-v-1 ? itemLength-(v*2)-1 : itemLength-(v*2)-o.scroll;
                    } else if(to>=itemLength-v+1) { // If last, then goto first
                        ul.css(animCss, -( (v) * liSize ) + "px" );
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be greater depending on the number of elements.
                        curr = to==itemLength-v+1 ? v+1 : v+o.scroll;
                    } else curr = to;
                } else {                    // If non-circular and to points to first or last, we just return.
                    if(to<0 || to>itemLength-v) return;
                    else curr = to;
                }                           // If neither overrides it, the curr will still be "to" and we can proceed.
                
                running = true; 
                ul.animate(
                    animCss == "left" ? { left: -(curr*liSize) } : { top: -(curr*liSize) } , o.speed, o.easing,
                    function() {
                        if(o.afterEnd)
                            o.afterEnd.call(this, vis());
                        running = false;
                    }
                );
                // Disable buttons when the carousel reaches the last/first, and enable when not
                if(!o.circular) {
                    $(o.btnPrev + "," + o.btnNext).removeClass("disabled");
                    $( (curr-o.scroll<0 && o.btnPrev)
                        ||
                       (curr+o.scroll > itemLength-v && o.btnNext)
                        ||
                       []
                     ).addClass("disabled");
                } 
            }
            return false;
        };
    });
};

function css(el, prop) {
    return parseInt($.css(el[0], prop)) || 0;
};
function width(el) {
    return  el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
};
function height(el) {
    return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
};

})(jQuery);



//Zoom



(function ($) {



    $(document).ready(function () {

        $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();

    });



    function format(str) {

        for (var i = 1; i < arguments.length; i++) {

            str = str.replace('%' + (i - 1), arguments[i]);

        }

        return str;

    }



    function CloudZoom(jWin, opts) {

        var sImg = $('img', jWin);

		var	img1;

		var	img2;

        var zoomDiv = null;

		var	$mouseTrap = null;

		var	lens = null;

		var	$tint = null;

		var	softFocus = null;

		var	$ie6Fix = null;

		var	zoomImage;

        var controlTimer = 0;      

        var cw, ch;

        var destU = 0;

		var	destV = 0;

        var currV = 0;

        var currU = 0;      

        var filesLoaded = 0;

        var mx,

            my; 

        var ctx = this, zw;

        // Display an image loading message. This message gets deleted when the images have loaded and the zoom init function is called.

        // We add a small delay before the message is displayed to avoid the message flicking on then off again virtually immediately if the

        // images load really fast, e.g. from the cache. 

        //var	ctx = this;

        setTimeout(function () {

            //						 <img src="/images/loading.gif"/>

            if ($mouseTrap === null) {

                var w = jWin.width();

                jWin.parent().append(format('<div style="width:%0px;position:absolute;top:75%;left:%1px;text-align:center" class="cloud-zoom-loading" >Loading...</div>', w / 3, (w / 2) - (w / 6))).find(':last').css('opacity', 0.5);

            }

        }, 200);





        var ie6FixRemove = function () {



            if ($ie6Fix !== null) {

                $ie6Fix.remove();

                $ie6Fix = null;

            }

        };



        // Removes cursor, tint layer, blur layer etc.

        this.removeBits = function () {

            //$mouseTrap.unbind();

            if (lens) {

                lens.remove();

                lens = null;             

            }

            if ($tint) {

                $tint.remove();

                $tint = null;

            }

            if (softFocus) {

                softFocus.remove();

                softFocus = null;

            }

            ie6FixRemove();



            $('.cloud-zoom-loading', jWin.parent()).remove();

        };





        this.destroy = function () {

            jWin.data('zoom', null);



            if ($mouseTrap) {

                $mouseTrap.unbind();

                $mouseTrap.remove();

                $mouseTrap = null;

            }

            if (zoomDiv) {

                zoomDiv.remove();

                zoomDiv = null;

            }

            //ie6FixRemove();

            this.removeBits();

            // DON'T FORGET TO REMOVE JQUERY 'DATA' VALUES

        };





        // This is called when the zoom window has faded out so it can be removed.

        this.fadedOut = function () {

            

			if (zoomDiv) {

                zoomDiv.remove();

                zoomDiv = null;

            }

			 this.removeBits();

            //ie6FixRemove();

        };



        this.controlLoop = function () {

            if (lens) {

                var x = (mx - sImg.offset().left - (cw * 0.5)) >> 0;

                var y = (my - sImg.offset().top - (ch * 0.5)) >> 0;

               

                if (x < 0) {

                    x = 0;

                }

                else if (x > (sImg.outerWidth() - cw)) {

                    x = (sImg.outerWidth() - cw);

                }

                if (y < 0) {

                    y = 0;

                }

                else if (y > (sImg.outerHeight() - ch)) {

                    y = (sImg.outerHeight() - ch);

                }



                lens.css({

                    left: x,

                    top: y

                });

                lens.css('background-position', (-x) + 'px ' + (-y) + 'px');



                destU = (((x) / sImg.outerWidth()) * zoomImage.width) >> 0;

                destV = (((y) / sImg.outerHeight()) * zoomImage.height) >> 0;

                currU += (destU - currU) / opts.smoothMove;

                currV += (destV - currV) / opts.smoothMove;



                zoomDiv.css('background-position', (-(currU >> 0) + 'px ') + (-(currV >> 0) + 'px'));              

            }

            controlTimer = setTimeout(function () {

                ctx.controlLoop();

            }, 30);

        };



        this.init2 = function (img, id) {



            filesLoaded++;

            //console.log(img.src + ' ' + id + ' ' + img.width);	

            if (id === 1) {

                zoomImage = img;

            }

            //this.images[id] = img;

            if (filesLoaded === 2) {

                this.init();

            }

        };



        /* Init function start.  */

        this.init = function () {

            // Remove loading message (if present);

            $('.cloud-zoom-loading', jWin.parent()).remove();





/* Add a box (mouseTrap) over the small image to trap mouse events.

		It has priority over zoom window to avoid issues with inner zoom.

		We need the dummy background image as IE does not trap mouse events on

		transparent parts of a div.

		*/

            $mouseTrap = jWin.parent().append(format("<div class='mousetrap visible-desktop' style='background:#fff;opacity:0;filter:alpha(opacity=0);z-index:99;position:absolute;width:%0px;height:%1px;left:%2px;top:%3px;\'></div>", sImg.outerWidth(), sImg.outerHeight(), 0, 0)).find(':last');



            //////////////////////////////////////////////////////////////////////			

            /* Do as little as possible in mousemove event to prevent slowdown. */

            $mouseTrap.bind('mousemove', this, function (event) {

                // Just update the mouse position

                mx = event.pageX;

                my = event.pageY;

            });

            //////////////////////////////////////////////////////////////////////					

            $mouseTrap.bind('mouseleave', this, function (event) {

                clearTimeout(controlTimer);

                //event.data.removeBits();                

				if(lens) { lens.fadeOut(299); }

				if($tint) { $tint.fadeOut(299); }

				if(softFocus) { softFocus.fadeOut(299); }

				zoomDiv.fadeOut(300, function () {

                    ctx.fadedOut();

                });																

                return false;

            });

            //////////////////////////////////////////////////////////////////////			

            $mouseTrap.bind('mouseenter', this, function (event) {

				mx = event.pageX;

                my = event.pageY;

                zw = event.data;

                if (zoomDiv) {

                    zoomDiv.stop(true, false);

                    zoomDiv.remove();

                }



                var xPos = opts.adjustX,

                    yPos = opts.adjustY;

                             

                var siw = sImg.outerWidth();

                var sih = sImg.outerHeight();



                var w = opts.zoomWidth;

                var h = opts.zoomHeight;

                if (opts.zoomWidth == 'auto') {

                    w = siw;

                }

                if (opts.zoomHeight == 'auto') {

                    h = sih;

                }

                //$('#info').text( xPos + ' ' + yPos + ' ' + siw + ' ' + sih );

                var appendTo = jWin.parent(); // attach to the wrapper			

                switch (opts.position) {

                case 'top':

                    yPos -= h; // + opts.adjustY;

                    break;

                case 'right':

                    xPos += siw; // + opts.adjustX;					

                    break;

                case 'bottom':

                    yPos += sih; // + opts.adjustY;

                    break;

                case 'left':

                    xPos -= w; // + opts.adjustX;					

                    break;

                case 'inside':

                    w = siw;

                    h = sih;

                    break;

                    // All other values, try and find an id in the dom to attach to.

                default:

                    appendTo = $('#' + opts.position);

                    // If dom element doesn't exit, just use 'right' position as default.

                    if (!appendTo.length) {

                        appendTo = jWin;

                        xPos += siw; //+ opts.adjustX;

                        yPos += sih; // + opts.adjustY;	

                    } else {

                        w = appendTo.innerWidth();

                        h = appendTo.innerHeight();

                    }

                }



                zoomDiv = appendTo.append(format('<div id="cloud-zoom-big" class="cloud-zoom-big hidden-phone" style="display:none;position:absolute;left:%0px;top:%1px;width:%2px;height:%3px;background-image:url(\'%4\');z-index:99;"></div>', xPos, yPos, w, h, zoomImage.src)).find(':last');



                // Add the title from title tag.

                if (sImg.attr('title') && opts.showTitle) {

                    zoomDiv.append(format('<div class="cloud-zoom-title">%0</div>', sImg.attr('title'))).find(':last').css('opacity', opts.titleOpacity);

                }



                // Fix ie6 select elements wrong z-index bug. Placing an iFrame over the select element solves the issue...		

                if ($.browser.msie && $.browser.version < 7) {

                    $ie6Fix = $('<iframe frameborder="0" src="#"></iframe>').css({

                        position: "absolute",

                        left: xPos,

                        top: yPos,

                        zIndex: 99,

                        width: w,

                        height: h

                    }).insertBefore(zoomDiv);

                }



                zoomDiv.fadeIn(500);



                if (lens) {

                    lens.remove();

                    lens = null;

                } /* Work out size of cursor */

                

                

                if(typeof event.data.zoomDivWidth == 'undefined'){

                	event.data.zoomDivWidth = zoomDiv.get(0).offsetWidth - (zoomDiv.css('border-left-width').replace(/\D/g, '')*1) - (zoomDiv.css('border-right-width').replace(/\D/g, '')*1);

                }

                if(typeof event.data.zoomDivHeight == 'undefined'){

                	event.data.zoomDivHeight = zoomDiv.get(0).offsetHeight - (zoomDiv.css('border-top-width').replace(/\D/g, '')*1) - (zoomDiv.css('border-bottom-width').replace(/\D/g, '')*1);

                }

                

                cw = (sImg.outerWidth() / zoomImage.width) * event.data.zoomDivWidth;

                

                ch = (sImg.outerHeight() / zoomImage.height) * event.data.zoomDivHeight;





                // Attach mouse, initially invisible to prevent first frame glitch

                lens = jWin.append(format("<div class = 'cloud-zoom-lens' style='display:none;z-index:98;position:absolute;width:%0px;height:%1px;'></div>", cw, ch)).find(':last');



                $mouseTrap.css('cursor', lens.css('cursor'));



                var noTrans = false;



                // Init tint layer if needed. (Not relevant if using inside mode)			

                if (opts.tint) {

                    lens.css('background', 'url("' + sImg.attr('src') + '")');

                    $tint = jWin.append(format('<div style="display:none;position:absolute; left:0px; top:0px; width:%0px; height:%1px; background-color:%2;" />', sImg.outerWidth(), sImg.outerHeight(), opts.tint)).find(':last');

                    $tint.css('opacity', opts.tintOpacity);                    

					noTrans = true;

					$tint.fadeIn(500);



                }

                if (opts.softFocus) {

                    lens.css('background', 'url("' + sImg.attr('src') + '")');

                    softFocus = jWin.append(format('<div style="position:absolute;display:none;top:2px; left:2px; width:%0px; height:%1px;" />', sImg.outerWidth() - 2, sImg.outerHeight() - 2, opts.tint)).find(':last');

                    softFocus.css('background', 'url("' + sImg.attr('src') + '")');

                    softFocus.css('opacity', 0.5);

                    noTrans = true;

                    softFocus.fadeIn(500);

                }



                if (!noTrans) {

                    lens.css('opacity', opts.lensOpacity);										

                }

				if ( opts.position !== 'inside' ) { lens.fadeIn(500); }



                // Start processing. 

                zw.controlLoop();



                return; // Don't return false here otherwise opera will not detect change of the mouse pointer type.

            });

        };



        img1 = new Image();

        $(img1).load(function () {

            ctx.init2(this, 0);

        });

        img1.src = sImg.attr('src');



        img2 = new Image();

        $(img2).load(function () {

            ctx.init2(this, 1);

        });

        img2.src = jWin.attr('href');

    }



    $.fn.CloudZoom = function (options) {

        // IE6 background image flicker fix

        try {

            document.execCommand("BackgroundImageCache", false, true);

        } catch (e) {}

        this.each(function () {

			var	relOpts, opts;

			// Hmm...eval...slap on wrist.

			eval('var	a = {' + $(this).attr('rel') + '}');

			relOpts = a;

            if ($(this).is('.cloud-zoom')) {

                $(this).css({

                    'position': 'relative',

                    'display': 'block'

                });

                $('img', $(this)).css({

                    'display': 'block'

                });

                // Wrap an outer div around the link so we can attach things without them becoming part of the link.

                // But not if wrap already exists.

                if ($(this).parent().attr('id') != 'wrap') {

                    $(this).wrap('<div id="wrap" style="top:0px;z-index:99;position:relative;"></div>');

                }

                opts = $.extend({}, $.fn.CloudZoom.defaults, options);

                opts = $.extend({}, opts, relOpts);

                $(this).data('zoom', new CloudZoom($(this), opts));



            } else if ($(this).is('.cloud-zoom-gallery')) {

                opts = $.extend({}, relOpts, options);

                $(this).data('relOpts', opts);

                $(this).bind('click', $(this), function (event) {

                    var data = event.data.data('relOpts');

                    // Destroy the previous zoom

                    $('#' + data.useZoom).data('zoom').destroy();

                    // Change the biglink to point to the new big image.

                    $('#' + data.useZoom).attr('href', event.data.attr('href'));

                    // Change the small image to point to the new small image.

                    $('#' + data.useZoom + ' img').attr('src', event.data.data('relOpts').smallImage);

                    // Init a new zoom with the new images.				

                    $('#' + event.data.data('relOpts').useZoom).CloudZoom();

                    return false;

                });

            }

        });

        return this;

    };



    $.fn.CloudZoom.defaults = {

        zoomWidth: 'auto',

        zoomHeight: 'auto',

        position: 'right',

        tint: false,

        tintOpacity: 0.5,

        lensOpacity: 0.5,

        softFocus: false,

        smoothMove: 3,

        showTitle: false,

        titleOpacity: 0.5,

        adjustX: 0,

        adjustY: 0

    };



})(jQuery);

//Megamenu

jQuery.fn.megamenu = function(options) {

	options = jQuery.extend({ 

		animation: "slide",  

		mm_timeout: 300

	}, options);

	var $megamenu_object = this; 

	$megamenu_object.find("li.parent").each(function(){  

		var $mm_item = jQuery(this).children('div'); 

		$mm_item.hide();  

		$mm_item.wrapInner('<div class="mm-item-base clearfix"></div>'); 

		var $timer = 0; 

		jQuery(this).bind('mouseenter', function(e){ 

			var mm_item_obj = jQuery(this).children('div'); 

			jQuery(this).find("a:first").addClass('hover');

			clearTimeout($timer);

			$timer = setTimeout(function(){  

				switch(options.animation) {

					case "show":

						mm_item_obj.show().addClass("shown-sub");

						break;

					case "slide":

						mm_item_obj.height("auto");

						mm_item_obj.slideDown('fast').addClass("shown-sub");

						break;

					case "fade":

						mm_item_obj.fadeTo('fast', 1).addClass("shown-sub");

						break; 

				}

			}, options.mm_timeout);	

		}); 

		jQuery(this).bind('mouseleave', function(e){ 

			clearTimeout($timer); 

			var mm_item_obj = jQuery(this).children('div'); 

			jQuery(this).find("a:first").removeClass('hover');

			switch(options.animation) {

				case "show":

					  mm_item_obj.hide(); 

					  break;

				case "slide":  

					  mm_item_obj.slideUp( 'fast',  function() { 

					  });

					  break;

				case "fade":

					  mm_item_obj.fadeOut( 'fast', function() { 

					  });

					  break;  

              break;

			} 

		}); 

	}); 

	this.show();

}; 

//Mousewheel

(function($) {



var types = ['DOMMouseScroll', 'mousewheel'];



$.event.special.mousewheel = {

    setup: function() {

        if ( this.addEventListener ) {

            for ( var i=types.length; i; ) {

                this.addEventListener( types[--i], handler, false );

            }

        } else {

            this.onmousewheel = handler;

        }

    },

    

    teardown: function() {

        if ( this.removeEventListener ) {

            for ( var i=types.length; i; ) {

                this.removeEventListener( types[--i], handler, false );

            }

        } else {

            this.onmousewheel = null;

        }

    }

};



$.fn.extend({

    mousewheel: function(fn) {

        return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");

    },

    

    unmousewheel: function(fn) {

        return this.unbind("mousewheel", fn);

    }

});





function handler(event) {

    var orgEvent = event || window.event, args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true, deltaX = 0, deltaY = 0;

    event = $.event.fix(orgEvent);

    event.type = "mousewheel";

    

    // Old school scrollwheel delta

    if ( event.wheelDelta ) { delta = event.wheelDelta/120; }

    if ( event.detail     ) { delta = -event.detail/3; }

    

    // New school multidimensional scroll (touchpads) deltas

    deltaY = delta;

    

    // Gecko

    if ( orgEvent.axis !== undefined && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {

        deltaY = 0;

        deltaX = -1*delta;

    }

    

    // Webkit

    if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY/120; }

    if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = -1*orgEvent.wheelDeltaX/120; }

    

    // Add event and delta to the front of the arguments

    args.unshift(event, delta, deltaX, deltaY);

    

    return $.event.handle.apply(this, args);

}



})(jQuery);

/*!

 * fancyBox - jQuery Plugin

 * version: 2.1.1 (Mon, 01 Oct 2012)

 * @requires jQuery v1.6 or later

 *

 * Examples at http://fancyapps.com/fancybox/

 * License: www.fancyapps.com/fancybox/#license

 *

 * Copyright 2012 Janis Skarnelis - janis@fancyapps.com

 *

 */



(function (window, document, $, undefined) {

	"use strict";



	var W = $(window),

		D = $(document),

		F = $.fancybox = function () {

			F.open.apply( this, arguments );

		},

		didUpdate = null,

		isTouch	  = document.createTouch !== undefined,



		isQuery	= function(obj) {

			return obj && obj.hasOwnProperty && obj instanceof $;

		},

		isString = function(str) {

			return str && $.type(str) === "string";

		},

		isPercentage = function(str) {

			return isString(str) && str.indexOf('%') > 0;

		},

		isScrollable = function(el) {

			return (el && !(el.style.overflow && el.style.overflow === 'hidden') && ((el.clientWidth && el.scrollWidth > el.clientWidth) || (el.clientHeight && el.scrollHeight > el.clientHeight)));

		},

		getScalar = function(orig, dim) {

			var value = parseInt(orig, 10) || 0;



			if (dim && isPercentage(orig)) {

				value = F.getViewport()[ dim ] / 100 * value;

			}



			return Math.ceil(value);

		},

		getValue = function(value, dim) {

			return getScalar(value, dim) + 'px';

		};



	$.extend(F, {

		// The current version of fancyBox

		version: '2.1.1',



		defaults: {

			padding : 15,

			margin  : 20,



			width     : 800,

			height    : 600,

			minWidth  : 100,

			minHeight : 100,

			maxWidth  : 9999,

			maxHeight : 9999,



			autoSize   : true,

			autoHeight : false,

			autoWidth  : false,



			autoResize  : !isTouch,

			autoCenter  : !isTouch,

			fitToView   : true,

			aspectRatio : false,

			topRatio    : 0.5,

			leftRatio   : 0.5,



			scrolling : 'auto', // 'auto', 'yes' or 'no'

			wrapCSS   : '',



			arrows     : true,

			closeBtn   : true,

			closeClick : false,

			nextClick  : false,

			mouseWheel : true,

			autoPlay   : false,

			playSpeed  : 3000,

			preload    : 3,

			modal      : false,

			loop       : true,



			ajax  : {

				dataType : 'html',

				headers  : { 'X-fancyBox': true }

			},

			iframe : {

				scrolling : 'auto',

				preload   : true

			},

			swf : {

				wmode: 'transparent',

				allowfullscreen   : 'true',

				allowscriptaccess : 'always'

			},



			keys  : {

				next : {

					13 : 'left', // enter

					34 : 'up',   // page down

					39 : 'left', // right arrow

					40 : 'up'    // down arrow

				},

				prev : {

					8  : 'right',  // backspace

					33 : 'down',   // page up

					37 : 'right',  // left arrow

					38 : 'down'    // up arrow

				},

				close  : [27], // escape key

				play   : [32], // space - start/stop slideshow

				toggle : [70]  // letter "f" - toggle fullscreen

			},



			direction : {

				next : 'left',

				prev : 'right'

			},



			scrollOutside  : true,



			// Override some properties

			index   : 0,

			type    : null,

			href    : null,

			content : null,

			title   : null,



			// HTML templates

			tpl: {

				wrap     : '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',

				image    : '<img class="fancybox-image" src="{href}" alt="" />',

				iframe   : '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0"' + ($.browser.msie ? ' allowtransparency="true"' : '') + '></iframe>',

				error    : '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',

				closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',

				next     : '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',

				prev     : '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'

			},



			// Properties for each animation type

			// Opening fancyBox

			openEffect  : 'fade', // 'elastic', 'fade' or 'none'

			openSpeed   : 250,

			openEasing  : 'swing',

			openOpacity : true,

			openMethod  : 'zoomIn',



			// Closing fancyBox

			closeEffect  : 'fade', // 'elastic', 'fade' or 'none'

			closeSpeed   : 250,

			closeEasing  : 'swing',

			closeOpacity : true,

			closeMethod  : 'zoomOut',



			// Changing next gallery item

			nextEffect : 'elastic', // 'elastic', 'fade' or 'none'

			nextSpeed  : 250,

			nextEasing : 'swing',

			nextMethod : 'changeIn',



			// Changing previous gallery item

			prevEffect : 'elastic', // 'elastic', 'fade' or 'none'

			prevSpeed  : 250,

			prevEasing : 'swing',

			prevMethod : 'changeOut',



			// Enable default helpers

			helpers : {

				overlay : true,

				title   : true

			},



			// Callbacks

			onCancel     : $.noop, // If canceling

			beforeLoad   : $.noop, // Before loading

			afterLoad    : $.noop, // After loading

			beforeShow   : $.noop, // Before changing in current item

			afterShow    : $.noop, // After opening

			beforeChange : $.noop, // Before changing gallery item

			beforeClose  : $.noop, // Before closing

			afterClose   : $.noop  // After closing

		},



		//Current state

		group    : {}, // Selected group

		opts     : {}, // Group options

		previous : null,  // Previous element

		coming   : null,  // Element being loaded

		current  : null,  // Currently loaded element

		isActive : false, // Is activated

		isOpen   : false, // Is currently open

		isOpened : false, // Have been fully opened at least once



		wrap  : null,

		skin  : null,

		outer : null,

		inner : null,



		player : {

			timer    : null,

			isActive : false

		},



		// Loaders

		ajaxLoad   : null,

		imgPreload : null,



		// Some collections

		transitions : {},

		helpers     : {},



		/*

		 *	Static methods

		 */



		open: function (group, opts) {

			if (!group) {

				return;

			}



			if (!$.isPlainObject(opts)) {

				opts = {};

			}



			// Close if already active

			if (false === F.close(true)) {

				return;

			}



			// Normalize group

			if (!$.isArray(group)) {

				group = isQuery(group) ? $(group).get() : [group];

			}



			// Recheck if the type of each element is `object` and set content type (image, ajax, etc)

			$.each(group, function(i, element) {

				var obj = {},

					href,

					title,

					content,

					type,

					rez,

					hrefParts,

					selector;



				if ($.type(element) === "object") {

					// Check if is DOM element

					if (element.nodeType) {

						element = $(element);

					}



					if (isQuery(element)) {

						obj = {

							href    : element.data('fancybox-href') || element.attr('href'),

							title   : element.data('fancybox-title') || element.attr('title'),

							isDom   : true,

							element : element

						};



						if ($.metadata) {

							$.extend(true, obj, element.metadata());

						}



					} else {

						obj = element;

					}

				}



				href  = opts.href  || obj.href || (isString(element) ? element : null);

				title = opts.title !== undefined ? opts.title : obj.title || '';



				content = opts.content || obj.content;

				type    = content ? 'html' : (opts.type  || obj.type);



				if (!type && obj.isDom) {

					type = element.data('fancybox-type');



					if (!type) {

						rez  = element.prop('class').match(/fancybox\.(\w+)/);

						type = rez ? rez[1] : null;

					}

				}



				if (isString(href)) {

					// Try to guess the content type

					if (!type) {

						if (F.isImage(href)) {

							type = 'image';



						} else if (F.isSWF(href)) {

							type = 'swf';



						} else if (href.charAt(0) === '#') {

							type = 'inline';



						} else if (isString(element)) {

							type    = 'html';

							content = element;

						}

					}



					// Split url into two pieces with source url and content selector, e.g,

					// "/mypage.html #my_id" will load "/mypage.html" and display element having id "my_id"

					if (type === 'ajax') {

						hrefParts = href.split(/\s+/, 2);

						href      = hrefParts.shift();

						selector  = hrefParts.shift();

					}

				}



				if (!content) {

					if (type === 'inline') {

						if (href) {

							content = $( isString(href) ? href.replace(/.*(?=#[^\s]+$)/, '') : href ); //strip for ie7



						} else if (obj.isDom) {

							content = element;

						}



					} else if (type === 'html') {

						content = href;



					} else if (!type && !href && obj.isDom) {

						type    = 'inline';

						content = element;

					}

				}



				$.extend(obj, {

					href     : href,

					type     : type,

					content  : content,

					title    : title,

					selector : selector

				});



				group[ i ] = obj;

			});



			// Extend the defaults

			F.opts = $.extend(true, {}, F.defaults, opts);



			// All options are merged recursive except keys

			if (opts.keys !== undefined) {

				F.opts.keys = opts.keys ? $.extend({}, F.defaults.keys, opts.keys) : false;

			}



			F.group = group;



			return F._start(F.opts.index);

		},



		// Cancel image loading or abort ajax request

		cancel: function () {

			var coming = F.coming;



			if (!coming || false === F.trigger('onCancel')) {

				return;

			}



			F.hideLoading();



			if (F.ajaxLoad) {

				F.ajaxLoad.abort();

			}



			F.ajaxLoad = null;



			if (F.imgPreload) {

				F.imgPreload.onload = F.imgPreload.onerror = null;

			}



			// If the first item has been canceled, then clear everything

			if (coming.wrap) {

				coming.wrap.stop(true).trigger('onReset').remove();

			}



			if (!F.current) {

				F.trigger('afterClose');

			}



			F.coming = null;

		},



		// Start closing animation if is open; remove immediately if opening/closing

		close: function (immediately) {

			F.cancel();



			if (false === F.trigger('beforeClose')) {

				return;

			}



			F.unbindEvents();



			if (!F.isOpen || immediately === true) {

				$('.fancybox-wrap').stop(true).trigger('onReset').remove();



				F._afterZoomOut();



			} else {

				F.isOpen = F.isOpened = false;

				F.isClosing = true;



				$('.fancybox-item, .fancybox-nav').remove();



				F.wrap.stop(true, true).removeClass('fancybox-opened');



				if (F.wrap.css('position') === 'fixed') {

					F.wrap.css(F._getPosition( true ));

				}



				F.transitions[ F.current.closeMethod ]();

			}

		},



		// Manage slideshow:

		//   $.fancybox.play(); - toggle slideshow

		//   $.fancybox.play( true ); - start

		//   $.fancybox.play( false ); - stop

		play: function ( action ) {

			var clear = function () {

					clearTimeout(F.player.timer);

				},

				set = function () {

					clear();



					if (F.current && F.player.isActive) {

						F.player.timer = setTimeout(F.next, F.current.playSpeed);

					}

				},

				stop = function () {

					clear();



					$('body').unbind('.player');



					F.player.isActive = false;



					F.trigger('onPlayEnd');

				},

				start = function () {

					if (F.current && (F.current.loop || F.current.index < F.group.length - 1)) {

						F.player.isActive = true;



						$('body').bind({

							'afterShow.player onUpdate.player'   : set,

							'onCancel.player beforeClose.player' : stop,

							'beforeLoad.player' : clear

						});



						set();



						F.trigger('onPlayStart');

					}

				};



			if (action === true || (!F.player.isActive && action !== false)) {

				start();

			} else {

				stop();

			}

		},



		// Navigate to next gallery item

		next: function ( direction ) {

			var current = F.current;



			if (current) {

				if (!isString(direction)) {

					direction = current.direction.next;

				}



				F.jumpto(current.index + 1, direction, 'next');

			}

		},



		// Navigate to previous gallery item

		prev: function ( direction ) {

			var current = F.current;



			if (current) {

				if (!isString(direction)) {

					direction = current.direction.prev;

				}



				F.jumpto(current.index - 1, direction, 'prev');

			}

		},



		// Navigate to gallery item by index

		jumpto: function ( index, direction, router ) {

			var current = F.current;



			if (!current) {

				return;

			}



			index = getScalar(index);



			F.direction = direction || current.direction[ (index >= current.index ? 'next' : 'prev') ];

			F.router    = router || 'jumpto';



			if (current.loop) {

				if (index < 0) {

					index = current.group.length + (index % current.group.length);

				}



				index = index % current.group.length;

			}



			if (current.group[ index ] !== undefined) {

				F.cancel();



				F._start(index);

			}

		},



		// Center inside viewport and toggle position type to fixed or absolute if needed

		reposition: function (e, onlyAbsolute) {

			var pos;



			if (F.isOpen) {

				pos = F._getPosition(onlyAbsolute);



				if (e && e.type === 'scroll') {

					delete pos.position;



					F.wrap.stop(true, true).animate(pos, 200);



				} else {

					F.wrap.css(pos);

				}

			}

		},



		update: function (e) {

			var type = (e && e.type),

				anyway = !type || type === 'orientationchange';



			if (anyway) {

				clearTimeout(didUpdate);



				didUpdate = null;

			}



			if (!F.isOpen || didUpdate) {

				return;

			}



			// Help browser to restore document dimensions

			if (anyway || isTouch) {

				F.wrap.removeAttr('style').addClass('fancybox-tmp');



				F.trigger('onUpdate');

			}



			didUpdate = setTimeout(function() {

				var current = F.current;



				if (!current) {

					return;

				}



				F.wrap.removeClass('fancybox-tmp');



				if (type !== 'scroll') {

					F._setDimension();

				}



				if (!(type === 'scroll' && current.canShrink)) {

					F.reposition(e);

				}



				F.trigger('onUpdate');



				didUpdate = null;



			}, (isTouch ? 500 : (anyway ? 20 : 300)));

		},



		// Shrink content to fit inside viewport or restore if resized

		toggle: function ( action ) {

			if (F.isOpen) {

				F.current.fitToView = $.type(action) === "boolean" ? action : !F.current.fitToView;



				F.update();

			}

		},



		hideLoading: function () {

			D.unbind('keypress.fb');



			$('#fancybox-loading').remove();

		},



		showLoading: function () {

			var el, viewport;



			F.hideLoading();



			// If user will press the escape-button, the request will be canceled

			D.bind('keypress.fb', function(e) {

				if ((e.which || e.keyCode) === 27) {

					e.preventDefault();

					F.cancel();

				}

			});



			el = $('<div id="fancybox-loading"><div></div></div>').click(F.cancel).appendTo('body');



			if (!F.defaults.fixed) {

				viewport = F.getViewport();



				el.css({

					position : 'absolute',

					top  : (viewport.h * 0.5) + viewport.y,

					left : (viewport.w * 0.5) + viewport.x

				});

			}

		},



		getViewport: function () {

			var locked = (F.current && F.current.locked) || false,

				rez    = {

					x: W.scrollLeft(),

					y: W.scrollTop()

				};



			if (locked) {

				rez.w = locked[0].clientWidth;

				rez.h = locked[0].clientHeight;



			} else {

				// See http://bugs.jquery.com/ticket/6724

				rez.w = isTouch && window.innerWidth  ? window.innerWidth  : W.width();

				rez.h = isTouch && window.innerHeight ? window.innerHeight : W.height();

			}



			return rez;

		},



		// Unbind the keyboard / clicking actions

		unbindEvents: function () {

			if (F.wrap && isQuery(F.wrap)) {

				F.wrap.unbind('.fb');

			}



			D.unbind('.fb');

			W.unbind('.fb');

		},



		bindEvents: function () {

			var current = F.current,

				keys;



			if (!current) {

				return;

			}



			// Changing document height on iOS devices triggers a 'resize' event,

			// that can change document height... repeating infinitely

			W.bind('orientationchange.fb' + (current.autoResize ? ' resize.fb' : '' ) + (current.autoCenter && !current.locked ? ' scroll.fb' : ''), F.update);



			keys = current.keys;



			if (keys) {

				D.bind('keydown.fb', function (e) {

					var code   = e.which || e.keyCode,

						target = e.target || e.srcElement;



					// Ignore key combinations and key events within form elements

					if (!e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey && !(target && (target.type || $(target).is('[contenteditable]')))) {

						$.each(keys, function(i, val) {

							if (current.group.length > 1 && val[ code ] !== undefined) {

								F[ i ]( val[ code ] );



								e.preventDefault();

								return false;

							}



							if ($.inArray(code, val) > -1) {

								F[ i ] ();



								e.preventDefault();

								return false;

							}

						});

					}

				});

			}



			if ($.fn.mousewheel && current.mouseWheel) {

				F.wrap.bind('mousewheel.fb', function (e, delta, deltaX, deltaY) {

					var target = e.target || null,

						parent = $(target),

						canScroll = false;



					while (parent.length) {

						if (canScroll || parent.is('.fancybox-skin') || parent.is('.fancybox-wrap')) {

							break;

						}



						canScroll = isScrollable( parent[0] );

						parent    = $(parent).parent();

					}



					if (delta !== 0 && !canScroll) {

						if (F.group.length > 1 && !current.canShrink) {

							if (deltaY > 0 || deltaX > 0) {

								F.prev( deltaY > 0 ? 'down' : 'left' );



							} else if (deltaY < 0 || deltaX < 0) {

								F.next( deltaY < 0 ? 'up' : 'right' );

							}



							e.preventDefault();

						}

					}

				});

			}

		},



		trigger: function (event, o) {

			var ret, obj = o || F.coming || F.current;



			if (!obj) {

				return;

			}



			if ($.isFunction( obj[event] )) {

				ret = obj[event].apply(obj, Array.prototype.slice.call(arguments, 1));

			}



			if (ret === false) {

				return false;

			}



			if (event === 'onCancel' && !F.isOpened) {

				F.isActive = false;

			}



			if (obj.helpers) {

				$.each(obj.helpers, function (helper, opts) {

					if (opts && F.helpers[helper] && $.isFunction(F.helpers[helper][event])) {

						opts = $.extend(true, {}, F.helpers[helper].defaults, opts);



						F.helpers[helper][event](opts, obj);

					}

				});

			}



			$.event.trigger(event + '.fb');

		},



		isImage: function (str) {

			return isString(str) && str.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp)((\?|#).*)?$)/i);

		},



		isSWF: function (str) {

			return isString(str) && str.match(/\.(swf)((\?|#).*)?$/i);

		},



		_start: function (index) {

			var coming = {},

				obj,

				href,

				type,

				margin,

				padding;



			index = getScalar( index );

			obj   = F.group[ index ] || null;



			if (!obj) {

				return false;

			}



			coming = $.extend(true, {}, F.opts, obj);



			// Convert margin and padding properties to array - top, right, bottom, left

			margin  = coming.margin;

			padding = coming.padding;



			if ($.type(margin) === 'number') {

				coming.margin = [margin, margin, margin, margin];

			}



			if ($.type(padding) === 'number') {

				coming.padding = [padding, padding, padding, padding];

			}



			// 'modal' propery is just a shortcut

			if (coming.modal) {

				$.extend(true, coming, {

					closeBtn   : false,

					closeClick : false,

					nextClick  : false,

					arrows     : false,

					mouseWheel : false,

					keys       : null,

					helpers: {

						overlay : {

							closeClick : false

						}

					}

				});

			}



			// 'autoSize' property is a shortcut, too

			if (coming.autoSize) {

				coming.autoWidth = coming.autoHeight = true;

			}



			if (coming.width === 'auto') {

				coming.autoWidth = true;

			}



			if (coming.height === 'auto') {

				coming.autoHeight = true;

			}



			/*

			 * Add reference to the group, so it`s possible to access from callbacks, example:

			 * afterLoad : function() {

			 *     this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');

			 * }

			 */



			coming.group  = F.group;

			coming.index  = index;



			// Give a chance for callback or helpers to update coming item (type, title, etc)

			F.coming = coming;



			if (false === F.trigger('beforeLoad')) {

				F.coming = null;



				return;

			}



			type = coming.type;

			href = coming.href;



			if (!type) {

				F.coming = null;



				//If we can not determine content type then drop silently or display next/prev item if looping through gallery

				if (F.current && F.router && F.router !== 'jumpto') {

					F.current.index = index;



					return F[ F.router ]( F.direction );

				}



				return false;

			}



			F.isActive = true;



			if (type === 'image' || type === 'swf') {

				coming.autoHeight = coming.autoWidth = false;

				coming.scrolling  = 'visible';

			}



			if (type === 'image') {

				coming.aspectRatio = true;

			}



			if (type === 'iframe' && isTouch) {

				coming.scrolling = 'scroll';

			}



			// Build the neccessary markup

			coming.wrap = $(coming.tpl.wrap).addClass('fancybox-' + (isTouch ? 'mobile' : 'desktop') + ' fancybox-type-' + type + ' fancybox-tmp ' + coming.wrapCSS).appendTo( coming.parent || 'body' );



			$.extend(coming, {

				skin  : $('.fancybox-skin',  coming.wrap),

				outer : $('.fancybox-outer', coming.wrap),

				inner : $('.fancybox-inner', coming.wrap)

			});



			$.each(["Top", "Right", "Bottom", "Left"], function(i, v) {

				coming.skin.css('padding' + v, getValue(coming.padding[ i ]));

			});



			F.trigger('onReady');



			// Check before try to load; 'inline' and 'html' types need content, others - href

			if (type === 'inline' || type === 'html') {

				if (!coming.content || !coming.content.length) {

					return F._error( 'content' );

				}



			} else if (!href) {

				return F._error( 'href' );

			}



			if (type === 'image') {

				F._loadImage();



			} else if (type === 'ajax') {

				F._loadAjax();



			} else if (type === 'iframe') {

				F._loadIframe();



			} else {

				F._afterLoad();

			}

		},



		_error: function ( type ) {

			$.extend(F.coming, {

				type       : 'html',

				autoWidth  : true,

				autoHeight : true,

				minWidth   : 0,

				minHeight  : 0,

				scrolling  : 'no',

				hasError   : type,

				content    : F.coming.tpl.error

			});



			F._afterLoad();

		},



		_loadImage: function () {

			// Reset preload image so it is later possible to check "complete" property

			var img = F.imgPreload = new Image();



			img.onload = function () {

				this.onload = this.onerror = null;



				F.coming.width  = this.width;

				F.coming.height = this.height;



				F._afterLoad();

			};



			img.onerror = function () {

				this.onload = this.onerror = null;



				F._error( 'image' );

			};



			img.src = F.coming.href;



			if (img.complete === undefined || !img.complete) {

				F.showLoading();

			}

		},



		_loadAjax: function () {

			var coming = F.coming;



			F.showLoading();



			F.ajaxLoad = $.ajax($.extend({}, coming.ajax, {

				url: coming.href,

				error: function (jqXHR, textStatus) {

					if (F.coming && textStatus !== 'abort') {

						F._error( 'ajax', jqXHR );



					} else {

						F.hideLoading();

					}

				},

				success: function (data, textStatus) {

					if (textStatus === 'success') {

						coming.content = data;



						F._afterLoad();

					}

				}

			}));

		},



		_loadIframe: function() {

			var coming = F.coming,

				iframe = $(coming.tpl.iframe.replace(/\{rnd\}/g, new Date().getTime()))

					.attr('scrolling', isTouch ? 'auto' : coming.iframe.scrolling)

					.attr('src', coming.href);



			// This helps IE

			$(coming.wrap).bind('onReset', function () {

				try {

					$(this).find('iframe').hide().attr('src', '//about:blank').end().empty();

				} catch (e) {}

			});



			if (coming.iframe.preload) {

				F.showLoading();



				iframe.one('load', function() {

					$(this).data('ready', 1);



					// iOS will lose scrolling if we resize

					if (!isTouch) {

						$(this).bind('load.fb', F.update);

					}



					// Without this trick:

					//   - iframe won't scroll on iOS devices

					//   - IE7 sometimes displays empty iframe

					$(this).parents('.fancybox-wrap').width('100%').removeClass('fancybox-tmp').show();



					F._afterLoad();

				});

			}



			coming.content = iframe.appendTo( coming.inner );



			if (!coming.iframe.preload) {

				F._afterLoad();

			}

		},



		_preloadImages: function() {

			var group   = F.group,

				current = F.current,

				len     = group.length,

				cnt     = current.preload ? Math.min(current.preload, len - 1) : 0,

				item,

				i;



			for (i = 1; i <= cnt; i += 1) {

				item = group[ (current.index + i ) % len ];



				if (item.type === 'image' && item.href) {

					new Image().src = item.href;

				}

			}

		},



		_afterLoad: function () {

			var coming   = F.coming,

				previous = F.current,

				placeholder = 'fancybox-placeholder',

				current,

				content,

				type,

				scrolling,

				href,

				embed;



			F.hideLoading();



			if (!coming || F.isActive === false) {

				return;

			}



			if (false === F.trigger('afterLoad', coming, previous)) {

				coming.wrap.stop(true).trigger('onReset').remove();



				F.coming = null;



				return;

			}



			if (previous) {

				F.trigger('beforeChange', previous);



				previous.wrap.stop(true).removeClass('fancybox-opened')

					.find('.fancybox-item, .fancybox-nav')

					.remove();



				if (previous.wrap.css('position') === 'fixed') {

					previous.wrap.css(F._getPosition( true ));

				}

			}



			F.unbindEvents();



			current   = coming;

			content   = coming.content;

			type      = coming.type;

			scrolling = coming.scrolling;



			$.extend(F, {

				wrap  : current.wrap,

				skin  : current.skin,

				outer : current.outer,

				inner : current.inner,

				current  : current,

				previous : previous

			});



			href = current.href;



			switch (type) {

				case 'inline':

				case 'ajax':

				case 'html':

					if (current.selector) {

						content = $('<div>').html(content).find(current.selector);



					} else if (isQuery(content)) {

						if (!content.data(placeholder)) {

							content.data(placeholder, $('<div class="' + placeholder + '"></div>').insertAfter( content ).hide() );

						}



						content = content.show().detach();



						current.wrap.bind('onReset', function () {

							if ($(this).find(content).length) {

								content.hide().replaceAll( content.data(placeholder) ).data(placeholder, false);

							}

						});

					}

				break;



				case 'image':

					content = current.tpl.image.replace('{href}', href);

				break;



				case 'swf':

					content = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + href + '"></param>';

					embed   = '';



					$.each(current.swf, function(name, val) {

						content += '<param name="' + name + '" value="' + val + '"></param>';

						embed   += ' ' + name + '="' + val + '"';

					});



					content += '<embed src="' + href + '" type="application/x-shockwave-flash" width="100%" height="100%"' + embed + '></embed></object>';

				break;

			}



			if (!(isQuery(content) && content.parent().is(current.inner))) {

				current.inner.append( content );

			}



			// Give a chance for helpers or callbacks to update elements

			F.trigger('beforeShow');



			// Set scrolling before calculating dimensions

			current.inner.css('overflow', scrolling === 'yes' ? 'scroll' : (scrolling === 'no' ? 'hidden' : scrolling));



			// Set initial dimensions and start position

			F._setDimension();



			current.wrap.removeClass('fancybox-tmp');



			current.pos = $.extend({}, current.dim, F._getPosition( true ));



			F.isOpen = false;

			F.coming = null;



			F.bindEvents();



			if (!F.isOpened) {

				$('.fancybox-wrap').not( current.wrap ).stop(true).trigger('onReset').remove();



			} else if (previous.prevMethod) {

				F.transitions[ previous.prevMethod ]();

			}



			F.transitions[ F.isOpened ? current.nextMethod : current.openMethod ]();



			F._preloadImages();

		},



		_setDimension: function () {

			var viewport   = F.getViewport(),

				steps      = 0,

				canShrink  = false,

				canExpand  = false,

				wrap       = F.wrap,

				skin       = F.skin,

				inner      = F.inner,

				current    = F.current,

				width      = current.width,

				height     = current.height,

				minWidth   = current.minWidth,

				minHeight  = current.minHeight,

				maxWidth   = current.maxWidth,

				maxHeight  = current.maxHeight,

				scrolling  = current.scrolling,

				scrollOut  = current.scrollOutside ? current.scrollbarWidth : 0,

				margin     = current.margin,

				wMargin    = margin[1] + margin[3],

				hMargin    = margin[0] + margin[2],

				wPadding,

				hPadding,

				wSpace,

				hSpace,

				origWidth,

				origHeight,

				origMaxWidth,

				origMaxHeight,

				ratio,

				width_,

				height_,

				maxWidth_,

				maxHeight_,

				iframe,

				body;



			// Reset dimensions so we could re-check actual size

			wrap.add(skin).add(inner).width('auto').height('auto');



			wPadding = skin.outerWidth(true)  - skin.width();

			hPadding = skin.outerHeight(true) - skin.height();



			// Any space between content and viewport (margin, padding, border, title)

			wSpace = wMargin + wPadding;

			hSpace = hMargin + hPadding;



			origWidth  = isPercentage(width)  ? (viewport.w - wSpace) * getScalar(width)  / 100 : width;

			origHeight = isPercentage(height) ? (viewport.h - hSpace) * getScalar(height) / 100 : height;



			if (current.type === 'iframe') {

				iframe = current.content;



				if (current.autoHeight && iframe.data('ready') === 1) {

					try {

						if (iframe[0].contentWindow.document.location) {

							inner.width( origWidth ).height(9999);



							body = iframe.contents().find('body');



							if (scrollOut) {

								body.css('overflow-x', 'hidden');

							}



							origHeight = body.height();

						}



					} catch (e) {}

				}



			} else if (current.autoWidth || current.autoHeight) {

				inner.addClass( 'fancybox-tmp' );



				// Set width or height in case we need to calculate only one dimension

				if (!current.autoWidth) {

					inner.width( origWidth );

				}



				if (!current.autoHeight) {

					inner.height( origHeight );

				}



				if (current.autoWidth) {

					origWidth = inner.width();

				}



				if (current.autoHeight) {

					origHeight = inner.height();

				}



				inner.removeClass( 'fancybox-tmp' );

			}



			width  = getScalar( origWidth );

			height = getScalar( origHeight );



			ratio  = origWidth / origHeight;



			// Calculations for the content

			minWidth  = getScalar(isPercentage(minWidth) ? getScalar(minWidth, 'w') - wSpace : minWidth);

			maxWidth  = getScalar(isPercentage(maxWidth) ? getScalar(maxWidth, 'w') - wSpace : maxWidth);



			minHeight = getScalar(isPercentage(minHeight) ? getScalar(minHeight, 'h') - hSpace : minHeight);

			maxHeight = getScalar(isPercentage(maxHeight) ? getScalar(maxHeight, 'h') - hSpace : maxHeight);



			// These will be used to determine if wrap can fit in the viewport

			origMaxWidth  = maxWidth;

			origMaxHeight = maxHeight;



			maxWidth_  = viewport.w - wMargin;

			maxHeight_ = viewport.h - hMargin;



			if (current.aspectRatio) {

				if (width > maxWidth) {

					width  = maxWidth;

					height = width / ratio;

				}



				if (height > maxHeight) {

					height = maxHeight;

					width  = height * ratio;

				}



				if (width < minWidth) {

					width  = minWidth;

					height = width / ratio;

				}



				if (height < minHeight) {

					height = minHeight;

					width  = height * ratio;

				}



			} else {

				width  = Math.max(minWidth,  Math.min(width,  maxWidth));

				height = Math.max(minHeight, Math.min(height, maxHeight));

			}



			// Try to fit inside viewport (including the title)

			if (current.fitToView) {

				maxWidth  = Math.min(viewport.w - wSpace, maxWidth);

				maxHeight = Math.min(viewport.h - hSpace, maxHeight);



				inner.width( getScalar( width ) ).height( getScalar( height ) );



				wrap.width( getScalar( width + wPadding ) );



				// Real wrap dimensions

				width_  = wrap.width();

				height_ = wrap.height();



				if (current.aspectRatio) {

					while ((width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight) {

						if (steps++ > 19) {

							break;

						}



						height = Math.max(minHeight, Math.min(maxHeight, height - 10));

						width  = height * ratio;



						if (width < minWidth) {

							width  = minWidth;

							height = width / ratio;

						}



						if (width > maxWidth) {

							width  = maxWidth;

							height = width / ratio;

						}



						inner.width( getScalar( width ) ).height( getScalar( height ) );



						wrap.width( getScalar( width + wPadding ) );



						width_  = wrap.width();

						height_ = wrap.height();

					}



				} else {

					width  = Math.max(minWidth,  Math.min(width,  width  - (width_  - maxWidth_)));

					height = Math.max(minHeight, Math.min(height, height - (height_ - maxHeight_)));

				}

			}



			if (scrollOut && scrolling === 'auto' && height < origHeight && (width + wPadding + scrollOut) < maxWidth_) {

				width += scrollOut;

			}



			inner.width( getScalar( width ) ).height( getScalar( height ) );



			wrap.width( getScalar( width + wPadding ) );



			width_  = wrap.width();

			height_ = wrap.height();



			canShrink = (width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight;

			canExpand = current.aspectRatio ? (width < origMaxWidth && height < origMaxHeight && width < origWidth && height < origHeight) : ((width < origMaxWidth || height < origMaxHeight) && (width < origWidth || height < origHeight));



			$.extend(current, {

				dim : {

					width	: getValue( width_ ),

					height	: getValue( height_ )

				},

				origWidth  : origWidth,

				origHeight : origHeight,

				canShrink  : canShrink,

				canExpand  : canExpand,

				wPadding   : wPadding,

				hPadding   : hPadding,

				wrapSpace  : height_ - skin.outerHeight(true),

				skinSpace  : skin.height() - height

			});



			if (!iframe && current.autoHeight && height > minHeight && height < maxHeight && !canExpand) {

				inner.height('auto');

			}

		},



		_getPosition: function (onlyAbsolute) {

			var current  = F.current,

				viewport = F.getViewport(),

				margin   = current.margin,

				width    = F.wrap.width()  + margin[1] + margin[3],

				height   = F.wrap.height() + margin[0] + margin[2],

				rez      = {

					position: 'absolute',

					top  : margin[0],

					left : margin[3]

				};



			if (current.autoCenter && current.fixed && !onlyAbsolute && height <= viewport.h && width <= viewport.w) {

				rez.position = 'fixed';



			} else if (!current.locked) {

				rez.top  += viewport.y;

				rez.left += viewport.x;

			}



			rez.top  = getValue(Math.max(rez.top,  rez.top  + ((viewport.h - height) * current.topRatio)));

			rez.left = getValue(Math.max(rez.left, rez.left + ((viewport.w - width)  * current.leftRatio)));



			return rez;

		},



		_afterZoomIn: function () {

			var current = F.current;



			if (!current) {

				return;

			}



			F.isOpen = F.isOpened = true;



			F.wrap.addClass('fancybox-opened').css('overflow', 'visible');



			F.reposition();



			// Assign a click event

			if (current.closeClick || current.nextClick) {

				F.inner.css('cursor', 'pointer').bind('click.fb', function(e) {

					if (!$(e.target).is('a') && !$(e.target).parent().is('a')) {

						F[ current.closeClick ? 'close' : 'next' ]();

					}

				});

			}



			// Create a close button

			if (current.closeBtn) {

				$(current.tpl.closeBtn).appendTo(F.skin).bind('click.fb', F.close);

			}



			// Create navigation arrows

			if (current.arrows && F.group.length > 1) {

				if (current.loop || current.index > 0) {

					$(current.tpl.prev).appendTo(F.outer).bind('click.fb', F.prev);

				}



				if (current.loop || current.index < F.group.length - 1) {

					$(current.tpl.next).appendTo(F.outer).bind('click.fb', F.next);

				}

			}



			F.trigger('afterShow');



			// Stop the slideshow if this is the last item

			if (!current.loop && current.index === current.group.length - 1) {

				F.play( false );



			} else if (F.opts.autoPlay && !F.player.isActive) {

				F.opts.autoPlay = false;



				F.play();

			}

		},



		_afterZoomOut: function () {

			var current = F.current;



			$('.fancybox-wrap').stop(true).trigger('onReset').remove();



			$.extend(F, {

				group  : {},

				opts   : {},

				router : false,

				current   : null,

				isActive  : false,

				isOpened  : false,

				isOpen    : false,

				isClosing : false,

				wrap   : null,

				skin   : null,

				outer  : null,

				inner  : null

			});



			F.trigger('afterClose', current);

		}

	});



	/*

	 *	Default transitions

	 */



	F.transitions = {

		getOrigPosition: function () {

			var current  = F.current,

				element  = current.element,

				orig     = current.orig,

				pos      = {},

				width    = 50,

				height   = 50,

				hPadding = current.hPadding,

				wPadding = current.wPadding,

				viewport = F.getViewport();



			if (!orig && current.isDom && element.is(':visible')) {

				orig = element.find('img:first');



				if (!orig.length) {

					orig = element;

				}

			}



			if (isQuery(orig)) {

				pos = orig.offset();



				if (orig.is('img')) {

					width  = orig.outerWidth();

					height = orig.outerHeight();

				}



			} else {

				pos.top  = viewport.y + (viewport.h - height) * current.topRatio;

				pos.left = viewport.x + (viewport.w - width)  * current.leftRatio;

			}



			if (current.locked) {

				pos.top  -= viewport.y;

				pos.left -= viewport.x;

			}



			pos = {

				top     : getValue(pos.top  - hPadding * current.topRatio),

				left    : getValue(pos.left - wPadding * current.leftRatio),

				width   : getValue(width  + wPadding),

				height  : getValue(height + hPadding)

			};



			return pos;

		},



		step: function (now, fx) {

			var ratio,

				padding,

				value,

				prop       = fx.prop,

				current    = F.current,

				wrapSpace  = current.wrapSpace,

				skinSpace  = current.skinSpace;



			if (prop === 'width' || prop === 'height') {

				ratio = fx.end === fx.start ? 1 : (now - fx.start) / (fx.end - fx.start);



				if (F.isClosing) {

					ratio = 1 - ratio;

				}



				padding = prop === 'width' ? current.wPadding : current.hPadding;

				value   = now - padding;



				F.skin[ prop ](  getScalar( prop === 'width' ?  value : value - (wrapSpace * ratio) ) );

				F.inner[ prop ]( getScalar( prop === 'width' ?  value : value - (wrapSpace * ratio) - (skinSpace * ratio) ) );

			}

		},



		zoomIn: function () {

			var current  = F.current,

				startPos = current.pos,

				effect   = current.openEffect,

				elastic  = effect === 'elastic',

				endPos   = $.extend({opacity : 1}, startPos);



			// Remove "position" property that breaks older IE

			delete endPos.position;



			if (elastic) {

				startPos = this.getOrigPosition();



				if (current.openOpacity) {

					startPos.opacity = 0.1;

				}



			} else if (effect === 'fade') {

				startPos.opacity = 0.1;

			}



			F.wrap.css(startPos).animate(endPos, {

				duration : effect === 'none' ? 0 : current.openSpeed,

				easing   : current.openEasing,

				step     : elastic ? this.step : null,

				complete : F._afterZoomIn

			});

		},



		zoomOut: function () {

			var current  = F.current,

				effect   = current.closeEffect,

				elastic  = effect === 'elastic',

				endPos   = {opacity : 0.1};



			if (elastic) {

				endPos = this.getOrigPosition();



				if (current.closeOpacity) {

					endPos.opacity = 0.1;

				}

			}



			F.wrap.animate(endPos, {

				duration : effect === 'none' ? 0 : current.closeSpeed,

				easing   : current.closeEasing,

				step     : elastic ? this.step : null,

				complete : F._afterZoomOut

			});

		},



		changeIn: function () {

			var current   = F.current,

				effect    = current.nextEffect,

				startPos  = current.pos,

				endPos    = { opacity : 1 },

				direction = F.direction,

				distance  = 200,

				field;



			startPos.opacity = 0.1;



			if (effect === 'elastic') {

				field = direction === 'down' || direction === 'up' ? 'top' : 'left';



				if (direction === 'down' || direction === 'right') {

					startPos[ field ] = getValue(getScalar(startPos[ field ]) - distance);

					endPos[ field ]   = '+=' + distance + 'px';



				} else {

					startPos[ field ] = getValue(getScalar(startPos[ field ]) + distance);

					endPos[ field ]   = '-=' + distance + 'px';

				}

			}



			// Workaround for http://bugs.jquery.com/ticket/12273

			if (effect === 'none') {

				F._afterZoomIn();



			} else {

				F.wrap.css(startPos).animate(endPos, {

					duration : current.nextSpeed,

					easing   : current.nextEasing,

					complete : F._afterZoomIn

				});

			}

		},



		changeOut: function () {

			var previous  = F.previous,

				effect    = previous.prevEffect,

				endPos    = { opacity : 0.1 },

				direction = F.direction,

				distance  = 200;



			if (effect === 'elastic') {

				endPos[ direction === 'down' || direction === 'up' ? 'top' : 'left' ] = ( direction === 'up' || direction === 'left' ? '-' : '+' ) + '=' + distance + 'px';

			}



			previous.wrap.animate(endPos, {

				duration : effect === 'none' ? 0 : previous.prevSpeed,

				easing   : previous.prevEasing,

				complete : function () {

					$(this).trigger('onReset').remove();

				}

			});

		}

	};



	/*

	 *	Overlay helper

	 */



	F.helpers.overlay = {

		defaults : {

			closeClick : true,  // close if clicking on the overlay

			speedOut   : 200,   // animation speed of fading out

			showEarly  : true,  // should be opened immediately or wait until the content is ready

			css        : {},    // custom overlay style

			locked     : true   // should be content locked into overlay

		},



		overlay : null,



		update : function () {

			var width = '100%', offsetWidth;



			// Reset width/height so it will not mess

			this.overlay.width(width).height('100%');



			// jQuery does not return reliable result for IE

			if ($.browser.msie) {

				offsetWidth = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);



				if (D.width() > offsetWidth) {

					width = D.width();

				}



			} else if (D.width() > W.width()) {

				width = D.width();

			}



			this.overlay.width(width).height(D.height());

		},



		// This is where we can manipulate DOM, because later it would cause iframes to reload

		onReady : function (opts, obj) {

			$('.fancybox-overlay').stop(true, true);



			if (!this.overlay) {

				$.extend(this, {

					overlay : $('<div class="fancybox-overlay"></div>').appendTo( obj.parent || 'body' ),

					margin  : D.height() > W.height() || $('body').css('overflow-y') === 'scroll' ? $('body').css('margin-right') : false,

					el : document.all && !document.querySelector ? $('html') : $('body')

				});

			}



			if (obj.fixed && !isTouch) {

				this.overlay.addClass('fancybox-overlay-fixed');



				if (obj.autoCenter && opts.locked) {

					obj.locked = this.overlay.append( obj.wrap );

				}

			}



			if (opts.showEarly === true) {

				this.beforeShow.apply(this, arguments);

			}

		},



		beforeShow : function(opts, obj) {

			var overlay = this.overlay.unbind('.fb').width('auto').height('auto').css( opts.css );



			if (opts.closeClick) {

				overlay.bind('click.fb', function(e) {

					if ($(e.target).hasClass('fancybox-overlay')) {

						F.close();

					}

				});

			}



			if (obj.fixed && !isTouch) {

				if (obj.locked) {

					this.el.addClass('fancybox-lock');



					if (this.margin !== false) {

						$('body').css('margin-right', getScalar( this.margin ) + obj.scrollbarWidth);

					}

				}



			} else {

				this.update();

			}



			overlay.show();

		},



		onUpdate : function(opts, obj) {

			if (!obj.fixed || isTouch) {

				this.update();

			}

		},



		afterClose: function (opts) {

			var that  = this,

				speed = opts.speedOut || 0;



			// Remove overlay if exists and fancyBox is not opening

			// (e.g., it is not being open using afterClose callback)

			if (that.overlay && !F.isActive) {

				that.overlay.fadeOut(speed || 0, function () {

					$('body').css('margin-right', that.margin);



					that.el.removeClass('fancybox-lock');



					that.overlay.remove();



					that.overlay = null;

				});

			}

		}

	};



	/*

	 *	Title helper

	 */



	F.helpers.title = {

		defaults : {

			type     : 'float', // 'float', 'inside', 'outside' or 'over',

			position : 'bottom' // 'top' or 'bottom'

		},



		beforeShow: function (opts) {

			var current = F.current,

				text    = current.title,

				type    = opts.type,

				title,

				target;



			if ($.isFunction(text)) {

				text = text.call(current.element, current);

			}



			if (!isString(text) || $.trim(text) === '') {

				return;

			}



			title = $('<div class="fancybox-title fancybox-title-' + type + '-wrap">' + text + '</div>');



			switch (type) {

				case 'inside':

					target = F.skin;

				break;



				case 'outside':

					target = F.wrap;

				break;



				case 'over':

					target = F.inner;

				break;



				default: // 'float'

					target = F.skin;



					title.appendTo('body');



					if ($.browser.msie) {

						title.width( title.width() );

					}



					title.wrapInner('<span class="child"></span>');



					//Increase bottom margin so this title will also fit into viewport

					F.current.margin[2] += Math.abs( getScalar(title.css('margin-bottom')) );

				break;

			}



			title[ (opts.position === 'top' ? 'prependTo'  : 'appendTo') ](target);

		}

	};



	// jQuery plugin initialization

	$.fn.fancybox = function (options) {

		var index,

			that     = $(this),

			selector = this.selector || '',

			run      = function(e) {

				var what = $(this).blur(), idx = index, relType, relVal;



				if (!(e.ctrlKey || e.altKey || e.shiftKey || e.metaKey) && !what.is('.fancybox-wrap')) {

					relType = options.groupAttr || 'data-fancybox-group';

					relVal  = what.attr(relType);



					if (!relVal) {

						relType = 'rel';

						relVal  = what.get(0)[ relType ];

					}



					if (relVal && relVal !== '' && relVal !== 'nofollow') {

						what = selector.length ? $(selector) : that;

						what = what.filter('[' + relType + '="' + relVal + '"]');

						idx  = what.index(this);

					}



					options.index = idx;



					// Stop an event from bubbling if everything is fine

					if (F.open(what, options) !== false) {

						e.preventDefault();

					}

				}

			};



		options = options || {};

		index   = options.index || 0;



		if (!selector || options.live === false) {

			that.unbind('click.fb-start').bind('click.fb-start', run);

		} else {

			D.undelegate(selector, 'click.fb-start').delegate(selector + ":not('.fancybox-item, .fancybox-nav')", 'click.fb-start', run);

		}



		return this;

	};



	// Tests that need a body at doc ready

	D.ready(function() {

		if ( $.scrollbarWidth === undefined ) {

			// http://benalman.com/projects/jquery-misc-plugins/#scrollbarwidth

			$.scrollbarWidth = function() {

				var parent = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body'),

					child  = parent.children(),

					width  = child.innerWidth() - child.height( 99 ).innerWidth();



				parent.remove();



				return width;

			};

		}



		if ( $.support.fixedPosition === undefined ) {

			$.support.fixedPosition = (function() {

				var elem  = $('<div style="position:fixed;top:20px;"></div>').appendTo('body'),

					fixed = ( elem[0].offsetTop === 20 || elem[0].offsetTop === 15 );



				elem.remove();



				return fixed;

			}());

		}



		$.extend(F.defaults, {

			scrollbarWidth : $.scrollbarWidth(),

			fixed  : $.support.fixedPosition,

			parent : $('body')

		});

	});



}(window, document, jQuery));

//Accordion menu

(function($){

    $.fn.extend({ 

		mtAccordionMenu: function(options) { 

			var defaults = {

				accordion: 'true',

				speed: 300,

				closedSign: 'collapse',

				openedSign: 'expand'

			}; 

			var opts = $.extend(defaults, options); 

			var $this = $(this);

			$this.find("li").each(function() {

				if($(this).find("ul").size() != 0){ 

					$(this).find("a:first").after("<span class='"+ opts.closedSign +"'>"+ opts.closedSign +"</span>"); 

					if($(this).find("a:first").attr('href') == "#"){

						$(this).find("a:first").click(function(){return false;});

					}

				}

			}); 

			$this.find("li.active").each(function() {

				$(this).parents("ul").slideDown(opts.speed);

				$(this).parents("ul").parent("li").find("span:first").html(opts.openedSign).removeClass(opts.closedSign);

			});

			if(opts.mouseType==0){

				$this.find("li span").click(function() {

					if($(this).parent().find("ul").size() != 0){

						if(opts.accordion){

							//Do nothing when the list is open

							if(!$(this).parent().find("ul").is(':visible')){

								parents = $(this).parent().parents("ul");

								visible = $this.find("ul:visible");

								visible.each(function(visibleIndex){

									var close = true;

									parents.each(function(parentIndex){

										if(parents[parentIndex] == visible[visibleIndex]){

											close = false;

											return false;

										}

									});

									if(close){

										if($(this).parent().find("ul") != visible[visibleIndex]){

											$(visible[visibleIndex]).slideUp(opts.speed, function(){

												$(this).parent("li").find("span:first").html(opts.closedSign).addClass(opts.closedSign);

											});

											

										}

									}

								});

							}

						}

						if($(this).parent().find("ul:first").is(":visible")){

							$(this).parent().find("ul:first").slideUp(opts.speed, function(){

								$(this).parent("li").find("span:first").delay(opts.speed+1000).html(opts.closedSign).addClass(opts.closedSign);

							});

							

							

						}else{

							$(this).parent().find("ul:first").slideDown(opts.speed, function(){

								$(this).parent("li").find("span:first").delay(opts.speed+1000).html(opts.openedSign).removeClass(opts.closedSign);

							});

						}

					}

				});

			}

			if(opts.mouseType>0){

				$this.find("li a").mouseenter(function() { 

					if($(this).parent().find("ul").size() != 0){

						if(opts.accordion){ 

							if(!$(this).parent().find("ul").is(':visible')){

								parents = $(this).parent().parents("ul");

								visible = $this.find("ul:visible");

								visible.each(function(visibleIndex){

									var close = true;

									parents.each(function(parentIndex){

										if(parents[parentIndex] == visible[visibleIndex]){

											close = false;

											return false;

										}

									});

									if(close){

										if($(this).parent().find("ul") != visible[visibleIndex]){

											$(visible[visibleIndex]).slideUp(opts.speed, function(){

												$(this).parent("li").find("span:first").html(opts.closedSign).addClass(opts.closedSign);

											});

											

										}

									}

								});

							}

						}

						if($(this).parent().find("ul:first").is(":visible")){

							$(this).parent().find("ul:first").slideUp(opts.speed, function(){

								$(this).parent("li").find("span:first").delay(opts.speed+1000).html(opts.closedSign).addClass(opts.closedSign);

							});

							

							

						}else{

							$(this).parent().find("ul:first").slideDown(opts.speed, function(){

								$(this).parent("li").find("span:first").delay(opts.speed+1000).html(opts.openedSign).removeClass(opts.closedSign);

							});

						}

					}

				});

			}

		}

	});



jQuery.fn.extend({

scrollToMe: function () {

	var x = jQuery(this).offset().top - 100;

	jQuery('html,body').animate({scrollTop: x}, 500);

}});	

	

})(jQuery);

//Script Manual

$mtkb(window).load(function(){

	 var productHover = {

        over: function(){

            $mtkb('.mt-hover', this).animate({opacity:1}, 200); 

        },

        timeout: 20,

        out: function(){

            $mtkb('.mt-hover', this).animate({opacity:0}, 200);

        }

    };

    $mtkb('.products-grid .product-image, .products-list .product-image').hoverIntent( productHover );  

});

$mtkb(document).ready(function() {

	/*$mtkb('.top-cart').hoverIntent({

		interval: 20,

		over: function() { $mtkb(this).addClass('cart-active').find('.mtajaxcart').slideDown(); },

		out: function() { $mtkb(this).removeClass('cart-active').find('.mtajaxcart').slideUp(); }

	});

	$mtkb('.mtajaxcart').css("display","none"); */

	

	$mtkb(function () {

		$mtkb(window).scroll(function () {

			if ($mtkb(this).scrollTop() > 100) {

				$mtkb('#back-top').fadeIn();

			} else {

				$mtkb('#back-top').fadeOut();

			}

		}); 

		$mtkb('#back-top a').click(function () {

			$mtkb('body,html').animate({

				scrollTop: 0

			}, 800);

			return false;

		});

	});  

	$mtkb('.product-image').hover(

		function () {   

			$mtkb(".main-quicklook", $mtkb(this)).fadeIn('slow');

		},

		function () { 

			$mtkb(".main-quicklook", $mtkb(this)).fadeOut('fast');

		}

	); 

	if($mtkb('.category-image img:first').length){

        var container = $mtkb('#category-image');

		var catimg = $mtkb('.category-image').html();

        $mtkb(catimg).appendTo(container).css('text-align', 'center');

		$mtkb('.category-image').detach();

        if($mtkb('.category-description').length){

            var catdesc = $mtkb('.category-description').html();

            $mtkb('<div/>').html(catdesc)

                .addClass('category-desc container hidden-phone')

                .appendTo(container);

            $mtkb('.category-description').detach();

        }

    } 

});  

function showMessage(message)

{ 

	$mtkb('body').append('<div class="message-alert"></div>');

	$mtkb('.message-alert').html(message).append('<button></button>'); 

	$mtkb('.message-alert').slideDown(200);

	$mtkb('button').click(function () {

		$mtkb('.message-alert').slideUp(500);

    });

	$mtkb('.message-alert').slideDown('500', function () {

        setTimeout(function () {

        	$mtkb('.message-alert').slideUp('500', function () {

        		$mtkb(this).slideUp(500, function(){ $mtkb(this).detach(); })

            });

        }, 9000)

    });

} 

function showOptions(id){

	$mtkb('#fancybox'+id).trigger('click');

}

function quicklook(id){

	$mtkb('#quicklook'+id).trigger('click');

}

function setAjaxData(data,iframe){

    if(data.status == 'ERROR'){

        alert(data.message);

    }else{

    	$mtkb('.top-cart').html('');

        if($mtkb('.top-cart')){

        	$mtkb('.top-cart').append(data.output);

        } 

        $mtkb.fancybox.close();

    }

} 

function ajaxReload(data,iframe){

	$mtkb('.mt-top-menu .links').replaceWith(data.toplink);

} 

function addCompare(e,url,id){

	url = url.replace("catalog/product_compare/add","mtcolinusadmin/product/compare");

	url += 'isAjax/1/';

	if(e.parents('.products-list-inner').length>0){

		e.parents('.products-list-inner').find('.ajax-loading-list').css('display', 'block');

	}else{

		e.parents('.top-actions-inner').find('.ajax-loading').css('display', 'block');

	}

    if($mtkb("#product_addtocart_form").length>0){

        $mtkb("#product_addtocart_form").find('.cart-loading').show();

    }

	$mtkb('.block-compare').addClass('compare-loading');

	$mtkb('.block-compare .block-content').css('display','none');

	$mtkb.ajax({

        url:url,

        dataType:'jsonp',

        success:function (data) { 

    		showMessage(data.message); 

    		if(e.parents('.products-list-inner').length>0){

				e.parents('.products-list-inner').find('.ajax-loading-list').css('display', 'none');

			}else{

				e.parents('.top-actions-inner').find('.ajax-loading').css('display', 'none');

			}

            if($mtkb("#product_addtocart_form").length>0){

                $mtkb("#product_addtocart_form").find('.cart-loading').hide();

            }

	    	if (data.status != 'ERROR' && $mtkb('#block-compare').length) {

		    	showMessage(data.message);

		    	$mtkb('#block-compare').removeClass('compare-loading');

		    	$mtkb('#block-compare .block-content').css('display','block');

	        	$mtkb('#block-compare').replaceWith(data.output);  

	    	} 

	    	if (data.status != 'ERROR'){ 

	    		$mtkb('.block-top-compare').html();

	        	$mtkb('.block-top-compare').html(data.topcompare);

	        }

        }

    });

}

function removeCompare(url){

	url = url.replace("catalog/product_compare/remove","mtcolinusadmin/product/rmcompare"); 

	url += 'isAjax/1/';

	$mtkb('#block-compare').addClass('compare-loading');

	$mtkb('#block-compare .block-content').css('display','none');

	$mtkb.ajax({

        url:url,

        dataType:'jsonp',

        success:function (data) {

        	if (data.status != 'ERROR' && $mtkb('#block-compare').length) {

		    	showMessage(data.message);

		    	$mtkb('#block-compare').removeClass('compare-loading');

		    	$mtkb('#block-compare .block-content').css('display','block');

	        	$mtkb('#block-compare').replaceWith(data.output); 

	    	}

	    	if (data.status != 'ERROR'){  

	    		showMessage(data.message); 

	    		$mtkb('.block-top-compare').html();

	        	$mtkb('.block-top-compare').html(data.topcompare);

	        }

        }

    });

}



function clearCompare(url){

    url = url.replace("catalog/product_compare/clear","mtcolinusadmin/product/clearall");

    url += 'isAjax/1/';

    $mtkb('#block-compare').addClass('compare-loading');

    $mtkb('#block-compare .block-content').css('display','none');

    $mtkb.ajax({

        url:url,

        dataType:'jsonp',

        success:function (data) {

            if (data.status != 'ERROR' && $mtkb('#block-compare').length) {

                showMessage(data.message);

                $mtkb('#block-compare').removeClass('compare-loading');

                $mtkb('#block-compare .block-content').css('display','block');

                $mtkb('#block-compare').replaceWith(data.output);

            }

            if (data.status != 'ERROR'){  

	    		showMessage(data.message); 

	    		$mtkb('.block-top-compare').html();

	        	$mtkb('.block-top-compare').html(data.topcompare);

	        }

        }

    });

}



function addWishlist(e,url,id){

	url = url.replace("wishlist/index","mtcolinusadmin/product");

	url += 'isAjax/1/'; 

	$mtkb('#block-wisthlist').addClass('wisthlist-loading');

	$mtkb('#block-wisthlist .block-content').css('display','none'); 

	if(e.parents('.products-list-inner').length>0){

		e.parents('.products-list-inner').find('.ajax-loading-list').css('display', 'block');

	}else{

		e.parents('.top-actions-inner').find('.ajax-loading').css('display', 'block');

	}

    if($mtkb("#product_addtocart_form").length>0){

        $mtkb("#product_addtocart_form").find('.cart-loading').show();

    }

	$mtkb.ajax({

        url:url,

        dataType:'jsonp',

        success:function (data) { 

    		showMessage(data.message);   

    		if(e.parents('.products-list-inner').length>0){

				e.parents('.products-list-inner').find('.ajax-loading-list').css('display', 'none');

			}else{

				e.parents('.top-actions-inner').find('.ajax-loading').css('display', 'none');

			}

            if($mtkb("#product_addtocart_form").length>0){

                $mtkb("#product_addtocart_form").find('.cart-loading').hide();

            }

	    	if (data.status != 'ERROR' && $mtkb('#block-wisthlist').length) {

		    	showMessage(data.message);

		    	$mtkb('#block-wisthlist').removeClass('wisthlist-loading');

		    	$mtkb('#block-wisthlist .block-content').css('display','block');

	        	$mtkb('#block-wisthlist').replaceWith(data.sidebar);  

	    	} 

	    	if(data.message!='Please Login First'){

	    		$mtkb('.mt-top-menu .links').replaceWith(data.toplink);

	    	} 

        }

    });

    return false;

}

function removeWishlist(url){

	url = url.replace("wishlist/index","mtcolinusadmin/product"); 

	url += 'isAjax/1/';

	$mtkb('#block-wisthlist').addClass('wisthlist-loading');

	$mtkb('#block-wisthlist .block-content').css('display','none');

	$mtkb.ajax({

        url:url,

        dataType:'jsonp',

        success:function (data) { 

    		showMessage(data.message); 

	    	if (data.status != 'ERROR' && $mtkb('#block-wisthlist').length) {

		    	showMessage(data.message);

		    	$mtkb('#block-wisthlist').removeClass('wisthlist-loading');

		    	$mtkb('#block-wisthlist .block-content').css('display','block');

	        	$mtkb('#block-wisthlist').replaceWith(data.sidebar);   

	    	} 

        	$mtkb('.mt-top-menu .links').replaceWith(data.toplink);  

        }

    });

}



function ajaxaddcart(url,id){ 

	$mtkb('.cart-loading').show();

	$mtkb('.cart').hide(); 

	data = '&isAjax=1&qty=1';

    url = url.replace("checkout/cart","mtcolinusadmin/index"); 

    try {

    	$mtkb.ajax( {

            url : url,

            dataType : 'json',

            data: data,

            type: 'post',

            success : function(data) { 

                setAjaxData(data,false); 

                showMessage(data.message);

                removeLoading(); 

                $mtkb('body').find('img.imgfly').remove();

                $mtkb('.cart-loading').hide();

                $mtkb('.cart').show(); 

                setTimeout(function () {

        			$mtkb('.cart-loading').slideUp(500);

        		}, 9000)

                $mtkb('.mt-top-menu .links').replaceWith(data.toplink);

            }

        });

    } catch (e) {

    }

}

function removeLoading(){

    $mtkb('.ajax-loading').hide();

    $mtkb(".ajax-loading-list").hide();

}

function deletecart(url){

	$mtkb('.cart-loading').show();

	$mtkb('.cart').hide(); 

	if (confirm("Are you sure you would like to remove this item from the shopping cart?")) {

		data = '&isAjax=1&qty=1';

	    url = url.replace("checkout/cart","mtcolinusadmin/index");

	    $mtkb.ajax( {

	        url : url,

	        dataType : 'json',

	        data: data,

	        type: 'post',

	        success : function(data) { 

	            setAjaxData(data,false); 

	            showMessage(data.message);

	            $mtkb('.cart-loading').hide();

	            $mtkb('.cart').show();

	            $mtkb('.mt-top-menu .links').replaceWith(data.toplink);

	        }

	    });

	}else{

		$mtkb('.cart-loading').hide();

		$mtkb('.cart').show();

	}

}

$mtkb(document).ready(function(){

	$mtkb('.fancybox').fancybox(

        {

           hideOnContentClick : true,

           width: 382,

           autoDimensions: true,

           type : 'iframe',

           showTitle: false,

           scrolling: 'no',

           onComplete: function(){ 

        	   $mtkb('#fancybox-frame').load(function() { 

        		   $mtkb('#fancybox-content').height($mtkb(this).contents().find('body').height()+30);

        		   $mtkb.fancybox.resize();

             });



           }

        }

    );

});

//Accordion config style

(function($){

    $.fn.accordion=function(){

        return this.each(function(){

            var menu= $(this);

            menu.find('ul.listpanel li div.active').slideDown('medium'); 

            menu.find('ul.listpanel li > span.mttitle').bind('click',function(event){ 

                var currentlink=$(event.currentTarget);

                if (currentlink.parent().find('div.active').size()==1)

                {

                    currentlink.parent().find('div.active').slideUp('medium',function(){

                        currentlink.parent().find('div.active').removeClass('active');

						currentlink.find('span.arrows').removeClass('current');

                    });

                }

                else if (menu.find('ul.listpanel li div.active').size()==0)

                {

                    show(currentlink);

                }

                else

                {

                    menu.find('ul.listpanel li div.active').slideUp('medium',function(){

                        menu.find('ul.listpanel li div.mainpattern').removeClass('active');

						menu.find('ul.listpanel li span.mttitle > span.arrows').removeClass('current');

                        show(currentlink);

                    });

                } 

            });

            function show(currentlink){

                currentlink.parent().find('div.mainpattern').addClass('active');

				currentlink.find('span.arrows').addClass('current');

                currentlink.parent().find('div.mainpattern').slideDown('medium');

            }

        });

    }

})(jQuery);

/////////Twitter//////

(function($) { 

    var TwitterTimeline = $.twitterTimeline = function(element, options) {

        this.element  = $(element);

        this.options  = $.extend(true, {}, this.options, options || {});



        this._init();

    }; 

    $.extend(TwitterTimeline.prototype, {

        options: {

            ajax: {

                url: 'http://api.twitter.com/1/statuses/user_timeline.json',

                data: {

                    screen_name     : '9magentothemes',

                    page            : 1,

                    trim_user       : true,

                    include_rts     : true,

                    exclude_replies : true,

                    include_entities: true

                },

                dataType: 'jsonp',

                type: 'GET'

            },

            count: 5,



            refresh: 300000,

            tweetTemplate : function(item) {

                return '<p>' + TwitterTimeline.parseTweet(item.text) + '</p>';

            },

            animateAdd: function(el) {

                return el;

            },

            animateRemove: function(el) {

                el.remove();

            }

        },

        _refreshTimeout: null,

        _init: function() {

            this._useLocalStorage = typeof localStorage !== 'undefined' && typeof JSON !== 'undefined';

            this._localStorageKey = 'twitterTimeline_' + this.options.ajax.data.screen_name;



            //read localStorage and write tweets if there are cached ones

            if (this._useLocalStorage === true) {

                var cache = localStorage.getItem(this._localStorageKey);

                if (cache !== null) {

                    cache = JSON.parse(cache);

                    if (cache.length > 0 ) {

                        this.update(cache);

                    }

                }

            }



            //get new tweets

            this.fetch();

        },

        update: function(data) {

            var self = this;



            if (this._refreshTimeout) {

                clearTimeout(this._refreshTimeout);

            }



            // update localStorage

            if (this._useLocalStorage === true && data.length > 0) {

                var cache = localStorage.getItem(this._localStorageKey);

                cache = cache !== null ? JSON.parse(cache) : [];

                cache = data.concat(cache).splice(0, this.options.count);

                cache = JSON.stringify(cache);

                try {

                    localStorage.removeItem(this._localStorageKey);

                    localStorage.setItem(this._localStorageKey, cache);

                } catch (e) { 

                    this._useLocalStorage = false;

                }

            }



            //add new tweets

            $.each(data.reverse(), function(idx, item) {

                //set since_id to current tweet for further updates

                self.options.ajax.data.since_id = item.id_str;



                //get tweet html from template and prepend to list

                var tweet = self.options.tweetTemplate.call(self, item);

                self.element.prepend(self.options.animateAdd($(tweet), idx));



                //remove last tweet if the number of elements is bigger than the defined count

                var tweets = self.element.children(self.options.el);

                if (tweets.length > self.options.count) {

                    self.options.animateRemove($(tweets[self.options.count]), idx);

                }

            });



            if (typeof this.options.refresh === 'number') {

                this._refreshTimeout = setTimeout($.proxy(this.fetch, this), this.options.refresh);

            }

        },

        fetch: function(options) {

            var ajax = $.extend(true, {}, this.options.ajax, options || {});

            

            var self = this,

                success = ajax.success;

                

            ajax.success = function(data) {

                self.update(data);

                if ($.isFunction(success)) {

                    success.apply(this, arguments);

                }

            };



            $.ajax(ajax);

        }

    });

	TwitterTimeline.timeAgo = function(dateString) {

        var rightNow = new Date();

        var then = new Date(dateString);



        if ($.browser.msie) {

            then = Date.parse(dateString.replace(/( \+)/, ' UTC$1'));

        }

        var diff = rightNow - then;

        var second = 1000,

            minute = second * 60,

            hour = minute * 60,

            day = hour * 24,

            week = day * 7;



        if (isNaN(diff) || diff < 0) {

            return "";

        }



        if (diff < second * 2) {

            return "right now";

        }



        if (diff < minute) {

            return Math.floor(diff / second) + " seconds ago";

        }



        if (diff < minute * 2) {

            return "about 1 minute ago";

        }



        if (diff < hour) {

            return Math.floor(diff / minute) + " minutes ago";

        }



        if (diff < hour * 2) {

            return "about 1 hour ago";

        }



        if (diff < day) {

            return  Math.floor(diff / hour) + " hours ago";

        }



        if (diff > day && diff < day * 2) {

            return "yesterday";

        }



        if (diff < day * 365) {

            return Math.floor(diff / day) + " days ago";

        }



        else {

            return "over a year ago";

        }

    };

    TwitterTimeline.parseTweet = function(text) {

        text = text.replace(/(\b(https?|ftp|file):\/\/[\-A-Z0-9+&@#\/%?=~_|!:,.;]*[\-A-Z0-9+&@#\/%=~_|])/ig, function(url) {

            return '<a href="' + url + '" target="_blank">' + url + '</a>';

        });



        text = text.replace(/(^|\s)@(\w+)/g, function(u) {

            return '<a href="http://twitter.com/' + $.trim(u.replace("@","")) + '" target="_blank">' + u + '</a>';

        });



        text = text.replace(/(^|\s)#(\w+)/g, function(t) {

            return '<a href="http://search.twitter.com/search/' + $.trim(t.replace("#","%23")) + '" target="_blank">' + t + '</a>';

        });



        return text;

    };



    $.fn.twitterTimeline = function(options) {

        if (typeof options === 'string') {

            var instance = $(this).data('twitterTimeline');

            return instance[options].apply(instance, Array.prototype.slice.call(arguments, 1));

        } else {

            return this.each(function() {

                var instance = $(this).data('twitterTimeline');



                if (instance) {

                    $.extend(true, instance.options, options || {});

                } else {

                    new TwitterTimeline(this, options);

                }

            });

        }

    };



})(jQuery);