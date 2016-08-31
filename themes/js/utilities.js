//AJAX
var request=new Array(); //variabel global agar bisa multiple

function theRequest(idx_ajax){
	try{
		request[idx_ajax]=new XMLHttpRequest();
	}catch(tryMicrosoft){
		try{
			request[idx_ajax]=new ActiveXObject("Msxml2.XMLHTTP");
		}catch(otherMicrosoft){
			try{
				request[idx_ajax]=new ActiveXObject("Microsoft.XMLHTTP");
			}catch(failed){
				request[idx_ajax]=false;
			}
		}
	}
}

function doRequested(target,linkObj,imgObj){
	var idx_ajax = request.length; 
	
	theRequest(idx_ajax);
	if(request[idx_ajax]){
		if(imgObj==true){
			document.getElementById(target).innerHTML = "<img src='icon-loading/loading.gif' /><br />"+document.getElementById(target).innerHTML;
		}else if(imgObj==false){
			document.getElementById(target).innerHTML = "<img src='icon-loading/loading.gif' />";
		}
		
		request[idx_ajax].open("GET",linkObj,true);
		request[idx_ajax].onreadystatechange=function(){showResponse(target,idx_ajax);}
		request[idx_ajax].setRequestHeader("Content-type","application/x-www-form-urlencoded");
		request[idx_ajax].send(null);
	}
}

function showResponse(target,idx_ajax){
	if(request[idx_ajax].readyState==4){
		if(request[idx_ajax].status==200){
			document.getElementById(target).innerHTML = request[idx_ajax].responseText;
		}else{
			document.getElementById(target).innerHTML = "Sorry, There Is Problem With Your Request.";
			request[idx_ajax].abort();
		}
	}
}