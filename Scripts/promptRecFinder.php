<?php
    //hente funksjon 
    require_once __DIR__ . '/../Scripts/geminiToGoogle.php';

    function findrecommendation($response){
        if (session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }

        // Oppretter om det ikke er en fra før av
        if (!isset($_SESSION["recommendations_given"])) {
            $_SESSION["recommendations_given"] = array(); //chatsamtalen er en array som blir appenda til for hver respons/input
        } 

        // Gemini-prompten må være instruert til å avslutte svaret med en BØKER: [...] JSON-blokk
        // når den anbefaler bøker (f.eks. BØKER: [{"title": "...", "author": "..."}]).
        // geminiAPI.php fjerner denne blokken fra teksten som vises i chatten,
        // mens denne funksjonen henter den ut og parser den til et array med tittel og forfatter.
        $books = [];
        if (preg_match('/BØKER:\s*(\[.*?\])\s*$/su', $response, $jsonMatch)) {
            $parsed = json_decode($jsonMatch[1], true);
            if (is_array($parsed)) {
                foreach ($parsed as $entry) {
                    $title  = trim($entry['title'] ?? '');
                    $author = trim($entry['author'] ?? '');
                    if (!empty($title) && !empty($author)) {
                        $books[] = ['title' => $title, 'author' => $author];
                    }
                }
            }
        }

        //dersom det er bokanbefalinger funnet, legges det til i sesjonens 'recommendations_given' array
        if (!empty($books)){
            foreach($books as $book){
                $_SESSION["recommendations_given"][] = $book;
            }
        }

        //funksjon i geminitogoogle scriptet som forer mønster-søk resultatet inn til google books
        geminiToGoogle();
    }
?>