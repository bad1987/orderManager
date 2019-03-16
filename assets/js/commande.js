
let articles;

$(window).on("load",initialize);

function showFootable(){
    // Footable
    jQuery(function($){
        $('.mytable').footable();
    });
}

function showFootableLigne(){
    // Footable
    jQuery(function($){
        $('.tableligne').footable();
    });
}

// function showFilter(){
// Footable
jQuery(function($){
    $('.filterDate').footable();
});
// }


// filtrer les statistiques du client en fonction de la periode
function filtrer(){
    let du = document.getElementById('du');
    let au = document.getElementById('au');
    let err = document.getElementById('filterError');

    $(err).text("");

    if(!$(du).val() || !$(au).val()){
        $(err).text("Date invalide");
    }
    else{
        
        var cmde = document.getElementById('cmde');
        var stat = document.getElementById('stat');
        var infosup = document.getElementById('infosup');
        var statInfo = document.getElementById('stat-loading');
        var wait = document.getElementById('waiting');

        cmde.style.display = "none";
        infosup.style.display = "none";
        stat.style.display = "block";
        wait.style.display = "block";

        // on commence par vider la table des statistiques avant de la charger
        $('#tb').empty();

        //chargement des commandes
        $.ajax({
            type:'GET',
            url:'/filterCommandes/'+$(du).val()+'/'+$(au).val(),
            success:function(data){
                wait.style.display = "none";
                var donne=JSON.parse(data);
                // Footable
                var tbody = document.getElementById('tb');
                var table = document.getElementsByClassName('table');
                var i = 0;
                $.each(donne,function(key,value){
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    var td2 = document.createElement('td');
                    var td3 = document.createElement('td');
                    if(i===0){
                        $('tr').attr('data-expanded','true');
                        i = i + 1;
                    }
                    var btn = document.createElement('button');
                    $(btn).attr('class','btn btn-info btn-sm float-right');
                    $(btn).attr('id',value['id']);
                    $(btn).attr('onclick','loadLigne(this)');
                    btn.innerHTML = "D&eacute;tail";

                    td1.innerHTML = value['numCmde'];
                    td2.innerHTML = value['dateCmde'];
                    td3.innerHTML = parseFloat(value['montantHT']);
                    td3.appendChild(btn);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tbody.appendChild(tr);
                });
                // table.style.display = "block";
                showFootable();
            },
            error:function(err){
                console.log('an error occured');
                console.log(err);
            },
            complete:function(com){
                // console.log(com);
            }
        });
        wait.style.display = "none";
    }
}

function initialize(){
    $.ajax({
        type:'GET',
        url:'init',
        success:function(data){
            var select = document.querySelector('#prod');
            articles = JSON.parse(data);
            // console.log(articles);
            $.each(articles,function(index,value){
                var option = document.createElement('option');
                option.text = value['designArt'];
                select.add(option);
            });
            $('select').trigger("chosen:updated");        }
    });

    // init client list
    var  clienttype = $('#user').attr('name');
    if (clienttype == 'COM') {
        initializeClientList();
    }
    
}

function commande(){
    var cmde = document.getElementById('cmde');
    var stat = document.getElementById('stat');
    var infosup = document.getElementById('infosup');
    let ligneCmde = document.getElementById('ligneCmde');

    $(ligneCmde).attr('style','display:none');
    cmde.style.display = "block";
    infosup.style.display = "block";
    stat.style.display = "none";
}


function lisibilite_nombre(nbr) { 
    var nombre = ''+nbr;
    var retour = '';
    var count=0;
    var decimal = 0;
    for(var i=nombre.length-1 ; i>=0 ; i--) {
        if(count!=0 && count % 3 == 0 && i<nombre.length-2 && (nombre[i+1]!='.' || nombre[i+1]!=',') && decimal==1) 
            retour = nombre[i]+' '+retour ;
        else{
            if(nombre[i]=='.'){
                decimal = 1;
            }
            retour = nombre[i]+retour ;
        }

        count++;
        
    }
    // alert('nb : '+nbr+' => '+retour);
    return retour; 
}

