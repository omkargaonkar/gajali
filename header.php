<html>
<head>
  <title>गजाली</title>
  <link rel="stylesheet" href="quote.css">
  <script src="jquery-file.js"></script>
  <script src="jquery-1.11.2.min.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="emoji/emoji.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Dekko" rel="stylesheet">
  <link rel="stylesheet" href="timeline.css" type="text/css">
  <link rel="stylesheet" href="gajali.css" type="text/css">
  <link rel="icon" href="images/gicon.png" type="image/png">
  <script type="text/javascript">
  window.onload = function() {
    var txts = document.getElementsByTagName('textarea');
    for(var i = 0, l = txts.length; i < l; i++) {
      if(/^[0-9]+$/.test(txts[i].getAttribute("maxlength"))) {
        var func = function() {
          var len = parseInt(this.getAttribute("maxlength"));
          if(this.value.length > len) {
            alert('Maximum length exceeded: ' + len);
            this.value = this.value.substr(0, len);
            return false;
          }
        }
        // txts[i].onkeyup = func;
        // txts[i].onblur = func;
      }
    };
  }
  </script>
</head>
<header class="headerClass">
  <div class="panelhead">
    <a id="gajalilink" href="index.php"><label id="gajali">गजाली</label></a>
  </div>
</header>
