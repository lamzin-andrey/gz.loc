function testAutomod() {
	console.log('Run test Automod');
	var data = [
	 'With phone 9187353657',	//nm
	 'Продам газель телефон 8 918 735 36 25',	//nm
	 'Продам газель телефон\
	  +7 (918) 735-36-25',						//nm
	 'А я просто продам газель',			 	//+
	 'А я просто 25 times продам goto 100 500 газель KM',	//+
	 'Будка 200 - 300 - 100  and more changes'	//nm
	], i;
	
	for (i = 0; i < data.length; i++) {
		var o = {addtext:data[i]}
		setAutoFlag(o);
		//console.log(o);
		var cond = false;
		
		switch (i) {
			case 0:
			case 1:
			case 2:
			case 5:
				cond = (o.nm == 1);
				//console.log(cond);
				break;
			case 3:
			case 4:
				cond = (String(o.nm) == 'undefined');
				break;
		}
		
		if (cond) {
			console.log(data[i] + " success");
		} else {
			console.log(data[i] + " FAIL!!!");
		}
	}
	
	
}

testAutomod();
