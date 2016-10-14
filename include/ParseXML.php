<?php
/**
 * Created by PhpStorm.
 * User: adanchavez
 * Date: 15/02/16
 * Time: 09:20 PM
 */

class parseXML{

    private $xml;

    //funcion
    public function crearMetadatos($v_titulo, $v_idioma, $v_descripcion,$v_version, $v_autor){
        $xml = new DomDocument('1.0', 'UTF-8');

        $metadata = $xml->createElement('Metadata');
        $metadata = $xml->appendChild($metadata);

        $general = $xml->createElement('General');
        $general = $metadata->appendChild($general);
        //  $exercise->setAttribute('value', 'presentation');// Agregar un atributo exercise

        $titulo = $xml->createElement('Titulo', $v_titulo);
        $titulo = $general->appendChild($titulo);

        $idioma = $xml->createElement('idioma',$v_idioma);
        $idioma = $general->appendChild($idioma);

        $descripcion = $xml->createElement('descripcion',$v_descripcion);
        $descripcion = $general->appendChild($descripcion);

        $version = $xml->createElement('version',$v_version);
        $version = $general->appendChild($version);

        $autor = $xml->createElement('autor',$v_autor);
        $autor = $general->appendChild($autor);

        $xml->formatOutput = true;
        $el_xml = $xml->saveXML();
        $result = $xml->save('/'.$v_titulo .'/metadata.xml');

        // Check for successful insertion
        if ($result) {
            $response["result"] = "SUCCESSFULLY";

            // User successfully inserted
            return $response;
        } else {
            $response["result"] = "FAILED";
            return $response;
        }


    }



    //funcion
    public function addexercises(){


        //arreglo de tres ejercios
        $exercise_array = array(
            array(
                'image' => 'ignacio-manuel-altamirano.jpg',
                'information' => 'Ignacio Manuel Altamirano.',
                'question' => 'What is his name?'
            ),
            array(
                'image' => 'ignacio-manuel-altamirano.jpg',
                'information' => 'Ignacio Manuel Altamirano.',
                'question' => 'What is his name?'
            ),
            array(
                'image' => 'ignacio-manuel-altamirano.jpg',
                'information' => 'Ignacio Manuel Altamirano.',
                'question' => 'What is his name?'
            )
        );


        $xml = new DomDocument('1.0', 'UTF-8');


        //Nodo alumnos.
        $unit = $xml->createElement('unit');
        $nodo_contador = 1;
        foreach ($exercise_array as $vuelta) {
            //Nodo ejercicio.
            $exercise = $unit->createElement('exercise');

            //atributo del nodo
            $exercise->setAttribute('value', 'presentation');
            $nodo_contador++;

            //nodo nombre
            $image = $xml->createElement('image', $vuelta['image']);
            //Nombre apellido
            $information = $xml->createElement('information', $vuelta['information']);
            //Nombre nivel
            $question = $xml->createElement('question', $vuelta['question']);
            //Agregamos los nodos hijos.
            $image->appendChild($image);
            $information->appendChild($information);
            $question->appendChild($question);
            $exercise->appendChild($exercise);
        }

        //Agregamos todo el árbol al objeto.
        $xml->appendChild($unit);

        $xml->formatOutput = true;
        $el_xml = $xml->saveXML();
        $result = $xml->save('2.xml');

        // Check for successful insertion
        if ($result) {
            $response["result"] = CREATED_SUCCESSFULLY;

            // User successfully inserted
            return $response;
        } else {
            $response["result"] = CREATE_FAILED;
            return $response;
        }


    }

//Para leerlo
    function leer(){
       // echo "<p><b>Mostrar el contenido del Xml</b></p>";
        $xml = simplexml_load_file('2.xml');
        $salida ="";
        foreach($xml->exercise as $item){
            $salida .=
                "<b>Image:</b> " . $item->image . "<br/>".
                "<b>Information:</b> " . $item->information . "<br/>".
                "<b>Question:</b> " . $item->question . "<br/>";
        }
        return $salida;
    }




}



?>