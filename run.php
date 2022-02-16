<?php
define(
    'IS_AJAX',
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
);
if (!IS_AJAX) {
    die('Resticted acess');
}

$file               = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
$reponses           = ['error' => 'false'];
$file_name         = $_POST['file_name'];

if ($file !== '') {
    
    if (0 < $_FILES['file']['error']) {
        
        _addError();
        $reponses[] = "Erreur d\'upload";
    } else {
        $authorized_format_file = [
            "image/jpeg",
            "image/jpg",
        ];
        if (!in_array($_FILES['file']["type"], $authorized_format_file)) {
            $reponses[] = 'format invalide';
            _addError();
        }

        $folder_user = "img_" . ((string) rand(10000, 990000) . '_' . time());
       

        while (is_dir($folder_user)) {
            $folder_user = "img_" . ((string) rand(10000, 990000) . '_' . time());
        }

        $create_dir = mkdir($folder_user, 0755);


        if (move_uploaded_file($_FILES['file']['tmp_name'], $folder_user . '/' . $file_name)) {
            $reponses[] = 'Convert sucessfully';
        } else {
            $reponses[] = 'Convert with errors';
        }
    }
}


if ($reponses['error'] = 'false') {
    unset($reponses['error']);
}

print json_encode($reponses);

function _addError()
{
    $reponses['error'] = 'true';
    print json_encode($reponses);
    exit;
}
