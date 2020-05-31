<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# Documentation : https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
# API : https://www.prevision-meteo.ch/services/json/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* * ***************************Includes********************************* */

require_once __DIR__ . '/../../../../core/php/core.inc.php';

class previsy extends eqLogic {
    /*     * *************************Attributs****************************** */

    public static $_widgetPossibility = array('custom' => true);

    /*     * **************************Configuration************************* */

    public function getConfigPrevisy() {
        $return["urlApi"] = "https://www.prevision-meteo.ch/services/json/"; // Url du Json de prevision-meteo.ch
        $return["jsonTampon"] = __DIR__ . "/../../../../plugins/previsy/core/json/"; // Dossier des Json en Tampon
        $return["icons"] = "/plugins/previsy/desktop/icons/"; // Dossier des icones
        $return["phrasesLangues"] = __DIR__ . "/../../../../plugins/previsy/core/class/translate/"; // Dossier des class permettant de construire des phrases en différentes langues
        $return["prevHeure"] = 72; // Heure max de récupération des données dans le Json
        $return["maxAlerte"] = 5; // Nombre max d'alerte ou widget à afficher
        $return["timeSynchro"] = 3600 * 2; // Synchro avec le site distant tous les X secondes
        return $return;
    }

    public function getCofingFormatDegres() {
        return config::byKey('type_degre', 'previsy', '0');
    }

    public function getCofingNbAlerte() {
        return config::byKey('nb_alerte', 'previsy', '0');
    }
    
    public function getCofingShowCommandes() {
        $return["show_mm_min"] = config::byKey('show_mm_min', 'previsy', '0');
        $return["show_mm_max"] = config::byKey('show_mm_max', 'previsy', '0');
        $return["show_mm_moyenne"] = config::byKey('show_mm_moyenne', 'previsy', '0');
        $return["show_mm_total"] = config::byKey('show_mm_total', 'previsy', '0');
        $return["show_temp_min"] = config::byKey('show_temp_min', 'previsy', '0');
        $return["show_temp_max"] = config::byKey('show_temp_max', 'previsy', '0');
        $return["show_temp_moyenne"] = config::byKey('show_temp_moyenne', 'previsy', '0');
        $return["show_humidite_min"] = config::byKey('show_humidite_min', 'previsy', '0');
        $return["show_humidite_max"] = config::byKey('show_humidite_max', 'previsy', '0');
        $return["show_humidite_moyenne"] = config::byKey('show_humidite_moyenne', 'previsy', '0');
        $return["show_vent_min"] = config::byKey('show_vent_min', 'previsy', '0');
        $return["show_vent_max"] = config::byKey('show_vent_max', 'previsy', '0');
        $return["show_vent_moyenne"] = config::byKey('show_vent_moyenne', 'previsy', '0');
        $return["show_vent_nom"] = config::byKey('show_vent_nom', 'previsy', '0');
        $return["show_rafale_min"] = config::byKey('show_rafale_min', 'previsy', '0');
        $return["show_rafale_max"] = config::byKey('show_rafale_max', 'previsy', '0');
        $return["show_rafale_moyenne"] = config::byKey('show_rafale_moyenne', 'previsy', '0');
        $return["show_txt_start"] = config::byKey('show_txt_start', 'previsy', '0');
        $return["show_txt_mm"] = config::byKey('show_txt_mm', 'previsy', '0');
        $return["show_txt_humidite"] = config::byKey('show_txt_humidite', 'previsy', '0');
        $return["show_txt_temperature"] = config::byKey('show_txt_temperature', 'previsy', '0');
        $return["show_txt_vent"] = config::byKey('show_txt_vent', 'previsy', '0');
        $return["show_condition_max"] = config::byKey('show_condition_max', 'previsy', '0');
        return $return;
    }

    /*     * ***********************Methode static*************************** */

