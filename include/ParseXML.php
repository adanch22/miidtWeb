<?php
/**
 * Created by PhpStorm.
 * User: adanchavez
 * Date: 15/02/16
 * Time: 09:20 PM
 */

class parseXML{

    private $xml;

    //funciones
    public function addMetadata($v_title, $v_language, $v_description,$v_version, $v_author, $v_book_name){
        //crear carpeta del oa
        $v_book_name = str_replace(' ', '', $v_book_name);
        $v_book_name = strtr($v_book_name,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');


        $v_title = str_replace(' ', '', $v_title);
        $v_title = strtr($v_title,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

        $carpeta = '../levels/level1/' . $v_book_name.'/'. $v_title;
        $carpeta2 = '../levels/level1/' . $v_book_name . '/content.xml';

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }



        //crear metadatos
        $xml = new DomDocument('1.0', 'UTF-8');
        $metadata = $xml->createElement('Metadata');
        $metadata = $xml->appendChild($metadata);
        $general = $xml->createElement('General');
        $general = $metadata->appendChild($general);
        //  $exercise->setAttribute('value', 'presentation');// Agregar un atributo exercise
        $title = $xml->createElement('Title', $v_title);
        $title = $general->appendChild($title);
        $language = $xml->createElement('language',$v_language);
        $language = $general->appendChild($language);
        $description = $xml->createElement('description',$v_description);
        $description = $general->appendChild($description);
        $version = $xml->createElement('version',$v_version);
        $version = $general->appendChild($version);
        $autor = $xml->createElement('author',$v_author);
        $autor = $general->appendChild($autor);
        $xml->formatOutput = true;
        $el_xml = $xml->saveXML();
        $result = $xml->save('../levels/level1/' . $v_book_name .'/' . str_replace(' ', '', $v_title) . '/metadata.xml');


        //crear archivo de contenido
        $result2 = $this->addcontent($v_title, $v_description, $v_author, $carpeta2);

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


    function addcontent($v_title, $v_description,$v_author, $filecontent){

        $v_titlex = str_replace(' ', '', $v_title);

        if(file_exists($filecontent)){

            $read_content = $this->leerContent($filecontent);

            /*---- crear guardados  */
            $xml = new DomDocument('1.0', 'UTF-8');
            $book = $xml->createElement('book');
            $book = $xml->appendChild($book);

            foreach ($read_content as $vuelta) {

                $unit = $xml->createElement('unit');
                $unit = $book->appendChild($unit);
                // Agregar un atributo
                $unit->setAttribute('value', $vuelta['value']);

                $image = $xml->createElement('title', $vuelta['title']);
                $image = $unit->appendChild($image);

                $information = $xml->createElement('description', $vuelta['information']);
                $information = $unit->appendChild($information);

                $author = $xml->createElement('author',$vuelta['author']);
                $author = $unit->appendChild($author);
            }

            //agregar nuevo
            $unit = $xml->createElement('unit');
            $unit = $book->appendChild($unit);
            // Agregar un atributo
            $unit->setAttribute('value',$v_titlex . '/oa' );

            $image = $xml->createElement('title', $v_title);
            $image = $unit->appendChild($image);

            $information = $xml->createElement('description', $v_description);
            $information = $unit->appendChild($information);

            $author = $xml->createElement('author',$v_author);
            $author = $unit->appendChild($author);

            $xml->formatOutput = true;
            $el_xml = $xml->saveXML();
            $result = $xml->save($filecontent);

        }else{
            /*---- crear nuevo  */

            $xml = new DomDocument('1.0', 'UTF-8');
            $book = $xml->createElement('book');
            $book = $xml->appendChild($book);

            //agregar nuevo
            $unit = $xml->createElement('unit');
            $unit = $book->appendChild($unit);
            // Agregar un atributo
            $unit->setAttribute('value',$v_titlex . '/oa' );

            $image = $xml->createElement('title', $v_title);
            $image = $unit->appendChild($image);

            $information = $xml->createElement('description', $v_description);
            $information = $unit->appendChild($information);

            $author = $xml->createElement('author',$v_author);
            $author = $unit->appendChild($author);

            $xml->formatOutput = true;
            $el_xml = $xml->saveXML();
            $result = $xml->save($filecontent);


        }

        return $result;


    }


    //funcion
    public function addexercises($learningobject, $exercise_type, $exercise_name, $exercise_description,
                                 $exercise_question, $exercise_answer1,$exercise_answer2,$exercise_answer3, $exercise_ok){

        $learningobject = str_replace(' ', '', $learningobject);
        $learningobject = strtr($learningobject,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

        $name_file = '../levels/level1/MetodosNumericos/'. $learningobject . '/oa.xml';

        if (file_exists($name_file))
        {

            $read_exercises = $this->leer($name_file);

            /*---- crear guardados  */
            $xml = new DomDocument('1.0', 'UTF-8');
            $unit = $xml->createElement('unit');
            $unit = $xml->appendChild($unit);

            foreach ($read_exercises as $vuelta) {



               if($vuelta['type'] == 'questionary'){

                   $exercise = $xml->createElement('exercise');
                   $exercise = $unit->appendChild($exercise);
                    // Agregar un atributo
                    $exercise->setAttribute('value', 'questionary');

                    $image = $xml->createElement('title', $vuelta['image']);
                    $image = $exercise->appendChild($image);

                   $information = $xml->createElement('information', $vuelta['information']);
                    $information = $exercise->appendChild($information);
                    $question = $xml->createElement('question',$vuelta['question']);
                    $question = $exercise->appendChild($question);
                    // Agregar un atributo
                    $question->setAttribute('value', $vuelta['atrquestion']);


                }else if($vuelta['type'] == 'multipleoptions'){

                    $exercise = $xml->createElement('exercise');
                    $exercise = $unit->appendChild($exercise);
                    // Agregar un atributo
                    $exercise->setAttribute('value', 'multipleoptions');

                    $image = $xml->createElement('title', $vuelta['image']);
                    $image = $exercise->appendChild($image);

                    $information = $xml->createElement('information', $vuelta['information']);
                    $information = $exercise->appendChild($information);

                    $question = $xml->createElement('question',$vuelta['question']);
                    $question = $exercise->appendChild($question);
                    // Agregar un atributo
                    $question->setAttribute('value', $vuelta['atrquestion']);

                    $answer = $xml->createElement('answer1',$vuelta['anwer1']);
                    $answer = $exercise->appendChild($answer);

                    $answer = $xml->createElement('answer2',$vuelta['anwer2']);
                    $answer = $exercise->appendChild($answer);

                    $answer = $xml->createElement('answer3',$vuelta['anwer3']);
                    $answer = $exercise->appendChild($answer);

                 }else if($vuelta['type'] == 'resource'){
                   $exercise = $xml->createElement('resource');
                   $exercise = $unit->appendChild($exercise);
                   // Agregar un atributo
                   $exercise->setAttribute('value', 'resource');
                   $title = $xml->createElement('title', $vuelta['image']);
                   $title = $exercise->appendChild($title);
                   $image = $xml->createElement('resourcetype', $vuelta['resourcetype']);
                   $image = $exercise->appendChild($image);
                   $information = $xml->createElement('file', $vuelta['information']);
                   $information = $exercise->appendChild($information);

               }



            }


            /*---- agregar nuevo ----*/
            if($exercise_type == 1){
                $exercise = $xml->createElement('exercise');
                $exercise = $unit->appendChild($exercise);
                // Agregar un atributo
                $exercise->setAttribute('value', 'questionary');

                $image = $xml->createElement('title', $exercise_name);
                $image = $exercise->appendChild($image);

                $information = $xml->createElement('information', $exercise_description);
                $information = $exercise->appendChild($information);
                $question = $xml->createElement('question',$exercise_question);
                $question = $exercise->appendChild($question);
                // Agregar un atributo
                $question->setAttribute('value', $exercise_answer1);


            }else{

                //codigo si es ejercio de opcion multiple
                $exercise = $xml->createElement('exercise');
                $exercise = $unit->appendChild($exercise);
                // Agregar un atributo
                $exercise->setAttribute('value', 'multipleoptions');

                $image = $xml->createElement('title', $exercise_name);
                $image = $exercise->appendChild($image);

                $information = $xml->createElement('information', $exercise_description);
                $information = $exercise->appendChild($information);

                $question = $xml->createElement('question',$exercise_question);
                $question = $exercise->appendChild($question);
                // Agregar un atributo
                $question->setAttribute('value', $exercise_ok);

                $answer = $xml->createElement('answer1',$exercise_answer1);
                $answer = $exercise->appendChild($answer);

                $answer = $xml->createElement('answer2',$exercise_answer2);
                $answer = $exercise->appendChild($answer);

                $answer = $xml->createElement('answer3',$exercise_answer3);
                $answer = $exercise->appendChild($answer);

            }

            $xml->formatOutput = true;
            $el_xml = $xml->saveXML();
           // $result = $xml->save('../levels/level1/Métodos Numéricos/'. $learningobject . '/oa.xml');
            $result = $xml->save($name_file);

    //
        } else {


            if($exercise_type == 1){

                $xml = new DomDocument('1.0', 'UTF-8');
                $unit = $xml->createElement('unit');
                $unit = $xml->appendChild($unit);

                $exercise = $xml->createElement('exercise');
                $exercise = $unit->appendChild($exercise);
                // Agregar un atributo
                $exercise->setAttribute('value', 'questionary');

                $image = $xml->createElement('title', $exercise_name);
                $image = $exercise->appendChild($image);

                $information = $xml->createElement('information', $exercise_description);
                $information = $exercise->appendChild($information);

                $question = $xml->createElement('question',$exercise_question);
                $question = $exercise->appendChild($question);
                // Agregar un atributo
                $question->setAttribute('value', $exercise_answer1);


                $xml->formatOutput = true;
                $el_xml = $xml->saveXML();
               // $result = $xml->save('../levels/level1/Métodos Númericos/'. $learningobject . '/oa.xml');
                $result = $xml->save($name_file);


            }else{
                //codigo de ejercicio de opcion multiple
                $xml = new DomDocument('1.0', 'UTF-8');
                $unit = $xml->createElement('unit');
                $unit = $xml->appendChild($unit);

                $exercise = $xml->createElement('exercise');
                $exercise = $unit->appendChild($exercise);
                // Agregar un atributo
                $exercise->setAttribute('value', 'multipleoptions');

                $image = $xml->createElement('title', $exercise_name);
                $image = $exercise->appendChild($image);

                $information = $xml->createElement('information', $exercise_description);
                $information = $exercise->appendChild($information);

                $question = $xml->createElement('question',$exercise_question);
                $question = $exercise->appendChild($question);
                // Agregar un atributo
                $question->setAttribute('value', $exercise_ok);

                $answer = $xml->createElement('answer1',$exercise_answer1);
                $answer = $exercise->appendChild($answer);

                $answer = $xml->createElement('answer2',$exercise_answer2);
                $answer = $exercise->appendChild($answer);

                $answer = $xml->createElement('answer3',$exercise_answer3);
                $answer = $exercise->appendChild($answer);

                $xml->formatOutput = true;
                $el_xml = $xml->saveXML();
               // $result = $xml->save('../levels/level1/Métodos Númericos/'. $learningobject . '/oa.xml');
                $result = $xml->save($name_file);




            }

        }

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



//Para leerlo
    function leer($name_file){
       // echo "<p><b>Mostrar el contenido del Xml</b></p>";
        $xml = simplexml_load_file($name_file);
        $att= 'value';
        $array_exercises = array();

        $exercise_c = array('image' => '',
            'information' => '',
            'question'=>'',
            'atrquestion'=>'',
            'type'=>'');

        $exercise_m = array('image' => '',
            'information' => '',
            'question'=>'',
            'atrquestion'=>'',
            'anwer1'=>'',
            'anwer2'=>'',
            'anwer3'=>'',
            'type'=>'');

        $resource = array('image'=>'',
            'information' => '',
            'type'=>'',
            'resourcetype'=>'');

        foreach($xml->exercise as $item){
            if($item->attributes()->$att == 'questionary')   {

                $exercise_c['type'] = $item->attributes()->$att;
                $exercise_c['image'] = $item->title;
                $exercise_c['information'] = $item->information;
                $exercise_c['question'] = $item->question;
                $exercise_c['atrquestion'] = $item->question->attributes()->$att;

                array_push ( $array_exercises , $exercise_c );
            }elseif($item->attributes()->$att == 'multipleoptions') {

                $exercise_m['type'] = $item->attributes()->$att;
                $exercise_m['image'] = $item->title;
                $exercise_m['information'] = $item->information;
                $exercise_m['question'] = $item->question;
                $exercise_m['atrquestion'] = $item->question->attributes()->$att;
                $exercise_m['anwer1'] = $item->answer1;
                $exercise_m['anwer2'] = $item->answer2;
                $exercise_m['anwer3'] = $item->answer3;

                array_push ( $array_exercises , $exercise_m);

            }

        }

        foreach($xml->resource as $item){
            if($item->attributes()->$att == 'resource'){
                $resource['type'] = $item->attributes()->$att;
                $resource['image'] = $item->title;
                $resource['resourcetype'] = $item->resourcetype;
                $resource['information'] = $item->file;

                array_push ( $array_exercises , $resource);
            }

        }




        return $array_exercises;
    }

    function leerContent($name_file){
        // echo "<p><b>Mostrar el contenido del Xml</b></p>";
        $xml = simplexml_load_file($name_file);
        $att= 'value';
        $array_units = array();

        $unit = array('title' => '',
            'information' => '',
            'author'=>'',
            'value'=>'');


        foreach($xml->unit as $item){

            $unit['value'] = $item->attributes()->$att;
            $unit['title'] = $item->title;
            $unit['information'] = $item->description;
            $unit['author'] = $item->author;

            array_push ( $array_units , $unit );

        }

        return $array_units;
    }

    function getAllexercises($name_file){

        $name_file = str_replace(' ', '', $name_file);
        $name_file = '../levels/level1/MetodosNumericos/'. $name_file . '/oa.xml';

        $xml = simplexml_load_file($name_file);

        $allexercises = count($xml->exercise);

        return $allexercises;
    }

    //funcion
    public function addresources($learningobject, $exercise_type, $exercise_description){

        $learningobject = str_replace(' ', '', $learningobject);
        $learningobject = strtr($learningobject,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

        $name_file = '../levels/level1/MetodosNumericos/'. $learningobject . '/oa.xml';

        if (file_exists($name_file))
        {

            $read_exercises = $this->leer($name_file);

            /*---- crear guardados  */
            $xml = new DomDocument('1.0', 'UTF-8');
            $unit = $xml->createElement('unit');
            $unit = $xml->appendChild($unit);

            foreach ($read_exercises as $vuelta) {

                if($vuelta['type'] == 'questionary'){
                    $exercise = $xml->createElement('exercise');
                    $exercise = $unit->appendChild($exercise);
                    // Agregar un atributo
                    $exercise->setAttribute('value', 'questionary');
                    $image = $xml->createElement('title', $vuelta['image']);
                    $image = $exercise->appendChild($image);
                    $information = $xml->createElement('information', $vuelta['information']);
                    $information = $exercise->appendChild($information);
                    $question = $xml->createElement('question',$vuelta['question']);
                    $question = $exercise->appendChild($question);
                    // Agregar un atributo
                    $question->setAttribute('value', $vuelta['atrquestion']);


                }else if($vuelta['type'] == 'multipleoptions'){
                    //codigo si es ejercio de opcion multiple
                    $exercise = $xml->createElement('exercise');
                    $exercise = $unit->appendChild($exercise);
                    // Agregar un atributo
                    $exercise->setAttribute('value', 'multipleoptions');

                    $image = $xml->createElement('title', $vuelta['image']);
                    $image = $exercise->appendChild($image);

                    $information = $xml->createElement('information', $vuelta['information']);
                    $information = $exercise->appendChild($information);

                    $question = $xml->createElement('question',$vuelta['question']);
                    $question = $exercise->appendChild($question);
                    // Agregar un atributo
                    $question->setAttribute('value', $vuelta['atrquestion']);

                    $answer = $xml->createElement('answer1',$vuelta['anwer1']);
                    $answer = $exercise->appendChild($answer);

                    $answer = $xml->createElement('answer2',$vuelta['anwer2']);
                    $answer = $exercise->appendChild($answer);

                    $answer = $xml->createElement('answer3',$vuelta['anwer3']);
                    $answer = $exercise->appendChild($answer);

                }else if($vuelta['type'] == 'resource'){
                    $exercise = $xml->createElement('resource');
                    $exercise = $unit->appendChild($exercise);
                    // Agregar un atributo
                    $exercise->setAttribute('value', 'resource');
                    $title = $xml->createElement('title', $vuelta['image']);
                    $title = $exercise->appendChild($title);
                    $image = $xml->createElement('resourcetype', $vuelta['resourcetype']);
                    $image = $exercise->appendChild($image);
                    $information = $xml->createElement('file', $vuelta['information']);
                    $information = $exercise->appendChild($information);

                }



            }


            /*---- agregar nuevo ----*/
            $exercise = $xml->createElement('resource');
            $exercise = $unit->appendChild($exercise);
            // Agregar un atributo
            $exercise->setAttribute('value', 'resource');
            $title = $xml->createElement('title', 'null');
            $title = $exercise->appendChild($title);
            $image = $xml->createElement('resourcetype',$exercise_type);
            $image = $exercise->appendChild($image);
            $information = $xml->createElement('file', $learningobject."/".$exercise_description);
            $information = $exercise->appendChild($information);

            $xml->formatOutput = true;
            $el_xml = $xml->saveXML();
            // $result = $xml->save('../levels/level1/Métodos Numéricos/'. $learningobject . '/oa.xml');
            $result = $xml->save($name_file);

            //si es el primero
        } else {


                $xml = new DomDocument('1.0', 'UTF-8');
                $unit = $xml->createElement('unit');
                $unit = $xml->appendChild($unit);

                $exercise = $xml->createElement('resource');
                $exercise = $unit->appendChild($exercise);
                // Agregar un atributo
                $exercise->setAttribute('value', 'resource');

                $title = $xml->createElement('title', 'null');
                $title = $exercise->appendChild($title);

                $image = $xml->createElement('resourcetype', $exercise_type);
                $image = $exercise->appendChild($image);

                $information = $xml->createElement('file', $learningobject."/".$exercise_description);
                $information = $exercise->appendChild($information);


                $xml->formatOutput = true;
                $el_xml = $xml->saveXML();
                //$result = $xml->save('../levels/level1/Métodos Númericos/'. $learningobject . '/oa.xml');
                $result = $xml->save($name_file);
        }

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



}



?>