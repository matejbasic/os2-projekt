$(function(){

	var filemanager = $('.filemanager'),
		breadcrumbs = $('.breadcrumbs'),
		
		asymetricEncryption = false,
		asymetricEncrpytBtn = $("#asymetricCryptBtn"),
		asymetricDecryption = false,
		asymetricDecryptBtn = $("#asymetricDecryptBtn"),
		
		symetricEncryption = false,
		symetricEncrpytBtn = $("#symetricCryptBtn"),
		symetricDecryption = false,
		symetricDecryptBtn = $("#symetricDecryptBtn"),
		
		digest = false,
		digestBtn = $("#digestBtn"),
		
		digitalSignature = false,
		digitalSignatureBtn = $("#digitalSignatureBtn"),
		digitalSignatureCheck = false,
		digitalSignatureCheckBtn = $("#digitalSignatureCheckBtn"),

		fileList = filemanager.find('.data');

	function btnChooser(flag, btn) {
		if (flag) {
			flag = false;
			btn.removeClass("choosed");
		}
		else {
			flag = true;
			btn.addClass("choosed");
			noticeTxt.text("Odaberite datoteku...");
		}
		noticeToggle(true);
		return flag;
	}	
	
	var notice = $("#notice");
	var noticeTxt = $("#notice_content");
	var noticeToggled = false;
	notice.toggle();
	
	function noticeToggle(short) {
		var time = 2000;
		if (short) {
			time = 700;
		}
		//console.log(time);
		if (!noticeToggled) {
			noticeToggled = true;
			notice.slideToggle("slow", function() {
				setTimeout(function() {
					notice.slideToggle();
					noticeToggled = false;
				}, time);
			});
		}
	}
	
	function setCryptOptions() {
		$("a.files").each(function() {
			$(this).click(function(e) {
				var format = $(this).children(".icon").text();
				var fileName = $(this).children(".name").text();
				var filePath = $(this).attr("href");
					
				if ( asymetricEncryption ) {
					asymetricEncryption = false;
					asymetricEncrpytBtn.removeClass("choosed");
					e.preventDefault();
					var ajaxurl = 'cryptr.php';
				
					data = {type: "asymetric", action:"encryption", path: filePath};
					$.post(ajaxurl, data, function (response) {
						if (response == "encrypted") {
							noticeTxt.text("Datoteka asimetrično kriptirana!");
							scan();
						}
						else if (response == "key-missing") {
							noticeTxt.text("Ključ nije pronađen!");
						}
						else {
							noticeTxt.text("Nešto je pošlo po krivu!");
						}
						noticeToggle();
					});
				}
				else if ( asymetricDecryption ) {
						e.preventDefault();
						asymetricDecryption = false;
						asymetricDecryptBtn.removeClass("choosed");
						
						var ajaxurl = 'cryptr.php';
				
						data = {type: "asymetric", action:"decryption", path: filePath};
						$.post(ajaxurl, data, function (response) {
							console.log(response);
							if (response == "decrypted") {
								noticeTxt.text("Datoteka dekriptirana!");
								scan();
							}
							else if (response == "key-missing") {
								noticeTxt.text("Ključ nije pronađen!");
							}
							else {
								noticeTxt.text("Nešto je pošlo po krivu!");
							}
							noticeToggle();
						});
					}
					else if ( symetricEncryption ) {
						e.preventDefault();
						symetricEncryption = false;
						symetricEncrpytBtn.removeClass("choosed");
						
						var ajaxurl = 'cryptr.php';
				
						data = {type: "symetric", action: "encryption", path: filePath};
						$.post(ajaxurl, data, function (response) {
							if (response == "encrypted") {
								console.log(response);
								noticeTxt.text("Datoteka simetrično kriptirana!");
								scan();
							}
							else if (response == "key-missing") {
								noticeTxt.text("Ključ nije pronađen!");
							}
							else {
								noticeTxt.text("Nešto je pošlo po krivu!");
							}
							noticeToggle();
						});
					}
					else if ( symetricDecryption ) {
						e.preventDefault();
						symetricDecryption = false;
						symetricDecryptBtn.removeClass("choosed");
						
						var ajaxurl = 'cryptr.php';
				
						data = {type: "symetric", action: "decryption", path: filePath};
						$.post(ajaxurl, data, function (response) {
							console.log(response);
							if (response == "decrypted") {
								noticeTxt.text("Datoteka dekriptirana!");
								scan();
							}
							else if (response == "key-missing") {
								noticeTxt.text("Ključ nije pronađen!");
							}
							else {
								noticeTxt.text("Nešto je pošlo po krivu!");
							}
							noticeToggle();
						});
					}
					else if ( digest ) {
						e.preventDefault();
						digest = false;
						digestBtn.removeClass("choosed");
						
						var ajaxurl = 'digest.php';
				
						data = {path: filePath};
						$.post(ajaxurl, data, function (response) {
							console.log(response);
							if (response == "digested") {
								noticeTxt.text("Sažetak datoteke je pohranjen!");
								scan();
							}
							else if (response == "key-missing") {
								noticeTxt.text("Ključ nije pronađen!");
							}
							else {
								noticeTxt.text("Nešto je pošlo po krivu!");
							}
							noticeToggle();
						});
					}
					else if ( digitalSignature ) {
						e.preventDefault();
						digitalSignature = false;
						digitalSignatureBtn.removeClass("choosed");
						
						var ajaxurl = 'digital_signature.php';
				
						data = {path: filePath};
						$.post(ajaxurl, data, function (response) {
							console.log("rp: " + response);
							if (response == "signed") {
								noticeTxt.text("Digitalni potpis kreiran!");
								scan();
							}
							else if (response == "key-missing") {
								noticeTxt.text("Ključ nije pronađen!");
							}
							else {
								noticeTxt.text("Nešto je pošlo po krivu!");
							}
							noticeToggle();
						});
					}
					else if ( digitalSignatureCheck ) {
						e.preventDefault();
						digitalSignatureCheck = false;
						digitalSignatureCheckBtn.removeClass("choosed");
						
						var ajaxurl = 'digital_signature_check.php';
				
						data = {path: filePath};
						$.post(ajaxurl, data, function (response) {
							console.log(response);
							if (response == "valid") {
								noticeTxt.text("Digitalni potpis valjan, sažeci se podudaraju!");
							}
							else if (response == "key-missing") {
								noticeTxt.text("Ključ nije pronađen!");
							}
							else {
								noticeTxt.text("Greška, sažeci se ne podudaraju!");
							}
							noticeToggle();
						});
					}
					else {
						console.log( "format: " + format );
						if ( format == ".txt" || format == ".html" || format == ".css" || format == ".php" || format == ".js" ) {
							e.preventDefault();
							
							var ajaxUrl = 'read_text.php';
							data = {path: filePath };
							
							$.post(ajaxUrl, data, function (response) {
								if (response != "error") {
									$("#fileName").val(fileName);
									$("#filePath").val(filePath);
									
									var txtPlain = $("#txtPlain");
									$("#txtPlain").val("");
									$("#txtPlain").val($('#txtPlain').val() + response );
									
								}
								else {
									noticeTxt.text("Greška prilikom otvaranja datoteke!");
									noticeToggle();
								}
							});
						}
					}
				});
			});
	}		
		
	function scan() {
	$.get('scan.php', function(data) {
		var response = [data],
			currentPath = '',
			breadcrumbsUrls = [];

		var folders = [],
			files = [];

		$(window).on('hashchange', function(){

			goto(window.location.hash);

		}).trigger('hashchange');

		filemanager.find('.search').click(function(){

			var search = $(this);

			search.find('span').hide();
			search.find('input[type=search]').show().focus();

		});


		// Listening for keyboard input on the search field.
		// We are using the "input" event which detects cut and paste
		// in addition to keyboard input.

		filemanager.find('input').on('input', function(e){

			folders = [];
			files = [];

			var value = this.value.trim();

			if(value.length) {

				filemanager.addClass('searching');

				// Update the hash on every key stroke
				window.location.hash = 'search=' + value.trim();
			}

			else {
				filemanager.removeClass('searching');
				window.location.hash = encodeURIComponent(currentPath);

			}

		}).on('keyup', function(e){

			// Clicking 'ESC' button triggers focusout and cancels the search

			var search = $(this);

			if(e.keyCode == 27) {

				search.trigger('focusout');

			}

		}).focusout(function(e){

			// Cancel the search

			var search = $(this);

			if(!search.val().trim().length) {

				window.location.hash = encodeURIComponent(currentPath);
				search.hide();
				search.parent().find('span').show();

			}

		});


		// Clicking on folders

		fileList.on('click', 'li.folders', function(e){
			e.preventDefault();

			var nextDir = $(this).find('a.folders').attr('href');

			if(filemanager.hasClass('searching')) {

				// Building the breadcrumbs

				breadcrumbsUrls = generateBreadcrumbs(nextDir);

				filemanager.removeClass('searching');
				filemanager.find('input[type=search]').val('').hide();
				filemanager.find('span').show();
			}
			else {
				breadcrumbsUrls.push(nextDir);
			}

			window.location.hash = encodeURIComponent(nextDir);
			currentPath = nextDir;
		});


		// Clicking on breadcrumbs

		breadcrumbs.on('click', 'a', function(e){
			e.preventDefault();

			var index = breadcrumbs.find('a').index($(this)),
				nextDir = breadcrumbsUrls[index];

			breadcrumbsUrls.length = Number(index);

			window.location.hash = encodeURIComponent(nextDir);

		});


		// Navigates to the given hash (path)

		function goto(hash) {

			hash = decodeURIComponent(hash).slice(1).split('=');

			if (hash.length) {
				var rendered = '';

				// if hash has search in it

				if (hash[0] === 'search') {

					filemanager.addClass('searching');
					rendered = searchData(response, hash[1].toLowerCase());

					if (rendered.length) {
						currentPath = hash[0];
						render(rendered);
					}
					else {
						render(rendered);
					}

				}

				// if hash is some path

				else if (hash[0].trim().length) {

					rendered = searchByPath(hash[0]);

					if (rendered.length) {

						currentPath = hash[0];
						breadcrumbsUrls = generateBreadcrumbs(hash[0]);
						render(rendered);

					}
					else {
						currentPath = hash[0];
						breadcrumbsUrls = generateBreadcrumbs(hash[0]);
						render(rendered);
					}

				}

				// if there is no hash

				else {
					currentPath = data.path;
					breadcrumbsUrls.push(data.path);
					render(searchByPath(data.path));
				}
			}
		}

		// Splits a file path and turns it into clickable breadcrumbs

		function generateBreadcrumbs(nextDir){
			var path = nextDir.split('/').slice(0);
			for(var i=1;i<path.length;i++){
				path[i] = path[i-1]+ '/' +path[i];
			}
			return path;
		}


		// Locates a file by path

		function searchByPath(dir) {
			var path = dir.split('/'),
				demo = response,
				flag = 0;

			for(var i=0;i<path.length;i++){
				for(var j=0;j<demo.length;j++){
					if(demo[j].name === path[i]){
						flag = 1;
						demo = demo[j].items;
						break;
					}
				}
			}

			demo = flag ? demo : [];
			return demo;
		}


		// Recursively search through the file tree

		function searchData(data, searchTerms) {

			data.forEach(function(d){
				if(d.type === 'folder') {

					searchData(d.items,searchTerms);

					if(d.name.toLowerCase().match(searchTerms)) {
						folders.push(d);
					}
				}
				else if(d.type === 'file') {
					if(d.name.toLowerCase().match(searchTerms)) {
						files.push(d);
					}
				}
			});
			return {folders: folders, files: files};
		}


		// Render the HTML for the file manager

		function render(data) {

			var scannedFolders = [],
				scannedFiles = [];

			if(Array.isArray(data)) {

				data.forEach(function (d) {

					if (d.type === 'folder') {
						scannedFolders.push(d);
					}
					else if (d.type === 'file') {
						scannedFiles.push(d);
					}

				});

			}
			else if(typeof data === 'object') {

				scannedFolders = data.folders;
				scannedFiles = data.files;

			}


			// Empty the old result and make the new one

			fileList.empty().hide();

			if(!scannedFolders.length && !scannedFiles.length) {
				filemanager.find('.nothingfound').show();
			}
			else {
				filemanager.find('.nothingfound').hide();
			}

			if(scannedFolders.length) {

				scannedFolders.forEach(function(f) {

					var itemsLength = f.items.length,
						name = escapeHTML(f.name),
						icon = '<span class="icon folder"></span>';

					if(itemsLength) {
						icon = '<span class="icon folder full"></span>';
					}

					if(itemsLength == 1) {
						itemsLength += ' datoteka';
					}
					else if(itemsLength > 1) {
						itemsLength += ' datoteke';
					}
					else {
						itemsLength = 'Prazno';
					}

					var folder = $('<li class="folders"><a href="'+ f.path +'" title="'+ f.path +'" class="folders">'+icon+'<span class="name">' + name + '</span> <span class="details">' + itemsLength + '</span></a></li>');
					folder.appendTo(fileList);
				});

			}

			if(scannedFiles.length) {

				scannedFiles.forEach(function(f) {

					var fileSize = bytesToSize(f.size),
						name = escapeHTML(f.name),
						fileType = name.split('.'),
						icon = '<span class="icon file"></span>';

					fileType = fileType[fileType.length-1];

					icon = '<span class="icon file f-'+fileType+'">.'+fileType+'</span>';

					var file = $('<li class="files"><a href="'+ f.path+'" title="'+ f.path +'" class="files" target="_blank">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a><img src="../assets/img/delete.png" class="deleteBtn"/></li>');
					file.appendTo(fileList);
					
					
				});

			}


			// Generate the breadcrumbs

			var url = '';

			if(filemanager.hasClass('searching')){

				url = '<span>Search results: </span>';
				//fileList.removeClass('animated');

			}
			else {

				//fileList.addClass('animated');

				breadcrumbsUrls.forEach(function (u, i) {

					var name = u.split('/');

					if (i !== breadcrumbsUrls.length - 1) {
						url += '<a href="'+u+'"><span class="folderName">' + name[name.length-1] + '</span></a> <span class="arrow">→</span> ';
					}
					else {
						url += '<span class="folderName">' + name[name.length-1] + '</span>';
					}

				});

			}

			breadcrumbs.text('').append(url);


			// Show the generated elements

			fileList.animate({'display':'inline-block'});
			setDeleteOption();
			setCryptOptions();
		}


		// This function escapes special html characters in names

		function escapeHTML(text) {
			return text.replace(/\&/g,'&amp;').replace(/\</g,'&lt;').replace(/\>/g,'&gt;');
		}


		// Convert file sizes from bytes to human readable units

		function bytesToSize(bytes) {
			var sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
			if (bytes == 0) return '0 B';
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
		}

	});
	}
	
	function setDeleteOption() {
		$(".deleteBtn").click( function() {
			var filePath = $(this).siblings("a").attr("href");
			var parent = $(this).parent();
			var doScan = false;
			var ajaxurl = 'delete_file.php';
			
			if ( filePath == "" ) {
				noticeTxt.text("Greška! Pokušajte ponovno.");
				noticeToggle(true);
			}
			else {
			
				
			
				var pathParts = filePath.split("/");
				if ( pathParts.length > 2 ) {
					doScan = true;
				}
			
				data = {path: filePath};
				$.post(ajaxurl, data, function (response) {
					if (response == "error") {
						noticeTxt.text("Greška! Pokušajte ponovno.");
						//scan();
					}
					else {
						noticeTxt.text("Datoteka obrisana.");
						parent.toggle();
						if (doScan) {
							scan();
						}
					}
					noticeToggle();
				});
			}
		});
	}
	
	function uploadManager() {
		var ul = $('#upload ul');

		$('#drop a').click( function(){
			$(this).parent().find('input').click();
		} );

		$('#upload').fileupload({

			dropZone: $('#drop'),

			add: function (e, data) {

				var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
					' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

				tpl.find('p').text(data.files[0].name)
							 .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

				data.context = tpl.appendTo(ul);

				tpl.find('input').knob();

				tpl.find('span').click(function(){

					if(tpl.hasClass('working')){
						jqXHR.abort();
					}

					tpl.fadeOut(function(){
						tpl.remove();
					});

				});

				// Automatically upload the file once it is added to the queue
				var jqXHR = data.submit();
			},

			progress: function(e, data){

				// Calculate the completion percentage of the upload
				var progress = parseInt(data.loaded / data.total * 100, 10);

				// Update the hidden input field and trigger a change
				// so that the jQuery knob plugin knows to update the dial
				data.context.find('input').val(progress).change();

				if(progress == 100){
					data.context.removeClass('working');
					setTimeout(function() {
						scan();
					}, 1000);
				}
			},

			fail:function(e, data){
				// Something has gone wrong!
				data.context.addClass('error');
			}

		});


		// Prevent the default action when a file is dropped on the window
		$(document).on('drop dragover', function (e) {
			e.preventDefault();
		});

		// Helper function that formats the file sizes
		function formatFileSize(bytes) {
			if (typeof bytes !== 'number') {
				return '';
			}

			if (bytes >= 1000000000) {
				return (bytes / 1000000000).toFixed(2) + ' GB';
			}

			if (bytes >= 1000000) {
				return (bytes / 1000000).toFixed(2) + ' MB';
			}

			return (bytes / 1000).toFixed(2) + ' KB';
		}
	}
	
	uploadManager();
	scan();
	
	$("#newTxtBtn").click(function() {
				$("#fileName").val("");
				$("#filePath").val("");
				$("#txtPlain").val("");
			});
	
	//toggle "text editor", "file upload"
	$("#textEditor").slideToggle("fast");
	$("#fileUpload").slideToggle("fast");
	
	$("#toggleTextEditor").click(function() {
		$("#textEditor").slideToggle();
	});
	$("#toggleFileUpload").click(function() {
		$("#fileUpload").slideToggle();
	});
	
		
	//generiranje ključeva
	$('#generateKeysBtn').click(function(){			
		var ajaxurl = 'keys_generator.php';
		$.post(ajaxurl, "", function (response) {
			if (response == "generated" ) {
				noticeTxt.text("Ključevi generirani!");
				scan();
			}
			else {
				noticeTxt.text("Greška. Pokušajte ponovno!");
			}
			noticeToggle();
		});
	});
	
	//generiranje jednog paragrafa (Lorem Ipsum)
	$("#generateTxtBtn").click(function() {
		var date = new Date();
		var dateNow = date.getHours().toString() + ":" + date.getMinutes().toString() + ":" + date.getSeconds().toString()
					  + " " + date.getDate().toString() + "." + (date.getMonth()+1).toString() + "." + date.getFullYear().toString() + "." ; 
		var txtPlain = $("#txtPlain");
		var LoremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eodem modo is enim tibi nemo dabit, quod, expetendum sit, id esse laudabile. Ergo in gubernando nihil, in officio plurimum interest, quo in genere peccetur. Duo Reges: constructio interrete. Sed finge non solum callidum eum, qui aliquid improbe faciat, verum etiam praepotentem, ut M. Sed tu istuc dixti bene Latine, parum plane. Nam et a te perfici istam disputationem volo, nec tua mihi oratio longa videri potest.";
				
		$("#txtPlain").val("");
		$('#txtPlain').val($('#txtPlain').val() + dateNow + "\n" + LoremIpsum);
				
				
	});
	
	//pohrana txt/html datoteke
	$("#savePlainBtn").click(function() {
		var ajaxurl = 'save_text_to_file.php';
		var txtPlain = $("#txtPlain").val();
		var filePath = $("#filePath").val().trim();
		
		if ( $("#fileName").val().indexOf(".") == -1 ) {
			$("#fileName").val($('#fileName').val() + ".txt" );
		}
		
		if ( filePath == "" ) {
			filePath = "datoteke/" + $("#fileName").val();
		}
		
		data = {text: txtPlain, path: filePath};
		$.post(ajaxurl, data, function (response) {
			if (response == "saved") {
				noticeTxt.text("Datoteka pohranjena!");
				scan();
			}
			else {
				noticeTxt.text("Greška! Pokušajte ponovno.");
			}
			noticeToggle();
		});
	});
				
	$("#asymetricCryptBtn").click(function() {
		asymetricEncryption = btnChooser(asymetricEncryption, asymetricEncrpytBtn);
	});
	$("#asymetricDecryptBtn").click(function() {
		asymetricDecryption = btnChooser(asymetricDecryption, asymetricDecryptBtn);
	});
		
	$("#symetricCryptBtn").click(function() {
		symetricEncryption = btnChooser(symetricEncryption, symetricEncrpytBtn);
	});
	$("#symetricDecryptBtn").click(function() {
		symetricDecryption = btnChooser(symetricDecryption, symetricDecryptBtn);
	});
	digestBtn.click(function() {
		digest = btnChooser(digest, digestBtn);
	});
	digitalSignatureBtn.click(function() {
		digitalSignature = btnChooser(digitalSignature, digitalSignatureBtn);
	});
	digitalSignatureCheckBtn.click(function() {
		digitalSignatureCheck = btnChooser(digitalSignatureCheck, digitalSignatureCheckBtn);
	});
			
});