    public function UpdateDatas($previsy) {
        log::add('previsy', 'debug', 'UpdateDatas :. Lancement #ID#' . $previsy->getId());

        $previsy->clearDatas($previsy);

        $info = $previsy->get($previsy->getId());

        log::add('previsy', 'debug', 'UpdateDatas :. Lancement des mises à jour des données de #ID#' . $previsy->getId());

        $previsy->checkAndUpdateCmd('ville', $info["GLOBAL"]["VILLE"]);
        $previsy->checkAndUpdateCmd('latitude', $info["GLOBAL"]["LATITUDE"]);
        $previsy->checkAndUpdateCmd('longitude', $info["GLOBAL"]["LONGITUDE"]);
        $previsy->checkAndUpdateCmd('last_update', $info["GLOBAL"]["LAST_SYNCHRO"]);
        
        $showCommande = $previsy->getCofingShowCommandes();

        $cpt = 0;
        foreach ($info["ALERTES"]["GROUP"] as $value_alerte) {
            $idCmd = array();
            $cpt++;
            if ($cpt < 10) {
                $id_key = "0" . $cpt;
            } else {
                $id_key = $cpt;
            }
            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_dans_heure', $value_alerte["DANS_HEURE"]);
            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_type', $value_alerte["TYPE"]);
            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_date_start', $value_alerte["START"]);
            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_date_end', $value_alerte["END"]);
            
            if ($showCommande["show_condition_max"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_condition_max', $value_alerte["CONDITION_MAX"]);
            }
            if ($showCommande["show_mm_min"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_mm_min', $value_alerte["MM"]["MIN"]);
            }
            if ($showCommande["show_mm_max"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_mm_max', $value_alerte["MM"]["MAX"]);
            }
            if ($showCommande["show_mm_moyenne"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_mm_moyenne', $value_alerte["MM"]["MOY"]);
            }
            if ($showCommande["show_mm_total"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_mm_total', $value_alerte["MM"]["TOTAL"]);
            }
            if ($showCommande["show_temp_min"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_temp_min', $value_alerte["TEMPERATURE"]["MIN"]);
            }
            if ($showCommande["show_temp_max"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_temp_max', $value_alerte["TEMPERATURE"]["MAX"]);
            }
            if ($showCommande["show_temp_moyenne"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_temp_moyenne', $value_alerte["TEMPERATURE"]["MOY"]);
            }
            if ($showCommande["show_humidite_min"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_humidite_min', $value_alerte["HUMIDITE"]["MIN"]);
            }
            if ($showCommande["show_humidite_max"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_humidite_max', $value_alerte["HUMIDITE"]["MAX"]);
            }
            if ($showCommande["show_humidite_moyenne"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_humidite_moyenne', $value_alerte["HUMIDITE"]["MOY"]);
            }
            if ($showCommande["show_vent_min"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_vent_min', $value_alerte["VENT_VITESSE"]["MIN"]);
            }
            if ($showCommande["show_vent_max"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_vent_max', $value_alerte["VENT_VITESSE"]["MAX"]);
            }
            if ($showCommande["show_vent_moyenne"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_vent_moyenne', $value_alerte["VENT_VITESSE"]["MOY"]);
            }
            if ($showCommande["show_vent_nom"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_vent_nom', $value_alerte["VENT_NOM"]);
            }
            if ($showCommande["show_rafale_min"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_rafale_min', $value_alerte["VENT_RAFALES"]["MIN"]);
            }
            if ($showCommande["show_rafale_max"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_rafale_max', $value_alerte["VENT_RAFALES"]["MAX"]);
            }
            if ($showCommande["show_rafale_moyenne"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_rafale_moyenne', $value_alerte["VENT_RAFALES"]["MOY"]);
            }
            
            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_duree', $value_alerte["DUREE_HEURE"]);
            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_txt_full', $value_alerte["TXT"]["FULL"]);
            
            if ($showCommande["show_txt_start"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_txt_start', $value_alerte["TXT"]["START"]);
            }
            if ($showCommande["show_txt_mm"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_txt_mm', $value_alerte["TXT"]["MM"]);
            }
            if ($showCommande["show_txt_temperature"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_txt_temperature', $value_alerte["TXT"]["TEMPERATURE"]);
            }
            if ($showCommande["show_txt_humidite"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_txt_humidite', $value_alerte["TXT"]["HUMIDITE"]);
            }
            if ($showCommande["show_txt_vent"] == 1) {
                $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_txt_vent', $value_alerte["TXT"]["VENT"]);
            }

            $idCmd = $previsy->getIdEtNameCmd($id_key, array('widget', 'txt_full'));

            $previsy->checkAndUpdateCmd('alerte_' . $id_key . '_widget', $previsy->getWidget($value_alerte, $idCmd));

            $mc = cache::byKey('previsyWidgetdashboard' . $previsy->getId());
            $mc->remove();
        }

        if (empty($value_alerte["TYPE"]) AND empty($info["ERROR"])) {
            $previsy->checkAndUpdateCmd('alerte_01_widget', $previsy->getWidgetNull());
        } elseif ($info["ERROR"] == TRUE) {
            $previsy->checkAndUpdateCmd('alerte_01_widget', $previsy->getWidgetError($info["GLOBAL"]["VILLE"]));
        }

        $previsy->toHtml('dashboard');
        $previsy->refreshWidget();

        log::add('previsy', 'debug', 'UpdateDatas :. Fin des mises à jour des données de #ID#' . $previsy->getId());
    }

    public function updateTampon() {
        log::add('previsy', 'debug', 'updateTampon :. Lancement');
    }

    /*     * *********************Méthodes d'instance************************* */

    public static function cronHourly() {
        $eqLogics = eqLogic::byType('previsy');
        foreach ($eqLogics as $previsy) {
            if ($previsy->getIsEnable() == 1) {
                $previsy->updateJsonDatas($previsy->getId());
                log::add('previsy', 'debug', 'cronHourly :. Lancement pour #ID#' . $previsy->getId());
            }
        }
    }

    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {
        log::add('previsy', 'debug', 'preInsert :. Lancement');
    }

    public function postInsert() {
        log::add('previsy', 'debug', 'postInsert :. Lancement');
    }

    public function preSave() {
        log::add('previsy', 'debug', 'preSave :. Lancement');
    }

    public function postSave() {
        log::add('previsy', 'debug', 'postSave :. Début de la création ou Mise à jour des commandes #ID#' . $this->getId());

        $nb_alerte = config::byKey('nb_alerte', 'previsy', '0');
        
        $showCommande = $this->getCofingShowCommandes();

        $info = $this->getCmd(null, 'last_update');
        if (!is_object($info)) {
            $info = new previsyCmd();
            $info->setName(__('SynchroLastUpDate', __FILE__));
        }
        $info->setLogicalId('last_update');
        $info->setEqLogic_id($this->getId());
        $info->setIsHistorized(0);
        $info->setIsVisible(0);
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();

        $info = $this->getCmd(null, 'ville');
        if (!is_object($info)) {
            $info = new previsyCmd();
            $info->setName(__('SynchroVille', __FILE__));
        }
        $info->setLogicalId('ville');
        $info->setEqLogic_id($this->getId());
        $info->setIsHistorized(0);
        $info->setIsVisible(0);
        $info->setType('info');
        $info->setSubType('string');
        $info->save();
        
        $info = $this->getCmd(null, 'latitude');
        if (!is_object($info)) {
            $info = new previsyCmd();
            $info->setName(__('Latitude', __FILE__));
        }
        $info->setLogicalId('latitude');
        $info->setEqLogic_id($this->getId());
        $info->setIsHistorized(0);
        $info->setIsVisible(0);
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();
        
        $info = $this->getCmd(null, 'longitude');
        if (!is_object($info)) {
            $info = new previsyCmd();
            $info->setName(__('Longitude', __FILE__));
        }
        $info->setLogicalId('longitude');
        $info->setEqLogic_id($this->getId());
        $info->setIsHistorized(0);
        $info->setIsVisible(0);
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();

        for ($i = 1; $i <= $nb_alerte; $i++) {

            if ($i < 10) {
                $id = "0" . $i;
            } else {
                $id = $i;
            }

            $info = $this->getCmd(null, 'alerte_' . $id . '_widget');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_widget', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_widget');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setIsVisible(0);
            $info->setType('info');
            $info->setSubType('string');
            $info->save();

            $info = $this->getCmd(null, 'alerte_' . $id . '_dans_heure');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_dans_heure', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_dans_heure');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setIsVisible(0);
            $info->setType('info');
            $info->setSubType('string');
            $info->save();

            $info = $this->getCmd(null, 'alerte_' . $id . '_type');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_type', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_type');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setIsVisible(0);
            $info->setType('info');
            $info->setSubType('string');
            $info->save();
            
            if ($showCommande["show_condition_max"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_condition_max');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_condition_max', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_condition_max');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }

            $info = $this->getCmd(null, 'alerte_' . $id . '_date_start');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_date_start', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_date_start');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setIsVisible(0);
            $info->setType('info');
            $info->setSubType('numeric');
            $info->save();

            $info = $this->getCmd(null, 'alerte_' . $id . '_date_end');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_date_end', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_date_end');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setIsVisible(0);
            $info->setType('info');
            $info->setSubType('numeric');
            $info->save();
            
            if ($showCommande["show_mm_moyenne"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_mm_moyenne');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_mm_moyenne', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_mm_moyenne');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setUnite('MM');
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_mm_min"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_mm_min');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_mm_min', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_mm_min');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setUnite('MM');
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_mm_max"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_mm_max');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_mm_max', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_mm_max');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setUnite('MM');
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_mm_total"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_mm_total');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_mm_total', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_mm_total');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setUnite('MM');
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_temp_min"] == 1) {           
                $info = $this->getCmd(null, 'alerte_' . $id . '_temp_min');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_temp_min', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_temp_min');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_temp_max"] == 1) {           
                $info = $this->getCmd(null, 'alerte_' . $id . '_temp_max');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_temp_max', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_temp_max');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_temp_moyenne"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_temp_moyenne');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_temp_moyenne', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_temp_moyenne');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_humidite_min"] == 1) {            
                $info = $this->getCmd(null, 'alerte_' . $id . '_humidite_min');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_humidite_min', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_humidite_min');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_humidite_max"] == 1) {            
                $info = $this->getCmd(null, 'alerte_' . $id . '_humidite_max');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_humidite_max', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_humidite_max');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_humidite_moyenne"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_humidite_moyenne');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_humidite_moyenne', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_humidite_moyenne');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_vent_min"] == 1) {            
                $info = $this->getCmd(null, 'alerte_' . $id . '_vent_min');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_vent_min', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_vent_min');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_vent_max"] == 1) {            
                $info = $this->getCmd(null, 'alerte_' . $id . '_vent_max');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_vent_max', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_vent_max');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_vent_moyenne"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_vent_moyenne');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_vent_moyenne', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_vent_moyenne');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_rafale_min"] == 1) {            
                $info = $this->getCmd(null, 'alerte_' . $id . '_rafale_min');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_rafale_min', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_rafale_min');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_rafale_max"] == 1) {            
                $info = $this->getCmd(null, 'alerte_' . $id . '_rafale_max');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_rafale_max', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_rafale_max');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            if ($showCommande["show_rafale_moyenne"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_rafale_moyenne');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_rafale_moyenne', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_rafale_moyenne');
                $info->setEqLogic_id($this->getId());
                $info->setUnite($this->getCofingFormatDegres());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('numeric');
                $info->save();
            }
            
            $info = $this->getCmd(null, 'alerte_' . $id . '_duree');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_duree', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_duree');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setIsVisible(0);
            $info->setUnite('H');
            $info->setType('info');
            $info->setSubType('numeric');
            $info->save();
            
            if ($showCommande["show_txt_start"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_txt_start');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_txt_start', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_txt_start');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }
            
            $info = $this->getCmd(null, 'alerte_' . $id . '_txt_full');
            if (!is_object($info)) {
                $info = new previsyCmd();
                $info->setName(__('Alerte+' . $id . '_txt_full', __FILE__));
            }
            $info->setLogicalId('alerte_' . $id . '_txt_full');
            $info->setEqLogic_id($this->getId());
            $info->setIsHistorized(0);
            $info->setType('info');
            $info->setSubType('string');
            $info->save();
            
            if ($showCommande["show_txt_mm"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_txt_mm');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_txt_mm', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_txt_mm');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }
            
            if ($showCommande["show_txt_temperature"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_txt_temperature');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_txt_temperature', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_txt_temperature');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }
            
            if ($showCommande["show_txt_humidite"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_txt_humidite');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_txt_humidite', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_txt_humidite');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }
            
            if ($showCommande["show_txt_vent"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_txt_vent');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_txt_vent', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_txt_vent');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }
            
            if ($showCommande["show_vent_nom"] == 1) {
                $info = $this->getCmd(null, 'alerte_' . $id . '_vent_nom');
                if (!is_object($info)) {
                    $info = new previsyCmd();
                    $info->setName(__('Alerte+' . $id . '_vent_nom', __FILE__));
                }
                $info->setLogicalId('alerte_' . $id . '_vent_nom');
                $info->setEqLogic_id($this->getId());
                $info->setIsHistorized(0);
                $info->setIsVisible(0);
                $info->setType('info');
                $info->setSubType('string');
                $info->save();
            }
        }

        $refresh = $this->getCmd(null, 'refresh');
        if (!is_object($refresh)) {
            $refresh = new previsyCmd();
            $refresh->setName(__('Rafraichir', __FILE__));
        }
        $refresh->setEqLogic_id($this->getId());
        $refresh->setLogicalId('refresh');
        $refresh->setType('action');
        $refresh->setSubType('other');
        $refresh->save();

        log::add('previsy', 'debug', 'postSave :. Fin de la création ou Mise à jour des commandes #ID#' . $this->getId());

        $eqLogic = self::byId($this->getId());
        if ($eqLogic->getIsEnable() == 1 AND $eqLogic->getConfiguration("ville") != "") {
            log::add('previsy', 'debug', 'postSave :. miseEnCacheJson : ' . $eqLogic->getConfiguration("ville"));
            $this->updateJsonDatas($this->getId());
        }
    }

    public function preUpdate() {
        log::add('previsy', 'debug', 'preUpdate :. lancement');
    }

    public function postUpdate() {
        log::add('previsy', 'debug', 'postUpdate :. lancement');
    }

    public function preRemove() {
        $config = $this->getConfigPrevisy();
        $tempJson = $config["jsonTampon"] . $this->getConfiguration("ville") . ".json";
        if (is_file($tempJson)) {
            log::add('previsy', 'debug', 'preRemove :. Suppression du fichier Json : ' . $tempJson);
            unlink($tempJson);
        }
    }

    public function postRemove() {
        log::add('previsy', 'debug', 'postRemove :. lancement');
    }

// Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin

    public function toHtml($_version = 'dashboard') {

        $config = $this->getConfigPrevisy();

        $replace = $this->preToHtml($_version); //récupère les informations de notre équipement

        if (!is_array($replace)) {
            return $replace;
        }
        
        $showCommande = $this->getCofingShowCommandes();

        $this->emptyCacheWidget(); //vide le cache. Pratique pour le développement
        $version = jeedom::versionAlias($_version);

        $last_date = $this->getCmd(null, 'ville');
        $replace['#ville#'] = (is_object($last_date)) ? $last_date->execCmd() : '';
        
        $last_date = $this->getCmd(null, 'latitude');
        $replace['#latitude#'] = (is_object($last_date)) ? $last_date->execCmd() : '';
        
        $last_date = $this->getCmd(null, 'longitude');
        $replace['#longitude#'] = (is_object($last_date)) ? $last_date->execCmd() : '';

        $last_date = $this->getCmd(null, 'last_update');
        $replace['#last_date#'] = (is_object($last_date)) ? $last_date->execCmd() : '';

        for ($i = 1; $i <= $config["maxAlerte"]; $i++) {
            $tmp_cmd = "alerte_0" . $i . "_dans_heure";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';

            $tmp_cmd = "alerte_0" . $i . "_date_start";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';

            $tmp_cmd = "alerte_0" . $i . "_date_end";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';

            $tmp_cmd = "alerte_0" . $i . "_type";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';

            $tmp_cmd = "alerte_0" . $i . "_duree";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            
            if ($showCommande["show_mm_min"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_mm_min";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }
            
            if ($showCommande["show_mm_max"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_mm_max";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_mm_moyenne"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_mm_moyenne";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_mm_total"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_mm_total";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }
            
            if ($showCommande["show_temp_min"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_temp_min";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_temp_max"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_temp_max";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_temp_moyenne"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_temp_moyenne";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }
            
            if ($showCommande["show_humidite_min"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_humidite_min";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_humidite_max"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_humidite_max";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_humidite_moyenne"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_humidite_moyenne";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }
            
            if ($showCommande["show_vent_min"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_vent_min";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_vent_max"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_vent_max";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_vent_moyenne"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_vent_moyenne";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }
            
            if ($showCommande["show_rafale_min"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_rafale_min";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_rafale_max"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_rafale_max";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            if ($showCommande["show_rafale_moyenne"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_rafale_moyenne";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? number_format(${$tmp_cmd}->execCmd(), 1) : '';
            }

            $tmp_cmd = "alerte_0" . $i . "_txt_full";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';

            if ($showCommande["show_txt_start"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_txt_start";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            if ($showCommande["show_txt_mm"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_txt_mm";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            if ($showCommande["show_txt_temperature"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_txt_temperature";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            if ($showCommande["show_txt_humidite"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_txt_humidite";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            if ($showCommande["show_txt_vent"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_txt_vent";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            if ($showCommande["show_vent_nom"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_vent_nom";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            if ($showCommande["show_condition_max"] == 1) {
                $tmp_cmd = "alerte_0" . $i . "_condition_max";
                ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
                $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
            }

            $tmp_cmd = "alerte_0" . $i . "_widget";
            ${$tmp_cmd} = $this->getCmd(null, $tmp_cmd);
            $replace["#" . $tmp_cmd . "#"] = (is_object(${$tmp_cmd})) ? ${$tmp_cmd}->execCmd() : '';
        }

        return template_replace($replace, getTemplate('core', $version, 'previsy', 'previsy'));
    }

    /*
     * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
      public static function postConfig_<Variable>() {
      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
      public static function preConfig_<Variable>() {
      }
     */

    /*     * **********************Getteur Setteur*************************** */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# START -> PREVISY
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    
    public function get($_id) {

        log::add('previsy', 'debug', 'get :. #ID#' . $_id . ' lancement');

        $eqLogic = self::byId($_id);

        $config = $eqLogic->getConfigPrevisy();

        $config["LANGUE"] = "fr_FR";

        if ($config["LANGUE"] == "fr_FR") {
            log::add('previsy', 'debug', 'get :. Chargement du module de construction des phrases en Français');
            require_once $config["phrasesLangues"] . 'previsy.class.fr_FR.php';
        } else {
            log::add('previsy', 'debug', 'get :. Chargement du module de construction des phrases en Anglais');
            require_once $config["phrasesLangues"] . 'previsy.class.en_US.php';
        }

        $now = $tmp_now = $al_last = array();

        if ($eqLogic->getIsEnable() == 1) {

            // Données de configuration widget
            $now["GLOBAL"]["VILLE"] = $eqLogic->getConfiguration("ville");
            $now["GLOBAL"]["TYPE_DEGRE"] = $eqLogic->getCofingFormatDegres();

            // Récuprération des données JSON
            log::add('previsy', 'debug', 'get :. Chargement des données du Json en Tampon #ID#' . $_id);
            $getJson = $eqLogic->getJsonTampon($eqLogic->getId());

            $json = $getJson["datas"];
            $now["GLOBAL"]["LAST_SYNCHRO"] = $getJson["datetime"];
            
            if(!empty($eqLogic->getConfiguration("latitude")) AND !empty($eqLogic->getConfiguration("longitude"))){
                $now["GLOBAL"]["VILLE"] = NULL;
                $now["GLOBAL"]["LATITUDE"] = $eqLogic->getConfiguration("latitude");
                $now["GLOBAL"]["LONGITUDE"] = $eqLogic->getConfiguration("longitude");
            } elseif(!empty($eqLogic->getConfiguration("ville"))){
                $now["GLOBAL"]["VILLE"] = $eqLogic->getConfiguration("ville");
                $now["GLOBAL"]["LATITUDE"] = $json->city_info->latitude;
                $now["GLOBAL"]["LONGITUDE"] = $json->city_info->longitude;
            }

            if (!is_array($json->errors)) {

                $date = new DateTime("Now");
                $date_plus_un = new DateTime("Now");
                $date_plus_un->add(new DateInterval('PT1H'));
                $lang = new previsy_language;

                $tmp_day = $lang->getDate($date);

                $dur = $alertes = 0;

                if ($date->format('i') >= 50) { // A partir de 50 on annonce le temps de l'heure suivante
                    $date->add(new DateInterval('PT1H'));
                    $date_plus_un->add(new DateInterval('PT2H'));
                    $now["GLOBAL"]["HEURE+0"] = $eqLogic->formatHeure($date->format('H')) . "H00";
                } else {
                    $now["GLOBAL"]["HEURE+0"] = $eqLogic->formatHeure($date->format('H')) . "H00";
                }

                for ($i = 0; $i <= $config["prevHeure"]; $i++) {

                    $tmp_now = NULL;
                    $tmp_now["+H"] = $i;

                    if ($i == 0) {
                        $a = 0;
                        $tmp_now["TMP"]["HOUR_JSON"] = $now["GLOBAL"]["HEURE+0"];
                    } else {
                        $date->add(new DateInterval('PT1H'));
                        $date_plus_un->add(new DateInterval('PT1H'));
                        $tmp_now["TMP"]["HOUR_JSON"] = $eqLogic->formatHeure($date->format('H')) . "H00";
                    }

                    if ($date->format('H') == "00" AND $i != 0) {
                        $a++;
                    }

                    $tmp_now["+J"] = $a;

                    $tmp_day = $lang->getDate($date);
                    $tmp_day_plus_un = $lang->getDate($date_plus_un);

                    $tmp_now["TMP"]["DAY_JSON"] = "fcst_day_" . $a;
                    $tmp_now["TMP"]["CONDITION"] = $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->CONDITION;
                    $tmp_now["CONDITION_KEY"] = $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->CONDITION_KEY;

                    // Récupération des alertes météo
                    $txt_meteo = $lang->infosCondition($tmp_now["TMP"]["CONDITION"]);

                    // Créer une alerte en fonction du seuil de vent
                    if ($json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->WNDSPD10m >= $eqLogic->getConfiguration("seuilVent")) {
                        $alerteVent = TRUE;
                    } else {
                        $alerteVent = FALSE;
                    }

                    // Regroupe les alertes
                    if ($txt_meteo == NULL AND $alerteVent == FALSE) {
                        unset($al_last);
                    } elseif ($alertes < $eqLogic->getCofingNbAlerte()) {
                        
                        if (!isset($al_last["TYPE"])) {
                            $alertes++;
                            $al_last["START"] = $date->format('YmdH') . "00";
                            $al_last["START_TXT"] = $tmp_day["JOUR_TXT"];
                            $dur = 1;
                            $al_last["DANS_JOUR"] = $a;
                            $al_last["DANS_HEURE"] = $i;
                            log::add('previsy', 'debug', 'get :. Alerte [' . $al_last["START"] . '] ' . $al_last["TYPE"] . ' ajoutée pour ' . $now["GLOBAL"]["VILLE"]);
                        }

                        $al_last["END"] = $date_plus_un->format('YmdH') . "00";
                        $al_last["END_TXT"] = $tmp_day_plus_un["JOUR_TXT"];

                        if ($txt_meteo != NULL) {
                            $al_last["TYPE"] = $txt_meteo["ALERTE"];
                        } else {
                            $al_last["TYPE"] = "vent";
                        }

                        $al_last["HEURE"] = $date->format('G');
                        $al_last["ICON"] = $eqLogic->getIcon($al_last["TYPE"]);


                        // Précipitations
                        $mm = $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->APCPsfc;

                        $al_last["MM"]["ARRAY"][] = $mm;

                        $al_last["MM"]["MIN"] = min($al_last["MM"]["ARRAY"]);
                        if ($mm == min($al_last["MM"]["ARRAY"])) {
                            $al_last["MM"]["CONDITION_MIN_TXT"] = $txt_meteo["TXT"];
                        }

                        $al_last["MM"]["MAX"] = max($al_last["MM"]["ARRAY"]);
                        if ($mm == max($al_last["MM"]["ARRAY"])) {
                            $al_last["MM"]["CONDITION_MAX_TXT"] = $txt_meteo["TXT"];
                            $al_last["CONDITION_MAX"] = $tmp_now["TMP"]["CONDITION"];
                        }

                        $al_last["MM"]["TOTAL"] = array_sum($al_last["MM"]["ARRAY"]);
                        $al_last["MM"]["MOY"] = $al_last["MM"]["TOTAL"] / count($al_last["MM"]["ARRAY"]);

                        // Températures 
                        if ($now["GLOBAL"]["TYPE_DEGRE"] == "°C") {
                            $temperature = $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->TMP2m;
                        } else {
                            $temperature = $eqLogic->celsiusToFahrenheit($json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->TMP2m);
                        }
                        
                        $al_last["TEMPERATURE"] = $eqLogic->getMinMaxMoyenne($al_last["TEMPERATURE"], $temperature);

                        // Autres données
                        $al_last["HUMIDITE"] = $eqLogic->getMinMaxMoyenne($al_last["HUMIDITE"], $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->RH2m);
                        $al_last["VENT_VITESSE"] = $eqLogic->getMinMaxMoyenne($al_last["VENT_VITESSE"], $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->WNDSPD10m);
                        $al_last["VENT_RAFALES"] = $eqLogic->getMinMaxMoyenne($al_last["VENT_RAFALES"], $json->{$tmp_now["TMP"]["DAY_JSON"]}->hourly_data->{$tmp_now["TMP"]["HOUR_JSON"]}->WNDGUST10m);

                        $al_last["VENT_NOM"] = $lang->echelleBeaufort($al_last["VENT_VITESSE"]["MOY"]);

                        $al_last["DUREE_HEURE"] = $dur++;
                        $al_last["AFFICHE_TXT_WIDGET"] = $eqLogic->getConfiguration("afficheTxt");

                        $al_last["TXT"] = $lang->constructTxt($al_last, $now["GLOBAL"]["TYPE_DEGRE"]);

                        $now["ALERTES"]["GROUP"][$alertes] = $al_last;

                        $now["ALERTES"]["DETAILS"][] = $tmp_now;
                    }
                }
                if (!isset($now["ALERTES"]["DETAILS"][0]["CONDITION_KEY"])) {
                    log::add('previsy', 'debug', 'get :. Aucune alerte pour ' . $now["GLOBAL"]["VILLE"]);
                }

                return $now;
            } else {
                log::add("previsy", "error", "get :. La ville " . $now["GLOBAL"]["VILLE"] . " n'est pas référencé sur prevision-meteo.ch");
                $now["ERROR"] = TRUE;
                return $now;
            }
        }
    }

    public function clearDatas($previsy) {
        log::add('previsy', 'debug', 'clearDatas :. Lancement du nettoyage des commandes');
        $cmds = $previsy->getCmd();
        foreach ($cmds as $cmd) {
            if ($cmd->getLogicalId() != 'refresh') {
                $previsy->checkAndUpdateCmd($cmd->getLogicalId(), NULL);
            }
        }
        log::add('previsy', 'debug', 'clearDatas :. Fin du nettoyage des commandes');
    }

    public function getIdEtNameCmd($_idKey, $_sarray) {
        foreach ($_sarray as $name) {
            $nameCmd = 'alerte_' . $_idKey . '_' . $name;
            $tempCmd = $this->getCmd(null, $nameCmd);
            $return[$name]["id"] = $tempCmd->getId();
            $return[$name]["name"] = $nameCmd;
        }
        return $return;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# STOP -> PREVISY
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# START -> GESTION DES OUTILS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getMinMaxMoyenne($_array, $_input) {
        $return = $_array;
        $return["ARRAY"][] = $_input;
        $return["MIN"] = min($return["ARRAY"]);
        $return["MAX"] = max($return["ARRAY"]);
        $return["MOY"] = array_sum($return["ARRAY"]) / count($return["ARRAY"]);
        return $return;
    }

    public function showDebug($_array) {
        echo "<pre>";
        print_r($_array);
        echo "</pre>";
    }

    public function getIcon($_type) {

        $config = $this->getConfigPrevisy();
        $config["icons"];

        switch ($_type) {
            case "pluie":
                return $config["icons"] . "pluie.svg";
                break;
            case "neige":
                return $config["icons"] . "neige.svg";
                break;
            case "neige_pluie":
                return $config["icons"] . "neige.svg";
                break;
            case "orage":
                return $config["icons"] . "eclair.svg";
                break;
            case "brouillard":
                return $config["icons"] . "brouillard.svg";
                break;
            case "vent":
                return $config["icons"] . "vent.svg";
                break;
        }
    }

    public function celsiusToFahrenheit($_temp) {
        return $_temp * 9 / 5 + 32;
    }

    public function formatHeure($_heure) {
        if ($_heure < 10) {
            return substr($_heure, 1, 1);
        } else {
            return $_heure;
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# STOP -> GESTION DES OUTILS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# START -> GESTION JSON
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getJsonTampon($_id) {
        $config = $this->getConfigPrevisy();
        $return["datas"] = json_decode(file_get_contents($config["jsonTampon"] . $_id . ".json"));
        $return["datetime"] = filemtime($config["jsonTampon"] . $_id . ".json");
        log::add('previsy', 'debug', 'getJsonTampon :. Chargement du Json : ' . $config["jsonTampon"] . $_id . '.json');
        return $return;
    }

    public function updateJsonDatas($_id = NULL) {
        $eqLogic = self::byId($_id);

        $ville = $eqLogic->getConfiguration("ville");
        
        $latitude = $eqLogic->getConfiguration("latitude");
        $ongitude = $eqLogic->getConfiguration("longitude");
        
        $config = $eqLogic->getConfigPrevisy();

        $tempJson = $config["jsonTampon"] . $_id . ".json";

        if (is_file($tempJson)) {
            $lastUpdate = filemtime($config["jsonTampon"] . $_id . ".json");
            $diffTime = time() - $lastUpdate;
            if ($diffTime > $config["timeSynchro"]) {
                log::add('previsy', 'debug', 'updateJsonDatas :. Temps de cache écoulé rechargement des données depuis prevision-meteo.ch');
                $eqLogic->miseEnCacheJson($_id);
                log::add('previsy', 'debug', 'updateJsonDatas :. Mise à jour depuis le json en cache');
                $eqLogic->UpdateDatas($eqLogic);
            } else {
                log::add('previsy', 'debug', 'updateJsonDatas :. Mise à jour depuis le json en cache');
                $eqLogic->UpdateDatas($eqLogic);
            }
        } else {
            log::add('previsy', 'debug', 'updateJsonDatas :. Json en cache inexistant chargement des données depuis prevision-meteo.ch');
            $eqLogic->miseEnCacheJson($_id);
            log::add('previsy', 'debug', 'updateJsonDatas :. Mise à jour depuis le json en cache');
            $eqLogic->UpdateDatas($eqLogic);
        }
    }

    public function miseEnCacheJson($_id = NULL) {
        $eqLogic = self::byId($_id);

        $ville = $this->getConfiguration("ville");
        
        $latitude = $this->getConfiguration("latitude");
        $longitude = $this->getConfiguration("longitude");
        
        if(!empty($latitude) AND !empty($longitude)){
            $searchBy = "lat=".$latitude."lng=".$longitude;
        } else {
            $searchBy = $ville;
        }
        
        $config = $this->getConfigPrevisy();

        $tempStartTimeUrl = time();

        if (!is_dir($config["jsonTampon"])) {
            log::add('previsy', 'debug', 'miseEnCacheJson :.  Création du dossier ' . $config["jsonTampon"]);
            mkdir($config["jsonTampon"], 0777);
        }

        log::add('previsy', 'debug', 'miseEnCacheJson :. Récupération des données ' . $config["urlApi"] . $ville);
        $json = file_get_contents($config["urlApi"] . $searchBy); // Prod

        if (!empty($json)) {
            $file_tmp = $config["jsonTampon"] . $_id . ".temp";
            $file = $config["jsonTampon"] . $_id . ".json";

            $fichier = fopen($file_tmp, 'w');
            fputs($fichier, $json);
            fclose($fichier);

            unlink($file);
            rename($file_tmp, $file);
            chmod($file, 0777);

            $tempStopTimeUrl = time();
            $tempTimeUrl = $tempStopTimeUrl - $tempStartTimeUrl;

            log::add('previsy', 'debug', 'miseEnCacheJson :. La récupération des données de ' . $ville . ' faite en ' . $tempTimeUrl . ' secondes');
            log::add('previsy', 'debug', 'miseEnCacheJson :. Enregistrement du Json : ' . $file);
        } else {
            log::add('previsy', 'debug', 'miseEnCacheJson :.  Impossible de se connecter à https://www.prevision-meteo.ch/services/json/' . $ville . '. Le cache est donc conservé.');
            //log::add('previsy', 'error', 'miseEnCacheJson :. Impossible de se connecter à https://www.prevision-meteo.ch/services/json/' . $ville . '. Le cache est donc conservé.');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# STOP -> GESTION JSON
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# START -> GESTION DU WIDGET
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getWidget($_datas, $_cmdIds = NULL) {

        log::add('previsy', 'debug', 'getWidget :. Lancement de la création ou de la mise à jour du Widget #ID#' . $_cmdIds["widget"]["id"]);

        $degre = $this->getCofingFormatDegres();

        if ($_datas["DANS_HEURE"] == 0) {
            $dansHeure = "<span style='font-weight: bold;'>En ce moment</span>";
        } else {
            $dansHeure = "Dans <span style='font-weight: bold;'>" . $_datas["DANS_HEURE"] . "H</span>";
        }
        $return = "<div data-cmd_id='" . $_cmdIds["widget"] . "' class='previsyWidget'>
        
                    
                        <div style ='text-align: center; display: inline-block; margin: 2px;'>
                            <div style='font-size: 1em;'>" . $dansHeure . "</div>
                            <div style='font-size: 4em; margin-top: -10px;'><img title='Alerte " . $_datas["TYPE"] . "' src='" . $_datas["ICON"] . "' width='60px'></img></div>
                            <div style='font-size:0.9em;'><span style='font-weight: bold;'>" . $_datas["START_TXT"] . "</span> | <span style='font-weight: bold;'>" . $_datas["END_TXT"] . "</span></div>
                            <div style='font-size:0.9em' margin-top: -10px;><span style='font-weight: bold;'>" . $_datas["CONDITION_MAX"] . "</span> au plus haut et pour une durée de <span style='font-weight: bold;'>" . $_datas["DUREE_HEURE"] . "H</span></div>
                            <div style='font-size:0.9em;'>Type de vent : <span style='font-weight: bold;'>" . $_datas["VENT_NOM"] . "</span></div>                        
                        </div>
                    
                    <div style='display: inline-block; text-align: center;'>
                        <div class='previsyBlock previsyBlock1'>
                            <div class='previsyBlockMoyenne'>
                                <div><i title='Total des précipitation' class='fas fa-tachometer-alt' style='font-size:2em; height: 31px;'></i></div>
                                <div class='previsySubTitleMoyenne'>- Moyenne -</div>
                                <div class='previsySubChiffreMoyenne'>" . number_format($_datas["MM"]["MOY"], 1) . "<span style='font-size:0.7em'>MM</span></div>
                                <div class='previsySubTitleMoyenne'>Précipitation (" . $_datas["MM"]["TOTAL"] . "<span style='font-size:0.6em'>MM</span>)</div>
                            </div>";
        if ($_datas["DUREE_HEURE"] > 1) {
            $return .= "<div class='previsyBlockMinMax'>
                                <div class ='previsySubBlock previsySubBlock_G'>
                                    <div class='previsySubChiffre'>" . $_datas["MM"]["MIN"] . "<span style='font-size:0.7em'>MM</span></div>
                                    <div class='previsySubTitleMoyenne'>Min.</div>
                                </div>
                                <div class ='previsySubBlock previsySubBlock_D'>
                                    <div class='previsySubChiffre'>" . $_datas["MM"]["MAX"] . "<span style='font-size:0.7em'>MM</span></div>
                                    <div class='previsySubTitleMoyenne'>Max.</div>
                                </div>
                            </div>";
        }
        $return .= "</div>
                        <div class='previsyBlock  previsyBlock2'>
                            <div class='previsyBlockMoyenne'>
                                <div><i title='Tempétature moyenne' class='icon jeedom-thermo-moyen' style='font-size:2em'></i></div>
                                <div class='previsySubTitleMoyenne'>- Moyenne -</div>
                                <div class='previsySubChiffreMoyenne'>" . number_format($_datas["TEMPERATURE"]["MOY"], 1) . "<span style='font-size:0.7em'>" . $degre . "</span></div>
                                <div class='previsySubTitleMoyenne'>Température</div>
                            </div>";
        if ($_datas["DUREE_HEURE"] > 1) {
            $return .= "<div class='previsyBlockMinMax'>
                                <div class ='previsySubBlock previsySubBlock_G'>
                                    <div class='previsySubChiffre'>" . $_datas["TEMPERATURE"]["MIN"] . "<span style='font-size:0.7em'>" . $degre . "</span></div>
                                    <div class='previsySubTitleMoyenne'>Min.</div>
                                </div>
                                <div class ='previsySubBlock previsySubBlock_D'>
                                    <div class='previsySubChiffre'>" . $_datas["TEMPERATURE"]["MAX"] . "<span style='font-size:0.7em'>" . $degre . "</span></div>
                                    <div class='previsySubTitleMoyenne'>Max.</div>
                                </div>
                            </div>";
        }
        $return .= "</div>
                        <div class='previsyBlock  previsyBlock3'>
                            <div class='previsyBlockMoyenne'>
                                <div><i title='Humidité moyenne en pourcentage' class='icon jeedomapp-humidity' style='font-size:2em'></i></div>
                                <div class='previsySubTitleMoyenne'>- Moyenne -</div>
                                <div class='previsySubChiffreMoyenne'>" . number_format($_datas["HUMIDITE"]["MOY"], 1) . "<span style='font-size:0.7em'>%</span></div>
                                <div class='previsySubTitleMoyenne'>Humidité</div>
                            </div>";
        if ($_datas["DUREE_HEURE"] > 1) {
            $return .= "<div class='previsyBlockMinMax'>
                                <div class ='previsySubBlock previsySubBlock_G'>
                                    <div style='font-size:1em'>" . $_datas["HUMIDITE"]["MIN"] . "<span style='font-size:0.7em'>%</span></div>
                                    <div class='previsySubTitleMoyenne'>Min.</div>
                                </div>
                                <div class ='previsySubBlock previsySubBlock_D'>
                                    <div class='previsySubChiffre'>" . $_datas["HUMIDITE"]["MAX"] . "<span style='font-size:0.7em'>%</span></div>
                                    <div class='previsySubTitleMoyenne'>Max.</div>
                                </div>
                            </div>";
        }
        $return .= "</div>
                        <div class='previsyBlock  previsyBlock4'>
                            <div class='previsyBlockMoyenne'>
                                <div><i title='Vitesse moyenne du vent' class='icon meteo-vent' style='font-size:2em'></i></div>
                                <div class='previsySubTitleMoyenne'>- Moyenne -</div>
                                <div class='previsySubChiffreMoyenne'>" . number_format($_datas["VENT_VITESSE"]["MOY"], 1) . "<span style='font-size:0.7em'>Km/H</span></div>
                                <div class='previsySubTitleMoyenne'>Vitesse du vent</div>
                            </div>";
        if ($_datas["DUREE_HEURE"] > 1) {
            $return .= "<div class='previsyBlockMinMax'>
                                <div class ='previsySubBlock previsySubBlock_G'>
                                    <div class='previsySubChiffre'>" . $_datas["VENT_VITESSE"]["MIN"] . "<span style='font-size:0.7em'>Km/H</span></div>
                                    <div class='previsySubTitleMoyenne'>Min.</div>
                                </div>
                                <div class ='previsySubBlock previsySubBlock_D'>
                                    <div style='font-size:1em'>" . $_datas["VENT_VITESSE"]["MAX"] . "<span style='font-size:0.7em'>Km/H</span></div>
                                    <div class='previsySubTitleMoyenne'>Max.</div>
                                </div>
                            </div>";
        }
        $return .= "</div>

                        <div class='previsyBlock  previsyBlock5'>
                            <div class='previsyBlockMoyenne'>
                                <div><i title='Vitesse moyenne des rafales' class='icon techno-ventilation' style='font-size:2em'></i></div>
                                <div class='previsySubTitleMoyenne'>- Moyenne -</div>
                                <div class='previsySubChiffreMoyenne'>" . number_format($_datas["VENT_RAFALES"]["MOY"], 1) . "<span style='font-size:0.7em'>Km/H</span></div>
                                <div class='previsySubTitleMoyenne'>Force Rafales</div>
                            </div>";
        if ($_datas["DUREE_HEURE"] > 1) {
            $return .= "<div class='previsyBlockMinMax'>
                                <div class ='previsySubBlock previsySubBlock_G'>
                                    <div class='previsySubChiffre'>" . $_datas["VENT_RAFALES"]["MIN"] . "<span style='font-size:0.7em'>Km/H</span></div>
                                    <div class='previsySubTitleMoyenne'>Min.</div>
                                </div>
                                <div class ='previsySubBlock previsySubBlock_D'>
                                    <div class='previsySubChiffre'>" . $_datas["VENT_RAFALES"]["MAX"] . "<span style='font-size:0.7em'>Km/H</span></div>
                                    <div class='previsySubTitleMoyenne'>Max.</div>
                                </div>
                            </div>";
        }
        $return .= "</div>
                    </div>";

        if ($_datas["AFFICHE_TXT_WIDGET"] == 1) {
            $return .= "<div data-cmd_id='" . $_cmdIds["txt_full"]["id"] . "'>
                        <textarea rows='4' style='width:100%;'>" . $_datas["TXT"]["FULL"] . "</textarea>
                    </div>";
        }
        $return .= "<div style='float:none; clear:both'></div>
            </div>";

        log::add('previsy', 'debug', 'getWidget :. Fin de la création ou de la mise à jour du Widget #ID#' . $_cmdIds["widget"]["id"]);

        return $return;
    }

    public function getWidgetNull() {
        log::add('previsy', 'debug', 'getWidgetNull :. Création widget rien à signaler');
        return "<div style='width:100%; padding:0 5px;'>
                    <div class='previsyWidget' style='margin:0; padding:5px; width:100%;'>
                        <div style ='text-align: center; display: inline-block; margin: 2px;'>
                            <div style='font-size: 4em; margin-top: -10px;'><i class='far fa-check-circle'></i></div>
                            <div style='font-size: 1em;'>Auncune alerte à déclarer</div>  
                        </div>
                   </div>
                </div>";
    }

    public function getWidgetError($_ville) {
        log::add('previsy', 'debug', 'getWidgetError :. Création widget error');
        return "<div style='width:100%; padding:0 5px;'>
                    <div class='previsyWidget' style='margin:0; padding:5px; width:100%;'>
                        <div style ='text-align: center; display: inline-block; margin: 2px;'>
                            <div style='font-size: 4em; margin-top: -10px;'><i class='fas fa-exclamation-triangle'></i></div>
                            <div style='font-size: 1em;'>La ville de <span style='font-weight: bold;'>" . $_ville . "</span> n'est pas référencée sur prevision-meteo.ch </div>
                       </div>
                    </div>
                   </div>";
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# STOP -> GESTION DU WIDGET
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

class previsyCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

    public function execute($_options = array()) {
        $eqlogic = $this->getEqLogic();
        switch ($this->getLogicalId()) { //vérifie le logicalid de la commande 			
            case 'refresh': // LogicalId de la commande rafraîchir que l’on a créé dans la méthode Postsave 
                log::add('previsy', 'debug', 'execute :. Lancement de la commande refresh : #ID#' . $eqlogic->getId());
                $eqlogic->updateJsonDatas($eqlogic->getId());
                break;
        }
    }

    /*     * **********************Getteur Setteur*************************** */
}
