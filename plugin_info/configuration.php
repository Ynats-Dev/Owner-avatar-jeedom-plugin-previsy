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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
?>
<form class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Nombre d'alerte en prévision à afficher}}</label>
            <div class="col-lg-2">
                <select class="configKey form-control" data-l1key="nb_alerte">
                    <option value="1">1 alerte</option>
                    <option value="2">2 alertes</option>
                    <option value="3">3 alertes</option>
                    <option value="4">4 alertes</option>
                    <option value="5">5 alertes</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Temperature}}</label>
            <div class="col-lg-2">
                <select class="configKey form-control" data-l1key="type_degre">
                    <option value="°C">Degrés Celsius (°C)</option>
                    <option value="°F">Degrés Fahrenheit (°F)</option>
                </select>
            </div>
        </div>
       
<?php function addTrConfig($_datal1key, $_name){
    echo '  <tr style="background-color:transparent!important;">
                <td style="padding:2px;"><input type="checkbox" class="configKey form-control" style="top:0" data-l1key="'.$_datal1key.'" /></td>
                <td style="padding:2px;">'.$_name.'</td>
            </tr>';
}
?>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Commandes à afficher (en option pour vos scénarios)}}</label>
            <div class="col-lg-3">
                 <table>
                    <?php
                        addTrConfig("show_mm_min", "Commandes mm_min");
                        addTrConfig("show_mm_max", "Commandes mm_max");
                        addTrConfig("show_mm_moyenne", "Commandes mm_moyenne");
                        addTrConfig("show_mm_total", "Commandes mm_total");
                        addTrConfig("show_temp_min", "Commandes temp_min");
                        addTrConfig("show_temp_max", "Commandes temp_max");
                        addTrConfig("show_temp_moyenne", "Commandes temp_moyenne");
                        addTrConfig("show_humidite_min", "Commandes humidite_min");
                        addTrConfig("show_humidite_max", "Commandes humidite_max");
                        addTrConfig("show_humidite_moyenne", "Commandes humidite_moyenne");  
                        addTrConfig("show_vent_min", "Commandes vent_min");  
                        addTrConfig("show_vent_max", "Commandes vent_max");  
                        addTrConfig("show_vent_moyenne", "Commandes vent_moyenne");  
                        addTrConfig("show_vent_nom", "Commandes vent_nom");  
                        addTrConfig("show_rafale_min", "Commandes rafale_min");  
                        addTrConfig("show_rafale_max", "Commandes rafale_max");  
                        addTrConfig("show_rafale_moyenne", "Commandes rafale_moyenne");  
                        addTrConfig("show_txt_start", "Commandes txt_start");  
                        addTrConfig("show_txt_mm", "Commandes txt_mm");  
                        addTrConfig("show_txt_humidite", "Commandes txt_humidite");
                        addTrConfig("show_txt_temperature", "Commandes txt_temperature");
                        addTrConfig("show_txt_vent", "Commandes txt_vent");
                        addTrConfig("show_condition_max", "Commandes condition_max");
                    ?>
                </table>
            </div>
        </div>

  </fieldset>
</form>

<div style="float: right; font-size: xx-small;">29/08/2020 | Stable 1.0.3</div>