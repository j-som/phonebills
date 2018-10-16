<?php 
foreach ($_POST as $name => $value) { 
echo "post $name: $value<br />"; 
} 
foreach ($_GET as $name => $value) { 
echo "get $name: $value<br />"; 
} 
?> 
