document.createElement("spiv");

var head = document.getElementsByTagName('head')[0],
    style = document.createElement('style'),
    rules = document.createTextNode('spiv { display:inline-block; }');

style.type = 'text/css';
if(style.styleSheet)
    style.styleSheet.cssText = rules.nodeValue;
else style.appendChild(rules);
head.appendChild(style);