function statistique(){
    var cmde = document.getElementById('cmde');
    var stat = document.getElementById('stat');
    var infosup = document.getElementById('infosup');
    var statInfo = document.getElementById('stat-loading');
    var wait = document.getElementById('waiting');

    cmde.style.display = "none";
    infosup.style.display = "none";
    stat.style.display = "block";
    wait.style.display = "block";

    // on commence par vider la table des statistiques avant de la charger
    $('#tb').empty();

    //chargement des commandes
    $.ajax({
        type:'GET',
        url:'statCommandes',
        success:function(data){
            wait.style.display = "none";
            var donne=JSON.parse(data);
            // Footable
            var tbody = document.getElementById('tb');
            var table = document.getElementsByClassName('table');
            var i = 0;
            $.each(donne,function(key,value){
                var tr = document.createElement('tr');
                var td1 = document.createElement('td');
                var td2 = document.createElement('td');
                var td3 = document.createElement('td');
                if(i===0){
                    $('tr').attr('data-expanded','true');
                    i = i + 1;
                }
                var btn = document.createElement('button');
                $(btn).attr('class','btn btn-info btn-sm float-right');
                $(btn).attr('id',value['id']);
                $(btn).attr('onclick','loadLigne(this)');
                btn.innerHTML = "D&eacute;tail";

                td1.innerHTML = value['numCmde'];
                td2.innerHTML = value['dateCmde'];
                td3.innerHTML = parseFloat(value['montantHT']);
                // console.log(parseFloat(value['montantHT']).toLocaleString());
                // console.log(lisibilite_nombre(parseFloat(value['montantHT']).toString()));
                td3.appendChild(btn);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tbody.appendChild(tr);
            });
            // table.style.display = "block";
            showFootable();

            // var ul = document.createElement('ul');
            // $(ul).attr('class','list-group');
            // $.each(donne,function(key,value){
            //     var li = document.createElement('li');
            //     li.innerHTML = "<a href=\"#\"> Commande du: " + value['dateCmde'] + "  Montant HT: " + value['montantHT'] + " fcfa</a>";
            //     $(li).attr('class','list-group-item');
            //     ul.appendChild(li);
            // });
            // statInfo.appendChild(ul);
            // console.log(JSON.parse(data));
            
        },
        error:function(err){
            console.log('an error occured');
            console.log(err);
        },
        complete:function(com){
            // console.log(com);
        }
    });
    wait.style.display = "none";
    // showFilter();
}

var clientName = 'null';

function checkUserType(){
    var user = document.getElementById('user');
    var  clienttype = $(user).attr('name');

    if (clienttype == 'COM') {
        inputDialog();
    }
    else{
        send();
    }
    
}

function send(){

    var rows = document.getElementById('cmdb').rows;
    // console.log(rows);
    var error = document.getElementById('panierVide');
    var pbar = document.getElementById('pbar');
    var con = document.getElementById('confirm');
    var clientList = document.getElementById('clientList');
    var  clienttype = $('#user').attr('name');

    // we start by hiding the select client error
    $("#cl_error").css('display','none');

    if(rows.length === 0){
        error.style.display = "block";
        var tab = document.getElementById("tab");
        $(tab).css('display','none');
    }
    else if (clienttype == 'COM' && clientList[clientList.selectedIndex].value == "") {
        $("#cl_error").css('display','inline');
    }
    else{
        
        var user = document.getElementById('user');
        let clientName = 'NULL';
        var clientRef = 'NULL';
        var clientDesign = 'NULL';
        // console.log(clientRef);

        if (clienttype == 'COM') {
             clientRef = clientList[clientList.selectedIndex].value;
             clientDesign = clientList[clientList.selectedIndex].text;
        }
        error.style.display = "none";

        // progress bar and "valider" button
        pbar.style.display = "block";
        con.disabled=true;

        // var rows = document.getElementById('cmdb').rows;
        var order = {};
        for (var i = 0; i < rows.length; i++) {
            var artIndex = $(rows[i].cells[3].children).attr('data-index');
            var previous = 0;
            try{
                previous = parseInt(order[articles[artIndex]['refArt']][1]) + parseInt(rows[i].cells[1].textContent);
            }
            catch(error){
                previous = parseInt(rows[i].cells[1].textContent);
            }

            order[articles[artIndex]['refArt']] = [rows[i].cells[0].textContent,
                // rows[i].cells[1].textContent,
                 String(previous),
                articles[artIndex]['pu']];
        }

        order['prixTotal'] = prixTotal;
        order['clientRef']  = clientRef;
        order['clientDesign'] = clientDesign;
        order = JSON.stringify({'order':order});
        // console.log(order);

        
        $.ajax({
            type:'POST',
            url:'commandeClient',
            data:order,
            contentType:'application/json',
            success:function(data){
                var sendResult = document.getElementById('sendResult');
                
                // progress bar
                pbar.style.display = "none";
                console.log(data);
                sendResult.innerHTML = data;
                $(sendResult).fadeIn(2000);
                $(sendResult).fadeOut(10000);
            },
            complete:function(data){
                if(data['status'] === 200){
                    console.log("operation terminee");
                    var tbd = rows[0].parentNode;
                    while(tbd.firstChild){
                        tbd.removeChild(tbd.firstChild);
                    }
                    var tab = document.getElementById("tab");
                    $(tab).css('display','none');
                    prixTotal = 0;
                    document.getElementById('valeur').innerHTML=0;
                }
                con.disabled=false;
                console.log(data);
            },
            error:function(err){
                console.log('something went wrong');
                console.log(err);
                if(err['status'] === 200){
                    // progress bar
                    pbar.style.display = "none";
                    var info = '';
                    var string = err['responseText'];
                    for(var i=10;i<string.length -1;i++){
                        info = info + string[i];
                    }
                    sendResult.innerHTML = info;
                    $(sendResult).fadeIn(2000);
                    $(sendResult).fadeOut(10000);
                }
                else{
                    console.log("une erreur s'est produite lors de l'envoi du mail");
                    console.log(err['responseText']);
                }
            }
        });
        // valid.style.display = "block";
    }
}

