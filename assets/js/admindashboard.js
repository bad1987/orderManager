
// $(window).on("load",initialize);


let clients = null;
function findClient(){
	let motif = $('input[name=motif]').val();
	let key = $('select[name=key]').val();
	let table = document.getElementById('Searchresult');
	let notfound = document.getElementById('notfound');
	let tbody = document.getElementById('tbsearch');

	$(table).css('display','none');
	$(notfound).css('display','none');

	$(tbody).empty();
	if(key !=""){
		// console.log(key);
		let array = {};
		array['key'] = key;
		array['motif'] = motif;
		array['csrf_bad_token'] = $.cookie("csrf_cookie_name");
		// let csrf_bad_token = $("#csrftoken").val();
		// array['csrf_bad_token'] = csrf_bad_token;
		// array['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
		let data = JSON.stringify({'data':array});
    let searchurl = $('#baseurl').text() + 'searchuser';
		$.ajax({
            type:'POST',
            url: searchurl,
            data:data,
            contentType:'application/json',
            success:function(retour){
            	console.log(retour);
            	var donne=JSON.parse(retour);
            	if(donne == false){
            		$(notfound).css('display','block');
            	}
            	else{
            		clients = donne;
            		$.each(donne,function(key,value){
	            		var tr = document.createElement('tr');
	                    var td1 = document.createElement('td');
	                    var td2 = document.createElement('td');
	                    var td3 = document.createElement('td');
	                    var td4 = document.createElement('td');
	                    var td5 = document.createElement('td');
	                    var btn = document.createElement('a');
	                    $(btn).attr('class','btn btn-info btn-sm');
	                    $(btn).attr('id',value['id']);
	                    $(btn).attr('href','#modification');
	                    $(btn).attr('onclick','editclient(this)');
	                    $(btn).text('editer');
	                    $(td1).text(value['name']);
	                    $(td2).text(value['username']);
	                    $(td3).text(value['email']);
	                    $(td4).text(value['phoneNum']);
	                    td5.appendChild(btn);
	                    tr.appendChild(td1);
	                    tr.appendChild(td2);
	                    tr.appendChild(td3);
	                    tr.appendChild(td4);
	                    tr.appendChild(td5);
	                    tbody.appendChild(tr);
	            	});
	            	$(table).css('display','block');
            	}

            },
            complete:function(retour){
            	console.log(retour);
            },
            error:function(retour){
            	console.log('an error occured');
            	console.log(retour);
            }
		});
	}
}

function editclient(btn){
	let edited = document.getElementById('modification');
	$(edited).css('display','none');
	// console.log('edition encours');
	if(clients == null){
		console.log('no client to modify');
		return;
	}

	let id = $(btn).attr('id'),cl=null;
	$.each(clients,function(key,value){
		if(value['id'] === id){
			cl = value;
			return false;
		}
	});
	
	if (cl != null) {
		$("#modification :input[name=name]").attr('value',cl['name']);
		$("#modification :input[name=username]").attr('value',cl['username']);
		$("#modification :input[name=email]").attr('value',cl['email']);
		$("#modification :input[name=phoneNum]").attr('value',cl['phoneNum']);
		// $("#modification :select[name=categorie]").attr('value',cl['cat_Ref']);
		$('select option[value='+cl['cat_Ref'] +']').attr("selected",true);

		$(edited).css('display','block');
	}
}

