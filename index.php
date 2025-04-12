<?php

  /**
   * Include files that define global variables, db connections, and all functions
   */
  try {
      include("_config/config.php");
      include("_config/db_connect.php");
      include("_includes/header.php");
      include("_includes/functions.php");
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();     
  }

  // Get all parameters for the active season
  $active_season = get_active_season();
  
  // Set global variables for the active season parameters
  $season_id = $active_season["id"];
  $season_name = $active_season["name"];   

  // Set league id and season id varaibles from their global
  $league_id = $GLOBALS['league_id'];

  
  include("main-query-arrays-new.php");
  
?>


<!-- Add styling to leaderboard-->
<script>
  $(document).ready(function() {

    $('#leaderboard').DataTable({
      searching: false,
      paging: false,
      info: false,
      order: [[ 9, "desc" ]]
    });

  });
</script>

<!-- Add leaderboard sort arrow styles -->
<style>
  th.sortable {
    cursor: pointer;
    position: relative;
  }

  th.sortable::after {
    content: " ▲▼"; /* Display both arrows by default */
    font-size: 0.8em;
    position: absolute;
    right: 5px;
    color: #ccc; /* Light gray to indicate inactive state */
  }

  th.sortable.asc::after {
    content: " ▲"; /* Show only the ascending arrow when sorted */
    color: #ccc; /* Darker color to indicate active state */
  }

  th.sortable.desc::after {
    content: " ▼"; /* Show only the descending arrow when sorted */
    color: #ccc; /* Darker color to indicate active state */
  }
</style>






<?php
  include("navigation-new.php");

  include("banner-new.php");

  include("leader_board-new.php");

  include("league-team-tables-new.php");
?>











      <script>
        document.addEventListener("DOMContentLoaded", function () {
          const table = document.getElementById("leaderboard");

          // Add click event to each sortable column header
          table.querySelectorAll("th.sortable").forEach(header => {
            header.addEventListener("click", function () {
              const columnIndex = header.cellIndex; // Get the index of the clicked column
              const tbody = table.querySelector("tbody");
              const rows = Array.from(tbody.querySelectorAll("tr"));

              // Determine the current sort direction
              const isAscending = header.classList.contains("asc");
              table.querySelectorAll("th.sortable").forEach(th => th.classList.remove("asc", "desc")); // Reset classes
              header.classList.toggle("asc", !isAscending);
              header.classList.toggle("desc", isAscending);

              // Sort rows based on the column's numeric values
              rows.sort((a, b) => {
                const valA = parseFloat(a.cells[columnIndex]?.textContent.trim()) || 0;
                const valB = parseFloat(b.cells[columnIndex]?.textContent.trim()) || 0;
                return isAscending ? valA - valB : valB - valA; // Ascending or descending
              });

              // Append sorted rows back to the table body
              rows.forEach(row => tbody.appendChild(row));
            });
          });
        });
      </script>
  </body>
</html>


