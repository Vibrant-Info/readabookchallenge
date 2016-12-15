var nodemailer = require('nodemailer');
var http = require('http');
module.exports = function(app, passport, connection) {
	var username = "readabookchallenge@gmail.com";
	var hash = "3a3bdd183ec7601ae380c99c4ad01445ebb1c3ea";
	var test = "0";
	var sender = "RDBOOK";
	
	var updateQuery;
	// GET USER PROFILE DETAILS
    app.get('/my-profile', function(req, res) {		
		var email = req.session.users.email;		
		var query = "SELECT users.id as user_id,users.first_name,users.last_name,users.email_id,users.phone_number,users.alt_phone_number,users.age,users.profile_image,users.wallet, user_address.id as address_id, user_address.address, user_address.city, user_address.area, user_address.area, user_address.landmark, user_address.pincode  FROM `users` LEFT outer JOIN user_address on users.id = user_address.user_id WHERE users.email_id='"+email+"' AND users.status='1'";
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
		var query = "SELECT `id`, `category_name` as name, `category_image` as image FROM `category` WHERE deleted = '0'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			genres = rows;
		});	
		
	
			var interested_query = "SELECT category_id FROM `users_genre` WHERE user_id ='"+req.session.users.id+"'";
			connection.query(interested_query, function(err, interested){
				res.send({'genres': genres, 'interested': interested});
						
		});
    });
	
	// GET WALLET STATUS
	app.get('/walletRequestStatus', function(req, res){
	
			var interested_query = "SELECT status FROM `wallet_request` WHERE user_id ='"+req.session.users.id+"' AND status = 'pending' ";
			connection.query(interested_query, function(err, resq){
				if(resq.length == 1)
					res.send({'status': resq[0]['status']});
				else
					res.send({'status': 'no data'});
			});			
		
	})
	// PROFILE UPDATE
	app.put('/updateProfile', function(req, res) {
		var email = req.session.users.email;
		var ids = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
		
		var data = req.body.data;
		var orderData = req.body.orderData;
		var orderId;
		
		req.session.orderData = orderData;
		req.session.orderUserProfile = data;
		
		console.log(req.session.orderData)
		console.log(req.session.orderUserProfile)
		
		var MAX_ID_QUERY = "SELECT MAX(id) as max FROM orders";
		connection.query(MAX_ID_QUERY, function(err, max_id){
			last_order_id = max_id[0]['max'] + 1;
			if( data.last_name != ''){
				letter1 = data.first_name.substring(0, 1);
				letter2 = data.last_name.substring(0, 1);
				orderId = letter1+letter2+"-"+last_order_id
			}else{
				letter1 = data.first_name.substring(0, 2);
				orderId = letter1+"-"+last_order_id
			}
		});
		connection.query(ids, function(err, id){
			if(err) throw err;
			var update_check_query = "SELECT * FROM `users` WHERE email_id = '"+data.email_id+"' AND id != '"+id[0].id+"'";
			connection.query(update_check_query, function(err, rows){
				if(err) throw err;
				if(rows.length == 0){
					updateQuery = "UPDATE `users` SET `first_name`='"+data.first_name+"', `last_name`='"+data.last_name+"', `email_id`='"+data.email_id+"',  `age`='"+data.age+"', `phone_number`='"+data.phone_number+"', `alt_phone_number`='"+data.alt_phone_number+"' WHERE id = '"+data.user_id+"' "
					connection.query(updateQuery, function(err, rows){
						if(err) throw err;
						var address_count_query = "SELECT `id` FROM `user_address` WHERE user_id = '"+data.user_id+"'";
						connection.query(address_count_query, function(err, address_count){
							if(err) throw err;
							if(address_count.length == 1){
								updateQuery = "UPDATE `user_address` SET `address`='"+data.address+"', `city`='"+data.city+"', `area`='"+data.area+"',  `landmark`='"+data.landmark+"', `pincode`='"+data.pincode+"' ,`upadated_date` = NOW() WHERE user_id = '"+data.user_id+"' "
								connection.query(updateQuery, function(err, rows){
									if(err) throw err;
									res.send({'code':200,'status':'OK','message':"Updated Successfully", 'someText': orderId});
								});
							}else{
								insert_address_query = "INSERT INTO `user_address` (user_id, address, city, area, landmark, pincode, upadated_date) VALUES ('"+data.user_id+"', '"+data.address+"', '"+data.city+"', '"+data.area+"', '"+data.landmark+"', '"+data.pincode+"', NOW())";
								connection.query(insert_address_query, function(err, address){
									if(err) throw err;
									res.send({'code':200,'status':'OK','message':"Updated Successfully"});
								});
							}
						});
					});
				}else{
					res.send({'code':400,'status':'failed','message':"User already exsit!!"});
				}
			});	
		});
    });
	
	// BOOKS DETAILS
	app.get("/books", function(req, res, next){
		var books = [];
	
			query = "SELECT orders.id as orders_id, orders.due_date, orders.status, order_items.book_id FROM `orders` LEFT OUTER JOIN `order_items` ON order_items.order_id = orders.id WHERE orders.user_id = '"+req.session.users.id+"' AND (orders.status IN( 'due', 'auto', 'open', 'pickup') )";
			connection.query(query, function(err, rows){
				if(err) throw err;
					if(rows.length != 0 && rows[0]['book_id'] != null ){
						var due_date = rows[0]['due_date'];
						var status = rows[0]['status'];
						for(var i=0; i < rows.length; i++){					
							var book_query = "SELECT book_info.cover, book_info.title, book_info.category_id, book_info.author, category.category_name FROM `book_info`, `category` WHERE book_info.id = '"+rows[i]['book_id']+"' AND category.id IN (book_info.category_id)";
							connection.query(book_query, function(err, book_rows){
								books.push(book_rows[0]);
								if( rows.length == books.length){
									res.send({'reading': books, 'timer': due_date, 'status': status});
								}
							});						
						}				
					}else{
						
						res.send({'timer': '','reading': '', 'status': ''});
					}
			});
		 /* */
	});
	
	// UPDATE GENERE
	app.post("/updateGenere", function(req, res){
		var cat_id = req.body.id;
		
			var checkCat = "SELECT id FROM users_genre WHERE user_id = '"+req.session.users.id+"' AND category_id = '"+cat_id+"'";
			connection.query(checkCat, function(err, checkCatres){
				if(err) throw err;
				if( checkCatres.length == 0){
					var insertInterest = "INSERT INTO  users_genre (user_id, category_id) VALUES ('"+req.session.users.id+"', '"+cat_id+"')";
					
					connection.query(insertInterest, function(err, interestedRows){
						res.send(interestedRows);
					});
				}else{
					var deleteInterest = "DELETE FROM `users_genre` WHERE user_id = '"+req.session.users.id+"' AND category_id = '"+cat_id+"'";
					
					connection.query(deleteInterest, function(err, result){
						res.send(result);
					});
				}
			
		});
	});
	
	// TIME UP
	app.post("/timeUp", function(req, res){
		var email = req.session.users.email;
		var query = "SELECT `id`,`wallet` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, users){
			if(err) throw err;
			query = "SELECT orders.id, orders.status, orders.due_date, orders.price FROM `orders` WHERE orders.user_id = '"+req.session.users.id+"' AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
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
					}else if(orders[0]['status'] == 'auto'){
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
										wallet_log_query = "INSERT INTO `logs_wallet` (`user_id`,`wallet_amount`,`actions`) VALUES ('"+users[0]['id']+"','"+orders[0]['price']+"' ,'Auto renewal Dedection by system')";
										connection.query(wallet_log_query, function(err, wallet_log){
											res.send(wallet_log);
										});
									}
								});
							}
						});
					}else if(orders[0]['status'] == 'due'){
						var nd = new Date();
						var requested_date = nd.getFullYear()+'-'+(nd.getMonth() + 1)+'-'+nd.getDate()+' '+ nd.getHours()+':'+nd.getMinutes()+':'+nd.getSeconds();
						
						update_status_query = "UPDATE `orders` SET status='pickup', requested_date='"+requested_date+"' WHERE id = '"+orders[0]['id']+"'";
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
	
	//WALLET REQUEST
	app.post("/walletRequest", function(req, res){
		var wallet_log_query = "INSERT INTO `wallet_request` (`user_id`, `paytm_phone_number`, `status`) VALUES ('"+req.body.id+"', '"+req.body.number+"',  'pending' )";
		connection.query(wallet_log_query, function(err, rows){
			if(err) throw err;
			if(rows.affectedRows == 1){
				res.send({code: 200, status: 'OK'})
			}
		});
	});
	
	// EXTEND TIME
	app.post("/extendTime", function(req, res){
		var time = req.body.time;
		var books = req.body.books;
		var email = req.session.users.email;
		var days;
		
		var extendPlan_query = "SELECT week_"+time+" FROM extend_plans WHERE no_of_books = '"+books+"'";
		connection.query(extendPlan_query, function(err, extendPlan){
			var query = "SELECT `id`,`wallet`, `first_name`, `phone_number` FROM `users` WHERE email_id = '"+email+"'";
			connection.query(query, function(err, users){
				if(err) throw err;
				query = "SELECT orders.id as orders_id, orders.due_date,  order_items.book_id FROM `orders`, `order_items` WHERE orders.user_id = '"+users[0]['id']+"' AND order_items.order_id = orders.id AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
				connection.query(query, function(err, orders){
					if(time == 1){
						days = 7;
					}else if(time == 2){
						days = 14;
					}else if(time == 3){
						days = 21;
					}else if(time == 4){
						days = 28;
					}
					var date = new Date(orders[0]['due_date']);
					var newdate = new Date(date);
					newdate.setDate(newdate.getDate() + days);
					var nd = new Date(newdate);
					var new_due_date = nd.getFullYear()+'-'+(nd.getMonth() + 1)+'-'+nd.getDate()+' '+ nd.getHours()+':'+nd.getMinutes()+':'+nd.getSeconds();
					
					if( users[0]['wallet'] >= extendPlan[0]['week_'+time]){
						update_status_query = "UPDATE `orders` SET due_date='"+new_due_date+"' WHERE id = '"+orders[0]['orders_id']+"'";
						connection.query(update_status_query, function(err, update_status){
							if(err) throw err;
							if(update_status.affectedRows == 1){
								wallet = users[0]['wallet'] - extendPlan[0]['week_'+time];
								update_wallet_query = "UPDATE `users` SET `wallet` = '"+wallet+"' WHERE `id` = '"+users[0]['id']+"'";
								connection.query(update_wallet_query, function(err, update_wallet){
									
									if(update_wallet.affectedRows == 1){
										wallet_log_query = "INSERT INTO `logs_wallet` (`user_id`,`wallet_amount`,`actions`) VALUES ('"+users[0]['id']+"','"+extendPlan[0]['week_'+time]+"','Time Extend for "+time+" Week')";
										connection.query(wallet_log_query, function(err, wallet_log){
											if(err) throw err;
											
											/* var message = encodeURI("Hi "+users[0]['first_name']+", Your extension request for "+time+" week(s) for the Read a Book Challenge has been processed. Happy Reading !");
											var numbers = users[0]['phone_number'];
											var SMSdata = "username="+username+"&hash="+hash+"&message="+message+"&sender="+sender+"&numbers="+numbers+"&test="+test;
											
											var options = {
											  host: 'api.textlocal.in',
											  port: 80,
											  path: '/send/?'+SMSdata,
											  method: 'POST'
											};

											http.request(options, function(res) {
											  console.log('STATUS: ' + res.statusCode);
											  console.log('HEADERS: ' + JSON.stringify(res.headers));
											  res.setEncoding('utf8');
											  res.on('data', function (chunk) {
												console.log('BODY: ' + chunk);
											  });
											}).end(); */
											res.send({'code': 200, 'status': 'OK'});
										});
									}
									
								});
							}
						});
					}else{
						res.send({'code': 400, 'message': 'Insufficient Balance. Please Add Money into your wallet!'});
					}
				});
			});
		});
	});
	
	//ONLY PICKUP
	app.post("/onlyPickup", function(req, res){
		var reason = req.body.reason;
		var email = req.session.users.email;
		var query = "SELECT `id`,`wallet` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, users){
			if(err) throw err;
			query = "SELECT orders.id, orders.status, orders.due_date, orders.price FROM `orders` WHERE orders.user_id = '"+users[0]['id']+"' AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
			connection.query(query, function(err, orders){
				if(err) throw err;
				if(orders.length == 1){
					var update_orders_query = "UPDATE orders SET requested_date = NOW(), pickup_reason = '"+reason+"', status = 'pickup' WHERE id = '"+orders[0]['id']+"'";
					connection.query(update_orders_query, function(err, update_orders){
						if(err) throw err;
						res.send(update_orders);
					});
				}else{
					res.send({code: 400, status: 'error', message: 'No order Available'});
				}
			});
		});
	});
	
	// SET DELIVERY TYPE IN SESSION
	app.post("/setDeliveryType", function(req, res){
		
		var email = req.session.users.email;
		var query = "SELECT `id`,`wallet` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, users){
			if(err) throw err;
			query = "SELECT orders.id FROM `orders` WHERE orders.user_id = '"+users[0]['id']+"' AND (orders.status = 'selection' OR orders.status = 'packaging' OR orders.status = 'labeling')";
			connection.query(query, function(err, orders){
				if(err) throw err;
				if(orders.length == 0){
					req.session.deliveryType = req.body.val;
					res.send({'code': 200});
				}else
					res.send({'code': 400});
			});
		});
		
	});
	
	// ADD WISHLIST
	app.post("/wishlistAdd", function(req, res){
		var data = req.body.data;
		var auth = "";
		var title = data.volumeInfo.title;
		var authors = data.volumeInfo.authors;
		var edition = "";
		var img = data.volumeInfo.imageLinks.smallThumbnail;
		var isbn = data.volumeInfo.industryIdentifiers[1].identifier;
		var genre = data.volumeInfo.categories[0];
		
		for(var j=0;j< authors.length; j++){
			auth += authors[j] + ", ";
		}
	
		var email = req.session.users.email;
		var book_check_query = "SELECT `id` FROM `book_info` WHERE isbn = '"+isbn+"'";
		connection.query(book_check_query, function(err, books){
			if(err) throw err;
			if(books.length >= 1){
				var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
				connection.query(query, function(err, user){
					if(err) throw err;
					var dupWishlist_query = "SELECT id FROM wishlist WHERE user_id = '"+user[0]['id']+"' AND isbn = '"+isbn+"'";
					connection.query(dupWishlist_query, function(err, dupWishlist){
						if(err) throw err;
						if(dupWishlist.length == 0){
							var wishlistAdd_query = "INSERT INTO `wishlist` (`user_id`, `isbn`, `title`, `genre`,`author`, `edition`, `cover_image`) VALUES ('"+user[0]['id']+"', '"+isbn+"', '"+title+"','"+genre+"', '"+authors+"', '"+edition+"', '"+img+"')";
							connection.query(wishlistAdd_query, function(err, wishlistAdd){
								if(err) throw err;
								res.send(wishlistAdd);
							});
						}else{
							res.send({"code": 400});
						}
					});
				});
			}else{
				var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
				connection.query(query, function(err, user){
					if(err) throw err;
					var dupWishlist_query = "SELECT id FROM wishlist WHERE user_id = '"+user[0]['id']+"' AND isbn = '"+isbn+"'";
					connection.query(dupWishlist_query, function(err, dupWishlist){
						if(err) throw err;
						console.log(dupWishlist.length);
						if(dupWishlist.length == 0){
							var wishlistAdd_query = "INSERT INTO `wishlist` (`user_id`, `isbn`, `title`, `genre`, `author`, `edition`, `cover_image`) VALUES ('"+user[0]['id']+"', '"+isbn+"', '"+title+"','"+genre+"', '"+authors+"', '"+edition+"', '"+img+"')";
							connection.query(wishlistAdd_query, function(err, wishlistAdd){
								if(err) throw err;
								var request_query = "INSERT INTO `request_book` (`member_id`, `book_title`, `isbn`, `author`, `edition`, `request_date`, `request_status`) VALUES ('"+user[0]['id']+"', '"+title+"', '"+isbn+"', '"+authors+"', '"+edition+"', NOW(), 'Pending')";
									connection.query(request_query, function(err, request){
										if(err) throw err;
										res.send(request);
									});
							});
						}else{
							res.send({"code": 400});
						}
					});
				});
			}
		});
	});
	
	//LOAD WISHLIST
	app.get('/loadWishlist', function(req, res){
		var wishlist_query = "SELECT * FROM `wishlist` WHERE user_id = '"+req.session.users.id+"'";
		connection.query(wishlist_query, function(err, wishlist){
			if(err) throw err;
			if(wishlist.length > 0){
				res.send({'code': 200, 'data': wishlist});
			}else{
				res.send({'code': 400, 'message': 'No wishlist Found!'});
			}
		});
	});
	
	//DELETE WISHLIST
	app.post('/wishlistDelete', function(req, res){
		var email = req.session.users.email;
		var id = req.body.id;
		if(email != ''){
			var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
			connection.query(query, function(err, user){
				if(err) throw err;
				var wishlist_query = "DELETE FROM `wishlist` WHERE user_id = '"+user[0]['id']+"' AND id ='"+id+"'";
				connection.query(wishlist_query, function(err, wishlist){
					if(err) throw err;
					res.send(wishlist);
				});
			});
		}
	});
	
	//ADD MYLIBRARY
	app.post("/libraryAdd", function(req, res){
		var data = req.body.data;
		var auth = "";
		var title = data.volumeInfo.title;
		var authors = data.volumeInfo.authors;
		var edition = "";
		var img = data.volumeInfo.imageLinks.smallThumbnail;
		var isbn = data.volumeInfo.industryIdentifiers[1].identifier;
		var genre = data.volumeInfo.categories[0];
		
		for(var j=0;j< authors.length; j++){
			auth += authors[j] + ", ";
		}
	
		var email = req.session.users.email;
		var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, user){
			if(err) throw err;
			var dupLibrary_query = "SELECT id FROM library WHERE user_id = '"+user[0]['id']+"' AND isbn = '"+isbn+"'";
			connection.query(dupLibrary_query, function(err, dupLibrary){
				if(err) throw err;
				if(dupLibrary.length == 0){
					var libAdd_query = "INSERT INTO `library` (`user_id`, `isbn`, `title`, `genre`, `author`, `edition`, `cover_image`) VALUES ('"+user[0]['id']+"', '"+isbn+"', '"+title+"','"+genre+"', '"+authors+"', '"+edition+"', '"+img+"')";
					connection.query(libAdd_query, function(err, lib){
						if(err) throw err;
						res.send(lib);
					});
				}else{
					res.send({"code": 400});
				}
			});
		});
	});
	
	
	//LOAD MYLIBRARY
	app.get('/loadLibrary', function(req, res){
		var lib_query = "SELECT * FROM `library` WHERE user_id = '"+req.session.users.id+"'";
		connection.query(lib_query, function(err, lib){
			if(err) throw err;
			if(lib.length > 0){
				res.send({'code': 200, 'data': lib});
			}else{
				res.send({'code': 400, 'message': 'No Books Found!'});
			}
		});
	});
	
	//DELETE MYLIBRARY
	app.post('/libraryDelete', function(req, res){
		var email = req.session.users.email;
		var id = req.body.id;
		if(email != ''){
			var query = "SELECT `id` FROM `users` WHERE email_id = '"+email+"'";
			connection.query(query, function(err, user){
				if(err) throw err;
				var wishlist_query = "DELETE FROM `library` WHERE user_id = '"+user[0]['id']+"' AND id ='"+id+"'";
				connection.query(wishlist_query, function(err, lib){
					if(err) throw err;
					res.send(lib);
				});
			});
		}
	});
	
	//SEND MAIL 
	app.post("/mailEndorse", function(req, res){
		var data = req.body.data;
		console.log(data);
		// create reusable transporter object using the default SMTP transport
		var transporter = nodemailer.createTransport('smtps://lingu@vibrant-info.com:lingu@2015@smtp.gmail.com');

		// setup e-mail data with unicode symbols
		var mailOptions = {
			//from: '"'+data.first_name+' '+data.last_name+' ?" <"'+data.emailid+'">', // sender address
			to: 'readabookchallenge@gmail.com', // list of receivers
			subject: 'Read A Book Challenge - Website', // Subject line
			html: '<p><b>Hello Admin, </b><br> This mail coming from <b>Read A Book Challenge - Endorse</b>.<br>Name: "'+data.first_name+' '+data.last_name+'"<br>Email ID: "'+data.emailid+'"<br> Phone Number: "'+data.phone+'"<br>Books: "'+data.books+'"</p>' // html body
		};

		// send mail with defined transport object
		transporter.sendMail(mailOptions, function(error, info){
			if(error){
				return console.log(error);
			}
			res.send({"code": "200"});
			console.log('Message sent: ' + info.response);
		});
	});
	
	app.post("/mailEnquiry", function(req, res){
		var data = req.body.data;
		
		// create reusable transporter object using the default SMTP transport
		var transporter = nodemailer.createTransport('smtps://lingu@vibrant-info.com:lingu@2015@smtp.gmail.com');

		// setup e-mail data with unicode symbols
		var mailOptions = {
			//from: '"'+data.first_name+' '+data.last_name+' ?" <"'+data.emailid+'">', // sender address
			to: 'readabookchallenge@gmail.com', // list of receivers
			subject: 'Read A Book Challenge - Website', // Subject line
			html: '<p><b>Hello Admin, </b><br> This mail coming from <b>Read A Book Challenge - Enquiry</b>.<br>Name: '+data.first_name+' '+data.last_name+'<br>Email ID: '+data.emailid+'<br> Phone Number: '+data.phone+'<br>Subjects: '+data.subject+'<br>Message: '+data.querymessage+'</p>' // html body
		};

		// send mail with defined transport object
		transporter.sendMail(mailOptions, function(error, info){
			if(error){
				return console.log(error);
			}
			res.send({"code": "200"});
			console.log('Message sent: ' + info.response);
		});
	});
	
	//CHECK EMAIL DUPLICATE
	app.post('/checkEmailDup', function(req, res){
		var data = req.body.data;
		var type = data.type;
		var email = data.email;
		
		var query = "SELECT * FROM users WHERE email_id = '"+email+"'";
		connection.query(query, function(err, rows){
			if(err) throw err;
			if(rows.length == 1){
				res.send({"code": 400, "message": "Email ID Already Registered!"});
			}else{
				res.send({"code": 200});
			}			
		});
	});
	
	// GET EXTEND AMOUNT
	app.post("/getExtendAmount", function(req, res){
		var time = req.body.week;
		var books = req.body.books;
		
		var extendPlan_query = "SELECT week_"+time+" FROM extend_plans WHERE no_of_books = '"+books+"'";
		connection.query(extendPlan_query, function(err, extendPlan){ 
			if(err) throw err;
			res.send({'amount': extendPlan[0]["week_"+time]})
		});
	});
	
}