function saveClientData(){
	let passworderror = document.getElementById('passworderror');
	let nameerror = document.getElementById('nameerror');
	let usernameerror = document.getElementById('usernameerror');
	let emailerror = document.getElementById('emailerror');
	let phoneerror = document.getElementById('phoneerror');
	let saveSuccess = document.getElementById('saveSuccess');
	let saveError = document.getElementById('saveError');

	let erroccured = 0;
	$(passworderror).parent().css('display','none');
	$(nameerror).parent().css('display','none');
	$(usernameerror).parent().css('display','none');
	$(emailerror).parent().css('display','none');
	$(phoneerror).parent().css('display','none');
	$(saveSuccess).css('display','none');
	$(saveError).css('display','none');

	if ($("#modification :input[name=password]").val() != $("#modification :input[name=password_confirmation]").val()) {
		// console.log('Passwords not matching');
		$(passworderror).html('Passwords not matching');
		$(passworderror).parent().css('display','block');
		// console.log($(passworderror).parent());
		erroccured = 1;
	}

	if ($("#modification :input[name=username]").val() == "") {
		$(usernameerror).parent().css('display','block');
		erroccured = 1;
	}
	if ($("#modification :input[name=name]").val() == "") {
		$(nameerror).parent().css('display','block');
		erroccured = 1;
	}
	if ($("#modification :input[name=email]").val() == "") {
		$(emailerror).parent().css('display','block');
		erroccured = 1;
	}
	if ($("#modification :input[name=phoneNum]").val() == "") {
		$(phoneerror).parent().css('display','block');
		erroccured = 1;
	}

	if(erroccured == 1){
		return;
	}

	let data = {};
	data['name'] = $("#modification :input[name=name]").val();
	data['username'] = $("#modification :input[name=username]").val();
	data['email'] = $("#modification :input[name=email]").val();
	data['phoneNum'] = $("#modification :input[name=phoneNum]").val();
	data['cat_Ref'] = $('select[name=categorie]').val();
	if ($("#modification :input[name=password]").val() !=""){
		data['password'] = $("#modification :input[name=password]").val();
	}
	else{
		data['password'] = "false";
	}

	let update = JSON.stringify({'update':data});
  let savemodurl = $('#baseurl').text() + 'saveModifiedRecord';
	$.ajax({
		type:'POST',
        url: savemodurl,
        data:update,
        contentType:'application/json',
        success:function(data){
        	var donne=JSON.parse(data);
        	if(donne == "1"){
        		// $(saveSuccess).css('display','block');
        		$(saveSuccess).fadeIn(2000);
                $(saveSuccess).fadeOut(10000);
        	}

        },
        complete:function(data){
        	console.log(data);
        },
        error:function(data){
        	var donne=JSON.parse(data);
        	if(donne == "0"){
        		$(saveError).css('display','block');
        	}

        }
	});
}

function initialize(){
    let clientiniturl = $('#baseurl').text() + 'initClients';
    $.ajax({
        type:'GET',
        url: clientiniturl,
        success:function(data){
            var select = document.querySelector('#prod'),clients;
            clients = JSON.parse(data);
            // console.log(clients);
            $.each(clients,function(index,value){
                var option = document.createElement('option');
                $(option).attr('value',value['CL_Ref']);
                option.text = value['CL_Intitule'];
                select.add(option);
            });
            $('select').trigger("chosen:updated");
        }
    });
}

function getClientName(){
	$('#userinput').dialog({
        modal: true,
        height:300,
        width:420,
        title: "Nom du Client",
        show:{effect: 'fade', duration: 100},
        closeOnEscape: false,
        beforeClose:function(){
            
        },
        close:function(){
            
        },
        buttons: {
        'OK': function () {
          
         }
        },
        create: function( event, ui ) {
        	initialize();
        	var cu = $(this['#userinput']);
        	console.log(cu);
        },
        open: function( event, ui ) {
        	
        }
    });
}



