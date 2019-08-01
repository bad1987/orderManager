
let articles,clientLoaded='false';

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
        let filturl = $('#baseurl').text() + 'filterCommandes/'+$(du).val()+'/'+$(au).val();
        //chargement des commandes
        $.ajax({
            type:'GET',
            url: filturl,
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
    let initurl = $('#baseurl').text() + 'init';
    $.ajax({
        type:'GET',
        url: initurl,
        success:function(data){
            var select = document.querySelector('#prod');
            articles = JSON.parse(data);
            // console.log(articles);
            $.each(articles,function(index,value){
                var option = document.createElement('option');
                option.text = value['designArt'];
                $(option).attr('value',value['refArt']);
                select.add(option);
            });
            $('select').trigger("chosen:updated");        
        }
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
    let chargecmdurl = $('#baseurl').text() + 'statCommandes';
    //chargement des commandes
    $.ajax({
        type:'GET',
        url: chargecmdurl,
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
    var clientList = document.getElementById('clientList');

    // we start by hiding errors
    $("#cl_error").css('display','none');
    $('#panierVide').css('display','none');

    // check if the user chose any product
    if ($('.panier').children().length === 0) {
        $('#panierVide').css('display','block');
        return;
    }
    if($('#user').attr('name') == 'COM' && clientList[clientList.selectedIndex].value == ""){
        $("#cl_error").css('display','inline');
        return;
    }
    var user = document.getElementById('user');
    let clientName = 'NULL';
    var clientRef = 'NULL';
    var clientDesign = 'NULL';
    // console.log(clientRef);

    if ($('#user').attr('name') == 'COM') {
         clientRef = clientList[clientList.selectedIndex].value;
         clientDesign = clientList[clientList.selectedIndex].text;
    }
    $('#panierVide').css('display','none');

    // progress bar and "valider" button
    $('#pbar').css('display','block');
    $('#confirm').prop('disabled',true);

    let order = {};

    $('.panier').children().each(function(){
        let object = $($($(this).children()[0]).children()[1]).children();
        let artIndex =  $(object[2]).attr('data-index');
        let previous = 0;
        let unite = $(object[0]).text().split(' ')[1];
        try{
            previous = parseInt(order[articles[artIndex]['refArt']][1]) + parseInt(unite);
        }
        catch(error){
            previous = parseInt(parseInt(unite));
        }
        order[articles[artIndex]['refArt']] = [$($($(this).children()[0]).children()[0]).text(),
            // rows[i].cells[1].textContent,
             String(previous),
            parseFloat(articles[artIndex]['pu'])];
    });
    order['prixTotal'] = parseFloat(prixTotal);
    order['clientRef']  = clientRef;
    order['clientDesign'] = clientDesign;
    order = JSON.stringify({'order':order});
    console.log(order);
    let cmdeurl = $('#baseurl').text() + 'commandeClient';
    $.ajax({
        type:'POST',
        url: cmdeurl,
        data:order,
        contentType:'application/json',
        success:function(data){
            var sendResult = document.getElementById('sendResult');
            
            // progress bar
            // pbar.style.display = "none";
            $('#pbar').css('display','none');
            // console.log(data);
            $('#sendResult').text(data);
            $(sendResult).fadeIn(2000);
            $(sendResult).fadeOut(10000);
        },
        complete:function(data){
            if(data['status'] === 200){
                console.log("operation terminee");
                $('.panier').empty();
                prixTotal = 0;
                $('#valeur').text(0);
            }
            $('#confirm').prop('disabled',false);
            console.log(data);
        },
        error:function(err){
            console.log('something went wrong');
            console.log(err);
            if(err['status'] === 200){
                // progress bar
                $('#pbar').css('display','none');
                var info = '';
                var string = err['responseText'];
                for(var i=10;i<string.length -1;i++){
                    info = info + string[i];
                }
                // sendResult.innerHTML = info;
                $('#sendResult').text(info);
                $(sendResult).fadeIn(2000);
                $(sendResult).fadeOut(10000);
            }
            else{
                console.log("une erreur s'est produite lors de l'envoi du mail");
                console.log(err['responseText']);
            }
        }
    });
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
    let parent = $(btn.parentNode.parentNode);
    let produit = $($(parent).children()[0]).text();
    let unite = $($($(parent).children()[1]).children()[0]).text().split(' ')[1];
    let artIndex = $(btn).attr('data-index');
    prixTotal = prixTotal - unite * articles[artIndex]['pu'];
    $('#valeur').text(prixTotal);

    // deleting the undesired product
    $($(parent).parent()).remove();
    if ($('.panier').children().length === 0) {
        // console.log($('.panier').children().length);
        $('.valeurPanier').css('display','none');
    }

    // var tr = btn.parentNode.parentNode;
    // var design = tr.cells[0].innerHTML;
    // var qte = tr.cells[1].innerHTML;
    // // console.log($(tr.children[2].children).attr('data-index'));
    // var artIndex = $(btn).attr('data-index');
    // var total = document.getElementById('valeur');
    // prixTotal = prixTotal - qte * articles[artIndex]['pu'];
    // total.innerHTML = prixTotal;
    // var parent = tr.parentNode;
    // parent.removeChild(tr);
    // var rows = document.getElementById('cmdb').rows;
    // if (rows.length == 0) {
    //      var tab = document.getElementById("tab");
    //      $(tab).css('display','none');
    // }
}

function save(){
    var prod = document.getElementById("prod");
    var quant = document.getElementById("entree").value;
    var temp = [];
    var error = document.getElementById("error");

    // verification de la rupture
    let rupture = articles[prod.selectedIndex]['rupture'];
    if (parseInt(rupture) === 1) {
        return;
    }

    if ( !(quant+"").match(/^\d+$/)) {
        error.innerHTML = "<strong>Erreur! </strong> Quantité incorrecte. La quantité Entrée n'est pas un Nombre Entier.";
        error.style.display = "block";
    }
    else{
        // we check if the user entered zero
        if (parseInt(quant) === 0) {
            error.innerHTML = "<strong>Erreur! </strong> Quantité incorrecte. La quantité Entrée ne doit pas être nulle.";
            error.style.display = "block";
            return;
        }

        error.style.display = "none";
        temp.push(prod[prod.selectedIndex].value);
        temp.push(quant);
        productList.push(temp);

        let col = document.createElement('div');
        $(col).attr('class','col-md-4');
        let card = document.createElement('div');
        $(card).attr('class','card');
        let cardHeader = document.createElement('div');
        $(cardHeader).attr('class','card-header');
        $(cardHeader).text(prod[prod.selectedIndex].text);
        let cardBody = document.createElement('div');
        $(cardBody).attr('class','card-body');
        let spanQte = document.createElement('span');
        $(spanQte).attr('style','margin-right: 50px;');
        $(spanQte).text('Qte: ' + quant);
        let spanPrix = document.createElement('span');
        $(spanPrix).text('P.U: ' + parseFloat(articles[prod.selectedIndex]['pu']));
        let btn = document.createElement('button');
        $(btn).attr('class','btn btn-info btn-sm float-right');
        $(btn).attr('data-index',prod.selectedIndex);
        $(btn).attr('onclick','deleteArticle(this)');
        $(btn).text('Supprimer');

        $(cardBody).append(spanQte);
        $(cardBody).append(spanPrix);
        $(cardBody).append(btn);
        $(card).append(cardHeader);
        $(card).append(cardBody);
        $(col).append(card);
        $('.panier').append(col);
        
        // var row = table.insertRow(-1);
        // var cell1 = row.insertCell(0);
        // var cell2 = row.insertCell(1);
        // var cell3 = row.insertCell(2);
        // var cell4 = row.insertCell(3);
        // cell1.innerHTML = prod[prod.selectedIndex].value;
        // cell2.innerHTML = quant;
        // cell3.innerHTML = parseFloat(articles[prod.selectedIndex]['pu']);
        // cell4.innerHTML = "<button class=\"btn btn-danger btn-sm\"" + " data-index=\"" + prod.selectedIndex +"\"" +"onclick=\"deleteArticle(this)\">supprimer</button>"
        
        // on valorise le panier
        var total = document.getElementById('valeur');
        prixTotal = prixTotal + quant * articles[prod.selectedIndex]['pu'];
        total.innerHTML = prixTotal;
        document.getElementById("entree").value = "";
        if ($('.valeurPanier').css('display') === 'none') {
            $('.valeurPanier').css('display','block');
        }
        // $(tab).css('display','block');
    }

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
    var select = document.getElementById('clientList'),clients;
    let urlclient = $('#baseurl').text() + 'initClients';
    $.ajax({
        type:'GET',
        url: urlclient,
        success:function(data){
            
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

/*******************************************PROMOTION*************************************************************/
var base_url = $('#baseurl').text();
function voirPlus(){
    base_url = base_url+'toutespromo';
    let pluspromo = document.querySelector('#voirplus');
    let ul = $(pluspromo.parentNode.parentNode).children().eq(1);
    // remove all its children
    $(ul).empty();
    // retrieving all promotions
    $.ajax({
        type:'GET',
        url: base_url,
        success: function(data){
            data = JSON.parse(data);
            $.each(data, function(index,value){
                var li = document.createElement('li');
                $(li).attr('class','list-group-item');
                var a = document.createElement('a');
                $(a).attr('href',$('#baseurl').text()+'detailpromo/'+value['id_article']);
                a.text = value['designArt'];
                li.appendChild(a);
                $(ul).append(li);
            });
            $(pluspromo.parentNode).css('display','none');
            $('#promo').attr('class','scroll');
        }
    });
    // $(pluspromo.parentNode).css('display','none');

}

/****************************************************************************************************************/


/***********************************HSITORIQUE DES COMMANDES*****************************************************/

function loadLigne(btn){
    let numero = document.getElementById('numero');
    let urlLigne = $('#baseurl').text() + 'detailcommande/'+$(btn).attr('id');
    //initialisation
    $(numero).empty();

    $.ajax({
        type:'GET',
        url:urlLigne,
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
                numero.innerHTML = btn.parentNode.parentNode.children[0].children[0].innerHTML;
                // $('#detailCmde').css('display','block');
                $('#contenuCmde').empty();
                // console.log(btn.parentNode.parentNode.children[0].children[0].innerHTML);

                $.each(result,function(key,value){
                    let rowDiv1 = document.createElement('div');
                    $(rowDiv1).attr('class','row');
                    let colDiv1 = document.createElement('div');
                    $(colDiv1).attr('class','col-xs-6 col-sm-6 col-md-6');
                    $(colDiv1).text(value['libelleProduit']);
                    $(rowDiv1).append(colDiv1);

                    let colDiv2 = document.createElement('div');
                    $(colDiv2).attr('class','col-xs-6 col-sm-6 col-md-6');
                    $(colDiv2).text(parseFloat(value['Qte']));
                    $(rowDiv1).append(colDiv2);

                    $('#contenuCmde').append(rowDiv1);
                });
                $('#detailCmde').css('display','block');
                $('html','body').animate({scrollTop: $('#detailCmde').offset().top},1000);
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


/****************************************************************************************************************/

/**************************************RUPTURE*******************************************************************/
$('#prod').chosen().change(function(){
    let product = document.querySelector('#prod');
    let rupture = articles[product.selectedIndex]['rupture'];
    $('#error').css('display','none');
    if (parseInt(rupture) === 1) {
        $('#error').text("Ce produit est en rupture");
        $('#error').css('display','block');
        console.log(rupture);
    }
    // alert(product[product.selectedIndex].value);
    
});

/****************************************************************************************************************/