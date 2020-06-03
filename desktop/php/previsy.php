<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('previsy');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
    <div class="col-xs-12 eqLogicThumbnailDisplay">
        <legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction logoPrimary" data-action="add">
                <i class="fas fa-plus-circle"></i>
                <br>
                <span>{{Ajouter une ville}}</span>
            </div>
            <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
                <i class="fas fa-wrench"></i>
                <br>
                <span>{{Configuration}}</span>
            </div>
        </div>
        <legend><i class="fas fa-table"></i> {{Mes villes}}</legend>
        <input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />
        <div class="eqLogicThumbnailContainer">
            <?php
            foreach ($eqLogics as $eqLogic) {
                $opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
                echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
                echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
                echo '<br>';
                echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="col-xs-12 eqLogic" style="display: none;">
        <div class="input-group pull-right" style="display:inline-flex">
            <span class="input-group-btn">
                <a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
            </span>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
            <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
            <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
        </ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                <br/>
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Nom du lieu à sonder}}</label>
                            <div class="col-sm-3">
                                <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                                <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom du lieu à sonder}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                            <div class="col-sm-3">
                                <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                                    <option value="">{{Aucun}}</option>
                                    <?php
                                    foreach (jeeObject::all() as $object) {
                                        echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Catégorie}}</label>
                            <div class="col-sm-9">
                                <?php
                                foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                    echo '<label class="checkbox-inline">';
                                    echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                    echo '</label>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                                <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 15px;">
                            <label class="col-sm-3 control-label">{{Nom de la ville}}</label>
                            <div class="col-sm-3">
                                <input type="text" onkeyup="this.value=previsyNormalizer(this.value);" onfocus="this.value=previsyNormalizer(this.value);" class="eqLogicAttr form-control previsyVille" data-l1key="configuration" data-l2key="ville" placeholder="ville" />
                            </div>
                            <span style="float:left">
                                <span id="previsyLinkVille"></span>
                            </span>
                            <div><a href="" target="_blank"></a></div>
                        </div>
                        <div class="form-group" style="margin-top: 15px;">
                            <label class="col-sm-3 control-label">{{Coordonnées du point (prend le dessus sur la ville)}}</label>
                            <div class="col-sm-3">
                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="latitude" placeholder="latitude" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="longitude" placeholder="longitude" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            </div>
                            <div><a href="" target="_blank"></a></div>
                        </div>
<!--                        <div class="form-group" style="margin-top: 5px;">
                            <label class="col-sm-3 control-label">{{Afficher le widget (si vous utilisez seulement les datas)}}</label>
                            <div class="col-sm-3">
                                <input type="checkbox" class="eqLogicAttr checkbox-inline" data-l1key="configuration"  data-l2key="afficheBigWidget" />
                            </div>
                        </div>-->
                        <div class="form-group" style="margin-top: 5px;">
                            <label class="col-sm-3 control-label">{{Afficher le texte prédictif dans le widget }}</label>
                            <div class="col-sm-3">
                                <input type="checkbox" class="eqLogicAttr checkbox-inline" data-l1key="configuration"  data-l2key="afficheTxt" />
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 15px;">
                            <label class="col-sm-3 control-label">{{Seuil d'alerte pour le vent (échelle de Beaufort)}}</label>
                            <div class="col-sm-3">
                                <select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="seuilVent">
                                    <option value="20">[Force 4] Moyenne du vent à partir de 20 Km/H (Jolie brise)</option>
                                    <option value="29">[Force 5] Moyenne du vent à partir de 29 Km/H (Bonne brise)</option>
                                    <option value="39">[Force 6] Moyenne du vent à partir de 39 Km/H (Vent frais)</option>
                                    <option value="50">[Force 7] Moyenne du vent à partir de 50 Km/H (Grand frais)</option>
                                    <option value="62">[Force 8] Moyenne du vent à partir de 62 Km/H (Coup de vent)</option>
                                    <option value="75">[Force 9] Moyenne du vent à partir de 75 Km/H (Fort coup de vent)</option>
                                    <option value="89">[Force 10] Moyenne du vent à partir de 89 Km/H (Tempête)</option>
                                    <option value="103">[Force 11] Moyenne du vent à partir de 103 Km/H (Violente tempête)</option>
                                    <option value="118">[Force 12] Moyenne du vent à partir de 118 Km/H (Ouragan )</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="commandtab">
                <table id="table_cmd" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>{{Nom}}</th><th>{{Historique}}</th><th>{{Action}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include_file('desktop', 'previsy', 'js', 'previsy'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