function help(){
    var help = document.getElementById('aide');
    // help.style.display = "block";
    $(help).fadeIn(2000);
}


function cacher(){
    var cacher = document.getElementById('aide');
    // cacher.style.display = "none";
    $(cacher).fadeOut(1500);
}

let productList = [];
let prixTotal = 0;

function deleteArticle(btn){
    var tr = btn.parentNode.parentNode;
    var design = tr.cells[0].innerHTML;
    var qte = tr.cells[1].innerHTML;
    // console.log($(tr.children[2].children).attr('data-index'));
    var artIndex = $(btn).attr('data-index');
    var total = document.getElementById('valeur');
    prixTotal = prixTotal - qte * articles[artIndex]['pu'];
    total.innerHTML = prixTotal;
    var parent = tr.parentNode;
    parent.removeChild(tr);
    var rows = document.getElementById('cmdb').rows;
    if (rows.length == 0) {
         var tab = document.getElementById("tab");
         $(tab).css('display','none');
    }
}

function save(){
    var prod = document.getElementById("prod");
    var quant = document.getElementById("entree").value;
    var temp = [];
    var error = document.getElementById("error");
    var table = document.getElementById("tab").getElementsByTagName('tbody')[0];
    var tab = document.getElementById("tab");
    document.getElementById('panierVide').style.display = "none";

    if ( !(quant+"").match(/^\d+$/) ) {
        error.innerHTML = "<strong>Danger!</strong> Quantite Incorrecte. La Quantite Entree n'est pas un Nombre Entier.";
        error.style.display = "block";
    }
    else{
        error.style.display = "none";
        temp.push(prod[prod.selectedIndex].value);
        temp.push(quant);
        productList.push(temp);

        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = prod[prod.selectedIndex].value;
        cell2.innerHTML = quant;
        cell3.innerHTML = parseFloat(articles[prod.selectedIndex]['pu']);
        cell4.innerHTML = "<button class=\"btn btn-danger btn-sm\"" + " data-index=\"" + prod.selectedIndex +"\"" +"onclick=\"deleteArticle(this)\">supprimer</button>"
        
        // on valorise le panier
        var total = document.getElementById('valeur');
        prixTotal = prixTotal + quant * articles[prod.selectedIndex]['pu'];
        total.innerHTML = prixTotal;
        document.getElementById("entree").value = "";
        $(tab).css('display','block');
    }

}

function loadLigne(btn){
    let ligneCmde = document.getElementById('ligneCmde');
    let tbl = document.getElementById('tbl');
    let numero = document.getElementById('numero');

    $(tbl).empty();
    $(ligneCmde).attr('style','display:none');
    $.ajax({
        type:'GET',
        url:'detailcommande/'+$(btn).attr('id'),
        success:function(data){
            let result = JSON.parse(data);
            let i = 0;
            if(result.length === 0){
                let span = document.createElement('span');
                $(span).attr('class','text-danger');
                span.innerHTML = "cette commande ne contient pas d'articles";
                tbl.appendChild(span);
            }
            else{
                let first = btn.parentNode.parentNode;
                first = first.firstChild;
                numero.innerHTML = first.innerHTML;

                $.each(result,function(key,value){
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    if(i===0){
                        $('tr').attr('data-expanded','true');
                        i = i + 1;
                    }
                    td1.innerHTML = value['libelleProduit'];
                    td2.innerHTML = parseFloat(value['Qte']);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tbl.appendChild(tr);
                });
            }
        },
        error:function(err){
            console.log(err);
        },
        complete:function(data){

        }
    });

    $(ligneCmde).slideDown();
    // showFootableLigne();
    // console.log($(btn).attr('id'));
}


// cette partie concerne uniquement les commerciaux

$('form#inputForm').on('submit', function(event){
    event.preventDefault();
});

function inputDialog(){
    $('#userinput').dialog({
        modal: true,
        title: "Nom du Client",
        show:{effect: 'fade', duration: 100},
        closeOnEscape: false,
        beforeClose:function(){
            if ($('input[name="cname"]').val() == '') {
                $('#inputError').css('display','inline-block');
                inputDialog();
                return false;
            }
        },
        close:function(){
            send();
        },
        buttons: {
        'OK': function () {
          var name = $('input[name="cname"]').val();
          // var err = document.getElementById('error');
          $('#inputError').css('display','none');
          if (name == '') {
            // $(this).dialog('close');
            console.log('client\'s name is required');
            $('#inputError').css('display','inline-block');
          }
          else{
            $(this).dialog('close');
            // console.log("nom du client: "+name); 
          }
         }
        }
    });
}

// function submit(){
    
//     console.log('input dialog closed');
//     return $('input[name="cname"]').val();
// }


function initializeClientList(){
    $.ajax({
        type:'GET',
        url:'initClients',
        success:function(data){
            var select = document.getElementById('clientList'),clients;
            clients = JSON.parse(data);
            // console.log(clients);
            $.each(clients,function(index,value){
                var option = document.createElement('option');
                $(option).attr('value',value['CL_Ref']);
                option.text = value['CL_Intitule'];
                select.add(option);
            });
            $(select).trigger("chosen:updated");
        }
    });
}

