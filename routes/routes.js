
// app/routes.js
var OAuth = require('oauth').OAuth
  , oauth = new OAuth(
      "https://api.twitter.com/oauth/request_token",
      "https://api.twitter.com/oauth/access_token",
      "hXexltZCLpO49bLRwxp4wNV0T",
      "NwYl2EB1nUqq9qHY121E20wKtYGBUyo1qWTrsF2XQGRvRlx6YJ",
      "1.0",
      "http://localhost:3000/auth/twitter/callback",
      "HMAC-SHA1"
    );
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
						res.send({'code':200,'status':'OK','result':req.session.users});
					});
				}else if(type == 'google'){
					insert_query = "INSERT INTO `users` (`first_name`,`last_name`,`email_id`,`gplus_id`,`profile_image`) VALUES ('"+first_name+"','"+last_name+"','"+email+"','"+id+"','"+img+"')";
					connection.query(insert_query, function(err, rows){
						if(err) throw err;
						console.log(rows);
						req.session.users = req.body.data;
					});
				}else if(type == 'twitter'){
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
				}else if( type == 'twitter'){
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
	
    
app.get('/auth/twitter', function(req, res) {
 
  oauth.getOAuthRequestToken(function(error, oauth_token, oauth_token_secret, results) {
    if (error) {
      res.redirect("/");
    }
    else {
      req.session.oauth = {
        token: oauth_token,
        token_secret: oauth_token_secret
      };
    res.send('https://api.twitter.com/oauth/authenticate?oauth_token='+oauth_token);
    }
  });
 
});
    
 app.get('/auth/twitter/callback', function(req, res, next) {
 
  if (req.session.oauth) {
    req.session.oauth.verifier = req.query.oauth_verifier;
    var oauth_data = req.session.oauth;
    oauth.getOAuthAccessToken(
      oauth_data.token,
      oauth_data.token_secret,
      oauth_data.verifier,
      function(error, oauth_access_token, oauth_access_token_secret, results) {
        if (error) {
          res.send("Authentication Failure!");
        }
        else {
          req.session.oauth.access_token = oauth_access_token;
          req.session.oauth.access_token_secret = oauth_access_token_secret;
          console.log(results);
          var data={
              id : results.user_id,
    		  name : results.screen_name,
    			email : '',
    			img : '',
          }
          req.session.users = data;
          res.redirect('/');
        }
      }
    );
  }
  else {
    res.redirect('/login'); // Redirect to login page
  }
 
});
};



// route middleware to make sure a user is logged in
function isLoggedIn(req, res, next) {
    if (req.isAuthenticated())
        return next();
    res.redirect('/');
}