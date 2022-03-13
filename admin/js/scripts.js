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

        e.preventDefault();

    });
    

    
    
    

    //datatable list of all players on main_content.php
    $('#datatablesListPlayers').DataTable();
     
    


    // Edit User Submission
    $("#editUserSubmit").button().click(function(){
        alert("button");
        //location.reload();
        $('#editUser').modal('hide');
    });


    

    

    


});


