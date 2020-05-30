<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# Documentation : https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
# API : https://www.prevision-meteo.ch/services/json/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class previsy_language {

    public static function getDate($_date) {
        $return["HEURE"] = $_date->format('H:i');
        $return["DATE"] = $_date->format('j, n, Y');
        $return["JOUR"] = $_date->format('l');   
        $return["JOUR_TXT"] = $_date->format('F j, Y, g:i a');
        return $return;
    }
    
    public static function celsius_to_fahrenheit($_value) {
            return $_value*9/5+32;
    }

    public static function infosCondition($_condition) {
        switch ($_condition) {
            case "Ensoleillé":
                $return["TXT"] = array(
                    "PRESENT" => "the sky is sunny",
                    "FUTUR" => "the sky will be sunny"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Nuit claire":
                $return["TXT"] = array(
                    "PRESENT" => "the night is clear",
                    "FUTUR" => "the night will be clear"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Ciel voilé":
                $return["TXT"] = array(
                    "PRESENT" => "the sky is veiled",
                    "FUTUR" => "the sky will be veiled"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Nuit légèrement voilée":
                $return["TXT"] = array(
                    "PRESENT" => "the night is slightly veiled",
                    "FUTUR" => "the night will be slightly veiled"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Faibles passages nuageux":
                $return["TXT"] = array(
                    "PRESENT" => "there are weak cloudy periods",
                    "FUTUR" => "there will be weak cloudy periods"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Nuit bien dégagée": $return["TXT"] = array(
                    "PRESENT" => "the sky is sunny",
                    "FUTUR" => "the sky will be sunny"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Brouillard":
                $return["TXT"] = array(
                    "PRESENT" => "the night is clear",
                    "FUTUR" => "the night will be clear"
                );
                $return["ALERTE"] = "brouillard";
                break;
            case "Stratus":
                $return["TXT"] = array(
                    "PRESENT" => "the clouds in the sky are low and gray",
                    "FUTUR" => "the clouds in the sky will be low and gray"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Stratus se dissipant":
                $return["TXT"] = array(
                    "PRESENT" => "gray and low clouds scatter",
                    "FUTUR" => "the gray and low clouds will disperse"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Nuit claire et stratus":
                $return["TXT"] = array(
                    "PRESENT" => "the night is clear and the clouds are low and gray",
                    "FUTUR" => "the night will be clear and the clouds will be low and gray"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Eclaircies":
                $return["TXT"] = array(
                    "PRESENT" => "there are bright spots",
                    "FUTUR" => "there will be clearings"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Nuit nuageuse":
                $return["TXT"] = array(
                    "PRESENT" => "la nuit est nuageuse",
                    "FUTUR" => "la nuit sera nuageuse"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Faiblement nuageux":
                $return["TXT"] = array(
                    "PRESENT" => "le cliel est faiblement nuageux",
                    "FUTUR" => "le cliel sera faiblement nuageux"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Fortement nuageux":
                $return["TXT"] = array(
                    "PRESENT" => "le cliel est fortement nuageux",
                    "FUTUR" => "le cliel sera fortement nuageux"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Averses de pluie faible":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de faibles averses de pluie",
                    "FUTUR" => "il y aura de faibles averses de pluie"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Nuit avec averses":
                $return["TXT"] = array(
                    "PRESENT" => "il y a des averses durant la nuit",
                    "FUTUR" => "il y aura des averses durant la nuit"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Averses de pluie modérée":
                $return["TXT"] = array(
                    "PRESENT" => "il y a des averses de pluie modérée",
                    "FUTUR" => "il y aura des averses de pluie modérée"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Averses de pluie forte":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de fortes averses de pluie",
                    "FUTUR" => "il y aura de fortes averses de pluie"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Couvert avec averses":
                $return["TXT"] = array(
                    "PRESENT" => "le cliel est couvert avec des averses",
                    "FUTUR" => "le cliel sera couvert avec des averses"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Pluie faible":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de faibles précipitations de pluie",
                    "FUTUR" => "il y aura de faibles précipitations de pluie"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Pluie forte":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de fortes précipitations de pluie",
                    "FUTUR" => "il y aura de fortes précipitations de pluie"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Pluie modérée":
                $return["TXT"] = array(
                    "PRESENT" => "il pleut",
                    "FUTUR" => "il va pleuvoir"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Développement nuageux":
                $return["TXT"] = array(
                    "PRESENT" => "des nuages se forment dans le ciel",
                    "FUTUR" => "des nuages vont se former dans le ciel"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Nuit avec développement nuageux":
                $return["TXT"] = array(
                    "PRESENT" => "durant la nuit des nuages vont se forment dans le ciel",
                    "FUTUR" => "durant la nuit des nuages vont se former dans le ciel"
                );
                $return["ALERTE"] = NULL;
                break;
            case "Faiblement orageux":
                $return["TXT"] = array(
                    "PRESENT" => "le ciel est faiblement orageux",
                    "FUTUR" => "le ciel sera faiblement orageux"
                );
                $return["ALERTE"] = "pluie";
                break;
            case "Nuit faiblement orageuse":
                $return["TXT"] = array(
                    "PRESENT" => "la nuit est faiblement orageuse",
                    "FUTUR" => "la nuit sera faiblement orageuse"
                );
                $return["ALERTE"] = "orage";
                break;
            case "Orage modéré":
                $return["TXT"] = array(
                    "PRESENT" => "le ciel est orageux",
                    "FUTUR" => "le ciel sera orageux"
                );
                $return["ALERTE"] = "orage";
                break;
            case "Fortement orageux":
                $return["TXT"] = array(
                    "PRESENT" => "le ciel est fortement orageux",
                    "FUTUR" => "le ciel sera fortement orageux"
                );
                $return["ALERTE"] = "orage";
                break;
            case "Averses de neige faible":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de faibles averses de neige",
                    "FUTUR" => "il y aura de faibles averses de neige"
                );
                $return["ALERTE"] = "neige";
                break;
            case "Nuit avec averses de neige faible":
                $return["TXT"] = array(
                    "PRESENT" => "cette nuit, il y a de faibles averses de neige",
                    "FUTUR" => "durant la nuit, il y aura de faibles averses de neige"
                );
                $return["ALERTE"] = "neige";
                break;
            case "Neige faible":
                $return["TXT"] = array(
                    "PRESENT" => "il neige un petit peu",
                    "FUTUR" => "il va un petit peu neiger"
                );
                $return["ALERTE"] = "neige";
                break;
            case "Neige modérée":
                $return["TXT"] = array(
                    "PRESENT" => "il neige",
                    "FUTUR" => "il va neiger"
                );
                $return["ALERTE"] = "neige";
                break;
            case "Neige forte":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de forte tombé de neige",
                    "FUTUR" => "il va y voir de forte tombé de neige"
                );
                $return["ALERTE"] = "neige";
                break;
            case "Pluie et neige mêlée faible":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de la pluie mélée à un petit peu de neige",
                    "FUTUR" => "il y aura de la pluie mélée à un petit peu de neige"
                );
                $return["ALERTE"] = "neige_pluie";
                break;
            case "Pluie et neige mêlée modérée":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de la pluie mélée à de la neige",
                    "FUTUR" => "il y aura de la pluie mélée à de la neige"
                );
                $return["ALERTE"] = "neige_pluie";
                break;
            case "Pluie et neige mêlée forte":
                $return["TXT"] = array(
                    "PRESENT" => "il y a de la pluie mélée à de grosse tombée de neige",
                    "FUTUR" => "il y aura de la pluie mélée à de grosse tombée de neige"
                );
                $return["ALERTE"] = "neige_pluie";
                break;
        }
        return $return;
    }
    
    public static function formatHeure_txt($_heure) {

        if ($_heure == 0) {
            return "midhight";
        } else {
            return $_heure . " o'clock";
        }
    }

    public static function cronstruct_talk($_input) {

        if ($_input["INFOS"]["+J"] == 0) {
            $txt_talk_jour = ", either today at " . $this->formatHeure_txt($_input["INFOS"]["TMP"]["H_TXT"]) . ", ";
        } elseif ($_input["INFOS"]["+J"] == 1) {
            $txt_talk_jour = ", either tomorrow at " . $this->formatHeure_txt($_input["INFOS"]["TMP"]["H_TXT"]) . ", ";
        } elseif ($_input["INFOS"]["+J"] == 2) {
            $txt_talk_jour = ", either the day after tomorrow at " . $this->formatHeure_txt($_input["INFOS"]["TMP"]["H_TXT"]) . ", ";
        } elseif ($_input["INFOS"]["+J"] == 3) {
            $txt_talk_jour = ", either the day  after after tomorrow at " . $this->formatHeure_txt($_input["INFOS"]["TMP"]["H_TXT"]) . ", ";
        } else {
            $txt_talk_jour = ", either " . $_input["INFOS"]["TMP"]["JOURNEE"] . " " . $_input["INFOS"]["TMP"]["JOUR"] . " " . $this->traduitDateTimeMois($_input["INFOS"]["TMP"]["MOIS"], $this->_language) . " à " . $this->formatHeure_txt($_input["INFOS"]["TMP"]["H_TXT"]) . ", ";
        }

        if ($_input["INFOS"]["+H"] == 0) {
            $txt_talk_debut = "Right now, he's doing ";
        } else {
            $txt_talk_debut = "In " . $_input["INFOS"]["+H"] . " hour";
            if ($_input["INFOS"]["+H"] > 1) {
                $txt_talk_debut .= "s";
            }
            $txt_talk_debut .= $txt_talk_jour . "it will be ";
        }

        if ($_input["INFOS"]["PRECIPITATION_MM"] < 2) {
            $txt_talk_mm = "minimeter";
        } else {
            $txt_talk_mm = "minimeters";
        }

        if ($_input["INFOS"]["TMP"]["ISSNOW"] == 0) {
            $txt_talk_precipitation = ". This corresponds to a downpour of " . $_input["INFOS"]["PRECIPITATION_MM"] . " " . $txt_talk_mm . " of water per m²";
        } else {
            $txt_talk_precipitation = ". This corresponds to a volume of snow of " . $_input["INFOS"]["PRECIPITATION_MM"] . " " . $txt_talk_mm . " per m²";
        }

        $return = $txt_talk_debut . $this->celsius_to_fahrenheit($_input["INFOS"]["TEMPERATURE"]). "°F and " . $_input["CONDITION"];

        if ($_input["INFOS"]["PRECIPITATION_MM"] > 0) {
            $return .= $txt_talk_precipitation . ".";
        } else {
            $return .= ".";
        }

        return $return;
    }
}

?>
