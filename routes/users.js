module.exports = function(app, passport, connection) {
	var updateQuery;
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
	
	// PROFILE UPDATE
	app.put('/updateProfile', function(req, res) {
		var data = req.body.data;
		var update_check_query = "SELECT * FROM `users` WHERE email_id = '"+data.email_id+"' AND id != '"+data.user_id+"'";
		connection.query(update_check_query, function(err, rows){
			if(err) throw err;
			if(rows.length == 0){
				updateQuery = "UPDATE `users` SET `first_name`='"+data.first_name+"', `last_name`='"+data.last_name+"', `email_id`='"+data.email_id+"',  `age`='"+data.age+"', `phone_number`='"+data.phone_number+"', `alt_phone_number`='"+data.alt_phone_number+"' WHERE id = '"+data.user_id+"' "
				connection.query(updateQuery, function(err, rows){
					if(err) throw err;
					
				});
								
				updateQuery = "UPDATE `user_address` SET `address`='"+data.address+"', `city`='"+data.city+"', `area`='"+data.area+"',  `landmark`='"+data.landmark+"', `pincode`='"+data.pincode+"' WHERE user_id = '"+data.user_id+"' "
				connection.query(updateQuery, function(err, rows){
					if(err) throw err;
					
				});
				
				
			}else{
				res.send({'code':400,'status':'failed','message':"User already exsit!!"});
			}
		});	
    });
}