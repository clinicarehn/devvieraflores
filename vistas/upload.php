<?php   
$output = '';

if(isset($_FILES['file']['name'][0])){
    foreach($_FILES['file']['name'] as $keys=>$values){
        if(move_uploaded_file($_FILES['file']['tmp_name'][$keys],'./upload/'.$values)){
            $output .= "<div style='width:250px' class='ml-3'><img src='./upload/".$values."' class='w-100'></div>";
        }
    }
}

echo $output;
?> 