console.log("color is ready");

function HSVtoRGB(h, s, v) {
	var r, g, b, i, f, p, q, t;
	if (arguments.length === 1) {
		 s = h.s, v = h.v, h = h.h;
	}
	i = Math.floor(h * 6);
	f = h * 6 - i;
	p = v * (1 - s);
	q = v * (1 - f * s);
	t = v * (1 - (1 - f) * s);
	switch (i % 6) {
		case 0: r = v, g = t, b = p; break;
		case 1: r = q, g = v, b = p; break;
		case 2: r = p, g = v, b = t; break;
		case 3: r = p, g = q, b = v; break;
		case 4: r = t, g = p, b = v; break;
		case 5: r = v, g = p, b = q; break;
	}
	return {
		r: Math.round(r * 255),
		g: Math.round(g * 255),
		b: Math.round(b * 255)
	};
}

function glitter(p,prefix="#") {
	var rgb = HSVtoRGB(p/100.0*0.85, 1.0, 1.0);
	return prefix+byte2Hex(rgb.r)+byte2Hex(rgb.g)+byte2Hex(rgb.b);
}

function byte2Hex(n)
{
	var nybHexString = "0123456789ABCDEF";
	return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}

function hexcolorstring(r,g,b,prefix = "#")
{
	r = (r>255)?r%255:r;
	g = (g>255)?g%255:g;
	b = (b>255)?b%255:b;
	return "" + prefix + byte2Hex(r) + byte2Hex(g) + byte2Hex(b); 
}