<?php
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{

    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];

    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir("images/"))
        mkdir("images/", 0777);

    //comprobamos si el archivo ha subido
    $fecha = new DateTime();
    $name = $fecha->getTimestamp().".jpg";
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"images/".$name))
    {
        sleep(0.5);//retrasamos la petición 1/2 segundos
        echo $name;//devolvemos el nombre del archivo para pintar la imagen
    }
}else{
    throw new Exception("Error Processing Request", 1);
}
