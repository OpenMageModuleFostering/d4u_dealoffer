dateFuture1 = new Date(2013,10,26,12,00,00);
var divlists = [];
var leftdivlist = [];
function GetCount_offer(ddate,iid){

	dateNow = new Date();	//grab current date
	amount = ddate.getTime() - dateNow.getTime();	//calc milliseconds between dates
	delete dateNow;

	// if time is already past
	if(amount < 0){
		document.getElementById(iid).innerHTML="Now!";
	}
	// else date is still good
	else{
		days=0;hours=0;mins=0;secs=0;out="";

		amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs

		days=Math.floor(amount/86400);//days
		amount=amount%86400;

		hours=Math.floor(amount/3600);//hours
		amount=amount%3600;

		mins=Math.floor(amount/60);//minutes
		amount=amount%60;

		secs=Math.floor(amount);//seconds

		/*if(days != 0){out += days +" "+((days==1)?"day":"days")+", ";}
		if(hours != 0){out += hours +" "+((hours==1)?"hour":"hours")+", ";}
		out += mins +" "+((mins==1)?"min":"mins")+", ";
		out += secs +" "+((secs==1)?"sec":"secs")+", ";
		out = out.substr(0,out.length-2);*/
		if(days != 0){out += days +" "+((days==1)?"day":"days")+" &hearts; ";} else { out += " &hearts; ";}//&hearts;&#9685; 
		if(hours != 0){out += hours +" "+((hours==1)?"":"")+" : ";}
		out += mins +" "+((mins==1)?"":"")+": ";
		out += secs +" "+((secs==1)?"":"")+": ";
		out = out.substr(0,out.length-2);
		document.getElementById(iid).innerHTML=out;

		setTimeout(function(){GetCount_offer(ddate,iid)}, 1000);
	}
}
