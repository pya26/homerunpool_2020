<?php
include("../_config/config.php");
include("../_config/db_connect.php");
include("../_includes/functions.php");

include("../_includes/header.php");

?>
<html>
<head>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {

        	/*
            $("button").click(function() {
                $("h2").html("<p class='test'>click me</p>")
            });   

            $(".test").click(function(){
                alert();
            });
*/

var counter = 0;

$("button").click(function() {
    $("h2").append("<p class='test'>click me " + (++counter) + "</p>")
});

// With on():

$("h2").on("click", "p.test", function(){
    alert($(this).text());
});

        });

    </script>
</head>
<body>
    <h2></h2>
    <button>generate new element</button>
</body>
</html>



