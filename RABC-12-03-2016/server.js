var express = require('express');
//var path = require('path');
var favicon = require('serve-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');
var session		=	require('express-session');
var mysql = require('mysql');
var passport  = require('passport');
var TwitterStrategy  = require('passport-twitter').Strategy;
var app = express();
var sess;

var http = require('http'),
    fs = require('fs'),
    ccav = require('./ccavutil.js'),
    qs = require('querystring'),
    ccavReqHandler = require('./ccavRequestHandler.js'),
    ccavResHandler = require('./ccavResponseHandler.js');
	
	
/*
 app.set('views', path.join(__dirname, 'public'));
app.engine('html', require('ejs').renderFile);
app.set('view engine', 'html'); 

//app.use(express.static('public'));
*/
app.use(express.static('public'));
app.set('views', __dirname + '/public');
app.engine('html', require('ejs').renderFile);


app.use('favicon',__dirname+'/public/favicon.ico');
app.use(logger('dev'));
app.use(cookieParser());
//app.use(express.static(path.join(__dirname, 'public')));

app.use(session({secret: 'ssshhhhh',saveUninitialized: true,resave: true}));
app.use(bodyParser.json());      
//app.use(bodyParser.urlencoded({extended: true}))

app.use(passport.initialize());
app.use(passport.session());
var dbconfig = require('./config/dbconfig');

var con = mysql.createConnection({
	host: "localhost",
	user: "root",
	password: "",
	database: "readabook"
});
con.connect(function(err) {
  if (err) {
    console.error('error connecting: ' + err.stack);
    return;
  }
});


require('./routes/routes.js')(app,passport,con);
require('./routes/users.js')(app,passport,con);
require('./routes/startChallenge.js')(app,passport,con);
//require('./routes/ccavenue_payment.js')(app,passport,con);

app.get('/about', function (req, res){
    	res.render('dataFrom.html');
});

app.post('/ccavRequestHandler', function (request, response){
	ccavReqHandler.postReq(request, response);
});


app.post('/ccavResponseHandler', function (request, response){
		console.log(response);
		console.log(request);
        ccavResHandler.postRes(request, response);
});
app.post('/ccavRequestHandlerFinal', function (request, response){	
	ccavReqHandler.postReqFinal(request, response);
});


app.post('/ccavResponseHandlerFinal', function (request, response){
        ccavResHandler.postResFinal(request, response, con);
});	
	
   // used to serialize the user for the session
    passport.serializeUser(function(user, done) {
       console.log(user);
      done(null, user);
     //   done(null, user.id);
    });

    // used to deserialize the user
    passport.deserializeUser(function(id, done) {
       done(null, id);
    });
    
   
    // =========================================================================
    // TWITTER =================================================================
    // =========================================================================
    passport.use(new TwitterStrategy({
        consumerKey     : dbconfig.twitterAuth.TWITTER_KEY,
        consumerSecret  : dbconfig.twitterAuth.TWITTER_SECRET,
        callbackURL     : dbconfig.twitterAuth.callbackURL

    },
    function(token, tokenSecret, profile, done) {      
        process.nextTick(function() {		
			var datas = {};
			datas.id=profile.id;
			datas.first_name=profile.displayName;
			datas.last_name="";
			datas.email=profile.email;
			datas.img=profile.photos[0].value;
			var query = "SELECT * FROM `users` WHERE `twitter_id` = '"+datas.id+"'";	
			con.query(query, function(err, rows){
				if(err) throw err;
				
				if(rows.length == 0){
					var str = datas.img;
					var new_img = str.replace(/_normal/g, "");
					insert_query = "INSERT INTO `users` (`first_name`,`last_name`,`email_id`,`twitter_id`,`profile_image`) VALUES ('"+datas.first_name+"','"+datas.last_name+"','"+datas.email+"','"+datas.id+"','"+new_img+"')";
						con.query(insert_query, function(err, rows){
							if(err) throw err;	
						});
				}else{
					var str = datas.img;
					var new_img = str.replace(/_normal/g, "");
					update_query = "UPDATE `users` SET `profile_image` = '"+new_img+"' , `first_name` = '"+datas.first_name +"', `last_name` = '"+datas.last_name+"' WHERE `twitter_id` = '"+datas.id+"'"					
					con.query(update_query, function(err, rows){
						if(err) throw err;
					});
				}
			});
          done(null, datas);          
		});

    }));


app.listen(5000);
/* 
var debug = require('debug')('readabookchallenge:server');
var http = require('http');



//var port = normalizePort(process.env.PORT || '5000');
var port = normalizePort('5000');
app.set('port', port);


var server = http.createServer(app);



server.listen(port);
server.on('error', onError);
server.on('listening', onListening);



function normalizePort(val) {
  var port = parseInt(val, 10);

  if (isNaN(port)) {
    // named pipe
    return val;
  }

  if (port >= 0) {
    // port number
    return port;
  }

  return false;
}



function onError(error) {
  if (error.syscall !== 'listen') {
    throw error;
  }

  var bind = typeof port === 'string'
    ? 'Pipe ' + port
    : 'Port ' + port;

  // handle specific listen errors with friendly messages
  switch (error.code) {
    case 'EACCES':
      console.error(bind + ' requires elevated privileges');
      process.exit(1);
      break;
    case 'EADDRINUSE':
      console.error(bind + ' is already in use');
      process.exit(1);
      break;
    default:
      throw error;
  }
}



function onListening() {
  var addr = server.address();
  var bind = typeof addr === 'string'
    ? 'pipe ' + addr
    : 'port ' + addr.port;
  debug('Listening on ' + bind);
}
	 */

//module.exports = app;
