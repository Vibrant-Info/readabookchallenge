var http = require('http'),
    fs = require('fs'),
    //ccav = require('./ccavutil.js'),
    qs = require('querystring');
var crypto = require('crypto');
exports.postReq = function(request,response){
    var body = '',
	workingKey = 'D23CEB7A0C1A82229F4371065C34E4F6',	//Put in the 32-Bit Key provided by CCAvenue.
	accessCode = 'AVUK67DJ53BY95KUYB',			//Put in the Access Code provided by CCAvenue.
	encRequest = '',
	formbody = '';
				
    request.on('data', function (data) {
	body += data;
	//console.log(workingKey);
	encRequest = Encryptss(body,workingKey); 
	formbody = '<form id="nonseamless" method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"/> <input type="hidden" id="encRequest" name="encRequest" value="' + encRequest + '"><input type="hidden" name="access_code" id="access_code" value="' + accessCode + '"><script language="javascript">document.redirect.submit();</script></form>';
    });
				
    request.on('end', function () {
        response.writeHeader(200, {"Content-Type": "text/html"});
	response.write(formbody);
	response.end();
    });
   return; 
};
function Encryptss(plainText, workingKey) {
    var m = crypto.createHash('md5');
    m.update(workingKey);
    var key = m.digest();
    var iv = '\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f';    
    var cipher = crypto.createCipheriv('aes-128-cbc', key, iv);    
    var encoded = cipher.update(plainText, 'utf8', 'hex');
    encoded += cipher.final('hex');
    return encoded;
};


function decrypt(encText, workingKey) {
    	var m = crypto.createHash('md5');
    	m.update(workingKey)
    	var key = m.digest('binary');
	var iv = '\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f';	
	var decipher = crypto.createDecipheriv('aes-128-cbc', key, iv);
    	var decoded = decipher.update(encText,'hex','utf8');
	decoded += decipher.final('utf8');
    	return decoded;
};
