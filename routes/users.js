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
	app.get('/genre', function(req, res) {
		var genres;
		var email = req.session.users.email;
		var query = "SELECT `id`, `category_name` as name FROM `category` WHERE deleted = '0'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			genres = rows;
		});	
		
		var ids = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(ids, function(err, id){
			if(err) throw err;
			var interested_query = "SELECT category_id FROM `users_genre` WHERE user_id ='"+id[0]['id']+"'";
			connection.query(interested_query, function(err, interested){
				res.send({'genres': genres, 'interested': interested});
			});			
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
	
	// BOOKS DETAILS
	app.get("/books", function(req, res, next){
		var books = [];
		var email = req.session.users.email;
		var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			query = "SELECT orders.id as orders_id, orders.due_date,  order_items.book_id FROM `orders`, `order_items` WHERE orders.user_id = '"+rows[0]['id']+"' AND order_items.order_id = orders.id AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
			connection.query(query, function(err, rows){
				if(err) throw err;
				console.log(rows)
				if(rows.length > 0){
					var due_date = rows[0]['due_date'];
					for(var i=0; i < rows.length; i++){					
						var book_query = "SELECT book_info.cover, book_info.title, book_info.category_id, book_info.author, category.category_name FROM `book_info`, `category` WHERE book_info.id = '"+rows[i]['book_id']+"' AND category.id IN (book_info.category_id)";
						connection.query(book_query, function(err, book_rows){
							books.push(book_rows[0]);
							if( rows.length == books.length){
								res.send({'reading': books, 'timer': due_date});
							}
						});						
					}				
				}else{
					res.send({});
				}
			});
		});
	});
	
	// UPDATE GENERE
	app.post("/updateGenere", function(req, res){
		var cat_id = req.body.id;
		var email = req.session.users.email;
		var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			var checkCat = "SELECT id FROM users_genre WHERE user_id = '"+rows[0]['id']+"' AND category_id = '"+cat_id+"'";
			connection.query(checkCat, function(err, checkCatres){
				if(err) throw err;
				console.log(checkCatres)
				if( checkCatres.length == 0){
					var insertInterest = "INSERT INTO  users_genre (user_id, category_id) VALUES ('"+rows[0]['id']+"', '"+cat_id+"')";
					console.log(insertInterest)
					connection.query(insertInterest, function(err, interestedRows){
						res.send(interestedRows);
					});
				}else{
					var deleteInterest = "DELETE FROM `users_genre` WHERE user_id = '"+rows[0]['id']+"' AND category_id = '"+cat_id+"'";
					connection.query(deleteInterest, function(err, result){
						res.send(result);
					});
				}
			});
		});
	});
	
	// TIME UP
	app.post("/timeUp", function(req, res){
		var email = req.session.users.email;
		var query = "SELECT `id`,`wallet` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, users){
			if(err) throw err;
			query = "SELECT orders.id, orders.status, orders.due_date, orders.price FROM `orders` WHERE orders.user_id = '"+users[0]['id']+"' AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
			connection.query(query, function(err, orders){
				if(err) throw err;
				if(orders.length == 1){
					if(orders[0]['status'] == 'open'){
						var date = new Date(orders[0]['due_date']);
						var newdate = new Date(date);
						newdate.setDate(newdate.getDate() + 7);
						var nd = new Date(newdate);
						var new_due_date = nd.getFullYear()+'-'+(nd.getMonth() + 1)+'-'+nd.getDate()+' '+ nd.getHours()+':'+nd.getMinutes()+':'+nd.getSeconds();
						
						update_status_query = "UPDATE `orders` SET status='due', due_date='"+new_due_date+"' WHERE id = '"+orders[0]['id']+"'";
						connection.query(update_status_query, function(err, update_status){
							if(err) throw err;
							res.send(update_status);
						});
					}else if(orders[0]['status'] == 'due'){
						var date = new Date(orders[0]['due_date']);
						var newdate = new Date(date);
						newdate.setDate(newdate.getDate() + 30);
						var nd = new Date(newdate);
						var new_due_date = nd.getFullYear()+'-'+(nd.getMonth() + 1)+'-'+nd.getDate()+' '+ nd.getHours()+':'+nd.getMinutes()+':'+nd.getSeconds();
						
						update_status_query = "UPDATE `orders` SET status='auto', due_date='"+new_due_date+"' WHERE id = '"+orders[0]['id']+"'";
						connection.query(update_status_query, function(err, update_status){
							if(err) throw err;
							if(update_status.affectedRows == 1){
								wallet = users[0]['wallet'] - orders[0]['price'];
								update_wallet_query = "UPDATE `users` SET `wallet` = '"+wallet+"' WHERE `id` = '"+users[0]['id']+"'";
								connection.query(update_wallet_query, function(err, update_wallet){
									if(update_wallet.affectedRows == 1){
										wallet_log_query = "INSERT INTO `logs_wallet` (`user_id`,`actions`) VALUES ('"+users[0]['id']+"', 'Auto renewal Dedection by system')";
										connection.query(wallet_log_query, function(err, wallet_log){
											res.send(wallet_log);
										});
									}
								});
							}
						});
					}else if(orders[0]['status'] == 'auto'){
						var nd = new Date();
						var requested_date = nd.getFullYear()+'-'+(nd.getMonth() + 1)+'-'+nd.getDate()+' '+ nd.getHours()+':'+nd.getMinutes()+':'+nd.getSeconds();
						
						update_status_query = "UPDATE `orders` SET status='closed', requested_date='"+requested_date+"' WHERE id = '"+orders[0]['id']+"'";
						connection.query(update_status_query, function(err, update_status){
							if(err) throw err;
							if(update_status.affectedRows == 1){
								//KOORIEE API
								res.send(update_status);
							}
						});
					}
				}else{
					res.send("timeUp");
				}
			});
		});
	});
}