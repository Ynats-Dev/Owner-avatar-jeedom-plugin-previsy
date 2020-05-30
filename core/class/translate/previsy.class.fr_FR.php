<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# Documentation : https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
# API : https://www.prevision-meteo.ch/services/json/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class previsy_language {

    public static function test() {
        return "Calss chargée";
    }

    public static function getDate($_date) {
        $return["HEURE"] = $_date->format('H:i');
        $return["DATE"] = $_date->format('d/m/Y');
        $return["JOUR"] = $_date->format('l');
        $return["JOUR_TXT"] = self::traduitDateTimeJour($_date->format('l')) . " " . $_date->format('d') . " " . self::traduitDateTimeMois($_date->format('M')) . " " . $_date->format('Y') . " à " . $_date->format('H') . "H00";
        return $return;
    }

    public static function traduitDateTimeMois($_string) {
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $translate_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        return str_replace($english_months, $translate_months, $_string);
    }

    public static function traduitDateTimeJour($_string) {
        $english_months = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $translate_months = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        return str_replace($english_months, $translate_months, $_string);
    }

    public static function infosCondition($_condition) {
        switch ($_condition) {
            case "Brouillard":
                $return["TXT"] = "il va y avoir du brouillard";
                $return["ALERTE"] = "brouillard";
                break;
            case "Averses de pluie faible":
                $return["TXT"] = "il y aura de faibles averses de pluie";
                $return["ALERTE"] = "pluie";
                break;
            case "Nuit avec averses":
                $return["TXT"] = "il y aura des averses durant la nuit";
                $return["ALERTE"] = "pluie";
                break;
            case "Averses de pluie modérée":
                $return["TXT"] = "il y aura des averses de pluie modérées";
                $return["ALERTE"] = "pluie";
                break;
            case "Averses de pluie forte":
                $return["TXT"] = "il y aura de fortes averses de pluie";
                $return["ALERTE"] = "pluie";
                break;
            case "Couvert avec averses":
                $return["TXT"] = "le cliel sera couvert avec des averses";
                $return["ALERTE"] = "pluie";
                break;
            case "Pluie faible":
                $return["TXT"] = "il y aaura de faibles précipitations de pluie";
                $return["ALERTE"] = "pluie";
                break;
            case "Pluie forte":
                $return["TXT"] = "il y aura de fortes précipitations de pluie";
                $return["ALERTE"] = "pluie";
                break;
            case "Pluie modérée":
                $return["TXT"] = "il va pleuvoir";
                $return["ALERTE"] = "pluie";
                break;
            case "Faiblement orageux":
                $return["TXT"] = "le ciel sera faiblement orageux";
                $return["ALERTE"] = "orage";
                break;
            case "Nuit faiblement orageuse":
                $return["TXT"] = "la nuit sera faiblement orageuse";
                $return["ALERTE"] = "orage";
                break;
            case "Orage modéré":
                $return["TXT"] = "le ciel sera orageux";
                $return["ALERTE"] = "orage";
                break;
            case "Fortement orageux":
                $return["TXT"] = "le ciel sear fortement orageux";
                $return["ALERTE"] = "orage";
                break;
            case "Averses de neige faible":
                $return["TXT"] = "il y aura de faibles averses de neige";
                $return["ALERTE"] = "neige";
                break;
            case "Nuit avec averses de neige faible":
                $return["TXT"] = "cette nuit, il y aura de faibles averses de neige";
                $return["ALERTE"] = "neige";
                break;
            case "Neige faible":
                $return["TXT"] = "il va neiger un petit peu";
                $return["ALERTE"] = "neige";
                break;
            case "Neige modérée":
                $return["TXT"] = "il va neiger";
                $return["ALERTE"] = "neige";
                break;
            case "Neige forte":
                $return["TXT"] = "il y aura de forte tombé de neige";
                $return["ALERTE"] = "neige";
                break;
            case "Pluie et neige mêlée faible":
                $return["TXT"] = "il y aura de la pluie mélée à un petit peu de neige";
                $return["ALERTE"] = "neige_pluie";
                break;
            case "Pluie et neige mêlée modérée":
                $return["TXT"] = "il y aura de la pluie mélée à de la neige";
                $return["ALERTE"] = "neige_pluie";
                break;
            case "Pluie et neige mêlée forte":
                $return["TXT"] = "il y aura de la pluie mélée à de grosses tombées de neige";
                $return["ALERTE"] = "neige_pluie";
                break;
            default:
                return NULL;
        }

        return $return;
    }
    
        public static function echelleBeaufort($_input) {
        if ($_input < 1) {
            return 'calme';
        } elseif ($_input >= 1 AND $_input < 6) {
            return 'très légère brise';
        } elseif ($_input >= 6 AND $_input < 12) {
            return 'légère brise';
        } elseif ($_input >= 12 AND $_input < 20) {
            return 'petite brise';
        } elseif ($_input >= 20 AND $_input < 29) {
            return 'jolie brise';
        } elseif ($_input >= 29 AND $_input < 39) {
            return 'bonne brise';
        } elseif ($_input >= 39 AND $_input < 50) {
            return 'vent frais';
        } elseif ($_input >= 50 AND $_input < 62) {
            return 'grand vent frais';
        } elseif ($_input >= 62 AND $_input < 75) {
            $return["NOM"] = 'coup de vent';
        } elseif ($_input >= 75 AND $_input < 89) {
            return 'fort coup de vent';
        } elseif ($_input >= 89 AND $_input < 103) {
            return 'tempête';
        } elseif ($_input >= 103 AND $_input < 118) {
            return 'violente tempête';
        } elseif ($_input > 118) {
            return 'ouragan';
        }
    }

    public static function formatHeure_txt($_heure) {

        if ($_heure == 0) {
            return "minuit";
        } elseif ($_heure == 1) {
            return $_heure . " heure";
        } else {
            return $_heure . " heures";
        }
    }

    public static function constructTxt($_input, $_degre = "°C") {

        if ($_input["DANS_HEURE"] > 0 AND $_input["DANS_HEURE"] <= 6) {
            $return["START"] = "Dans " . $_input["DANS_HEURE"] . " heures,";
        } elseif ($_input["DANS_JOUR"] == 0 AND $_input["DANS_HEURE"] > 6) {
            $return["START"] = "Dans " . $_input["DANS_HEURE"] . " heures, soit aujourd'hui à partir de " . self::formatHeure_txt($_input["HEURE"]) . ",";
        } elseif ($_input["DANS_JOUR"] == 1 AND $_input["DANS_HEURE"] < 6) {
            $return["START"] = "Dans " . $_input["DANS_HEURE"] . " heures, soit tout à l'heure à " . self::formatHeure_txt($_input["HEURE"]) . ",";
        } elseif ($_input["DANS_JOUR"] == 1) {
            $return["START"] = "Dans " . $_input["DANS_HEURE"] . " heures, soit demain à partir de " . self::formatHeure_txt($_input["HEURE"]) . ",";
        } elseif ($_input["DANS_JOUR"] == 2) {
            $return["START"] = "Dans " . $_input["DANS_HEURE"] . " heures, soit après-demain à partir de " . self::formatHeure_txt($_input["HEURE"]) . ",";
        } elseif ($_input["DANS_JOUR"] > 2) {
            $return["START"] = "Dans " . $_input["DANS_HEURE"] . " heures, soit " . $_input["START_TXT"] . ",";
        }

        if ($_input["DANS_HEURE"] > 0) {
            if ($_input["TYPE"] == "pluie") {
                $return["START"] .= " il va pleuvoir durant " . $_input["DUREE_HEURE"] . " heure";
                if ($_input["DUREE_HEURE"] > 1) {
                    $return["START"] .= "s";
                } $return["START"] .= ". ";
            } elseif ($_input["TYPE"] == "orage") {
                $return["START"] .= " un orage est prévu durant " . $_input["DUREE_HEURE"] . " heure";
                if ($_input["DUREE_HEURE"] > 1) {
                    $return["START"] .= "s";
                } $return["START"] .= ". ";
            } elseif ($_input["TYPE"] == "neige") {
                $return["START"] .= " il va neiger durant " . $_input["DUREE_HEURE"] . " heure";
                if ($_input["DUREE_HEURE"] > 1) {
                    $return["START"] .= "s";
                } $return["START"] .= ". ";
            } elseif ($_input["TYPE"] == "neige_pluie") {
                $return["START"] .= " un mélange de neige et de pluie est prévu durant " . $_input["DUREE_HEURE"] . " heure";
                if ($_input["DUREE_HEURE"] > 1) {
                    $return["START"] .= "s";
                } $return["START"] .= ". ";
            } elseif ($_input["TYPE"] == "brouillard") {
                $return["START"] .= " un brouillard est prévu durant " . $_input["DUREE_HEURE"] . " heure";
                if ($_input["DUREE_HEURE"] > 1) {
                    $return["START"] .= "s";
                } $return["START"] .= ". ";
            } elseif ($_input["TYPE"] == "vent") {
                $return["START"] .= " il va y avoir du vent pendant " . $_input["DUREE_HEURE"] . " heure";
                if ($_input["DUREE_HEURE"] > 1) {
                    $return["START"] .= "s";
                } $return["START"] .= ". ";
            }
        }
        else{
            if ($_input["TYPE"] == "pluie") {
                $return["START"] .= "Il est en train de pleuvoir mais cela va se calmer d'ici peu de temps.";
            } elseif ($_input["TYPE"] == "orage") {
                $return["START"] .= "Il y a un orage qui va s'arrêter d'ici peu de temps.";
            } elseif ($_input["TYPE"] == "neige") {
                $return["START"] .= "Il neige mais cela va s'arrêter d'ici peu de temps.";
            } elseif ($_input["TYPE"] == "neige_pluie") {
                $return["START"] .= "Il y a un mélange de neige et de pluie qui va s'arrêter d'ici peu de temps.";
            } elseif ($_input["TYPE"] == "brouillard") {
                $return["START"] .= "Il y a du brouillard mais cela va s'arrêter d'ici peu de temps.";
            }            
        }
        
        if($_input["MM"]["TOTAL"] > 0){
            $return["MM"] .= "Il y aura un total de " . number_format($_input["MM"]["TOTAL"], 1) . " millimètre";
            if ($_input["MM"]["TOTAL"] > 1) {
                $return["MM"] .= "s";
            }
            $return["MM"] .= " de précipatation"; 
            
            if ($_input["DUREE_HEURE"] > 1) {
            $return["MM"] .= " soit une moyenne de " . number_format($_input["MM"]["MOY"], 1) . " millimètre";
            if ($_input["MM"]["MOY"] > 1) {
                $return["MM"] .= "s";
            }
            $return["MM"] .= " au m² et par heure.";

            if ($_input["MM"]["CONDITION_MAX_TXT"] != $_input["MM"]["CONDITION_MIN_TXT"]) {
                $return["MM"] .= " Au plus bas, " . $_input["MM"]["CONDITION_MIN_TXT"] . ", avec " . number_format($_input["MM"]["MIN"], 1) . " millimètre";
                if ($_input["MM"]["MIN"] > 1) {
                    $return["MM"] .= "s";
                }
                $return["MM"] .= " de précipitation. ";

                $return["MM"] .= " Au plus haut, " . $_input["MM"]["CONDITION_MAX_TXT"] . ", avec " . number_format($_input["MM"]["MAX"], 1) . " millimètre";
                if ($_input["MM"]["MAX"] > 1) {
                    $return["MM"] .= "s";
                }
                $return["MM"] .= " de précipitation. ";
            } else {
                $return["MM"] .= " En résumé, " . $_input["MM"]["CONDITION_MAX_TXT"] . ", avec des précipatations allant de " . number_format($_input["MM"]["MIN"], 1);
                $return["MM"] .= " à " . $_input["MM"]["MAX"] . " millimètre";
                if ($_input["MM"]["MAX"] > 1) {
                    $return["MM"] .= "s";
                }
                $return["MM"] .= ". ";
            }
        } else {
            $return["MM"] .= ". ";
        }
            
        } else {
            $return["MM"] = NULL;
        }

        if ($_input["TEMPERATURE"]["MIN"] != $_input["TEMPERATURE"]["MAX"]) {
            $return["TEMPERATURE"] = " La température moyenne sera de " . number_format($_input["TEMPERATURE"]["MOY"], 1) . $_degre;
            $return["TEMPERATURE"] .= " allant d'une amplitude de " . number_format($_input["TEMPERATURE"]["MIN"], 1) . $_degre . " à " . number_format($_input["TEMPERATURE"]["MAX"], 1) . $_degre . ".";
        } else {
            $return["TEMPERATURE"] = " La température sera de " . number_format($_input["TEMPERATURE"]["MOY"], 1) . $_degre . ".";
        }

        if ($_input["HUMIDITE"]["MIN"] != $_input["HUMIDITE"]["MAX"]) {
            $return["HUMIDITE"] = " Le taux d'humidité sera en moyenne à " . number_format($_input["HUMIDITE"]["MOY"], 1) . "%";
            $return["HUMIDITE"] .= " allant d'une amplitude de " . number_format($_input["HUMIDITE"]["MIN"], 1) . "% à " . number_format($_input["HUMIDITE"]["MAX"], 1) . "%.";
        } else {
            $return["HUMIDITE"] = " Le taux d'humidité sera de " . number_format($_input["HUMIDITE"]["MOY"], 1) . "%.";
        }

        $return["VENT"] = " Le vent soufflera en moyenne à " . number_format($_input["VENT_VITESSE"]["MOY"], 1) . "KM/H";
        $return["VENT"] .= " avec des rafales pouvant aller jusqu'à " . number_format($_input["VENT_RAFALES"]["MAX"], 1) . "KM/H.";

        $return["FULL"] = $return["START"] . $return["MM"] . $return["HUMIDITE"] . $return["TEMPERATURE"] . $return["VENT"];

        return $return;
    }

}

?>
