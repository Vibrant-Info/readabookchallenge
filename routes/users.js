module.exports = function(app, passport, connection) {
	// GET USER PROFILE DETAILS
    app.get('/my-profile', function(req, res) {
		var email = req.session.users.email;		
		var query = "SELECT users.*, user_address.* FROM `users`, user_address WHERE users.email_id='"+email+"' AND user_address.user_id = users.id";
		connection.query(query, function(err, rows){
			if(err) throw err;
			res.send(rows[0]);
		});		
    });
	
	// GET CITY
	app.get('/city', function(req, res) {	
		var query = "SELECT * FROM `delivery_city` WHERE status = '1'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			res.send(rows);
		});		
    });
	
	// GET PINCODE
	app.get('/pincode', function(req, res) {
		var query = "SELECT `area` FROM `delivery_areas` WHERE status = '1'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			res.send(rows);
		});		
    });
	
	// GET GNERE 
	app.get('/gnere', function(req, res) {
		var email = req.session.users.email;
		var query = "SELECT `id`, `category_name` as name FROM `category` WHERE deleted = '0'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			res.send(rows);
		});		
    });
}