var Slate = function () {
	
	var chartColors, nav, navTop;
	
	chartColors = ["#263849", "#F90", "#666", "#BBB"];
	
	
	return { start: start, chartColors: chartColors };
	
	function start () {

		nav = $('#nav');
		navTop = nav.offset ().top;
	
		bindNavEvents ();
		
		bindWidgetEvents ();
		
		bindAccordionEvents ();
		
		enableAutoPlugins ();
	}
	
	function enableAutoPlugins () {
		if ($.fn.tooltip) { 
			$('.ui-tooltip').tooltip (); 			
		}	
		
		if ($.fn.popover) { 
			$('.ui-popover').popover (); 			
		}		
		
		if ($.fn.lightbox) { 
			$('.ui-lightbox').lightbox();			
		}
		
		if ($.fn.dataTable) {
			$('.data-table').dataTable( {
				sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				sPaginationType: "bootstrap",
				oLanguage: {
					"sLengthMenu": "_MENU_ records per page"
				}
			});
		}
	}
	
	function bindNavEvents () {
		
		var msie8 = $.browser.version === '8.0' && $.browser.msie;
		
		if (!msie8) {
			$(window).bind ('scroll', navScroll);
		}
				
		$('#info-trigger').live ('click', function (e) {
			
			e.preventDefault ();
			
			$('#info-menu').toggleClass ('toggle-menu-show');
			
			$(document).bind ('click.info', function (e) {
				
				if ($(e.target).is ('#info-menu')) { return false; }
				
				if ($(e.target).parents ('#info-menu').length == 1) { return false; }
				
				$('#info-menu').removeClass ('toggle-menu-show');
				
				$(document).unbind ('click.info');
				
			});
			
		});
	}
	
	function navScroll () {
		var p = $(window).scrollTop ();
		
		((p)>navTop) ? $('body').addClass ('nav-fixed') : $('body').removeClass ('nav-fixed');
		
	}
	
	function bindWidgetEvents () {
		$('.widget-tabs .nav-tabs a').live ('click', widgetTabClickHandler);
	}
	
	function bindAccordionEvents () {
		$('.widget-accordion .accordion').on('show', function (e) {
	         $(e.target).prev('.accordion-heading').parent ().addClass('open');
	    });
	
	    $('.widget-accordion .accordion').on('hide', function (e) {
	        $(this).find('.accordion-toggle').not($(e.target)).parents ('.accordion-group').removeClass('open');
	    });
	    
	    $('.widget-accordion .accordion').each (function () {	    	
	    	$(this).find ('.accordion-body.in').parent ().addClass ('open');
	    });
	}
	
	function widgetTabClickHandler (e) {
		e.preventDefault();
		$(this).tab('show');
	}
	
}();




$(function () {

	Slate.start ();

});
function formatNumber(input)
{
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
    if(num.indexOf('.') > -1){
    num = num.split('.');
    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
    if(num[1].length > 2){
    alert('Masukkan angka!');
    num[1] = num[1].substring(0,num[1].length-1);
    } input.value = num[0]+'.'+num[1];
    } else{ input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'') };
    }
    else{ alert('Masukkan angka!');
    input.value = input.value.substring(0,input.value.length-1);
    }
}
function addCommas(nStr)
{
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}