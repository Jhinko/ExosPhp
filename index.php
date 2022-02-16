<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<div>
    <div>
        <h1> Je vais sauvegarder un fichier sur mon serveur 😎</h1>
    </div>
    <form action="#" method="POST" id="form_controller">
        <div>
            <input type="file" class="form-controller" name="_files" id="_files" multiple >
        </div>

        <div>
            <input type="submit" value="ENREGISTRER">
        </div>
    </form>
</div>


<script>
    $("#form_controller").on("submit", (e) =>  {
        e.preventDefault();
        fetchSaveFiles();
    });

var fileList = [];
var fileInput = document.getElementById('_files');
fileInput.addEventListener('change', function() {
    fileList = []
    for (var i = 0; i < fileInput.files.length; i++) {
        fileList.push(fileInput.files[i]);
    }
});

function fetchSaveFiles() {
    let authorized_firmat_file = [
        "image/jpeg",
        "image/jpg",
    ];

    if (fileList.length < 1) {
        alert("Add a img")
        return false;
    }
    if (fileList.length > 3) {
        alert("you can only upload a maximun of 3 files");
        return false;
    }

    let isImageFile = true;
    fileList.forEach(function(file) {
        if(authorized_firmat_file.includes(file.type)) {
            saveFiles(file);
        } else {
            alert("you can only upload .jpeg or .jpg files");
            isImageFile = false;
        }
    });
    return isImageFile;
}

function saveFiles(file) {
    var formData = new FormData();
    formData.append('file', file);
    formData.append('file_name', file.name);

    $.ajax({
        url: '/run.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function(response) {
            response = JSON.parse(response);
            if(response.error !== undefined) {
                return false;  
            }
            let mon_message = response[0] ? response [0] : "";
            let html = 
            `<div class="px-5">
                <span class="text-light">${mon_message}</span>
            </div>`;

            $("#form_controller").append($(html));
        },
        error: function(error) {
            console.log(error);
        }
    });
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

