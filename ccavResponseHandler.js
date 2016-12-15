var http = require('http'),
    fs = require('fs'),
    qs = require('querystring');
var crypto = require('crypto');

exports.postRes = function(request,response, connection){
    var ccavEncResponse='',
	ccavResponse='',	
	workingKey = 'D23CEB7A0C1A82229F4371065C34E4F6',	//Put in the 32-Bit Key provided by CCAvenue.
	ccavPOST = '';
	
        request.on('data', function (data) {
	    ccavEncResponse += data;
	    ccavPOST =  qs.parse(ccavEncResponse);
	    var encryption = ccavPOST.encResp;
	    ccavResponse = decrypt(encryption,workingKey);
        });

	request.on('end', function () {
		//response.send(ccavResponse);
		var htmlcode = "";
		if(ccavResponse != ""){
			data = ccavResponse.split('&');
			var arr = [];
			var arr1 = [];
			for(i=0;i<data.length;i++){
				equalData = data[i].split('=');
				var ss = equalData[0];
				arr.push(equalData[1]);
				arr1.push(equalData[0]);				
			}
			
			var order_status = arr[arr1.indexOf('order_status')];
			var order_amount = arr[arr1.indexOf('amount')];
			//console.log(request)
			if( order_status == "Success" ){
				var insert_log = "INSERT INTO logs_wallet (user_id, wallet_amount, actions) VALUES ('"+request.session.users.id+"','"+order_amount+"','Deposit Amount Added By Reader')"
				connection.query( insert_log, function(err, rows){
					if(err) throw err;
					var take_wallet_query = "SELECT wallet FROM `users` WHERE id = '"+request.session.users.id+"'";
					connection.query(take_wallet_query, function(err, take_wallet){
						if(err) throw err;
						update_user_wallet_query = "UPDATE users SET wallet = "+take_wallet[0]['wallet']+"+"+order_amount+" WHERE id='"+request.session.users.id+"'";
						connection.query(update_user_wallet_query, function(err, update_user_wallet){
							if(err) throw err;
							//if(update_user_wallet.affectedRows == 1)
								htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/thank-you";</script></body></html>';
								response.writeHeader(200, {"Content-Type": "text/html"});
								response.write(htmlcode);
								response.end(); 
						});						
					});
				});
			}else if( order_status == "Aborted" ){
				htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/profile";</script></body></html>';
				response.writeHeader(200, {"Content-Type": "text/html"});
				response.write(htmlcode);
				response.end(); 
			}
		}
        
	}); 	
};

