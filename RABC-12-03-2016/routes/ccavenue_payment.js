
module.exports = function(app, passport, connection) {
	app.get('/about', function (req, res){
    	res.render('dataFrom.html');
	});
	
}