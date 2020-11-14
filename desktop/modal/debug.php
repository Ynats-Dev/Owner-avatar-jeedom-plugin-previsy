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

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$eqLogics = eqLogic::byType('previsy');
        foreach ($eqLogics as $previsy) {
            if ($previsy->getIsEnable() == 1) {
?>

        <div class="col-md-12">
            <div class="panel panel-primary" id="div_functionalityPanel">
                <div class="panel-heading">
                    <h3 class="panel-title"># <?php echo $previsy->getName() ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                        previsy::printArray(previsy::getJsonTampon($previsy->getId()));
                    ?>
                </div>
            </div>
        </div>

        <?php
    }
}
?>
