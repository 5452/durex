window.onload = function(){
	var wrap =  document.getElementById("wrapper");
	var navIcon = document.getElementById("nav_icon");
	var navBack = document.getElementById("nav_back");
	navIcon.onclick = function(){
		wrap.style.left = "31.25%";
		wrap.style.position = "absolute";
		wrap.style.overflow = "initial";
		navIcon.style.display = "none";
	}
	navBack.onclick = function(){
		wrap.style.left = "0";
		navIcon.style.display = "";
	}

}