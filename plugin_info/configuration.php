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
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Commandes à afficher (en option pour vos scénarios)}}</label>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_mm_min" />
                <span>Commandes mm_min</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_mm_max" />
                <span>Commandes mm_max</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_mm_moyenne" />
                <span>Commandes mm_moyenne</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_mm_total" />
                <span>Commandes mm_total</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_temp_min" />
                <span>Commandes temp_min</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_temp_max" />
                <span>Commandes temp_max</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_temp_moyenne" />
                <span>Commandes temp_moyenne</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_humidite_min" />
                <span>Commandes humidite_min</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_humidite_max" />
                <span>Commandes humidite_max</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_humidite_moyenne" />
                <span>Commandes humidite_moyenne</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_vent_min" />
                <span>Commandes vent_min</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_vent_max" />
                <span>Commandes vent_max</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_vent_moyenne" />
                <span>Commandes vent_moyenne</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_vent_nom" />
                <span>Commandes vent_nom</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_rafale_min" />
                <span>Commandes rafale_min</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_rafale_max" />
                <span>Commandes rafale_max</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_rafale_moyenne" />
                <span>Commandes rafale_moyenne</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_txt_start" />
                <span>Commandes txt_start</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_txt_mm" />
                <span>Commandes txt_mm</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_txt_humidite" />
                <span>Commandes txt_humidite</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_txt_temperature" />
                <span>Commandes txt_temperature</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_txt_vent" />
                <span>Commandes txt_vent</span>
            </div>
        </div>
        <div class="form-group">
            <span class="col-lg-4 control-label"></span>
            <div class="col-lg-3">
                <input type="checkbox" class="configKey form-control" style="top:0" data-l1key="show_condition_max" />
                <span>Commandes condition_max</span>
            </div>
        </div>
  </fieldset>
</form>

