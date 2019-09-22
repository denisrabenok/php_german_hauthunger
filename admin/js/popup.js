// JavaScript Document
var newWindow = null; 

function closeWin()
{ 
	if (newWindow != null)
	{ 
		if(!newWindow.closed) 
		newWindow.close(); 
	} 
} 

function popUpWin(url, type, strWidth, strHeight)
{ 

	closeWin(); 

	if (type == "fullScreen")
	{ 

		strWidth = screen.availWidth - 10; 
		strHeight = screen.availHeight - 100; 
	} 

	var tools=""; 
	if (type == "standard" || type == "fullScreen")	
	tools = "resizable=no,toolbar=no,location=no,scrollbars=yes,menubar=no,status=no,width="+strWidth+",height="+strHeight+",top=0,left=0"; 
	
	if (type == "console")
	tools = "resizable=yes,toolbar=no,location=no,scrollbars=yes,width="+strWidth+",height="+strHeight+",left=0,top=0"; 
	
	newWindow = window.open(url, 'newWin', tools); 
	newWindow.focus(); 
} 