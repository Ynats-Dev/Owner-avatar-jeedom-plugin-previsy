
function previsy_cpt() {   
    var checked = $(".previsy_checkbox:checked").length;
    var select = $( "#previsy_select" ).val();
    var nb = checked*select;
    if(nb > 23){
        $('#div_alert_previsy').showAlert({message: "{{Attention ! Vous avez un trop grand nombre de commandes, soit au total "+nb+" commandes et le plugin risque de mettre beaucoup trop de temps à répondre.<br />Pour résoudre le problème, mettre moins d'alerte et/ou moins de commande à afficher.}}", level: 'warning'});
    } else {
        $('#div_alert_previsy').hide();
    }
}

function previsy_mode_plugin() { 
    var mode = $( "#previsy_mode" ).val();
    if(mode == "normal"){
        $('#show_commandes_plus').hide();
    } else {
        $('#show_commandes_plus').show();
    }
}

setTimeout(function(){
    previsy_cpt();
    previsy_mode_plugin();
}, 150);
