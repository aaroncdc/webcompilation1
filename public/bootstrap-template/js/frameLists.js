	var itemList = document.getElementById("item-list-1");
	var ilSL = document.getElementById("il-s-l");
	var ilSR = document.getElementById("il-s-r");
	var scroll = document.getElementById("item-list-scroll");
	var items = 10;
	var itemWidth = 150;
	var paddinglr = 30; // 2 * 15
	var borderWidth = 2; // 1 * 2 sides
	var totalItemWidth = 30 + borderWidth + itemWidth;
	var listWidth = totalItemWidth * items;
	itemList.style.minWidth = listWidth + "px";

	function doScrollLeft() {
		scroll.scrollLeft -= totalItemWidth;
		ilSR.style.display = "block";
		if(scroll.scrollLeft < 1)
			ilSL.style.display = "none";
		else
			ilSL.style.display = "block";
	}

	function doScrollRight() {
		scroll.scrollLeft += totalItemWidth;
		ilSL.style.display = "block";
		if(scroll.scrollLeft >= (listWidth - scroll.offsetWidth))
			ilSR.style.display = "none";
		else
			ilSR.style.display = "block";
	}

	ilSL.addEventListener("click", doScrollLeft);
	ilSR.addEventListener("click", doScrollRight);