exports.postResFinal = function(request,response, connection){
    var ccavEncResponse='',
	ccavResponse='',	
	workingKey = 'D23CEB7A0C1A82229F4371065C34E4F6',	//Put in the 32-Bit Key provided by CCAvenue.
	ccavPOST = '';
	
        request.on('data', function (data) {
	    ccavEncResponse += data;
	    ccavPOST =  qs.parse(ccavEncResponse);
	    var encryption = ccavPOST.encResp;
	    ccavResponse = decrypt(encryption,workingKey);
        });

	request.on('end', function () {
		//response.send(ccavResponse);
		console.log(ccavResponse);
		var htmlcode = "";
		if(ccavResponse != ""){
			
			
			data = ccavResponse.split('&');
			var arr = [];
			var arr1 = [];
			for(i=0;i<data.length;i++){
				equalData = data[i].split('=');
				var ss = equalData[0];
				arr.push(equalData[1]);
				arr1.push(equalData[0]);				
			}
			
			var order_status = arr[arr1.indexOf('order_status')];
			var order_amount = arr[arr1.indexOf('amount')];
			var transaction_id = arr[arr1.indexOf('tracking_id')];
			
			var orderData = request.session.orderData;
			var profile = request.session.orderUserProfile;
			
			var types = arr[arr1.indexOf('payment_mode')];
			var ip_address = '';
			var deliveryType = request.session.deliveryType;
			var email = request.session.users.email;
			
			var method, orderId;
			var first_name = profile.first_name;
			var last_name = profile.last_name;
			var last_order_id;
			
			var method = 'Online';
			
			/* if(type == 'Credit Card'){
				types = "CC";
			}else if(type == 'Net banking'){
				types = "Net banking";
			}else if(type == 'Debit Card'){
				types = "DC";
			}else {
				types = "wallet";
			} */
				
			profile.user_id = request.session.users.id;
			
			//console.log(request)
			if( order_status == "Success" ){
				query = "SELECT orders.id, orders.status, orders.due_date, orders.price FROM `orders` WHERE orders.user_id = '"+request.session.users.id+"' AND (orders.status = 'due' OR orders.status = 'auto' OR orders.status = 'open')";
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
								var createOrderQuery = "INSERT INTO orders (`order_no`,`user_id`,`books_nos`,`genres`,`price`,`delivery_charges`,`pickup_charges`,`deposit`, `total`,`phone_number`,`alt_phone_number`,`ip_address`, `transaction_id`,`payment_method`,`payment_type`,`shipping_mode`,`status`) VALUES ('"+orderId+"', '"+profile.user_id+"', '"+orderData.no_of_book+"','"+orderData.cat_ids+"','"+orderData.price_per_month+"','"+orderData.delivery_charge+"','"+orderData.pickup_charge+"','"+orderData.deposit+"','"+orderData.total+"','"+profile.phone_number+"','"+profile.alt_phone_number+"','"+ip_address+"','"+transaction_id+"','"+method+"','"+types+"','"+deliveryType+"', 'selection' )";
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
																	htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/thank-you";</script></body></html>';
																	response.writeHeader(200, {"Content-Type": "text/html"});
																	response.write(htmlcode);
																	response.end(); 
																}
															});
														}
													});
												}else{
													htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/thank-you";</script></body></html>';
													response.writeHeader(200, {"Content-Type": "text/html"});
													response.write(htmlcode);
													response.end(); 
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
							var createOrderQuery = "INSERT INTO orders (`order_no`,`user_id`,`books_nos`,`genres`,`price`,`delivery_charges`,`pickup_charges`,`deposit`, `total`,`phone_number`,`alt_phone_number`,`ip_address`,`transaction_id`, `payment_method`,`payment_type`,`shipping_mode`,`status`) VALUES ('"+orderId+"', '"+profile.user_id+"', '"+orderData.no_of_book+"','"+orderData.cat_ids+"','"+orderData.price_per_month+"','"+orderData.delivery_charge+"','"+orderData.pickup_charge+"','"+orderData.deposit+"','"+orderData.total+"','"+profile.phone_number+"','"+profile.alt_phone_number+"','"+ip_address+"','"+transaction_id+"','"+method+"','"+types+"','"+deliveryType+"', 'selection' )";
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
																htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/thank-you";</script></body></html>';
																response.writeHeader(200, {"Content-Type": "text/html"});
																response.write(htmlcode);
																response.end(); 
															}
														});
													}
												});
											}else{
												htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/thank-you";</script></body></html>';
												response.writeHeader(200, {"Content-Type": "text/html"});
												response.write(htmlcode);
												response.end(); 
											}
										}
									});
								}
							});
						});
					}
				});
				/* var insert_log = "INSERT INTO logs_wallet (user_id, wallet_amount, actions) VALUES ('"+request.session.users.id+"','"+order_amount+"','Deposit Amount Added By Reader')"
				connection.query( insert_log, function(err, rows){
					if(err) throw err;
					var take_wallet_query = "SELECT wallet FROM `users` WHERE id = '"+request.session.users.id+"'";
					connection.query(take_wallet_query, function(err, take_wallet){
						if(err) throw err;
						update_user_wallet_query = "UPDATE users SET wallet = "+take_wallet[0]['wallet']+"+"+order_amount+" WHERE id='"+request.session.users.id+"'";
						connection.query(update_user_wallet_query, function(err, update_user_wallet){
							if(err) throw err;
							//if(update_user_wallet.affectedRows == 1)
								htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://readabookchallenge.com/#/thank-you";</script></body></html>';
								response.writeHeader(200, {"Content-Type": "text/html"});
								response.write(htmlcode);
								response.end(); 
						});						
					});
				}); */
			}else if( order_status == "Aborted" ){
				htmlcode = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Response Handler</title></head><body><script>location.href = "http://www.readabookchallenge.com/#/profile";</script></body></html>';
				response.writeHeader(200, {"Content-Type": "text/html"});
				response.write(htmlcode);
				response.end(); 
			}
		}
        
	}); 	
};

function decrypt(encText, workingKey) {
    	var m = crypto.createHash('md5');
    	m.update(workingKey)
    	var key = m.digest();
	var iv = '\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f';	
	var decipher = crypto.createDecipheriv('aes-128-cbc', key, iv);
    	var decoded = decipher.update(encText,'hex','utf8');
	decoded += decipher.final('utf8');
    	return decoded;
};