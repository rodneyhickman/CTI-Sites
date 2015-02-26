var DROPTIME = 1000;
function dropWait()
{
	this.className = this.className.replace("hover", "");
}

function initMenu()
{
	var nodes = document.getElementById("navigation").getElementsByTagName("li");
	for (var i=0; i<nodes.length; i++)
	{
		nodes[i].onmouseover = function()
		{
			if(this.dropTime)
			{
				clearTimeout(this.dropTime);
			}
			var parentNodes = this.parentNode.getElementsByTagName("li");
			for(var j=0; j<parentNodes.length; j++)
			{
				if(parentNodes[j].className.indexOf("hover") != -1 && parentNodes[j].parentNode == this.parentNode)
				{
					parentNodes[j].className = parentNodes[j].className.replace("hover", "");
				}
			}
			this.className += " hover";
		}
		nodes[i].onmouseout = function()
		{
			this.dropTime = setTimeout(dropWait.bind(this), DROPTIME);
		}
	}
}

if (window.addEventListener) window.addEventListener("load", initMenu, false);
else if (window.attachEvent) window.attachEvent("onload", initMenu);