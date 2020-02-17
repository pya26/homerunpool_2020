



<?php
include("../_config/config.php");
include("../_includes/header.php");
/*
$search_select = '<select class="mdb-select md-form" multiple searchable="Search here..">';
$search_select .= '<option value="" disabled selected>Choose your country</option>';
$search_select .= '<option value="1">USA</option>';
$search_select .= '<option value="2">Germany</option>';
$search_select .= '<option value="3">France</option>';
$search_select .= '<option value="3">Poland</option>';
$search_select .= '<option value="3">Japan</option>';
$search_select .= '</select>';
$search_select .= '<button class="btn-save btn btn-primary btn-sm">Save</button>';

print $search_select;
*/
?>

<script>
(function($) {
    $(function() {
        window.fs_test = $('.test').fSelect();
    });
})(jQuery);
</script>


<form method="post" action="scrap_process.php" name="scrap-form">
<select class="test" name="test[]" multiple="multiple">
        <optgroup label="Group A">
            <option value="1">Option 1</option>
            <option value="2" selected>Option 2</option>
            <option value="3">Option 3</option>
            <option value="4">Option 4</option>
            <option value="5">Option 5</option>
        </optgroup>
        <optgroup label="Group B">
            <option value="6" selected>Option 6</option>
            <option value="7">Option 7</option>
            <option value="8">Option 8</option>
            <option value="9">Option 9</option>
        </optgroup>
    </select>

    <input type="submit" value="submit">
  </form>
