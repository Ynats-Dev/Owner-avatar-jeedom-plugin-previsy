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

function previsy_install() {
    
}

function previsy_update() {
    if(@glob(__DIR__ . "/../../../plugins/previsy/core/json/*")){
        shell_exec("sudo chmod 777 -R ". __DIR__ . "/../../../plugins/previsy/data");
        shell_exec("sudo mv " . dirname(__DIR__) . "/../../../plugins/previsy/core/json/*.json " . dirname(__DIR__) . "/../../../plugins/previsy/data/json");
    } 
}

function previsy_remove() {
    
}

?>
