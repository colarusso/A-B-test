function logClick(id) {
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('POST', '/wp-content/plugins/A-B/lib/A-B_log.php', true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            console.log(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring(id));
}

function getquerystring(id) {
    qstr = 'c=' + escape(id)  // NOTE: no '?' before querystring
    return qstr;
}
