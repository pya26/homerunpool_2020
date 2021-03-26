$(function() {

	/*
	var obj = [];
	$('#add_league_team_form').submit(function(event){
  	obj.push($('#player_ids').val());

    console.log(obj);

    event.preventDefault();
  });
*/

	/*$('#login_form').on('submit', function(e){
		$('#exampleModalCenter').modal('show');
		console.log('stay open');
			e.preventDefault();
		});*/

/*
	 * Set date format and max date to select for jquery datepicker widget
	 */
$( "#datepicker" ).datepicker({
		dateFormat: 'yymmdd'
	});



$("#date").datepicker({
		dateFormat: 'yymmdd',
	});
/*
	$("#date_for_season").datepicker({
		dateFormat: 'yymmdd',
		maxDate: new Date()
	});
*/
	$("#create_account").submit(function(event){

		$('#error_msg').html("");
		$('#CreateAccountModal').modal('show');

		event.preventDefault();

		var $first_name = $('#first_name').val();
		var $last_name = $('#last_name').val();
		var $email = $('#email').val();
		var $pwd = $('#password1').val();

		console.log('');


	});


	$("#login_form").submit(function(event){

		$('#error_msg').html("");

		$('#LogInModal').modal('show');

		event.preventDefault();

		var email = $('#email_uname').val();
		var pwd = $('#password1').val();

		$.ajax(
			'login_process.php?email=' + email + '&pwd=' + pwd,
			{
				success: function(data) {
					var jsonData = JSON.parse(data);

					if(jsonData.reg_id == 0){
						$display_html_error_msg = '<div class="alert alert-dismissible alert-danger">';
						$display_html_error_msg += '<button type="button" class="close" data-dismiss="alert">×</button>';
						$display_html_error_msg += jsonData.msg;
						$display_html_error_msg += '</div>';
						$('div#error_msg').html($display_html_error_msg);
						console.log(jsonData.reg_id);
					} else {
						$('#LogInModal').modal('hide');
						location.reload();
					}

				},
				error: function() {
					$display_html_error_msg = '<div class="alert alert-dismissible alert-danger">';
					$display_html_error_msg += '<button type="button" class="close" data-dismiss="alert">×</button>';
					$display_html_error_msg += 'An error ocurred during your login process. Please try logging in again';
					$display_html_error_msg += '</div>';
					$('#error_msg').html($display_html_error_msg);
					//alert('There was some error performing the AJAX call to get the season!');
					//error_msg
					 //$('<div id="errors"/>').html(errors).appendTo('.modal-body');
					 //$('#errorModal').modal('show');
				}
			}
		);

	});


	$("#forgot_form").submit(function(event){

		$('#ForgotModal').modal('show');

		event.preventDefault();

		var email = $('#email').val();

		$.ajax(
			'forgot_password_process.php?email=' + email,
			{
				success: function(data) {
					var jsonData = JSON.parse(data);

					console.log(jsonData.msg);


					if(jsonData.msg_code == 0){
						$display_html_error_msg = '<div class="alert alert-dismissible alert-danger">';
						$display_html_error_msg += '<button type="button" class="close" data-dismiss="alert">×</button>';
						$display_html_error_msg += jsonData.msg;
						$display_html_error_msg += '</div>';
						$('div#error_msg').html($display_html_error_msg);
					} else if(jsonData.msg_code == 1) {
						$display_html_error_msg = '<div class="alert alert-dismissible alert-success">';
						$display_html_error_msg += '<button type="button" class="close" data-dismiss="alert">×</button>';
						$display_html_error_msg += jsonData.msg;
						$display_html_error_msg += '</div>';
						$('div#error_msg').html($display_html_error_msg);
						//$('#LogInModal').modal('hide');
						//location.reload();
					} else if(jsonData.msg_code == 2) {
						$display_html_error_msg = '<div class="alert alert-dismissible alert-danger">';
						$display_html_error_msg += '<button type="button" class="close" data-dismiss="alert">×</button>';
						$display_html_error_msg += jsonData.msg;
						$display_html_error_msg += '</div>';
						$('div#error_msg').html($display_html_error_msg);
						console.log(jsonData.msg);
						//$('#LogInModal').modal('hide');
						//location.reload();
					}

				},
				error: function() {

				}


			}

		);




		//console.log(email);

	});





	/*
	 * reset display results on 'get_apis_params.php' when page is refreshed
	 */
    $('#api_menu').val('');

    /*
	 * use ajax to dynamically display api parameters for each api name when selected from the select menu on 'get_apis_params.php'
	 */
	$( "#api_menu" ).change(function(e) {

		event.preventDefault();

		$api_id = $( "#api_menu" ).val();

		$.ajax(
			'get_api_description.php?api_id=' + $api_id,
			{

				success: function(data) {

					var jsonData = JSON.parse(data);

					var api_info = jsonData.api_name + "<br />";
					api_info += jsonData.api_url  + "<br />";
					api_info += jsonData.api_desc  + "<br />";

					var api_info_form = "<form id='target'>";
					$.each(jsonData, function( index, value ){
						if(value.api_param_name){
							api_info += '<input type="checkbox" id="api_param_filter" name="api_param_filter" value="' + value.api_param_id + '">' + value.api_param_name + ' -- ' + value.api_param_filter + '<br />';
						}

					});

					api_info_form += api_info + '<input type="submit" value="A submit button">';

					$('.result').html(api_info_form);

				},
				error: function() {
					alert('There was some error performing the AJAX call!');
				}
			}
		);
	});

	/**
	 * select_daily_homeruns.php
	 */


	 $("#daily_hr_form").validate({
		//debug: true,
		rules: {
			date: "required"
		},
		messages: {
			date: "  Enter a date"
		},


		//Submit Handler Function
        submitHandler: function (form) {

        	var date = $('#date').val();

			$('#daily_hr_form_results').html('');

			$("#Preloader").show();


			$.ajax(
			'/sandbox/homerunpool_2020/front_office/update_daily_homeruns_process.php?date=' + date,
			{
				success: function(data) {

					var valid_json_data = IsValidJSONString(data);

					console.log(valid_json_data);
					//console.log(data);

					if(valid_json_data){

						var jsonData = JSON.parse(data);
						//var jsonData = data;

						var display_daily_hrs = '';

						$.each(jsonData.gamelogs, function( index, value ){

							var player_id = value.player.id;
							var player_firstname = value.player.firstName;
							var player_lastname = value.player.lastName;
							var homeruns = value.stats.batting.homeruns;

							if(homeruns > 0){
								display_daily_hrs += player_id + ' -- ' + player_firstname + ' ' + player_lastname + ' -- ' + homeruns + '<br />';
							}
						});

						$('#daily_hr_form_results').html(display_daily_hrs);

					 	$("#Preloader").hide();

					} else {


						$('#daily_hr_form_results').html('No data to display');


						$("#Preloader").hide();
					}



				},

				error: function() {

					alert('There was some error performing the AJAX call to get daily homeruns!');
					$("#Preloader").hide();
				}
			});

        }
	});


	 /*
	$("#daily_hr_form").submit(function(e){

		event.preventDefault();

		var date = $('#date').val();

		$('#daily_hr_form_results').html('');

		$("#Preloader").show();
		$.ajax(
			'update_daily_homeruns_process.php?date=' + date,

			{
				success: function(data) {

					var valid_json_data = IsValidJSONString(data);

					console.log(valid_json_data);
					console.log(data);

					if(valid_json_data){

						var jsonData = JSON.parse(data);
						//var jsonData = data;

						var display_daily_hrs = '';

						$.each(jsonData.gamelogs, function( index, value ){

							var player_id = value.player.id;
							var player_firstname = value.player.firstName;
							var player_lastname = value.player.lastName;
							var homeruns = value.stats.batting.homeruns;

							if(homeruns > 0){
								display_daily_hrs += player_id + ' -- ' + player_firstname + ' ' + player_lastname + ' -- ' + homeruns + '<br />';
							}
						});

						$('#daily_hr_form_results').html(display_daily_hrs);

					 	$("#Preloader").hide();

					} else {


						$('#daily_hr_form_results').html('No data to display');


						$("#Preloader").hide();
					}



				},

				error: function() {

					alert('There was some error performing the AJAX call to get daily homeruns!');
					$("#Preloader").hide();
				}
			}
		);
	});
*/





	$('#select_season_form').submit(function(e){

		$('#display_season').val('');

		event.preventDefault();

		var date = $('#date_for_season').val();
		var url = $('#url').val() + date;

		//console.log(date);
		//console.log(url);


		$.ajax(
			'get_season.php?url=' + url,
			{
				success: function(data) {
					var jsonData = JSON.parse(data);
					if(jsonData && jsonData.seasons[0]){
						//console.log(jsonData.seasons[0].slug);
						$('#display_season').html(jsonData.seasons[0].slug);
					} else {
						//console.log('Season not defined for this date yet.');
						$('#display_season').html('Season not defined for this date.');
					}
				},
				error: function() {
					alert('There was some error performing the AJAX call to get the season!');
				}
			}
		);
	});




	function IsValidJSONString(str) {
		try {
			JSON.parse(str);
		} catch (e) {
			return false;
		}

		return true;
	}




	/**
	 * select_daily_homeruns.php
	 */


	$("#check_all_roster_status").click(function () {
        $(".rosterStatusCheckBoxClass").prop('checked', $(this).prop('checked'));
    });
    $("#check_all_positions").click(function () {
        $(".positionCheckBoxClass").prop('checked', $(this).prop('checked'));
    });


    $("#seed_players_form").submit(function(e){

		event.preventDefault();

		$('#player_seed_display_msg').html('');

		var url_string = '?';

		var season = $("#select_season option:selected" ).text();
		if(season !== 'Choose one'){
			url_string += 'season=' + season + '&';
		} else {
        	url_string += '';
        }


		var roster_statuses = new Array();
		$("input:checkbox[name=roster_status]:checked").each(function(){
		    roster_statuses.push($(this).val());
		});

		if(roster_statuses != ''){
        	url_string += 'rosterstatus=' + roster_statuses.join(",") + '&';
        } else {
        	url_string += '';
        }


	    var positions = new Array();
        $("input:checkbox[name=position]:checked").each(function(){
            positions.push($(this).val());
        });
        if(positions != ''){
        	url_string += 'position=' + positions.join(",");
        } else {
        	url_string += '';
        }

        $("#Preloader").show();
        //console.log(url_string);

        $.ajax(
			'/sandbox/homerunpool_2020/front_office/seed_players_table_process.php' + url_string,
			{

				success: function(data) {

					var jsonData = JSON.parse(data);

					$("#Preloader").hide();

					$('#player_seed_display_msg').html(jsonData);



				},
				error: function() {
					$("#Preloader").hide();
					alert('There was some error performing the AJAX call!');
				}
			}
		);





	});

/*
    $("#seed_players_form").validate({

		rules: {
			select_season: "required",
			'roster_status[]':{
				required: true,
				minlength: 1
			},
			'position[]':{
				required: true,
				minlength: 1
			}
		},
		messages: {
			select_season: "  Select a season",
			'roster_status[]': "Please select at least 1 roster status.",
			'position[]': "Please select at least 1 position.",
		},

		//Submit Handler Function
        submitHandler: function (form) {

        	$('#player_seed_display_msg').html('');

			var url_string = '?';

			var season = $("#select_season option:selected" ).text();
			if(season !== 'Choose one'){
				url_string += 'season=' + season + '&';
			} else {
	        	url_string += '';
	        }


			var roster_statuses = [];

	        $.each($("input[name='roster_status']:checked"), function(){
	            roster_statuses.push($(this).val());
	        });

	        if(roster_statuses != ''){
	        	url_string += 'rosterstatus=' + roster_statuses.join(",") + '&';
	        } else {
	        	url_string += '';
	        }

	        var positions = [];
	        $.each($("input[name='position']:checked"), function(){
	            positions.push($(this).val());
	        });
	        if(positions != ''){
	        	url_string += 'position=' + positions.join(",");
	        } else {
	        	url_string += '';
	        }

	        $("#Preloader").show();

        	$.ajax(
			'http://localhost/sandbox/homerunpool_2020/front_office/seed_players_table_process.php' + url_string,

				{
					success: function(data) {

						var jsonData = JSON.parse(data);

						//console.log(jsonData);

						$("#Preloader").hide();

						$('#player_seed_display_msg').html(jsonData);

					},

					error: function() {

						alert('There was some error performing the AJAX call to get seed the player database!');

						$("#Preloader").hide();
					}
				}
			);
        }

	});
*/

    /*
	$("#seed_players_form").submit(function(e){

		event.preventDefault();


		$('#player_seed_display_msg').html('');

		var url_string = '?';

		var season = $("#select_season option:selected" ).text();
		if(season !== 'Choose one'){
			url_string += 'season=' + season + '&';
		} else {
        	url_string += '';
        }

		var roster_statuses = [];
        $.each($("input[name='roster_status']:checked"), function(){
            roster_statuses.push($(this).val());
        });
        if(roster_statuses != ''){
        	url_string += 'rosterstatus=' + roster_statuses.join(",") + '&';
        } else {
        	url_string += '';
        }

        var positions = [];
        $.each($("input[name='position']:checked"), function(){
            positions.push($(this).val());
        });
        if(positions != ''){
        	url_string += 'position=' + positions.join(",");
        } else {
        	url_string += '';
        }




        $("#Preloader").show();
        console.log(url_string);
        $.ajax(
			'seed_players_table_process.php' + url_string,

			{
				success: function(data) {

					var jsonData = JSON.parse(data);

					console.log(jsonData);

					$("#Preloader").hide();

					$('#player_seed_display_msg').html(jsonData);

				},

				error: function() {

					alert('There was some error performing the AJAX call to get seed the player database!');

					$("#Preloader").hide();
				}
			}
		);

	});
	*/

	$("#seed_hrs_form").validate({
		//debug: true,
		rules: {
			select_season: "required"
		},
		messages: {
			select_season: "  Select a season"
		},


		submitHandler: function (form) {


			var url_string = '?';

			var season = $("#select_season option:selected" ).text();
			if(season !== 'Choose one'){
				url_string += 'season=' + season;
			} else {
	        	url_string += '';
	        }

	        $("#Preloader").show();

	        $.ajax(
				'seed_hr_tables_process.php' + url_string,

				{
					success: function(data) {

						var jsonData = JSON.parse(data);

						$("#Preloader").hide();

						$('#hr_seed_display_msg').html(jsonData);

					},

					error: function() {

						alert('There was some error performing the AJAX call to seed the HR databases!');

						$("#Preloader").hide();
					}
				}
			);


		}

	});



	/*
	$("#seed_hrs_form").submit(function(e){

		event.preventDefault();

		var url_string = '?';

		var season = $("#select_season option:selected" ).text();
		if(season !== 'Choose one'){
			url_string += 'season=' + season;
		} else {
        	url_string += '';
        }

        $("#Preloader").show();

        $.ajax(
			'seed_hr_tables_process.php' + url_string,

			{
				success: function(data) {

					var jsonData = JSON.parse(data);

					$("#Preloader").hide();

					$('#hr_seed_display_msg').html(jsonData);

				},

				error: function() {

					alert('There was some error performing the AJAX call to seed the HR databases!');

					$("#Preloader").hide();
				}
			}
		);

    });
*/














	$( "#menu_div_1" ).click(function() {
	  $( "#sub_menu_div_1" ).slideToggle("slow", function(){
	      //alert("The slideToggle() method is finished!");
	    });
	});
	$( "#menu_div_2" ).click(function() {
	  $( "#sub_menu_div_2" ).slideToggle("slow", function(){
	      //alert("The slideToggle() method is finished!");
	    });
	});



});
