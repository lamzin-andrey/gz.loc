$(document).addEvent('domready', amInit); 
function amInit() {
	$("bAmenu").onclick = function(){
		$("hAmenu").setStyle('left', '-187px');
		$("bAmenuOff").setStyle('left', '0px');
	}
	$("bAmenuOff").onclick = function(){
		$("hAmenu").setStyle('left', '0px');
		$("bAmenuOff").setStyle('left', '-20px');
	}
}


