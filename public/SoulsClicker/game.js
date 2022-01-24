/* MAIN UNITS*/
var imps = 0;
var impsps = 1;
var impupcost = 20;

var grunts = 0;
var gruntsps = 2;
var gruntupcost = 200;

var ghouls = 0;
var ghoulsps = 5;
var ghoulupcost = 1000;

var punishers = 0;
var punishersps = 50;
var punisherupcost = 15000;

var succubuss = 0;
var succubussps = 100;
var succubusupcost = 30000;

var reapers = 0;
var reapersps = 250;
var reaperupcost = 100000;

var hellraisers = 0;
var hellraisersps = 400;
var hellraiserupcost = 250000;

/* RESEARCH */
var NexusEfficience = 0;
var NEcost = 400;
var Nexus = 0;
var Ncost = 1000;
var Merchant = 0;
var Mcost = 100000;

var souls = 0;
var income = 0;
var spc = 1;

function updateDisplay() {
	$("#soulscounter").text(Math.floor(souls));
	$("#impupcost").text(impupcost);
	$("#implvl").text(imps);
	$("#gruntupcost").text(gruntupcost);
	$("#gruntlvl").text(grunts);
	$("#ghoulupcost").text(ghoulupcost);
	$("#ghoullvl").text(ghouls);
	$("#punisherlvl").text(punishers);
	$("#punisherupcost").text(punisherupcost);
	$("#succubuslvl").text(succubuss);
	$("#succubusupcost").text(succubusupcost);
	$("#reaperlvl").text(reapers);
	$("#reaperupcost").text(reaperupcost);
	$("#hellraiserlvl").text(hellraisers);
	$("#hellraiserupcost").text(hellraiserupcost);	

	
	$("#spccnt").text(1 * Math.ceil(Math.pow(10, Nexus)));

	$("#necost").text(NEcost);
	$("#nelvl").text(NexusEfficience);
	$("#ncost").text(Ncost);
	$("#nlvl").text(Nexus);
	$("#mecost").text(Mcost);
	$("#melvl").text(Merchant);
}

function calculateNetIncome() {
	income = (imps*impsps) + (grunts*gruntsps) + (ghouls*ghoulsps) + (punishers*punishersps) +
		(succubuss*succubussps) + (reapers*reapersps) + (hellraisers*hellraisersps);
	income += income * (0.05*NexusEfficience);
	souls += income / 100;
	$("#spscnt").text(income);
	//console.log("Income: " + income + ", Souls: " + souls);
	income = 0;
	updateDisplay();
}

$(document).ready(function(){
	setInterval(calculateNetIncome, 10);
	
	$("#impupcost").text(impupcost);
	$("#gruntupcost").text(gruntupcost);
	$("#ghoulupcost").text(ghoulupcost);
	$("#punisherupcost").text(punisherupcost);
	$("#succubusupcost").text(punisherupcost);
	$("reaperupcost").text(reaperupcost);
	$("hellraiserupcost").text(hellraiserupcost);
	
	$("#nexus").click(function(){
		souls += 1 * Math.ceil(Math.pow(10, Nexus));
		updateDisplay();
	});
	
	$("#updateimp").click(function(){
		if(souls >= impupcost)
		{
			souls -= impupcost;
			impupcost += Math.ceil((impupcost * 0.025) * (imps+1));
			imps++;
			updateDisplay();
		}
	});
	$("#updategrunt").click(function(){
		if(souls >= gruntupcost)
		{
			souls -= gruntupcost;
			gruntupcost += Math.ceil((gruntupcost * 0.025) * (grunts+1));
			grunts++;
			updateDisplay();
		}
	});
	$("#updateghoul").click(function(){
		if(souls >= ghoulupcost)
		{
			souls -= ghoulupcost;
			ghoulupcost += Math.ceil((ghoulupcost * 0.025) * (ghouls+1));
			ghouls++;
			updateDisplay();
		}
	});
		$("#updatepunisher").click(function(){
		if(souls >= punisherupcost)
		{
			souls -= punisherupcost;
			punisherupcost += Math.ceil((punisherupcost * 0.025) * (punishers+1));
			punishers++;
			updateDisplay();
		}
	});
		$("#updatesuccubus").click(function(){
		if(souls >= succubusupcost)
		{
			souls -= succubusupcost;
			succubusupcost += Math.ceil((succubusupcost * 0.025) * (succubuss+1));
			succubuss++;
			updateDisplay();
		}
	});
		$("#updatereaper").click(function(){
		if(souls >= reaperupcost)
		{
			souls -= reaperupcost;
			reaperupcost += Math.ceil((reaperupcost * 0.03) * (reapers+1));
			reapers++;
			updateDisplay();
		}
	});
		$("#updatehellraiser").click(function(){
		if(souls >= hellraiserupcost)
		{
			souls -= hellraiserupcost;
			hellraiserupcost += Math.ceil((hellraiserupcost * 0.035) * (hellraisers+1));
			hellraisers++;
			updateDisplay();
		}
	});
	
	$("#resne").click(function(){
		if(souls >= NEcost)
		{
			souls -= NEcost;
			NEcost *= 2;
			NexusEfficience++;
			updateDisplay();
		}
	});
	$("#resn").click(function(){
		if(souls >= Ncost)
		{
			souls -= Ncost;
			Nexus++;
			Ncost = (1000 * Math.ceil(Math.pow(10, Nexus))) * 2;
			updateDisplay();
		}
	});
	$("#resm").click(function(){
		if(souls >= Mcost)
		{
			souls -= Mcost;
			Merchant++;
			Mcost = (100000 * Math.ceil(Math.pow(10, Merchant))) * 2;
			
			impupcost = Math.ceil(impupcost/2);
			gruntupcost = Math.ceil(gruntupcost/2);
			ghoulupcost = Math.ceil(ghoulupcost/2);
			punisherupcost = Math.ceil(punisherupcost/2);
			succubusupcost = Math.ceil(succubusupcost/2);
			reaperupcost = Math.ceil(reaperupcost/2);
			hellraiserupcost = Math.ceil(hellraiserupcost/2);
			
			updateDisplay();
		}
	});
});

function cheatGiveSouls(value)
{
	souls += value;
}