/*********************************************PROMOTIONs***************************************************/
	function initializeArticle(){
    let initurl = $('#baseurl').text() + 'init';
    $.ajax({
      type:'GET',
      url: initurl,
      success:function(data){
        var select = document.querySelector('#nArticleList');
        articles = JSON.parse(data);
        $.each(articles,function(index,value){
          var option = document.createElement('option');
          option.text = value['designArt'];
          $(option).attr('value',value['refArt']);
          select.add(option);
        });
        $(select).trigger("chosen:updated");
      }
    });  
  }

  function saveNewPromo(){
  	var index = document.getElementById('nArticleList');
  	var selected = index[index.selectedIndex].value;

  	//second check of error in inputs
  	if (checkArticle() == -1) {
  		return;
  	}
  	if (checkQuantite() == -1) {
  		return;
  	}
  	if (checkPercentage() == -1) {
  		return;
  	}
  	if (checkUG() == -1) {
  		return;
  	}
  	if (checkDatedebut() == -1) {
  		return;
  	}
  	if (checkDatefin() == -1) {
  		return;
  	}

  	//building the array
  	let promo = {};
  	promo['article'] = selected;
  	promo['quantite'] = $('#quantite').val();
  	promo['pourcent'] = $('#pourcent').val();
  	promo['unitegratuite'] = $('#unitegratuite').val();
  	promo['dated'] = $('#datedebut').val();
  	promo['datef'] = $('#datefin').val();

  	promo = JSON.stringify({'promo': promo});
    let promonewurl = $('#baseurl').text() + 'newpromo';
  	//sending the request via ajax
  	$.ajax({
  		type: "POST",
  		url: promonewurl,
  		contentType: "application/json",
  		data: promo,
  		success: function(retour){
  			// console.log('operation success');
  			$('#successStatus').fadeIn(4000).fadeOut(3000);
  		},
  		complete: function(com){
  			// if (com.responseText === "1") {
  			// 	$('#successStatus').fadeIn(4000).fadeOut(3000);
  			// }
  			// else if (com.responseText === "-1") {
  			// 	$('#errorStatus').fadeIn(4000).fadeOut(3000);	
  			// }
  			// else{
  			// 	console.log(com.responseText);
  			// }
  		},
  		error: function(err){
  			$('#errorStatus').fadeIn(4000).fadeOut(3000);	
  		},
  	});
  }

  function checkArticle(){
  	$('#arterror').css('display','none');
  	let index = document.getElementById('nArticleList');
  	let selected = index[index.selectedIndex].value;
  	$('#arterror').css('display','none');
  	if (selected === "") {
  		$('#arterror').css('display','block');
  		return -1;
  	}
  }

  function checkQuantite(){
  	$('#qteerror').css('display','none');
  	$('#qteinvalid').css('display','none');
  	let quantite = $('#quantite').val();
  	if (quantite === "") {
  		$('#qteerror').css('display','block');
  		return -1
  	}
  	if (!(quantite+"").match(/^\d+$/)) {
  		$('#qteinvalid').css('display','block');
  		return -1;
  	}
  }

  function checkPercentage(){
  	$('#percenterror').css('display','none');
  	$('#percentinvalid').css('display','none');
  	let percent = $('#pourcent').val();
  	if (percent === "") {
  		$('#percenterror').css('display','block');
  		return -1;
  	}
  	if (!(percent +"").match(/^[\d.]+$/)) {
  		$('#percentinvalid').css('display','block');
  	}
  }

  function checkUG(){
  	$('#ugerror').css('display','none');
  	$('#uginvalid').css('display','none');
  	let ug = $('#quantite').val();
  	if (ug === "") {
  		$('#ugerror').css('display','block');
  		return -1
  	}
  	if (!(ug+"").match(/^\d+$/)) {
  		$('#uginvalid').css('display','block');
  		return -1;
  	}
  }

  function checkDatedebut(){
  	$('#datedinvalid').css('display','none');
  	if ($('#datedebut').val() === "") {
  		$('#datedinvalid').css('display','block');
  		return -1;
  	}
  }

  function checkDatefin(){
  	$('#datefinvalid').css('display','none');
  	if ($('#datefin').val() === "") {
  		$('#datefinvalid').css('display','block');
  		return -1;
  	}
  }


  function quantiteFocus(focus){
  	changeColor(focus);
  	checkArticle();
  }

  function quantiteBlur(blur){
  	resetColor(blur);
  }

  function pourcentageFocus(focus){
  	changeColor(focus);
  	checkQuantite();
  	checkArticle();
  }

  function pourcentageBlur(blur){
  	resetColor(blur);
  }

  function ugFocus(focus){
  	changeColor(focus);
  	checkArticle();
  	checkQuantite();
  	checkPercentage();
  }

  function ugBlur(blur){
  	resetColor(blur);
  }

  function datedFocus(focus){
  	changeColor(focus);
  	checkArticle();
  	checkQuantite();
  	checkPercentage();
  	checkUG();
  }

  function datedBlur(blur){
  	resetColor(blur);
  }

  function datefFocus(focus){
  	changeColor(focus);
  	checkArticle();
  	checkQuantite();
  	checkPercentage();
  	checkUG();
  	checkDatedebut();
  }

  function datefBlur(blur){
  	resetColor(blur);
  }

  function changeColor(object){
  	object.style.background = "#373c43";
  	object.style.color = "white";
  }

  function resetColor(object){
  	object.style.background = "white";
  	object.style.color = "black";
  }

  // initializeArticle();
  $(window).on("load",initializeArticle);

  // prevent form's default submition
  document.getElementById('newpromosubmit').addEventListener('click',function(event){
  	event.preventDefault();
  });

  function editPromo(){
  	$('#indisponible').css('display','none');
  	$('#editdata').css('display','none');
  	let index = document.getElementById('nArticleList');
		let selected = index[index.selectedIndex].value;
    let promofetchurl = $('#baseurl').text() + 'fetchPromo/' + selected;
  	$.ajax({
  		type: "GET",
  		url: promofetchurl,
  		success: function(data){
  			data = JSON.parse(data);
  			$('#editdata').css('display','block');
  			$('#editbody').empty();
  			if (data == false) {
  				$('#indisponible').css('display','block');
  			}
  			else{

  				$('#editdata').css('display','block');
  				// we empty the body table

  				$.each(data,function(index,value){
  					let tr = document.createElement('tr');
  					let td1 = document.createElement('td');
  					let input1 = document.createElement('input');
  					$(input1).attr('type','text');
  					$(input1).attr('name','quantite');
  					$(input1).attr('value',value['quantite']);
  					$(input1).attr('size',5);
  					$(td1).append(input1);
  					let td2 = document.createElement('td');
  					let input2 = document.createElement('input');
  					$(input2).attr('type','text');
  					$(input2).attr('name','pourcentage');
  					$(input2).attr('value',value['pourcentage']);
  					$(input2).attr('size',5);
  					$(td2).append(input2);
  					let td3 = document.createElement('td');
  					let input3 = document.createElement('input');
  					$(input3).attr('type','text');
  					$(input3).attr('name','unitegratuite');
  					$(input3).attr('value',value['unite_gratuite']);
  					$(input3).attr('size',5);
  					$(td3).append(input3);
  					let td4 = document.createElement('td');
  					let input4 = document.createElement('input');
  					$(input4).attr('type','text');
  					$(input4).attr('name','sommeil');
  					$(input4).attr('value',value['sommeil']);
  					$(input4).attr('size',5);
  					$(td4).append(input4);
  					let td5 = document.createElement('td');
  					let input5 = document.createElement('input');
  					$(input5).attr('type','date');
  					$(input5).attr('name','dated');
  					$(input5).attr('value',value['date_debut']);
  					$(input5).attr('size',5);
  					$(td5).append(input5);
  					let td6 = document.createElement('td');
  					let input6 = document.createElement('input');
  					$(input6).attr('type','date');
  					$(input6).attr('name','datef');
  					$(input6).attr('value',value['date_fin']);
  					$(input6).attr('size',5);
  					$(td6).append(input6);
  					let td7 = document.createElement('td');
  					let btn = document.createElement('a');
  					$(btn).attr('class','btn btn-success btn-sm');
  					$(btn).attr('id',value['id_promotion']);
  					$(btn).attr('onclick','updatePromo(this)');
  					btn.text = "Save";
  					$(td7).append(btn);
            let td8 = document.createElement('td');
            let div = document.createElement('div');
            $(div).attr('class','text-success successStatus');
            // $(div).attr('id','successStatus');
            div.innerHTML = "Saved";
            $(td8).append(div);

  					$(tr).append(td1);
  					$(tr).append(td2);
  					$(tr).append(td3);
  					$(tr).append(td4);
  					$(tr).append(td5);
  					$(tr).append(td6);
  					$(tr).append(td7);
            $(tr).append(td8);
  					$('#editbody').append(tr)
  				});
  			}
  		}
  	});
  }

  function updatePromo(obj){
    let data = {};
  	data['pk'] = $(obj).attr('id');
    $(obj.parentNode.parentNode).children().each(function(){
      let name = $($(this).children()[0]).attr('name'); 
      if (name !== undefined) {
        data[name] = $($(this).children()[0]).val();
        // console.log(name);
      }
      
    });
    data = JSON.stringify({'data':data});
    let promoeditedsaveurl = $('#baseurl').text() + 'saveEditedPromo';
    $.ajax({
      type: 'POST',
      url: promoeditedsaveurl,
      data: data,
      success: function(retour){
        console.log(retour);
        // $($(obj).next()).fadeIn(4000).fadeOut(3000);
        let last = $(obj.parentNode).next();
        // console.log($(last).children()[0]);
        $($(last).children()[0]).fadeIn(4000).fadeOut(3000);
      }
    })
  }
/************************************************************************************************/



