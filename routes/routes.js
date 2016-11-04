
// app/routes.js

module.exports = function(app, passport, connection) {   
    app.get('/logout', function(req, res) {
		req.session.destroy();
        res.redirect('/');
		//res.send({'code':200,'status':'OK'});
    });
	
    app.post('/saveUser', function(req, res, next) {
		var insert_query, update_query;
		var pro			= req.body;		
		var type		= pro.data.type;
		var id	 		= pro.data.id;
		var first_name 	= pro.data.first_name;
		var last_name 	= pro.data.last_name;
		var email 		= pro.data.email;
		var img 		= pro.data.img;		
		
		var query = "SELECT * FROM `users` WHERE `email_id` = '"+email+"'";		
		connection.query(query, function(err, rows){
			if(err) throw err;
			
			if(rows.length == 0){
				if( type == 'fb'){
					insert_query = "INSERT INTO `users` (`first_name`,`last_name`,`email_id`,`facebook_id`,`profile_image`) VALUES ('"+first_name+"','"+last_name+"','"+email+"','"+id+"','"+img+"')";
					connection.query(insert_query, function(err, rows){
						if(err) throw err;
						req.session.users = req.body.data;
						res.json({'code':200,'status':'OK','result':req.session.users});
					});
				}else if(type == 'google'){
					insert_query = "INSERT INTO `users` (`first_name`,`last_name`,`email_id`,`gplus_id`,`profile_image`) VALUES ('"+first_name+"','"+last_name+"','"+email+"','"+id+"','"+img+"')";
					connection.query(insert_query, function(err, rows){
						if(err) throw err;
						console.log(rows);
						req.session.users = req.body.data;
					});
				}
			}else{
				if( type == 'fb'){
					update_query = "UPDATE `users` SET `facebook_id` = '"+id+"', `profile_image` = '"+img+"' WHERE `email_id` = '"+email+"'"					
					connection.query(update_query, function(err, rows){
						if(err) throw err;
						req.session.users = req.body.data;
						res.json({'code':200,'status':'OK','result':req.session.users});
					});
				}else if( type == 'google'){
					update_query = "UPDATE `users` SET `gplus_id` = '"+id+"', `profile_image` = '"+img+"' WHERE `email_id` = '"+email+"'"					
					connection.query(update_query, function(err, rows){
						if(err) throw err;
						console.log(rows);
						req.session.users = req.body.data;
					});
				}
			}
		});
    });
	
    app.get('/getSession',function(req,res,next){
          res.send(req.session.users);
    });
};



// route middleware to make sure a user is logged in
function isLoggedIn(req, res, next) {
console.log(req.isAuthenticated());
    // if user is authenticated in the session, carry on
    if (req.isAuthenticated())
        return next();

    // if they aren't redirect them to the home page
    res.redirect('/');
}