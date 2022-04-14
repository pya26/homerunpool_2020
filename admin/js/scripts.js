/*!
    * Start Bootstrap - SB Admin v7.0.4 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});



$(function() {

    /*
     * Set date format and max date to select for jquery datepicker widget
     */
   
    $(".datepicker").datepicker({
        orientation: "bottom" // add this for placemenet
    });


    //datatable list of all players on main_content.php
    $('#datatablesListPlayers').DataTable();




    // Edit User Submission
    $("#editUserSubmit").button().click(function(){
        alert("button");
        //location.reload();
        $('#editUser').modal('hide');
    });




    // submit and process manual player edits from edit_player.php
    $("#update_player_manual").button().click(function(e){      

        var formData = {
            player_id: $('#validationPlayerID').val(),
            first_name: $('#validationFirstName').val(),
            last_name: $('#validationLastName').val(),
            position: $('#validationPrimaryPosition').val(),
            jersey_num: $('#validationJerseyNumber').val(),
            team_id: $('#validationTeamID').val(),
            team_abbr: $('#validationTeamAbbr').val(),
            height: $('#validationHeight').val(),
            weight: $('#validationWeight').val(),
            dob: $('#dob').val(),
            age: $('#validationAge').val(),
            birth_city: $('#validationBirthCity').val(),
            birth_country: $('#validationBirthCountry').val(),
            high_school: $('#validationHighSchool').val(),
            college: $('#validationCollege').val(),
            bats: $('#validationBats').val(),
            throw_hand: $('#validationThrows').val(),
            mlb_image: $('#validationMLBImage').val(),
            mlb_id: $('#validationMLBID').val(),
            status: $('#validationStatus').val(),
        };

        $.ajax({
                type: "POST",
                url: "edit_player_manual_process.php",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {



                if (!data.success) {
                    if (data.errors.player_id) {
                        /*$("#validationPlayerID").addClass("has-error");
                        $("#validationPlayerID").append(
                        '<div class="help-block">' + data.errors.name + "</div>"
                        );*/
                    }

                    if (data.errors.first_name) {
                        /*$("#validationFirstName").addClass("has-error");
                        $("#validationFirstName").append(
                        '<div class="help-block">' + data.errors.first_name + "</div>"
                        );*/
                    }

                    if (data.errors.last_name) {
                        /*$("#validationLastName").addClass("has-error");
                        $("#validationLastName").append(
                        '<div class="help-block">' + data.errors.last_name + "</div>"
                        );*/
                    }
                } else {
                    location.reload();
                    /*$("form").html(
                    '<div class="alert alert-success">' + data.message + "</div>"
                    );*/
                }


            //console.log(data);
            
        });

        e.preventDefault();
        
    });





    // update player edits via MySportsFeeds API from edit_player.php
    $("#update_player_msf").button().click(function(e){
        
        var formData = {
            player_id: $('#validationPlayerID').val(),
        };

        $.ajax({
                type: "POST",
                url: "edit_player_msf_process.php",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
            //console.log(data);
            location.reload();
        });

    });


    // update player edits via MySportsFeeds API from edit_player.php
    $("#add_league_season_draft").button().click(function(e){

        e.preventDefault();

        $league = $('#validationLeague').val();
        $season = $('#validationSeason').val();

        if($league == '' || $season == ''){
           window.location.href = "set_teams_players.php";
        } else {            
            window.location.href = "set_teams_players.php?league_id=" + $league + "&season_id=" + $season + "&class=0";
        }       

    });


    $("#addDraftedPlayer").button().click(function(e){

        e.preventDefault();

        $("#addDraftedPlayer").prop("disabled", true); 

        $league = $('#validationLeague').val();
        $season = $('#validationSeason').val();

        var drafted_player = $("#playerListDraft").val();
        var value = $('#playerlistOptions option').filter(function() { return this.value == drafted_player;}).data('value');

        $player_id = value ? value : 'No Match';
        

        $draft_order = $("#playerDraftOrder").val();
        $team_id = $("#team_id").val();
        
        var formData = {
            league_id: $league,
            season_id: $season,
            team_id: $team_id,
            player_id: $player_id,
            draft_order: $draft_order,
        };


        $.ajax({
                type: "POST",
                url: "add_drafted_player_process.php",
                data: formData,
                dataType: "json",
                encode: true
        }).done(function (data) {           
                    
                
            if (!data.success) {
                $("#addDraftedPlayer").prop("disabled", false); 
                
                console.log(data.message);
                e.preventDefault();
            } else {
                $("#addDraftedPlayer").prop("disabled", false); 
                console.log(data.message);                    
                window.location.href = "set_teams_players.php?league_id=" + $league + "&team_id=" + $team_id + "&season_id=" + $season + "&class=0";                   
            }

        });
        
        /*
        console.log($league);
        console.log($season);
        console.log($team_id);
        console.log($player_id);
        console.log($draft_order); 
        */      
         
    });

    


    
    

    /*$("#delete-button-container").on("click", "#deleteTeamPlayer", function() {

        console.log('you');
    });


    $("#deleteTeamPlayer").button().click(function(e){



    });*/

    //$("#deleteTeamPlayer").button().click(function(e){
    /*$("#deleteTeamPlayer").click(function(e) {

        

        e.preventDefault();

        
        e.preventDefault();

        $league = $('#validationLeague').val();
        $season = $('#validationSeason').val();
        $team_id = $("#team_id").val();

       

        $league_team_player_id = $(this).attr('data-id');

        console.log($league_team_player_id);

        return false;       
         
    });*/





    // 
    $("#add_league_teams_draft").button().click(function(e){

         //stop submit the form, we will post it manually.
         e.preventDefault();
        
        $league = $('#league_id').val();
        $season = $('#season_id').val();        
        $team_id = $('#validationTeams').val();
        $role_id = '2';       
        $status_id = 'A';

        var formData = {
            league_id: $league,
            season_id: $season,
            team_id: $team_id,
            role_id: $role_id,
            status_id: $status_id,
        };

        // disabled the submit button
        $("#add_league_teams_draft").prop("disabled", true);       
        
         
        $.ajax({
                type: "POST",
                url: "add_league_teams_draft_process.php",
                data: formData,
                dataType: "json",
                encode: true
        }).done(function (data) {           
                    
                
            if (!data.success) {
                $("#add_league_teams_draft").prop("disabled", false); 
                
                console.log(data.message);
                e.preventDefault();
            } else {
                $("#add_league_teams_draft").prop("disabled", false); 
                console.log(data.message);                    
                window.location.href = "set_teams_players.php?league_id=" + $league + "&season_id=" + $season + "&class=0";                   
            }

        });       
       

    });




    $("#submitActiveSeasonButton").button().click(function(e){

        //stop submit the form, we will post it manually.
        e.preventDefault();

        $active_season = $('#validationCustomActiveSeason').val();

        var formData = {
            active_season_id: $active_season,
        };

        // disabled the submit button
        $("#submitActiveSeasonButton").prop("disabled", true);

        $.ajax({
                type: "POST",
                url: "update_active_season_process.php",
                data: formData,
                dataType: "json",
                encode: true
        }).done(function (data) {

            if (!data.success) {
                $("#submitActiveSeasonButton").prop("disabled", false); 
                
                console.log(data.message);
                
            } else {
                $("#submitActiveSeasonButton").prop("disabled", false); 
                console.log(data.message);                    
                                  
            }


        });
        
        
    });




    $("#createUserFormButton").button().click(function(e){

        //stop submit the form, we will post it manually.
        e.preventDefault();

        $first_name = $('#validationCustom01').val();
        $last_name = $('#validationCustom02').val();
        $email = $('#validationCustomEmail').val();
        $mobile_phone = $('#validationCustomMobile').val();        
        $pwd = $('#validationCustomPassword').val();
        $pwd_confirm = $('#validationCustomPasswordConfirm').val();

        var formData = {
            first_name: $first_name,
            last_name: $last_name,
            email: $email,            
        };

        /*  mobile_phone: $mobile_phone,
            pwd: $pwd,
            pwd_confirm: $pwd_confirm,        
        */

        // disabled the submit button
        $("#createUserFormButton").prop("disabled", true);

        $.ajax({
                type: "POST",
                url: "add_user_process.php",
                data: formData,
                dataType: "json",
                encode: true
        }).done(function (data) {

            if (!data.success) {
                
                $("#createUserFormButton").prop("disabled", false);                
                console.log(data.message);                
                
            } else {

                $("#createUserFormButton").prop("disabled", false); 
                console.log(data.message);               
                                  
            }

        });
            
            
    });


        
    

        $("#createTeamButton").button().click(function(e){
            
            //stop submit the form, we will post it manually.
            e.preventDefault();
            
            $reg_id = $('#validationUser').val();
            $team_name = $('#validationTeamName').val();
            $role_id = $('#validationRole').val();

             var formData = {
                reg_id: $reg_id,
                team_name: $team_name,
                role_id: $role_id,            
            };

            // disabled the submit button
            $("#createTeamButton").prop("disabled", true);


            $.ajax({
                type: "POST",
                url: "create_teams_process.php",
                data: formData,
                dataType: "json",
                encode: true
            }).done(function (data) {

                if (!data.success) {
                    
                    $("#createTeamButton").prop("disabled", false);                
                    console.log(data.message);                
                    
                } else {

                    $("#createTeamButton").prop("disabled", false); 
                    console.log(data.message); 
                    location.reload();              
                                      
                }

            });

        });




    $("#seed_hrs_form_submit").button().click(function(e){  
        
        e.preventDefault();

        $("#seed_hrs_form_submit").prop("disabled", true);

        //var url_string = '?';

        $selected_season = $('#select_season').val();

        /*if($selected_season !== '0'){
            url_string += 'season=' + $selected_season;
            console.log(url_string); 
        } else {
            url_string += '';
            console.log(url_string);
        }*/

        $("#Preloader").show();


        var formData = {
            selected_season: $selected_season,
        };


        $.ajax({
            type: "POST",
            url: "seed_hr_tables_process.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function (data) {
            

            if (!data.success) {
                
                $("#seed_hrs_form_submit").prop("disabled", false);

                $("#Preloader").hide();

                console.log('error!');                
                
            } else {

                $("#seed_hrs_form_submit").prop("disabled", false); 

                $("#Preloader").hide();

                $("#seed_hr_table_success_msg").show();

                console.log(data); 
                //location.reload();              
                                  
            }

        });   
         



    });




    $("#daily_hr_form_submit").button().click(function(e){  
            
        e.preventDefault();

        $hr_date = $('#hr_date').val();

        var formData = {
            hr_date: $hr_date,
        };
        

        $.ajax({
            type: "POST",
            url: "update_daily_hrs_process.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function (data) {
            

            if (!data.success) {
                
                /*$("#seed_hrs_form_submit").prop("disabled", false);

                $("#Preloader").hide();*/

                console.log('error!');                
                
            } else {

                console.log(data.homeruns);

                var hrs_array = data.homeruns;
                var newHTML = [];

                $.each(hrs_array, function(index, value) {
                    newHTML.push(value.player_id + ' ' + value.player_name + ' ' + value.homerun_num);
                });

                $("#daily_hr_form_results").html(newHTML.join("<br />"));
                
                

                
                /*$.each( data.homeruns, function( key, value ) {

                     document.getElementById("daily_hr_form_results").textContent = data.homeruns.player_id;
                   
                   
                    
                });*/
        

               

                //$('#daily_hr_form_results').html(display_daily_hrs);
                //$('#daily_hr_form_results').html(data.homeruns);
                //document.getElementById("display-array").textContent = array.join(", ");

                /*$("#seed_hrs_form_submit").prop("disabled", false); 

                $("#Preloader").hide();

                $("#seed_hr_table_success_msg").show();

                console.log(data); 
                //location.reload(); */             
                                  
            }

        });

        //console.log($hr_date); 

    }); 




    







});


