var http = require('http');
var querystring = require("querystring");
module.exports = function(app, passport, connection) {
	
	// PRICE
	app.post('/price', function(req, res){
		var count = req.body.count;
		var interested = req.body.interested;
		var cat_id = "";
		for( i = 0; i< interested.length; i++){
			cat_id += interested[i]['category_id'] + ',';
		}
		cat_id = cat_id.replace(/(^,)|(,$)/g, "");
		
		var plan_query = "SELECT * FROM plans WHERE `status` = '1' AND `no_of_book` = '"+count+"'";
		connection.query(plan_query, function(err, plans){
			var plan = plans[0];
			
			var cat_name_query = "SELECT `id`,`category_name` FROM `category` WHERE id IN ("+cat_id+")";
			connection.query(cat_name_query, function(err, cat_name){
				var category_name = cat_name
				res.send({"plan": plan, "cat_name": category_name});
			});
		});
	});
	
	// CHECKOUT
	app.post('/checkOut', function(req, res){
		var orderData = req.body.order;
		var profile = req.body.profile;
		var type = req.body.type;
		var ip_address = req.body.ip;
		var deliveryType = req.session.deliveryType;
		var email = req.session.users.email;
		
		var method, orderId;
		var first_name = profile.first_name;
		var last_name = profile.last_name;
		var last_order_id;
		
		if(type == 'CC'){
			method = 'Online';
		}else if(type == 'DC'){
			method = 'Online';
		}else if(type == 'Net Banking'){
			method = 'Online';
		}else if(type == 'COD'){
			method = 'COD';
		}
		
		var date = new Date();
		var newdate = new Date(date);
		newdate.setDate(newdate.getDate() + 6);
		var nd = new Date(newdate);	
		var monthNames = [
		  "January", "February", "March",
		  "April", "May", "June", "July",
		  "August", "September", "October",
		  "November", "December"
		];

		var date = new Date(nd);
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		var terms;
		
		if( day == 1 )
			terms = 'st';
		else if( day == 2 )
			terms = 'nd';
		else if( day == 3)
			terms = 'rd';
		else
			terms = 'th';
		
		var expectedDate = day + terms+' ' + monthNames[monthIndex] + ' ' + year;
							
		var query = "SELECT `id`,`wallet` FROM `users` WHERE email_id = '"+email+"'";
		connection.query(query, function(err, users){
			if(err) throw err;
			profile.user_id = users[0]['id'];
			query = "SELECT orders.id, orders.status, orders.due_date, orders.price FROM `orders` WHERE orders.user_id = '"+users[0]['id']+"' AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
			connection.query(query, function(err, orders){
				if(err) throw err;
				if(orders != ''){
					var update_orders_query = "UPDATE orders SET requested_date = NOW() WHERE id = '"+orders[0]['id']+"'";
					connection.query(update_orders_query, function(err, update_orders){
						if(err) throw err;
						var MAX_ID_QUERY = "SELECT MAX(id) as max FROM orders";
						connection.query(MAX_ID_QUERY, function(err, max_id){
							last_order_id = max_id[0]['max'] + 1;
							if( last_name != ''){
								letter1 = first_name.substring(0, 1);
								letter2 = last_name.substring(0, 1);
								orderId = letter1+letter2+"-"+last_order_id
							}else{
								letter1 = first_name.substring(0, 2);
								orderId = letter1+"-"+last_order_id
							}
							
							
							// INSERT TO ORDERS TABLE
							var createOrderQuery = "INSERT INTO orders (`order_no`,`user_id`,`books_nos`,`genres`,`price`,`delivery_charges`,`pickup_charges`,`deposit`, `total`,`phone_number`,`alt_phone_number`,`ip_address`,`payment_method`,`payment_type`,`shipping_mode`,`status`) VALUES ('"+orderId+"', '"+profile.user_id+"', '"+orderData.no_of_book+"','"+orderData.cat_ids+"','"+orderData.price_per_month+"','"+orderData.delivery_charge+"','"+orderData.pickup_charge+"','"+orderData.deposit+"','"+orderData.total+"','"+profile.phone_number+"','"+profile.alt_phone_number+"','"+ip_address+"','"+method+"','"+type+"','"+deliveryType+"', 'selection' )";
							connection.query(createOrderQuery, function(err, rows){
								if(err) throw err;
								if(rows.insertId != ''){
									// INSERT TO ORDERS ADDRESS
									insert_address = "INSERT INTO `orders_address` (`order_id`, `address`, `city`, `area`, `landmark`, `pincode`) VALUES ('"+rows.insertId+"', '"+ profile.address +"', '"+ profile.city +"','"+ profile.area +"','"+ profile.landmark +"','"+ profile.pincode +"' )";
									connection.query(insert_address, function(err, addrRows){
										if(err) throw err;
										if(addrRows.affectedRows == 1){
											if( orderData.deposit > 0 ){
												// UPDATE USER WALLET IF DEPOSIT AMOUNT IS THERE IN PAYMENT
												var total_wallet = profile.wallet + orderData.deposit;
												update_user_wallet = "UPDATE `users` SET wallet = '"+total_wallet+"' WHERE id = '"+profile.user_id+"'";
												connection.query(update_user_wallet, function(err, update_user_wallet){
													if(err) throw err;
													if(update_user_wallet.affectedRows == 1){
														// INSERT INTO WALLET LOGS TABLES
														var wallet_logs_query = "INSERT INTO logs_wallet (`user_id`, `wallet_amount`, `actions`) VALUES ('"+profile.user_id+"', '"+orderData.deposit+"', 'Added by User from Orders' )";
														connection.query(wallet_logs_query, function(err, walletRows){
															if(err) throw err;
															if(walletRows.affectedRows == 1){
																var options = {
																  hostname: 'librarian.readabookchallenge.com',
																  port: 81,
																  path: '/send_sms_test.php',
																  method: 'POST',
																  headers: {
																	  'Content-Type': 'application/json',
																  },
																  data:{
																	  'type': 'placingOrder',
																	  'firstName': first_name,
																	  'date': expectedDate,
																	  'mobile': profile.phone_number
																  }
																};
																var req = http.request(options, function(res) {
																  console.log('Status: ' + res.statusCode);
																  console.log('Headers: ' + JSON.stringify(res.headers));
																  res.setEncoding('utf8');
																  res.on('data', function (body) {
																	console.log('Body: ' + body);
																  });
																});
																req.on('error', function(e) {
																  console.log('problem with request: ' + e.message);
																});
																req.end();
																res.send({'code': 200, 'status' : 'OK'})
															}
														});
													}
												});
											}else{
												var options = {
													  hostname: 'librarian.readabookchallenge.com',
													  port: 81,
													  path: '/send_sms_test.php',
													  method: 'POST',
													  headers: {
														  'Content-Type': 'application/json',
													  },
													  data: {
														  'type': 'placingOrder',
														  'firstName': first_name,
														  'date': expectedDate,
														  'mobile': profile.phone_number
													  }
													};
												var req = http.request(options, function(res) {
												  console.log('Status: ' + res.statusCode);
												  console.log('Headers: ' + JSON.stringify(res.headers));
												  res.setEncoding('utf8');
												  res.on('data', function (body) {
													console.log('Body: ' + body);
												  });
												});
												req.on('error', function(e) {
												  console.log('problem with request: ' + e.message);
												});
												req.end();
												res.send({'code': 200, 'status' : 'OK'})
											}
										}
									});
								}
							});
						});	
					});
				}else{
					var MAX_ID_QUERY = "SELECT MAX(id) as max FROM orders";
					connection.query(MAX_ID_QUERY, function(err, max_id){
						last_order_id = max_id[0]['max'] + 1;
						if( last_name != ''){
							letter1 = first_name.substring(0, 1);
							letter2 = last_name.substring(0, 1);
							orderId = letter1+letter2+"-"+last_order_id
						}else{
							letter1 = first_name.substring(0, 2);
							orderId = letter1+"-"+last_order_id
						}						
						
						// INSERT TO ORDERS TABLE
						var createOrderQuery = "INSERT INTO orders (`order_no`,`user_id`,`books_nos`,`genres`,`price`,`delivery_charges`,`pickup_charges`,`deposit`, `total`,`phone_number`,`alt_phone_number`,`ip_address`,`payment_method`,`payment_type`,`shipping_mode`,`status`) VALUES ('"+orderId+"', '"+profile.user_id+"', '"+orderData.no_of_book+"','"+orderData.cat_ids+"','"+orderData.price_per_month+"','"+orderData.delivery_charge+"','"+orderData.pickup_charge+"','"+orderData.deposit+"','"+orderData.total+"','"+profile.phone_number+"','"+profile.alt_phone_number+"','"+ip_address+"','"+method+"','"+type+"','"+deliveryType+"', 'selection' )";
						console.log(createOrderQuery)
						connection.query(createOrderQuery, function(err, rows){
							if(err) throw err;
							if(rows.insertId != ''){
								// INSERT TO ORDERS ADDRESS
								insert_address = "INSERT INTO `orders_address` (`order_id`, `address`, `city`, `area`, `landmark`, `pincode`) VALUES ('"+rows.insertId+"', '"+ profile.address +"', '"+ profile.city +"','"+ profile.area +"','"+ profile.landmark +"','"+ profile.pincode +"' )";
								connection.query(insert_address, function(err, addrRows){
									if(err) throw err;
									if(addrRows.affectedRows == 1){
										if( orderData.deposit > 0 ){
											// UPDATE USER WALLET IF DEPOSIT AMOUNT IS THERE IN PAYMENT
											var total_wallet = profile.wallet + orderData.deposit;
											update_user_wallet = "UPDATE `users` SET wallet = '"+total_wallet+"' WHERE id = '"+profile.user_id+"'";
											connection.query(update_user_wallet, function(err, update_user_wallet){
												if(err) throw err;
												if(update_user_wallet.affectedRows == 1){
													// INSERT INTO WALLET LOGS TABLES
													var wallet_logs_query = "INSERT INTO logs_wallet (`user_id`, `wallet_amount`, `actions`) VALUES ('"+profile.user_id+"', '"+orderData.deposit+"', 'Added by User from Orders' )";
													connection.query(wallet_logs_query, function(err, walletRows){
														if(err) throw err;
														if(walletRows.affectedRows == 1){
															var options = {
															  hostname: 'librarian.readabookchallenge.com',
															  port: 81,
															  path: '/send_sms_test.php',
															  method: 'POST',
															  headers: {
																  'Content-Type': 'application/json',
															  },
															  data: {
																  'type': 'placingOrder',
																  'firstName': first_name,
																  'date': expectedDate,
																  'mobile': profile.phone_number
															  }
															};
																var req = http.request(options, function(res) {
																  console.log('Status: ' + res.statusCode);
																  console.log('Headers: ' + JSON.stringify(res.headers));
																  res.setEncoding('utf8');
																  res.on('data', function (body) {
																	console.log('Body: ' + body);
																  });
																});
																req.on('error', function(e) {
																  console.log('problem with request: ' + e.message);
																});
																req.end();
															res.send({'code': 200, 'status' : 'OK'})
														}
													});
												}
											});
										}else{
											 var options = {
											  hostname: 'librarian.readabookchallenge.com',
											  port: 81,
											  path: 'send_sms_test.php',
											  method: 'POST',
											  headers: {
												  'Content-Type': 'application/json',
											  },
											  data: {
												  'type': 'placingOrder',
												  'firstName': first_name,
												  'date': expectedDate,
												  'mobile': profile.phone_number
											  }
											};
											var req = http.request(options, function(res) {
											  console.log('Status: ' + res.statusCode);
											  console.log('Headers: ' + JSON.stringify(res.headers));
											  res.setEncoding('utf8');
											  res.on('data', function (body) {
												console.log('Body: ' + body);
											  });
											});
											req.on('error', function(e) {
											  console.log('problem with request: ' + e.message);
											});
											req.end(); 
											/*var data = {
											   var1:"something",
											   var2:"something else"
											};
											
											var qs = querystring.stringify(data);
											var qslength = qs.length;
											var options = {
												hostname: "librarian.readabookchallenge.com",
												port: 81,
												path: "send_sms_test.php/123",
												method: 'POST',
												headers:{
													'Content-Type': 'application/json'
												}
											};

											var buffer = "";
											var req = http.request(options, function(res) {
												res.on('data', function (chunk) {
												   buffer+=chunk;
												});
												res.on('end', function() {
													console.log(buffer);
												});
											});

											req.write(qs);
											req.end();*/
											res.send({'code': 200, 'status' : 'OK'})
										}
									}
								});
							}
						});
					});
				}
			});
		});
	});
	
	/* CHECK CHALLENGE */
	
	app.get("/checkChallenge", function(req, res){
		var type = req.session.deliveryType
		
		if(type){
			res.send({'code': 200, 'status' : 'OK'});
		}else{
			res.send({'code': 400, 'status' : 'OK'})
		}
	});
	/* CHECK CHALLENGE */
	
	/* app.get("/genOrderNumber", function(req, res){
		var MAX_ID_QUERY = "SELECT MAX(id) as max FROM orders";
		connection.query(MAX_ID_QUERY, function(err, max_id){
			last_order_id = max_id[0]['max'] + 1;
			if( last_name != ''){
				letter1 = first_name.substring(0, 1);
				letter2 = last_name.substring(0, 1);
				orderId = letter1+letter2+"-"+last_order_id
			}else{
				letter1 = first_name.substring(0, 2);
				orderId = letter1+"-"+last_order_id
			}
		});
	}); */
	
}