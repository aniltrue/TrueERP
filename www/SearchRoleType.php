<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Kullanıcı Rolü";
$PageName = "PAGE_DEV_ROLE_TYPES_SEARCH";
$SearchSQL = "SELECT * FROM UserTitleRoles natural join (UserRoleTypes u left join Pages p ON u.PageName = p.PageName)";
$OrderSQL = "ORDER BY RoleName, RoleDescription ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

// TODO

?>

<?php include('class/Search.php'); ?>
