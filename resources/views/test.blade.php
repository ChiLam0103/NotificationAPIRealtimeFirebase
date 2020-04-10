<!DOCTYPE html>
<html>
<head>
	<title>Firebase Example</title>
</head>
<body>
<a href='#' id="dnperm">Reuqest Permission</a><br /><br />
Username: <input type="text" id="username" /><br/>
Message: <input type="text" id="message" /><br/>
<input type="button" id="btnGetMessage" value="Get Message" /><br/><br/>
<ul id="comment">
</ul>

<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.10/firebase.js"></script>
<script>

	var dnperm = document.getElementById('dnperm');

	dnperm.addEventListener('click',function(e){
		e.preventDefault();
		if(!window.Notification){
			alert('Not supported');
		}else{
			Notification.requestPermission().then(function(p){
				if(p=='denied'){
					alert('You denied to show notification');
				}else if(p=='granted'){
					alert('You allowed to show notification');
				}
			});
		}
	});


	function writeUserData(name, message) {
	  database.push().set({
	    username: name,
	    message: message
	  });
	}

	function renderUI(obj){
		var html='';
		
		var keys = Object.keys(obj);
		for(var i=0;i<keys.length;i++){
			html+="<li><b><i>"+obj[keys[i]].username+"</i></b> says: "+obj[keys[i]].message+"</li>";
		}
		$('#comment').html(html);
	}

	$('#btnGetMessage').click(function(){
		writeUserData($('#username').val(),$('#message').val());
		$('#username').val('');
		$('#message').val('');
	});

  // Initialize Firebase
  // TODO: Replace with your project's customized code snippet
  var config = {
    // apiKey: "",
    // authDomain: "",
    // databaseURL: "",
    // storageBucket: "",
    // messagingSenderId: "",
	apiKey: "AIzaSyDJrBbsFA7Kn3qE6KC2-6QoZGHqDxMzznE",
    authDomain: "laravelfirebase-7ab9c.firebaseapp.com",
    databaseURL: "https://laravelfirebase-7ab9c.firebaseio.com",
   // projectId: "laravelfirebase-7ab9c",
    storageBucket: "laravelfirebase-7ab9c.appspot.com",
    messagingSenderId: "642201691807",
    // appId: "1:642201691807:web:b8abd89be257ff837924aa",
    // measurementId: "G-0EY5HC6C5G"
  };
  firebase.initializeApp(config);

  var database = firebase.database().ref().child("users");

  database.on('value', function(snapshot) {
    renderUI(snapshot.val());
  });

  database.on('child_added', function(data) {
    	if(Notification.permission!=='default'){
					var notify;
					
						notify= new Notification('Tin nhắn mới từ '+data.val().username,{
							'body': data.val().message,
							'icon': 'images.jpg',
							'tag': data.getKey()
						});

						notify.onclick = function(){
							alert(this.tag);
						}

		}else{
			alert('Please allow the notification first');
		}
  });
</script>
</body>
</html>