module.exports = function(app, passport, connection) {   
    app.get('/logout', function(req, res) {
		req.session.destroy();
        res.redirect('/');
		//res.send({'code':200,'status':'OK'});
    });
	
    app.post('/saveUser', function(req, res, next) {
		
		console.log(req.body)
		var insert_query, update_query;
		var pro			= req.body;	
		var type		= pro.data.type;
		var id	 		= pro.data.id;
		var first_name 	= pro.data.first_name;
		var last_name 	= pro.data.last_name;
		var email 		= pro.data.email;
		var img 		= pro.data.img;		
		console.log(pro)
		if(type != "twitter"){
			var query = "";
			if( type == 'fb'){
				var query = "SELECT * FROM `users` WHERE `facebook_id` = '"+id+"' OR `email_id` = '"+email+"'";
			}
			if( type == 'google'){
				var query = "SELECT * FROM `users` WHERE `gplus_id` = '"+id+"' OR `email_id` = '"+email+"'";
			}

			console.log(query);
			
			connection.query(query, function(err, rows){
				if(err) throw err;
				
				if(rows.length == 0){
					if( type == 'fb'){
						insert_query = "INSERT INTO `users` (`first_name`,`last_name`,`email_id`,`facebook_id`,`profile_image`) VALUES ('"+first_name+"','"+last_name+"','"+email+"','"+id+"','"+img+"')";
						connection.query(insert_query, function(err, rows){
							if(err) throw err;
							var query_f = "SELECT * FROM `users` WHERE `facebook_id` = '"+id+"'";	
							
							connection.query(query_f, function(err, rows){
								if(err) throw err;
								var datas = {};
								datas.id = rows[0].id;
								datas.first_name = rows[0].first_name;
								datas.last_name = rows[0].last_name;
								datas.email = rows[0].email_id;
								datas.img = rows[0].profile_image;
								datas.facebook_id = rows[0].facebook_id;
								datas.twitter_id = rows[0].twitter_id;
								datas.gplus_id = rows[0].gplus_id;
								req.session.users =datas;	
								res.send({'code':200,'status':'OK','result':req.session.users});								
							});
							
						});
					}else if(type == 'google'){
						insert_query = "INSERT INTO `users` (`first_name`,`last_name`,`email_id`,`gplus_id`,`profile_image`) VALUES ('"+first_name+"','"+last_name+"','"+email+"','"+id+"','"+img+"')";
						connection.query(insert_query, function(err, rows){
							if(err) throw err;
							var query_f = "SELECT * FROM `users` WHERE `gplus_id` = '"+id+"'";	
							console.log(query_f);
							connection.query(query_f, function(err, rows){
								if(err) throw err;
								var datas = {};
								datas.id = rows[0].id;
								datas.first_name = rows[0].first_name;
								datas.last_name = rows[0].last_name;
								datas.email = rows[0].email_id;
								datas.img = rows[0].profile_image;
								datas.facebook_id = rows[0].facebook_id;
								datas.twitter_id = rows[0].twitter_id;
								datas.gplus_id = rows[0].gplus_id;
								req.session.users =datas;	
								res.send({'code':200,'status':'OK','result':req.session.users});								
							});
							
						});
					}
				}else{
					if( type == 'fb'){
						update_query = "UPDATE `users` SET  `profile_image` = '"+img+"', `facebook_id` = '"+id+"' WHERE `id` = '"+rows[0]['id']+"'"					
						connection.query(update_query, function(err, rows){
							if(err) throw err;
							var query_f = "SELECT * FROM `users` WHERE `facebook_id` = '"+id+"'";		
							connection.query(query_f, function(err, rows){
								if(err) throw err;
								console.log(rows);
								var datas = {};
								datas.id = rows[0].id;
								datas.first_name = rows[0].first_name;
								datas.last_name = rows[0].last_name;
								datas.email = rows[0].email_id;
								datas.img = rows[0].profile_image;
								datas.facebook_id = rows[0].facebook_id;
								datas.twitter_id = rows[0].twitter_id;
								datas.gplus_id = rows[0].gplus_id;
								req.session.users =datas;	
								res.send({'code':200,'status':'OK','result':req.session.users});								
							});
							
						});
					}else if( type == 'google'){
						update_query = "UPDATE `users` SET  `profile_image` = '"+img+"', `gplus_id` = '"+id+"'  WHERE `id` = '"+rows[0]['id']+"'"					
						connection.query(update_query, function(err, rows){
							if(err) throw err;
							
							var query_f = "SELECT * FROM `users` WHERE `gplus_id` = '"+id+"'";		
							connection.query(query_f, function(err, rows){
								if(err) throw err;
								var datas = {};
								datas.id = rows[0].id;
								datas.first_name = rows[0].first_name;
								datas.last_name = rows[0].last_name;
								datas.email = rows[0].email_id;
								datas.img = rows[0].profile_image;
								datas.facebook_id = rows[0].facebook_id;
								datas.twitter_id = rows[0].twitter_id;
								datas.gplus_id = rows[0].gplus_id;
								req.session.users =datas;	
								res.send({'code':200,'status':'OK','result':req.session.users});								
							});
						});
					}
				}
			});
		}else{	
			update_query = "UPDATE `users` SET `email_id` = '"+email+"' WHERE `twitter_id` = '"+req.session.users.twitter_id+"'";	
			
			connection.query(update_query, function(err, rows){
				if(err) throw err;
				req.session.users.email = email;
				res.send({'code':200,'status':'OK','result':req.session.users});
			});
		}
    });
	
    app.get('/getSession',function(req,res,next){
          res.send(req.session.users);
    });
	
    
	app.get('/auth/twitter', passport.authenticate('twitter'));

	// handle the callback after twitter has authenticated the user

	app.get('/auth/twitter/callback', 
		passport.authenticate('twitter', { 
			successRedirect: '/loginSuccess',
			failureRedirect: '/' 
		})/* ,
		function(req, res) {
			console.log(req.user);
			var query = "SELECT * FROM `users` WHERE `twitter_id` = '"+req.user.id+"'";	
			console.log(query);
			connection.query(query, function(err, rows){
				if(err) throw err;				
				var datas = {};
				console.log(rows);
				if(rows.length > 0){
					datas.id = rows[0].id;
					datas.first_name = rows[0].first_name;
					datas.last_name = rows[0].last_name;
					datas.email = rows[0].email_id;
					datas.img = rows[0].profile_image;
					datas.facebook_id = rows[0].facebook_id;
					datas.twitter_id = rows[0].twitter_id;
					datas.gplus_id = rows[0].gplus_id;
					req.session.users =datas;		
					res.redirect('#/');					
				}else{
					console.log('else');
					req.session.users =req.user;		
					res.redirect('#/');	
				}
			});
		} */
	);
	
	app.get('/loginSuccess', function(req, res, next) {
		var query = "SELECT * FROM `users` WHERE `twitter_id` = '"+req.user.id+"'";	
		console.log(query);
		connection.query(query, function(err, rows){
			if(err) throw err;				
			var datas = {};
			console.log(rows);
			if(rows.length > 0){
				datas.id = rows[0].id;
				datas.first_name = rows[0].first_name;
				datas.last_name = rows[0].last_name;
				datas.email = rows[0].email_id;
				datas.img = rows[0].profile_image;
				datas.facebook_id = rows[0].facebook_id;
				datas.twitter_id = rows[0].twitter_id;
				datas.gplus_id = rows[0].gplus_id;
				req.session.users =datas;		
				res.redirect('#/');					
			}else{
				console.log('else');
				req.session.users =req.user;		
				res.redirect('#/');	
			}
		});
	});
	
};